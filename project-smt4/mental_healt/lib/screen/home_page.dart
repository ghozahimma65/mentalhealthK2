// Nama file: home_page.dart

import 'package:flutter/material.dart';
import 'package:sp_util/sp_util.dart';
import 'package:mobile_project/screen/riwayat_hasil_tes.dart'; // Import RiwayatHasilTesScreen
import 'package:mobile_project/screen/TesDiagnosaScreen.dart'; // Ganti '/kuis' jika KuisScreen adalah TesDiagnosaScreen
import 'package:mobile_project/screen/tes_info_screen.dart'; // Tes Perkembangan
import 'package:mobile_project/screen/profile_screen.dart'; // My Profile
import 'package:mobile_project/screen/meditation_screen.dart'; // Meditasi
import 'package:mobile_project/screen/quotes_screen.dart'; // Quotes
import 'package:mobile_project/screen/rencana_screen.dart'; // Rencana/Self Care

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  // Variabel 'name' sudah tidak diperlukan di sini karena akan diakses di _HomePageContent
  // String? name = SpUtil.getString('nama');
  int _selectedIndex = 0;

  // DAFTAR LAYAR YANG AKAN DITAMPILKAN PADA BOTTOM NAVIGATION BAR
  final List<Widget> _screens = <Widget>[
    _HomePageContent(), // Index 0: Home Page Content
    const TesInfoScreen(), // Index 1: Tes Perkembangan
    const TesDiagnosaScreen(), // Index 2: Tes Diagnosa (asumsi ini layar yang benar)
    const RiwayatHasilTesScreen(), // Index 3: Hasil Tes
    const ProfileScreen(), // Index 4: My Profile
  ];

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _screens[_selectedIndex],
      bottomNavigationBar: BottomNavigationBar(
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(icon: Icon(Icons.home_filled), label: 'Home'),
          BottomNavigationBarItem(
              icon: Icon(Icons.insights_rounded), label: 'Tes Perkembangan'),
          BottomNavigationBarItem(
              icon: Icon(Icons.play_circle_outline), label: 'Tes Diagnosa'),
          BottomNavigationBarItem(
              icon: Icon(Icons.library_books_outlined), label: 'Hasil Tes'),
          BottomNavigationBarItem(
              icon: Icon(Icons.person_outline), label: 'My Profile'),
        ],
        currentIndex: _selectedIndex,
        selectedItemColor: Colors.deepPurple,
        unselectedItemColor: Colors.grey,
        showUnselectedLabels: true,
        type: BottomNavigationBarType.fixed,
        onTap: _onItemTapped,
        elevation: 5.0,
        backgroundColor: Colors.white,
      ),
    );
  }
}

// Widget terpisah untuk konten halaman utama
class _HomePageContent extends StatelessWidget {
  _HomePageContent({Key? key}) : super(key: key);

  // Pindahkan akses SpUtil.getString('nama') ke sini
  final String? name = SpUtil.getString('nama');

  // Metode untuk menangani tap pada kartu fitur di halaman Home
  void _handleFeatureCardTap(
      BuildContext context, String featureName, String routeName) {
    print('$featureName card tapped, navigating to $routeName');
    Navigator.pushNamed(context, routeName);
  }

