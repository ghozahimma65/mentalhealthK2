// Nama file: profile_screen.dart
import 'package:flutter/material.dart';

class ProfileScreen extends StatefulWidget {
  // Gunakan const jika widget ini tidak butuh parameter awal
  const ProfileScreen({super.key});

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  // State untuk switch Face ID / Touch ID
  bool _faceIdEnabled = false; // Nilai awal (bisa diambil dari setting nanti)

  // Helper widget untuk membuat satu baris menu/opsi
  Widget _buildSettingsTile({
    required IconData icon,
    required String title,
    String? subtitle, // Subtitle opsional
    Widget? trailing, // Widget di ujung kanan (Switch, Icon, dll)
    VoidCallback? onTap, // Aksi saat di-tap (opsional)
  }) {
    return ListTile(
      // Ikon di sebelah kiri
      leading: CircleAvatar( // Beri latar belakang pada ikon agar mirip desain
        radius: 22,
        backgroundColor: Colors.deepPurple.withOpacity(0.1),
        child: Icon(icon, color: Colors.deepPurple),
      ),
      // Judul Opsi
      title: Text(title, style: const TextStyle(fontWeight: FontWeight.w500)),
      // Subtitle Opsi (jika ada)
      subtitle: subtitle != null
          ? Text(subtitle, style: TextStyle(fontSize: 12, color: Colors.grey.shade600))
          : null,
      // Widget Trailing (jika ada)
      trailing: trailing,
      // Aksi onTap
      onTap: onTap ?? () {}, // Beri aksi kosong jika onTap null
      contentPadding: const EdgeInsets.symmetric(vertical: 4.0, horizontal: 0), // Atur padding vertikal
       dense: true, // Buat ListTile lebih rapat
    );
  }

