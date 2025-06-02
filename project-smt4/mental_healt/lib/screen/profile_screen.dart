// lib/screens/profile_screen.dart
import 'package:flutter/material.dart';
import '../services/auth_service.dart'; // Sesuaikan path ke AuthService Anda
import '../models/user_model.dart';   // Sesuaikan path ke User model Anda

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({super.key});

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  final AuthService _authService = AuthService();
  Future<User>? _userProfileFuture;

  @override
  void initState() {
    super.initState();
    _loadUserProfile(); // Muat data profil saat halaman dibuka
  }

  void _loadUserProfile() {
    if (mounted) { // Pastikan widget masih ada di tree sebelum setState
      setState(() {
        _userProfileFuture = _authService.getUserProfile();
      });
    }
  }

  Future<void> _handleLogout() async {
    // Dialog konfirmasi sebelum logout
    bool? confirmLogout = await showDialog<bool>(
      context: context,
      builder: (BuildContext ctx) {
        return AlertDialog(
          title: const Text('Konfirmasi Logout'),
          content: const Text('Anda yakin ingin keluar dari akun ini?'),
          actions: <Widget>[
            TextButton(
              child: const Text('Batal'),
              onPressed: () {
                Navigator.of(ctx).pop(false); // Kirim false jika batal
              },
            ),
            TextButton(
              style: TextButton.styleFrom(foregroundColor: Colors.red),
              child: const Text('Logout'),
              onPressed: () {
                Navigator.of(ctx).pop(true); // Kirim true jika konfirmasi logout
              },
            ),
          ],
        );
      },
    );

    if (confirmLogout == true && mounted) {
      await _authService.logout(); // Panggil fungsi logout dari AuthService
      // Navigasi ke halaman login dan hapus semua rute sebelumnya
      Navigator.of(context).pushNamedAndRemoveUntil('/login', (route) => false);
    }
  }

  // Helper widget untuk membuat satu baris menu/opsi (disesuaikan dengan UI Anda sebelumnya)
  Widget _buildSettingsTile({
    required IconData icon,
    required String title,
    String? subtitle, // subtitle sekarang opsional
    VoidCallback? onTap,
  }) {
    return ListTile(
      leading: CircleAvatar( // Menggunakan CircleAvatar untuk ikon seperti di UI Anda
        radius: 20,
        backgroundColor: Theme.of(context).primaryColor.withOpacity(0.1),
        child: Icon(icon, color: Theme.of(context).primaryColor, size: 20),
      ),
      title: Text(title, style: const TextStyle(fontWeight: FontWeight.w500, fontSize: 15.5)),
      subtitle: subtitle != null && subtitle.isNotEmpty
          ? Text(subtitle,
              style: TextStyle(fontSize: 12, color: Colors.grey.shade600))
          : null,
      trailing: const Icon(Icons.chevron_right_rounded, color: Colors.grey),
      onTap: onTap,
      contentPadding: const EdgeInsets.symmetric(vertical: 4.0, horizontal: 0), // Sesuaikan padding
      dense: true,
    );
  }

  // Helper widget untuk judul seksi
  Widget _buildSectionTitle(String title) {
    return Padding(
      padding: const EdgeInsets.only(left: 16.0, right: 16.0, top: 20.0, bottom: 10.0), // Sesuaikan padding
      child: Text(
        title.toUpperCase(),
        style: TextStyle(
          fontSize: 13.5,
          fontWeight: FontWeight.bold,
          color: Colors.grey.shade700,
          letterSpacing: 0.8,
        ),
      ),
    );
  }

  // Method untuk membangun tampilan profil utama setelah data user didapatkan
  Widget _buildProfileContentView(User user) {
    return ListView(
      padding: const EdgeInsets.symmetric(vertical: 15.0, horizontal: 16.0),
      children: [
        // Kartu Header Profil - SESUAI PERMINTAAN ANDA
        Card(
          elevation: 2.5,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          margin: const EdgeInsets.only(bottom: 25.0),
          child: Padding(
            padding: const EdgeInsets.symmetric(vertical: 20.0, horizontal: 16.0), // Padding disesuaikan
            child: Row(
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                // FOTO PROFIL DIHILANGKAN
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        user.name, // NAMA DINAMIS DARI API
                        style: const TextStyle(
                            fontSize: 22, fontWeight: FontWeight.bold), // Font size sedikit lebih besar
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                      const SizedBox(height: 6),
                      Text(
                        user.email, // EMAIL DINAMIS DARI API
                        style: TextStyle(
                            fontSize: 15, color: Colors.grey.shade700),
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                      ),
                      // USERNAME (@handle) DIHILANGKAN
                    ],
                  ),
                )
              ],
            ),
          ),
        ),

        // Seksi "Pengaturan Akun" DIHILANGKAN karena itemnya diminta dihapus
        // (Ubah Kata Sandi & Pengaturan Notifikasi dihapus)

        // --- Informasi & Bantuan --- (Tetap Ada)
        _buildSectionTitle('Informasi & Bantuan'),
        _buildSettingsTile(
            icon: Icons.help_outline_rounded,
            title: 'Bantuan & Dukungan',
            onTap: () {
              // Pastikan rute '/bantuan' ada di main.dart
              Navigator.pushNamed(context, '/bantuan');
            }),
        const Divider(thickness: 0.5, height: 1), // Divider lebih tipis
        _buildSettingsTile(
            icon: Icons.info_outline_rounded,
            title: 'Tentang Aplikasi',
            onTap: () {
              // Pastikan rute '/tentang_aplikasi' ada di main.dart
              Navigator.pushNamed(context, '/tentang_aplikasi');
            }),
        const Divider(thickness: 0.5, height: 1),
        _buildSettingsTile(
            icon: Icons.privacy_tip_outlined,
            title: 'Kebijakan Privasi',
            onTap: () {
              // Pastikan rute '/kebijakan_privasi' ada di main.dart
              Navigator.pushNamed(context, '/kebijakan_privasi');
            }),
        const SizedBox(height: 30), // Spasi sebelum logout

        // --- Logout ---
        ListTile(
          leading: CircleAvatar(
            radius: 20,
            backgroundColor: Colors.red.withOpacity(0.08),
            child:
                const Icon(Icons.logout_rounded, color: Colors.redAccent, size: 20),
          ),
          title: const Text('Logout',
              style:
                  TextStyle(fontWeight: FontWeight.w600, color: Colors.redAccent, fontSize: 16)),
          trailing: const Icon(Icons.chevron_right, color: Colors.redAccent),
          onTap: _handleLogout,
          contentPadding:
              const EdgeInsets.symmetric(vertical: 4.0, horizontal: 4.0), // Sesuaikan padding ListTile
          dense: true,
        ),
        const SizedBox(height: 20),
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    print("ProfileScreen: build() dipanggil. Status Future: ${_userProfileFuture.toString()}");
    return Scaffold(
      appBar: AppBar(
        title: const Text('Profil Saya'),
        elevation: 0.5, // Sedikit lebih halus dari 1.0
        automaticallyImplyLeading: Navigator.canPop(context),
      ),
      backgroundColor: Theme.of(context).scaffoldBackgroundColor, // Gunakan warna background dari tema
      body: FutureBuilder<User>(
        future: _userProfileFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            print("ProfileScreen FutureBuilder: Waiting...");
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            print("ProfileScreen FutureBuilder: Error - ${snapshot.error}");
            return Center(
              child: Padding(
                padding: const EdgeInsets.all(20.0),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(Icons.error_outline_rounded, color: Colors.red.shade400, size: 60),
                    const SizedBox(height: 15),
                    Text(
                      'Gagal memuat data profil Anda.\n(${snapshot.error.toString().replaceFirst("Exception: ", "")})',
                      textAlign: TextAlign.center,
                      style: TextStyle(color: Colors.red.shade700, fontSize: 16),
                    ),
                    const SizedBox(height: 20),
                    ElevatedButton.icon(
                      icon: const Icon(Icons.refresh_rounded),
                      label: const Text("Coba Lagi"),
                      onPressed: _loadUserProfile,
                    )
                  ],
                ),
              ),
            );
          } else if (snapshot.hasData) {
            final user = snapshot.data!;
            print("ProfileScreen FutureBuilder: Data received - User: ${user.name}");
            return _buildProfileContentView(user);
          } else {
            print("ProfileScreen FutureBuilder: No data and no error (snapshot data is null).");
            // Ini bisa terjadi jika future selesai tapi data null (jarang jika API mengembalikan error)
            return const Center(child: Text('Tidak ada data profil untuk ditampilkan.'));
          }
        },
      ),
    );
  }
}