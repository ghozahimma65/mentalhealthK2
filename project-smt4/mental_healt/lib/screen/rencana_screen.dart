// Nama file: rencana_screen.dart
import 'package:flutter/material.dart';

// Model sederhana untuk satu item Rencana Self Care
class SelfCarePlan {
  String id;
  String title;
  String description; // Deskripsi singkat atau catatan
  bool isCompleted;
  TimeOfDay? reminderTime; // Opsional: waktu pengingat

  SelfCarePlan({
    required this.id,
    required this.title,
    this.description = '',
    this.isCompleted = false,
    this.reminderTime,
  });
}

class RencanaScreen extends StatefulWidget {
  const RencanaScreen({super.key});

  @override
  State<RencanaScreen> createState() => _RencanaScreenState();
}

class _RencanaScreenState extends State<RencanaScreen> {
  // --- CONTOH DATA RENCANA SELF CARE (Ganti dengan sumber data Anda) ---
  final List<SelfCarePlan> _selfCarePlans = [
    SelfCarePlan(
        id: '1',
        title: 'Minum Air Putih 2 Liter',
        description: 'Target harian untuk hidrasi.',
        isCompleted: true),
    SelfCarePlan(
        id: '2',
        title: 'Jalan Kaki 30 Menit',
        description: 'Di pagi atau sore hari.',
        isCompleted: false),
    SelfCarePlan(
        id: '3',
        title: 'Meditasi 10 Menit',
        description: 'Sebelum tidur untuk relaksasi.',
        isCompleted: false),
    SelfCarePlan(
        id: '4',
        title: 'Baca Buku 1 Bab',
        description: 'Buku non-fiksi atau fiksi favorit.',
        isCompleted: true),
    SelfCarePlan(
        id: '5',
        title: 'Tidur Cukup 7-8 Jam',
        description: 'Penting untuk pemulihan fisik & mental.'),
  ];
  // --------------------------------------------------------------------

