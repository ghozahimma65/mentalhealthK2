// lib/screen/profile_screen.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart'; // Digunakan untuk dialog dan navigasi Get.offAllNamed
import 'package:shared_preferences/shared_preferences.dart';
import '../services/auth_service.dart'; // Sesuaikan path jika perlu

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({super.key});

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  String _userName = "Pengguna"; // Nilai default
  String _userEmail = "email@example.com"; // Nilai default
  bool _isLoading = true;

  // Instance AuthService untuk menggunakan metode logout
  final AuthService _authService = AuthService();

  @override
  void initState() {
    super.initState();
    _loadUserData();
  }

  Future<void> _loadUserData() async {
    if (!mounted) return; // Pastikan widget masih ada di tree
    setState(() {
      _isLoading = true;
    });
    final prefs = await SharedPreferences.getInstance();
    if (!mounted) return; // Cek lagi setelah await
    setState(() {
      // Mengambil data pengguna yang disimpan oleh AuthService saat login
      _userName = prefs.getString('user_name') ?? "Pengguna";
      _userEmail = prefs.getString('user_email') ?? "email@example.com";
      _isLoading = false;
    });
  }

  // Widget untuk bagian header profil yang sudah dimodifikasi
  Widget _buildProfileHeader(BuildContext context) {
    if (_isLoading) {
      return const Padding(
        padding: EdgeInsets.symmetric(vertical: 40.0),
        child: Center(child: CircularProgressIndicator()),
      );
    }
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 24.0, horizontal: 16.0),
      margin: const EdgeInsets.only(bottom: 24.0, top: 10.0),
      decoration: BoxDecoration(
        color: Theme.of(context).cardColor,
        borderRadius: BorderRadius.circular(16.0),
        boxShadow: [
          BoxShadow(
            color: Theme.of(context).shadowColor.withOpacity(0.05),
            spreadRadius: 1,
            blurRadius: 8,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          // Foto profil dihilangkan
          const SizedBox(height: 8),
          Text(
            _userName, // Menampilkan nama pengguna dinamis
            style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                  fontWeight: FontWeight.bold,
                  color: Theme.of(context).textTheme.titleLarge?.color
                ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 6.0),
          Text(
            _userEmail, // Menampilkan email pengguna dinamis
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                  color: Colors.grey.shade600,
                ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 8),
          // Username handle dan tombol edit dihilangkan
        ],
      ),
    );
  }

  // Helper widget untuk membuat item menu
  Widget _buildSettingsTile({
    required BuildContext context,
    required IconData icon,
    required String title,
    VoidCallback? onTap,
    Color? iconColor,
    Color? textColor,
    bool showArrow = true,
  }) {
    return ListTile(
      leading: CircleAvatar(
        radius: 22,
        backgroundColor: (iconColor ?? Theme.of(context).colorScheme.primaryContainer).withOpacity(0.7),
        child: Icon(icon, color: iconColor ?? Theme.of(context).colorScheme.onPrimaryContainer, size: 22),
      ),
      title: Text(title, style: TextStyle(fontWeight: FontWeight.w500, color: textColor ?? Theme.of(context).textTheme.bodyLarge?.color, fontSize: 16)),
      trailing: showArrow ? Icon(Icons.chevron_right, color: Colors.grey.shade500) : null,
      onTap: onTap,
      contentPadding: const EdgeInsets.symmetric(vertical: 6.0, horizontal: 8.0),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
    );
  }

  // Fungsi untuk menampilkan Snackbar jika fitur belum ada
  void _showFeatureNotAvailableSnackbar(String featureName) {
    if (!mounted) return;
    Get.snackbar(
      'Segera Hadir',
      'Fitur $featureName belum tersedia saat ini.',
      snackPosition: SnackPosition.BOTTOM,
      backgroundColor: Colors.grey.shade800,
      colorText: Colors.white,
      margin: const EdgeInsets.all(10),
      borderRadius: 8,
      duration: const Duration(seconds: 2),
    );
  }

  // Fungsi untuk menangani logout
  void _handleLogout() {
    Get.defaultDialog(
        title: "Konfirmasi Logout",
        middleText: "Anda yakin ingin keluar dari akun ini?",
        titleStyle: Get.textTheme.titleLarge?.copyWith(color: Theme.of(context).textTheme.bodyLarge?.color),
        middleTextStyle: Get.textTheme.bodyMedium?.copyWith(color: Theme.of(context).textTheme.bodySmall?.color),
        textConfirm: "Logout",
        textCancel: "Batal",
        cancelTextColor: Get.isDarkMode ? Colors.white70 : Colors.black87,
        confirmTextColor: Colors.white,
        buttonColor: Colors.redAccent.shade400,
        backgroundColor: Theme.of(context).dialogBackgroundColor,
        barrierDismissible: false,
        radius: 15.0,
        onConfirm: () async {
          await _authService.logout(); // Panggil method logout dari AuthService
          print('User logged out, navigating to login.');
          if (mounted) {
            Get.offAllNamed('/login'); // Pastikan rute '/login' terdaftar
          }
           Get.snackbar(
            "Logout Berhasil",
            "Anda telah keluar.",
            snackPosition: SnackPosition.BOTTOM,
            backgroundColor: Colors.green,
            colorText: Colors.white,
          );
        },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Profil Saya'),
        elevation: 0.8,
        centerTitle: true,
        automaticallyImplyLeading: false, // Menghilangkan tombol back otomatis
      ),
      body: RefreshIndicator(
        onRefresh: _loadUserData, // Memanggil _loadUserData saat refresh
        child: ListView(
          padding: const EdgeInsets.symmetric(vertical: 10.0, horizontal: 16.0),
          children: [
            _buildProfileHeader(context),

            // Opsi "Ubah Kata Sandi" dan "Pengaturan Notifikasi" dihilangkan

            // --- Informasi & Bantuan ---
            Padding(
              padding: const EdgeInsets.only(top: 16.0, bottom: 8.0, left: 8.0, right: 8.0),
              child: Text('Informasi & Bantuan',
                  style: Theme.of(context).textTheme.titleSmall?.copyWith(
                        color: Colors.grey.shade700,
                        fontWeight: FontWeight.w600,
                      )),
            ),
            Card(
              elevation: 1.0,
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
              child: Column(
                children: [
                  _buildSettingsTile(
                      context: context,
                      icon: Icons.help_outline_rounded,
                      title: 'Bantuan & Dukungan',
                      onTap: () {
                        // Ganti dengan navigasi jika halaman sudah ada
                        // Contoh: Get.toNamed('/bantuan');
                        _showFeatureNotAvailableSnackbar('Bantuan & Dukungan');
                      }),
                  const Divider(height: 0, indent: 70, endIndent: 16),
                  _buildSettingsTile(
                      context: context,
                      icon: Icons.info_outline_rounded,
                      title: 'Tentang Aplikasi',
                      onTap: () {
                        // Contoh: Get.toNamed('/tentang_aplikasi');
                        _showFeatureNotAvailableSnackbar('Tentang Aplikasi');
                      }),
                  const Divider(height: 0, indent: 70, endIndent: 16),
                  _buildSettingsTile(
                      context: context,
                      icon: Icons.privacy_tip_outlined,
                      title: 'Kebijakan Privasi',
                      onTap: () {
                        // Contoh: Get.toNamed('/kebijakan_privasi');
                        _showFeatureNotAvailableSnackbar('Kebijakan Privasi');
                      }),
                ],
              ),
            ),
            const SizedBox(height: 24),

            // --- Logout ---
            Card(
               elevation: 1.0,
               shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
               child: _buildSettingsTile(
                context: context,
                icon: Icons.logout_rounded,
                title: 'Logout',
                iconColor: Colors.redAccent.shade400,
                textColor: Colors.redAccent.shade400,
                showArrow: false,
                onTap: _handleLogout,
              ),
            ),
            const SizedBox(height: 20),
          ],
        ),
      ),
    );
  }
}