  Widget _buildGridItemCard({
    required BuildContext context, // Tetap lewatkan context untuk onPressed
    required String title,
    String? subtitle,
    IconData? iconData,
    String? imagePath,
    required Gradient gradient,
    required String routeName,
    bool isImageLarge = false,
  }) {
    return Card(
      elevation: 2.5,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      clipBehavior: Clip.antiAlias,
      child: InkWell(
        onTap: () => _handleFeatureCardTap(context, title, routeName),
        borderRadius: BorderRadius.circular(10),
        child: Container(
          decoration: BoxDecoration(gradient: gradient),
          padding: const EdgeInsets.all(8),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              if (imagePath != null)
                Padding(
                  padding: const EdgeInsets.only(bottom: 5.0),
                  child: Image.asset(
                    imagePath,
                    height: isImageLarge ? 32 : 26,
                    width: isImageLarge ? 32 : 26,
                    fit: BoxFit.contain,
                    errorBuilder: (context, error, stackTrace) => Icon(
                      iconData ?? Icons.help_outline,
                      size: isImageLarge ? 32 : 26,
                      color: Colors.white70,
                    ),
                  ),
                )
              else if (iconData != null)
                Padding(
                  padding: const EdgeInsets.only(bottom: 5.0),
                  child: Icon(iconData, size: isImageLarge ? 32 : 26, color: Colors.white),
                ),
              Text(
                title,
                textAlign: TextAlign.center,
                style: const TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.bold,
                    color: Colors.white),
                maxLines: 2,
                overflow: TextOverflow.ellipsis,
              ),
              if (subtitle != null && subtitle.isNotEmpty) ...[
                const SizedBox(height: 1),
                Text(
                  subtitle,
                  textAlign: TextAlign.center,
                  style: TextStyle(
                      fontSize: 8,
                      color: Colors.white.withOpacity(0.8)),
                  maxLines: 2,
                  overflow: TextOverflow.ellipsis,
                ),
              ],
            ],
          ),
        ),
      ),
    );
  }


  // --- DEFINISI HELPER WIDGET YANG SUDAH ADA (TETAP SAMA) ---
  Widget _buildHeader(BuildContext context) { // Tambahkan context sebagai parameter
    return Padding(
      padding: const EdgeInsets.only(left: 16.0, right: 16.0, top: 16.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          const CircleAvatar(
            radius: 22,
            backgroundColor: Color(0xFFE8EAF6),
            child:
                Icon(Icons.person_outline, color: Color(0xFF7E57C2), size: 26),
          ),
          IconButton(
            icon: const Icon(Icons.notifications_none_outlined,
                color: Colors.black54, size: 28),
            onPressed: () {/* Aksi notifikasi */},
          ),
        ],
      ),
    );
  }

  // >>> PERBAIKAN DI SINI <<<
  Widget _buildGreeting(BuildContext context) { // Tambahkan context sebagai parameter
    String? userName = name ?? "";
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text('Hello, $userName',
              style: Theme.of(context).textTheme.headlineMedium?.copyWith(
                  fontWeight: FontWeight.bold, color: Colors.black87)),
          const SizedBox(height: 5),
          Text('Bagaimana perasaanmu hari ini?',
              style: Theme.of(context)
                  .textTheme
                  .titleMedium
                  ?.copyWith(color: Colors.grey.shade700)),
        ],
      ),
    );
  }

  Widget _buildSearchBar(BuildContext context) { // Tambahkan context sebagai parameter
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 10.0),
      child: TextField(
        decoration: InputDecoration(
          hintText: 'Search..',
          hintStyle: TextStyle(color: Colors.grey.shade500),
          prefixIcon:
              Icon(Icons.search_rounded, color: Colors.grey.shade500, size: 24),
          filled: true,
          fillColor: Colors.grey.shade100,
          contentPadding:
              const EdgeInsets.symmetric(vertical: 16.0, horizontal: 20.0),
          border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(30.0),
              borderSide: BorderSide.none),
          enabledBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(30.0),
              borderSide: BorderSide.none),
          focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(30.0),
              borderSide:
                  BorderSide(color: Colors.deepPurple.shade300, width: 1.5)),
        ),
      ),
    );
  }

  Widget _buildAffirmationCard(BuildContext context) { // Tambahkan context sebagai parameter
    const String affirmation =
        "Setiap langkah kecilmu adalah kemajuan yang berarti.";
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 25),
        decoration: BoxDecoration(
          gradient: LinearGradient(
              colors: [Colors.deepPurple.shade400, Colors.deepPurple.shade600],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight),
          borderRadius: BorderRadius.circular(18.0),
          boxShadow: [
            BoxShadow(
                color: Colors.deepPurple.withOpacity(0.25),
                spreadRadius: 2,
                blurRadius: 8,
                offset: const Offset(0, 4))
          ],
        ),
        child: Row(
          children: [
            Icon(Icons.lightbulb_outline_rounded,
                color: Colors.white.withOpacity(0.8), size: 32),
            const SizedBox(width: 15),
            Expanded(
              child: Text(affirmation,
                  style: const TextStyle(
                      fontSize: 15,
                      color: Colors.white,
                      height: 1.5,
                      fontWeight: FontWeight.w500)),
            ),
          ],
        ),
      ),
    );
  }


  @override
  Widget build(BuildContext context) { // Context sudah tersedia di sini
    return SafeArea(
      child: ListView(
        padding: const EdgeInsets.only(bottom: 20.0),
        children: [
          _buildHeader(context), // Panggil dengan context
          const SizedBox(height: 20),
          _buildGreeting(context), // Panggil dengan context
          const SizedBox(height: 20),
          _buildSearchBar(context), // Panggil dengan context
          const SizedBox(height: 25),

          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16.0),
            child: GridView.count(
              crossAxisCount: 2,
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              crossAxisSpacing: 8,
              mainAxisSpacing: 8,
              childAspectRatio: 1.4,
              children: [
                _buildGridItemCard(
                  context: context,
                  title: 'Mental Health',
                  subtitle: 'Cek kondisi mental',
                  imagePath: 'assets/images/mental_health_illustration.png',
                  isImageLarge: true,
                  gradient: LinearGradient(
                      colors: [Colors.deepPurple.shade400, Colors.deepPurple.shade600],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight),
                  routeName: '/kuis',
                ),
                _buildGridItemCard(
                  context: context,
                  title: 'Meditasi',
                  subtitle: 'Temukan tenang',
                  iconData: Icons.self_improvement_rounded,
                  gradient: const LinearGradient(
                      colors: [Color(0xFF6A1B9A), Color(0xFF8E24AA)],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight),
                  routeName: '/meditasi',
                ),
                _buildGridItemCard(
                  context: context,
                  title: 'Quotes',
                  subtitle: 'Inspirasi harian',
                  iconData: Icons.format_quote_rounded,
                  gradient: const LinearGradient(
                      colors: [Color(0xFF00796B), Color(0xFF00897B)],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight),
                  routeName: '/quotes',
                ),
                _buildGridItemCard(
                  context: context,
                  title: 'Self Care',
                  subtitle: 'Jadwalkan aktivitas',
                  iconData: Icons.event_note_rounded,
                  gradient: const LinearGradient(
                      colors: [Color(0xFFEF6C00), Color(0xFFF57C00)],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight),
                  routeName: '/rencana',
                ),
              ],
            ),
          ),

          const SizedBox(height: 30),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16.0),
            child: Text(
              'Pengingat Untukmu',
              style: Theme.of(context).textTheme.titleLarge?.copyWith(
                    fontWeight: FontWeight.bold,
                    color: Colors.black.withOpacity(0.8),
                  ),
            ),
          ),
          const SizedBox(height: 15),
          _buildAffirmationCard(context), // Panggil dengan context
          const SizedBox(height: 20),
        ],
      ),
    );
  }
}