  // Fungsi untuk menampilkan dialog tambah/edit rencana (placeholder)
  Future<void> _showAddEditPlanDialog({SelfCarePlan? plan}) async {
    final _titleController = TextEditingController(text: plan?.title ?? '');
    final _descriptionController =
        TextEditingController(text: plan?.description ?? '');
    bool _isEditing = plan != null;

    return showDialog<void>(
      context: context,
      barrierDismissible: false, // Pengguna harus menekan tombol
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text(_isEditing ? 'Edit Rencana' : 'Tambah Rencana Baru'),
          content: SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                TextField(
                  controller: _titleController,
                  decoration: const InputDecoration(hintText: "Judul Rencana"),
                ),
                const SizedBox(height: 10),
                TextField(
                  controller: _descriptionController,
                  decoration:
                      const InputDecoration(hintText: "Deskripsi (opsional)"),
                  maxLines: 3,
                ),
                // TODO: Tambahkan pilihan waktu pengingat jika perlu
              ],
            ),
          ),
          actions: <Widget>[
            TextButton(
              child: const Text('Batal'),
              onPressed: () {
                Navigator.of(context).pop();
              },
            ),
            TextButton(
              child: Text(_isEditing ? 'Simpan' : 'Tambah'),
              onPressed: () {
                final title = _titleController.text;
                final description = _descriptionController.text;
                if (title.isNotEmpty) {
                  setState(() {
                    if (_isEditing) {
                      // Logika update rencana
                      plan.title = title;
                      plan.description = description;
                      print('Rencana diperbarui: ${plan.title}');
                    } else {
                      // Logika tambah rencana baru
                      _selfCarePlans.add(SelfCarePlan(
                        id: DateTime.now().millisecondsSinceEpoch.toString(),
                        title: title,
                        description: description,
                      ));
                      print('Rencana ditambahkan: $title');
                    }
                  });
                  Navigator.of(context).pop();
                } else {
                  // Tampilkan pesan jika judul kosong
                  ScaffoldMessenger.of(context).showSnackBar(
                    const SnackBar(
                        content: Text('Judul rencana tidak boleh kosong!'),
                        backgroundColor: Colors.red),
                  );
                }
              },
            ),
          ],
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Rencana Self Care Saya'),
        // backgroundColor: Colors.green.shade700, // Contoh warna
        // foregroundColor: Colors.white,
        actions: [
          // Tombol tambah di AppBar
          IconButton(
            icon: const Icon(Icons.add_circle_outline),
            tooltip: 'Tambah Rencana Baru',
            onPressed: () {
              _showAddEditPlanDialog();
            },
          )
        ],
      ),
      body: _selfCarePlans.isEmpty
          ? const Center(
              // Tampilan jika tidak ada rencana
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(Icons.event_note_outlined, size: 80, color: Colors.grey),
                  SizedBox(height: 16),
                  Text(
                    'Belum ada rencana self care.',
                    style: TextStyle(fontSize: 18, color: Colors.grey),
                  ),
                  SizedBox(height: 8),
                  Text(
                    'Tekan tombol + untuk menambahkan.',
                    style: TextStyle(fontSize: 14, color: Colors.grey),
                  ),
                ],
              ),
            )
          : ListView.builder(
              // Tampilan jika ada rencana
              padding: const EdgeInsets.all(12.0),
              itemCount: _selfCarePlans.length,
              itemBuilder: (context, index) {
                final plan = _selfCarePlans[index];
                return Card(
                  elevation: 2.0,
                  margin: const EdgeInsets.symmetric(vertical: 6.0),
                  shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(10.0)),
                  child: ListTile(
                    // Checkbox untuk menandai selesai
                    leading: Checkbox(
                      value: plan.isCompleted,
                      onChanged: (bool? value) {
                        setState(() {
                          plan.isCompleted = value ?? false;
                          // TODO: Simpan status ini ke database
                        });
                      },
                      activeColor: Theme.of(context).primaryColor,
                    ),
                    // Judul Rencana
                    title: Text(
                      plan.title,
                      style: TextStyle(
                        fontWeight: FontWeight.w500,
                        decoration: plan.isCompleted
                            ? TextDecoration.lineThrough
                            : null,
                        color: plan.isCompleted ? Colors.grey : Colors.black87,
                      ),
                    ),
                    // Deskripsi Rencana (jika ada)
                    subtitle: plan.description.isNotEmpty
                        ? Text(plan.description,
                            maxLines: 2,
                            overflow: TextOverflow.ellipsis,
                            style: TextStyle(
                              decoration: plan.isCompleted
                                  ? TextDecoration.lineThrough
                                  : null,
                              color: plan.isCompleted
                                  ? Colors.grey.shade500
                                  : Colors.grey.shade700,
                            ))
                        : null,
                    // Tombol Edit & Hapus
                    trailing: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        IconButton(
                          icon: Icon(Icons.edit_outlined,
                              color: Colors.blueGrey.shade400, size: 20),
                          tooltip: 'Edit Rencana',
                          onPressed: () {
                            _showAddEditPlanDialog(plan: plan);
                          },
                        ),
                        IconButton(
                          icon: Icon(Icons.delete_outline_rounded,
                              color: Colors.red.shade300, size: 20),
                          tooltip: 'Hapus Rencana',
                          onPressed: () {
                            // Konfirmasi sebelum hapus
                            showDialog(
                                context: context,
                                builder: (ctx) => AlertDialog(
                                      title: const Text("Hapus Rencana?"),
                                      content: Text(
                                          "Anda yakin ingin menghapus rencana '${plan.title}'?"),
                                      actions: [
                                        TextButton(
                                            onPressed: () {
                                              Navigator.of(ctx).pop();
                                            },
                                            child: const Text("Batal")),
                                        TextButton(
                                            onPressed: () {
                                              setState(() {
                                                _selfCarePlans.removeAt(index);
                                                // TODO: Hapus dari database
                                              });
                                              Navigator.of(ctx).pop();
                                              ScaffoldMessenger.of(context)
                                                  .showSnackBar(
                                                SnackBar(
                                                    content: Text(
                                                        'Rencana "${plan.title}" dihapus'),
                                                    duration:
                                                        Duration(seconds: 1)),
                                              );
                                            },
                                            child: const Text("Hapus",
                                                style: TextStyle(
                                                    color: Colors.red))),
                                      ],
                                    ));
                          },
                        ),
                      ],
                    ),
                    onTap: () {
                      // Tandai selesai/belum saat item ditekan
                      setState(() {
                        plan.isCompleted = !plan.isCompleted;
                        // TODO: Simpan status ini ke database
                      });
                    },
                  ),
                );
              },
            ),
      floatingActionButton: FloatingActionButton(
        // Tombol tambah besar
        onPressed: () {
          _showAddEditPlanDialog();
        },
        tooltip: 'Tambah Rencana Baru',
        child: const Icon(Icons.add),
        // backgroundColor: Colors.green.shade700, // Sesuaikan warna
      ),
    );
  }
}