  @override
  Widget build(BuildContext context) {
    // Data user dummy (ganti dengan data user asli dari state/database)
    const String userName = "Dyahna";
    const String userHandle = "@dyahnaa14";
    const String userImageUrl = 'assets/images/avatar_placeholder.png'; // GANTI DENGAN PATH AVATAR

    return Scaffold(
      // Tidak menggunakan AppBar standar agar judul "Profile" bisa di atas
      body: SafeArea(
        child: ListView( // Gunakan ListView agar bisa scroll
          padding: const EdgeInsets.symmetric(vertical: 20.0), // Padding atas & bawah
          children: [
            // Judul Halaman "Profile"
            const Padding(
              padding: EdgeInsets.symmetric(horizontal: 16.0),
              child: Text(
                'Profile',
                style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
              ),
            ),
            const SizedBox(height: 20),

            // Kartu Header Profil
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16.0),
              child: Container(
                padding: const EdgeInsets.all(16.0),
                decoration: BoxDecoration(
                  color: Colors.blue.shade300, // Warna biru sesuai gambar
                  borderRadius: BorderRadius.circular(10.0),
                   boxShadow: [
                      BoxShadow(
                        color: Colors.blue.withOpacity(0.2),
                        spreadRadius: 1,
                        blurRadius: 5,
                        offset: const Offset(0, 3),
                      ),
                   ]
                ),
                child: Row(
                  children: [
                    CircleAvatar(
                      radius: 30,
                      // Ganti dengan Image.network jika URL dari internet
                      backgroundImage: AssetImage(userImageUrl),
                       onBackgroundImageError: (exception, stackTrace) {
                         // Fallback jika gambar error
                         print("Error loading avatar: $exception");
                       },
                       // Fallback jika tidak ada background image
                       child: const Icon(Icons.person, size: 30, color: Colors.white70), // Tampilkan ikon jika gambar gagal
                    ),
                    const SizedBox(width: 15),
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          userName,
                          style: const TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                            color: Colors.white,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          userHandle,
                          style: TextStyle(
                            fontSize: 14,
                            color: Colors.white.withOpacity(0.9),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
            const SizedBox(height: 30),

            // --- Bagian Pengaturan Akun ---
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Judul Section (opsional, tidak ada di gambar tapi bisa ditambahkan)
                  // const Text('Account Settings', style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600)),
                  // const SizedBox(height: 10),

                  _buildSettingsTile(
                    icon: Icons.person_outline_rounded,
                    title: 'My Account',
                    subtitle: 'Make changes to your account',
                    // Trailing bisa berupa ikon notifikasi atau null
                    // trailing: Icon(Icons.error_outline, color: Colors.red, size: 18),
                    onTap: () {
                      print('My Account tapped');
                      // TODO: Navigasi ke halaman edit akun
                    },
                  ),
                  const Divider(height: 1), // Garis pemisah tipis
                  _buildSettingsTile(
                    icon: Icons.bookmark_border_rounded,
                    title: 'Saved Beneficiary',
                    subtitle: 'Manage your saved account',
                    onTap: () {
                      print('Saved Beneficiary tapped');
                      // TODO: Navigasi ke halaman beneficiary
                    },
                  ),
                   const Divider(height: 1),
                  _buildSettingsTile(
                    icon: Icons.face_retouching_natural_outlined, // Ikon Face ID
                    title: 'Face ID / Touch ID',
                    subtitle: 'Manage your device security',
                    trailing: Switch( // Widget Switch
                      value: _faceIdEnabled, // Ambil dari state
                      onChanged: (bool value) {
                        // Update state saat switch diubah
                        setState(() {
                          _faceIdEnabled = value;
                          // TODO: Simpan perubahan setting ini
                        });
                        print('Face ID/Touch ID toggled: $value');
                      },
                      activeColor: Colors.deepPurple, // Warna saat aktif
                    ),
                    // onTap untuk Switch biasanya tidak diperlukan, aksi ada di onChanged
                  ),
                   const Divider(height: 1),
                  _buildSettingsTile(
                    icon: Icons.security_outlined,
                    title: 'Two-Factor Authentication',
                    subtitle: 'Further secure your account for safety',
                    onTap: () {
                      print('Two-Factor Auth tapped');
                      // TODO: Navigasi ke halaman 2FA
                    },
                  ),
                   const Divider(height: 1),
                  _buildSettingsTile(
                    icon: Icons.logout_rounded,
                    title: 'Log out',
                    subtitle: 'Further secure your account for safety', // Subtitle ini mungkin perlu diganti
                    onTap: () {
                      print('Log out tapped');
                      // TODO: Implementasi logic logout
                      // Contoh: AuthService.logout().then((_) => Navigator.pushNamedAndRemoveUntil(context, '/login', (route) => false));
                       ScaffoldMessenger.of(context).showSnackBar(
                         const SnackBar(content: Text('Logout logic belum diimplementasikan.')),
                       );
                    },
                  ),
                ],
              ),
            ),
            const SizedBox(height: 30),

            // --- Bagian More ---
             Padding(
               padding: const EdgeInsets.symmetric(horizontal: 16.0),
               child: Column(
                 crossAxisAlignment: CrossAxisAlignment.start,
                 children: [
                    const Text(
                     'More',
                     style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600, color: Colors.grey),
                   ),
                   const SizedBox(height: 10),
                   _buildSettingsTile(
                     icon: Icons.help_outline_rounded,
                     title: 'Help & Support',
                     trailing: const Icon(Icons.chevron_right, color: Colors.grey),
                     onTap: () {
                       print('Help & Support tapped');
                       // TODO: Navigasi ke halaman bantuan
                     },
                   ),
                   const Divider(height: 1),
                   _buildSettingsTile(
                     icon: Icons.info_outline_rounded,
                     title: 'About App',
                      trailing: const Icon(Icons.chevron_right, color: Colors.grey),
                     onTap: () {
                       print('About App tapped');
                       // TODO: Navigasi ke halaman tentang aplikasi
                     },
                   ),
                 ],
               ),
             ),
             const SizedBox(height: 20), // Spasi di akhir list
          ],
        ),
      ),
      // Tidak perlu BottomNavigationBar di sini jika diakses dari HomePage
    );
  }
}