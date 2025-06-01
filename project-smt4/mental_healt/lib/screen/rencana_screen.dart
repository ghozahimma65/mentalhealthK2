// Nama file: lib/screen/rencana_screen.dart
import 'package:flutter/material.dart';
import '../services/rencana_service.dart'; // GANTI IMPORT INI
import '../models/self_care_plan.dart';   // Pastikan model sudah disesuaikan

class RencanaScreen extends StatefulWidget {
  const RencanaScreen({super.key});

  @override
  State<RencanaScreen> createState() => _RencanaScreenState();
}

class _RencanaScreenState extends State<RencanaScreen> {
  final _rencanaService = RencanaService(); // Gunakan RencanaService
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
      final data = await _rencanaService.getRencanaList(); // Panggil dari service
      if (!mounted) return;
      setState(() {
        _selfCarePlans = data;
        _isLoading = false;
      });
    } catch (e) {
      print("Error refreshing plan list from API: $e");
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

    Map<String, dynamic>? resultData = await showDialog<Map<String, dynamic>>(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext dialogContext) {
        // UI Dialog tetap sama seperti kode Anda sebelumnya (TextField untuk title & description)
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
              onPressed: () => Navigator.of(dialogContext).pop(null),
            ),
            ElevatedButton(
              child: Text(isEditing ? 'Simpan' : 'Tambah'),
              onPressed: () {
                final title = titleController.text.trim();
                final description = descriptionController.text.trim();
                if (title.isNotEmpty) {
                  Navigator.of(dialogContext).pop({
                    'title': title,
                    'description': description,
                  });
                } else {
                  ScaffoldMessenger.of(dialogContext).showSnackBar(
                    const SnackBar(content: Text('Judul rencana tidak boleh kosong!'), backgroundColor: Colors.red),
                  );
                }
              },
            ),
          ],
        );
      },
    );

    if (resultData != null) {
      setState(() { _isLoading = true; });
      try {
        if (isEditing && plan != null) {
          SelfCarePlan planToUpdate = SelfCarePlan(
            id: plan.id, // ID dari plan yang diedit
            title: resultData['title'],
            description: resultData['description'],
            isCompleted: plan.isCompleted, // Pertahankan status isCompleted saat ini
            createdAt: plan.createdAt,
            updatedAt: DateTime.now(), // Server akan update ini
          );
          await _rencanaService.updateRencana(plan.id, planToUpdate);
        } else {
          SelfCarePlan newPlan = SelfCarePlan.create( // Gunakan constructor .create
            title: resultData['title'],
            description: resultData['description'],
            // isCompleted akan default false dari constructor .create
          );
          await _rencanaService.createRencana(newPlan);
        }
        _refreshPlanList(); // Refresh list setelah simpan/tambah
      } catch (e) {
        print("Error saving/updating plan via API: $e");
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Gagal menyimpan rencana: ${e.toString()}'), backgroundColor: Colors.red)
          );
        }
      } finally {
        if (mounted) setState(() { _isLoading = false; });
      }
    }
  }

  Future<void> _toggleComplete(SelfCarePlan plan) async {
    if (!mounted) return;

    SelfCarePlan planToUpdate = SelfCarePlan(
      id: plan.id,
      title: plan.title,
      description: plan.description,
      isCompleted: !plan.isCompleted, // Toggle status
      createdAt: plan.createdAt,
      updatedAt: DateTime.now(), // Server akan update ini
    );

    // Optimistic UI update
    final int planIndex = _selfCarePlans.indexWhere((p) => p.id == plan.id);
    if (planIndex != -1) {
      setState(() {
        _selfCarePlans[planIndex].isCompleted = planToUpdate.isCompleted;
      });
    }
    
    try {
      await _rencanaService.updateRencana(plan.id, planToUpdate);
      // Jika sukses, tidak perlu refresh list penuh, UI sudah optimis
      // Namun, jika ingin data createdAt/updatedAt terbaru, panggil _refreshPlanList()
      // _refreshPlanList(); 
    } catch (e) {
      print("Error toggling complete status via API: $e");
      if(mounted) {
        // Rollback UI jika update API gagal
        if (planIndex != -1) {
          setState(() {
             // Kembalikan ke status awal
            _selfCarePlans[planIndex].isCompleted = !_selfCarePlans[planIndex].isCompleted;
          });
        }
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Gagal update status: ${e.toString()}'), backgroundColor: Colors.red)
        );
      }
    }
  }

  Future<void> _deletePlan(SelfCarePlan plan) async {
    bool? confirmDelete = await showDialog<bool>(
      context: context,
      builder: (ctx) => AlertDialog( /* ... dialog konfirmasi seperti kode Anda ... */ 
        title: const Text("Hapus Rencana?"),
        content: Text("Anda yakin ingin menghapus rencana '${plan.title}'?"),
        actions: [
          TextButton(onPressed: (){ Navigator.of(ctx).pop(false); }, child: const Text("Batal")),
          TextButton(onPressed: (){ Navigator.of(ctx).pop(true); }, child: const Text("Hapus", style: TextStyle(color: Colors.red))),
        ],
      )
    );

    if (confirmDelete == true) {
      setState(() { _isLoading = true; });
      try {
        await _rencanaService.deleteRencana(plan.id); // Panggil service
        _refreshPlanList(); // Refresh setelah delete
        if (!mounted) return;
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Rencana "${plan.title}" dihapus'), duration: const Duration(seconds: 2)),
        );
      } catch (e) {
        print("Error deleting plan via API: $e");
         if(mounted) {
            ScaffoldMessenger.of(context).showSnackBar(
                SnackBar(content: Text('Gagal menghapus rencana: ${e.toString()}'), backgroundColor: Colors.red)
            );
        }
      } finally {
        if(mounted) setState(() { _isLoading = false; });
      }
    }
  }

  @override
  void dispose() {
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    // Build method UI Anda (Scaffold, AppBar, ListView.builder)
    // sebagian besar akan sama. Pastikan ListTile menggunakan data dari
    // objek SelfCarePlan yang field-nya sudah disesuaikan dengan API.
    // Misalnya, plan.id sekarang adalah String.
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
              ? Center( /* ... Tampilan jika kosong ... */ ) // Sama seperti kode Anda
              : ListView.builder(
                  padding: const EdgeInsets.symmetric(horizontal: 8.0, vertical: 12.0),
                  itemCount: _selfCarePlans.length,
                  itemBuilder: (context, index) {
                    final plan = _selfCarePlans[index];
                    return Card(
                      // ... (styling Card seperti kode Anda)
                      child: ListTile(
                        // ... (Checkbox, title, subtitle, trailing seperti kode Anda)
                        // Pastikan semua field yang diakses dari 'plan' ada di model SelfCarePlan yang baru
                        contentPadding: const EdgeInsets.only(left: 8.0, right: 0.0),
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
                              onPressed: () => _deletePlan(plan),
                            ),
                          ],
                        ),
                        onTap: () => _toggleComplete(plan), // Aksi saat item di-tap
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