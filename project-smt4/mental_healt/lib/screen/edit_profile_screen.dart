// Nama file: lib/screen/edit_profile_screen.dart
import 'package:flutter/material.dart';

class EditProfileScreen extends StatefulWidget {
  const EditProfileScreen({super.key});

  @override
  State<EditProfileScreen> createState() => _EditProfileScreenState();
}

class _EditProfileScreenState extends State<EditProfileScreen> {
  // Controller untuk setiap TextField
  final _nameController = TextEditingController();
  final _handleController = TextEditingController();
  final _bioController = TextEditingController(); // Contoh tambahan: Bio

  final _formKey = GlobalKey<FormState>(); // Kunci untuk validasi form

  @override
  void initState() {
    super.initState();
    // TODO: Idealnya, isi controller ini dengan data user yang sekarang
    // Misalnya, ambil dari state management atau database
    _nameController.text = "Dyahna"; // Contoh data awal
    _handleController.text = "@dyahnaa14";
    _bioController.text = "Pengguna aplikasi kesehatan mental yang bersemangat!";
  }

  @override
  void dispose() {
    _nameController.dispose();
    _handleController.dispose();
    _bioController.dispose();
    super.dispose();
  }

  void _saveProfileChanges() {
    if (_formKey.currentState!.validate()) {
      // Form valid, lanjutkan proses penyimpanan
      String newName = _nameController.text;
      String newHandle = _handleController.text;
      String newBio = _bioController.text;

      // TODO: Implementasikan logika untuk menyimpan perubahan ini
      // ke state management, database lokal, atau API backend.
      print('Nama Baru: $newName');
      print('Handle Baru: $newHandle');
      print('Bio Baru: $newBio');

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Profil berhasil diperbarui!')),
      );
      Navigator.pop(context); // Kembali ke halaman profil setelah simpan
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Edit Profil'),
        actions: [
          IconButton(
            icon: const Icon(Icons.save_outlined),
            tooltip: 'Simpan Perubahan',
            onPressed: _saveProfileChanges, // Panggil fungsi simpan
          )
        ],
      ),
      body: SingleChildScrollView( // Agar bisa scroll jika form panjang
        padding: const EdgeInsets.all(20.0),
        child: Form( // Gunakan Form untuk validasi
          key: _formKey,
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: <Widget>[
              // --- Bagian Foto Profil (Placeholder) ---
              Center(
                child: Stack(
                  alignment: Alignment.bottomRight,
                  children: [
                    CircleAvatar(
                      radius: 50,
                      backgroundColor: Colors.grey.shade300,
                      // TODO: Ganti dengan Image.network atau Image.file
                      child: const Icon(Icons.person, size: 50, color: Colors.grey),
                    ),
                    Material( // Untuk efek ripple pada IconButton
                      color: Colors.transparent,
                      shape: const CircleBorder(),
                      clipBehavior: Clip.hardEdge,
                      child: IconButton(
                        icon: Icon(Icons.camera_alt, color: Theme.of(context).primaryColor),
                        onPressed: () {
                          // TODO: Implementasi logic ganti foto profil
                          print('Tombol ganti foto ditekan');
                           ScaffoldMessenger.of(context).showSnackBar(
                             const SnackBar(content: Text('Fitur ganti foto belum ada.')),
                           );
                        },
                      ),
                    )
                  ],
                ),
              ),
              const SizedBox(height: 30),

              // --- Input Nama ---
              TextFormField(
                controller: _nameController,
                decoration: const InputDecoration(
                  labelText: 'Nama Lengkap',
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.person_outline),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Nama tidak boleh kosong';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 20),

              // --- Input Username/Handle ---
              TextFormField(
                controller: _handleController,
                decoration: const InputDecoration(
                  labelText: 'Username (@handle)',
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.alternate_email),
                ),
                 validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Username tidak boleh kosong';
                  }
                  if (!value.startsWith('@')) {
                     return 'Username harus diawali @';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 20),

              // --- Input Bio (Contoh Tambahan) ---
              TextFormField(
                controller: _bioController,
                decoration: const InputDecoration(
                  labelText: 'Bio Singkat',
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.info_outline),
                  hintText: 'Ceritakan sedikit tentang diri Anda...'
                ),
                maxLines: 3, // Teks bisa beberapa baris
                maxLength: 150, // Batas karakter
              ),
              const SizedBox(height: 30),

              // Tombol Simpan (opsional, karena sudah ada di AppBar)
              // Center(
              //   child: ElevatedButton(
              //     style: ElevatedButton.styleFrom(
              //       padding: EdgeInsets.symmetric(horizontal: 50, vertical: 15)
              //     ),
              //     onPressed: _saveProfileChanges,
              //     child: const Text('Simpan Perubahan'),
              //   ),
              // ),
            ],
          ),
        ),
      ),
    );
  }
}