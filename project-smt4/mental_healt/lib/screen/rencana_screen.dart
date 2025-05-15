// Nama file: lib/screen/rencana_screen.dart
import 'package:flutter/material.dart';
// Sesuaikan path import helper dan model Anda
import '../helpers/database_helper.dart';
import '../models/self_care_plan.dart';

class RencanaScreen extends StatefulWidget {
  const RencanaScreen({super.key});

  @override
  State<RencanaScreen> createState() => _RencanaScreenState();
}

class _RencanaScreenState extends State<RencanaScreen> {
  final dbHelper = DatabaseHelper.instance;
  List<SelfCarePlan> _selfCarePlans = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _refreshPlanList();
  }

  Future<void> _refreshPlanList() async {
    if (!mounted) return;
    setState(() { _isLoading = true; });
    try {
      final data = await dbHelper.getAllPlans();
      if (!mounted) return;
      setState(() {
        _selfCarePlans = data;
        _isLoading = false;
      });
    } catch (e) {
      print("Error refreshing plan list: $e");
      if (!mounted) return;
      setState(() { _isLoading = false; });
      ScaffoldMessenger.of(context).showSnackBar(
         SnackBar(content: Text('Gagal memuat rencana: ${e.toString()}'), backgroundColor: Colors.red)
      );
    }
  }

  Future<void> _showAddEditPlanDialog({SelfCarePlan? plan}) async {
    final titleController = TextEditingController(text: plan?.title ?? '');
    final descriptionController = TextEditingController(text: plan?.description ?? '');
    bool isEditing = plan != null;

    SelfCarePlan? result = await showDialog<SelfCarePlan>( // Ubah agar bisa return SelfCarePlan
      context: context,
      barrierDismissible: false,
      builder: (BuildContext dialogContext) {
        return AlertDialog(
          title: Text(isEditing ? 'Edit Rencana' : 'Tambah Rencana Baru'),
          contentPadding: const EdgeInsets.fromLTRB(24.0, 20.0, 24.0, 0.0),
          content: SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                TextField(
                  controller: titleController,
                  decoration: const InputDecoration(labelText: "Judul Rencana", border: OutlineInputBorder()),
                  autofocus: true,
                  textInputAction: TextInputAction.next,
                ),
                const SizedBox(height: 16),
                TextField(
                  controller: descriptionController,
                  decoration: const InputDecoration(labelText: "Deskripsi (opsional)", border: OutlineInputBorder()),
                  maxLines: 3,
                  textInputAction: TextInputAction.done,
                ),
              ],
            ),
          ),
          actions: <Widget>[
            TextButton(
              child: const Text('Batal'),
              onPressed: () => Navigator.of(dialogContext).pop(null), // Return null jika batal
            ),
            ElevatedButton(
              child: Text(isEditing ? 'Simpan' : 'Tambah'),
              onPressed: () {
                final title = titleController.text.trim();
                final description = descriptionController.text.trim();
                if (title.isNotEmpty) {
                  SelfCarePlan resultingPlan;
                  if (isEditing) {
                    plan!.title = title;
                    plan.description = description;
                    // plan.isCompleted tetap, tidak diubah di dialog ini
                    resultingPlan = plan;
                  } else {
                    resultingPlan = SelfCarePlan(
                      id: DateTime.now().millisecondsSinceEpoch.toString(),
                      title: title,
                      description: description,
                    );
                  }
                  Navigator.of(dialogContext).pop(resultingPlan); // Return plan yang akan disimpan/diupdate
                } else {
                   ScaffoldMessenger.of(context).showSnackBar(
                     const SnackBar(content: Text('Judul rencana tidak boleh kosong!'), backgroundColor: Colors.red),
                   );
                }
              },
            ),
          ],
        );
      },
    );

    // Proses hasil dari dialog
    if (result != null) {
      if (isEditing) {
        await dbHelper.updatePlan(result);
        print('Rencana diperbarui: ${result.title}');
      } else {
        await dbHelper.insertPlan(result);
        print('Rencana ditambahkan: ${result.title}');
      }
      _refreshPlanList(); // Refresh list setelah simpan/tambah
    }
  }

  Future<void> _toggleComplete(SelfCarePlan plan) async {
    if (!mounted) return;
    // Optimistic UI update
    final originalStatus = plan.isCompleted;
    setState(() { plan.isCompleted = !plan.isCompleted; });
    
    try {
        await dbHelper.updatePlan(plan);
    } catch (e) {
        print("Error updating plan status: $e");
        if(mounted) {
            // Rollback UI jika update DB gagal
            setState(() { plan.isCompleted = originalStatus; });
            ScaffoldMessenger.of(context).showSnackBar(
                const SnackBar(content: Text('Gagal update status rencana.'), backgroundColor: Colors.red)
            );
        }
    }
    // Tidak perlu _refreshPlanList() penuh jika hanya update isCompleted,
    // kecuali jika urutan list bergantung pada status.
  }

  Future<void> _deletePlan(SelfCarePlan plan) async {
    bool? confirmDelete = await showDialog<bool>(
      context: context,
      builder: (ctx) => AlertDialog(
        title: const Text("Hapus Rencana?"),
        content: Text("Anda yakin ingin menghapus rencana '${plan.title}'?"),
        actions: [
          TextButton(onPressed: (){ Navigator.of(ctx).pop(false); }, child: const Text("Batal")),
          TextButton(onPressed: (){ Navigator.of(ctx).pop(true); }, child: const Text("Hapus", style: TextStyle(color: Colors.red))),
        ],
      )
    );

    if (confirmDelete == true) {
      await dbHelper.deletePlan(plan.id);
      _refreshPlanList();
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Rencana "${plan.title}" dihapus'), duration: const Duration(seconds: 2)),
      );
    }
  }

  @override
  void dispose() {
    // Tidak perlu dbHelper.closeConnection() di sini, biarkan koneksi terbuka selama app berjalan
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Rencana Self Care Saya'),
        actions: [
          IconButton(
            icon: const Icon(Icons.add_circle_outline),
            tooltip: 'Tambah Rencana Baru',
            onPressed: () => _showAddEditPlanDialog(),
          )
        ],
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : _selfCarePlans.isEmpty
              ? Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(Icons.event_note_outlined, size: 80, color: Colors.grey.shade400),
                      const SizedBox(height: 16),
                      const Text('Belum ada rencana self care.', style: TextStyle(fontSize: 18, color: Colors.grey)),
                      const SizedBox(height: 8),
                      const Text('Tekan tombol + untuk menambahkan.', style: TextStyle(fontSize: 14, color: Colors.grey)),
                    ],
                  ),
                )
              : ListView.builder(
                  padding: const EdgeInsets.symmetric(horizontal: 8.0, vertical: 12.0), // Sedikit padding
                  itemCount: _selfCarePlans.length,
                  itemBuilder: (context, index) {
                    final plan = _selfCarePlans[index];
                    return Card(
                      elevation: 2.0,
                      margin: const EdgeInsets.symmetric(horizontal: 8.0, vertical: 5.0), // Margin antar card
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10.0)),
                      child: ListTile(
                        contentPadding: const EdgeInsets.only(left: 8.0, right: 0.0), // Atur padding ListTile
                        leading: Checkbox(
                          value: plan.isCompleted,
                          onChanged: (bool? value) => _toggleComplete(plan),
                          activeColor: Theme.of(context).primaryColor,
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(4)),
                        ),
                        title: Text(
                          plan.title,
                          style: TextStyle(
                            fontWeight: FontWeight.w500,
                            decoration: plan.isCompleted ? TextDecoration.lineThrough : null,
                            color: plan.isCompleted ? Colors.grey.shade600 : Colors.black87,
                          ),
                        ),
                        subtitle: plan.description.isNotEmpty
                            ? Text(plan.description, maxLines: 2, overflow: TextOverflow.ellipsis, style: TextStyle(decoration: plan.isCompleted ? TextDecoration.lineThrough : null, color: plan.isCompleted ? Colors.grey.shade400 : Colors.grey.shade700,))
                            : null,
                        trailing: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            IconButton(
                              icon: Icon(Icons.edit_outlined, color: Colors.blueGrey.shade300, size: 22),
                              tooltip: 'Edit Rencana',
                              onPressed: () => _showAddEditPlanDialog(plan: plan),
                            ),
                            IconButton(
                              icon: Icon(Icons.delete_outline_rounded, color: Colors.red.shade400, size: 22),
                              tooltip: 'Hapus Rencana',
                              onPressed: () => _deletePlan(plan), // Hapus index jika tidak diperlukan
                            ),
                          ],
                        ),
                        onTap: () => _toggleComplete(plan),
                      ),
                    );
                  },
                ),
      floatingActionButton: FloatingActionButton(
        onPressed: () => _showAddEditPlanDialog(),
        tooltip: 'Tambah Rencana Baru',
        child: const Icon(Icons.add),
      ),
    );
  }
}