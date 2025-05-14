// Nama file: lib/screen/profile_screen.dart
import 'package:flutter/material.dart';

// Asumsi Anda punya route '/login' yang sudah terdaftar di main.dart

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({super.key});

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  // Contoh data, nanti diganti dengan data asli dari user
  String userName = "Dyahna"; // Anda bisa ambil dari state management
  String userHandle = "@dyahnaa14";
  String userEmail = "dyahna@example.com";
  final String userImageUrl = 'assets/images/avatar_placeholder.png'; // GANTI PATH INI

  // Helper widget untuk membuat satu baris menu/opsi
  Widget _buildSettingsTile({
    required IconData icon,
    required String title,
    String? subtitle,
    VoidCallback? onTap,
  }) {
    return ListTile(
      leading: CircleAvatar(
        radius: 20,
        backgroundColor: Theme.of(context).primaryColor.withOpacity(0.1),
        child: Icon(icon, color: Theme.of(context).primaryColor, size: 20),
      ),
      title: Text(title, style: const TextStyle(fontWeight: FontWeight.w500)),
      subtitle: subtitle != null
          ? Text(subtitle, style: TextStyle(fontSize: 12, color: Colors.grey.shade600))
          : null,
      trailing: const Icon(Icons.chevron_right, color: Colors.grey),
      onTap: onTap,
      contentPadding: const EdgeInsets.symmetric(vertical: 2.0, horizontal: 0),
      dense: true,
    );
  }

  // Fungsi untuk menampilkan SnackBar (jika halaman belum ada)
  void _showFeatureNotAvailableSnackbar(String featureName) {
    if (!mounted) return;
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text('Halaman $featureName belum tersedia'), duration: const Duration(seconds: 1)),
    );
  }

  // Fungsi untuk menangani logout
  void _handleLogout() {
    showDialog(
      context: context,
      builder: (BuildContext ctx) => AlertDialog(
        title: const Text('Konfirmasi Logout'),
        content: const Text('Anda yakin ingin keluar?'),
        actions: <Widget>[
          TextButton(onPressed: () => Navigator.of(ctx).pop(), child: const Text('Batal')),
          TextButton(
            child: const Text('Logout', style: TextStyle(color: Colors.red)),
            onPressed: () {
              Navigator.of(ctx).pop(); // Tutup dialog
              // Navigasi ke login dan hapus semua route sebelumnya
              Navigator.pushNamedAndRemoveUntil(context, '/login', (Route<dynamic> route) => false);
            },
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // AppBar sederhana
      appBar: AppBar(
        title: const Text('Profil Saya'),
        elevation: 0.5, // Sedikit shadow
        // backgroundColor: Colors.white, // Atau warna tema Anda
        // foregroundColor: Colors.black87,
      ),
      body: ListView(
        padding: const EdgeInsets.symmetric(vertical: 10.0, horizontal: 16.0),
        children: [
          // Kartu Header Profil
          Card(
            elevation: 2,
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
            margin: const EdgeInsets.only(bottom: 25.0),
            child: Padding(
              padding: const EdgeInsets.all(16.0),
              child: Row(
                children: [
                  CircleAvatar(
                    radius: 32,
                    backgroundImage: AssetImage(userImageUrl),
                    onBackgroundImageError: (e,s) { print("Error load avatar: $e");},
                    child: userImageUrl.isEmpty ? const Icon(Icons.person, size: 32, color: Colors.white70) : null,
                    backgroundColor: Colors.grey.shade300,
                  ),
                  const SizedBox(width: 15),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(userName, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
                        const SizedBox(height: 4),
                        Text(userHandle, style: TextStyle(fontSize: 14, color: Colors.grey.shade700)),
                        const SizedBox(height: 4),
                        Text(userEmail, style: TextStyle(fontSize: 12, color: Colors.grey.shade600)),
                      ],
                    ),
                  ),
                  IconButton(icon: Icon(Icons.edit_outlined, color: Theme.of(context).primaryColor, size: 20), onPressed: (){
                     Navigator.pushNamed(context, '/edit_profile');
                  })
                ],
              ),
            ),
          ),

          // --- Pengaturan Akun ---
          Text('Pengaturan Akun', style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Colors.grey.shade700)),
          const SizedBox(height: 8),
          _buildSettingsTile(icon: Icons.lock_outline_rounded, title: 'Ubah Kata Sandi', subtitle: 'Perbarui kata sandi Anda', onTap: () => Navigator.pushNamed(context, '/ubah_kata_sandi')),
          const Divider(height: 1),
          _buildSettingsTile(icon: Icons.notifications_active_outlined, title: 'Pengaturan Notifikasi', subtitle: 'Atur pengingat dan pemberitahuan', onTap: () => Navigator.pushNamed(context, '/pengaturan_notifikasi')),
          const SizedBox(height: 25),

          // --- Informasi & Bantuan ---
           Text('Informasi & Bantuan', style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Colors.grey.shade700)),
           const SizedBox(height: 8),
           _buildSettingsTile(icon: Icons.help_outline_rounded, title: 'Bantuan & Dukungan', onTap: () => Navigator.pushNamed(context, '/bantuan')),
           const Divider(height: 1),
           _buildSettingsTile(icon: Icons.info_outline_rounded, title: 'Tentang Aplikasi', onTap: () => Navigator.pushNamed(context, '/tentang_aplikasi')),
           const Divider(height: 1),
           _buildSettingsTile(icon: Icons.privacy_tip_outlined, title: 'Kebijakan Privasi', onTap: () => Navigator.pushNamed(context, '/kebijakan_privasi')),
           const SizedBox(height: 30),

          // --- Logout ---
          ListTile( // Menggunakan ListTile agar bisa ganti warna ikon dan teks
            leading: CircleAvatar(
              radius: 20,
              backgroundColor: Colors.red.withOpacity(0.1),
              child: const Icon(Icons.logout_rounded, color: Colors.red, size: 20),
            ),
            title: const Text('Logout', style: TextStyle(fontWeight: FontWeight.w500, color: Colors.red)),
            trailing: const Icon(Icons.chevron_right, color: Colors.red),
            onTap: _handleLogout,
            contentPadding: const EdgeInsets.symmetric(vertical: 2.0, horizontal: 0),
            dense: true,
          ),
          const SizedBox(height: 20),
        ],
      ),
    );
  }
}