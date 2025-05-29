// Nama file: home_page.dart
import 'package:flutter/material.dart';
import 'package:sp_util/sp_util.dart';

// Diasumsikan file layar tujuan navigasi sudah ada dan route terdaftar
// di main.dart

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  String? name = SpUtil.getString('nama');
  int _selectedIndex = 0;

  void _onItemTapped(int index) {
    String? routeName;
    switch (index) {
      case 0: // Home
        if (ModalRoute.of(context)?.settings.name == '/homepage' ||
            ModalRoute.of(context)?.settings.name == '/') {
          print("Already on Home");
        } else {
          Navigator.popUntil(context, (route) => route.isFirst);
        }
        break;
      case 1: // Tes Perkembangan (Penilaian Diri)
        routeName = '/tesperkembangan';
        break;
      case 2: // Tes Diagnosa
        routeName = '/kuis';
        break;
      case 3: // Hasil Tes
        routeName = '/hasil';
        break;
      case 4: // My Profile
        routeName = '/profile';
        break;
      default:
        print("Invalid index: $index");
    }

    if (routeName != null) {
      print("Navigating to $routeName from current index $_selectedIndex to $index");
      if (ModalRoute.of(context)?.settings.name != '/homepage' &&
          ModalRoute.of(context)?.settings.name != '/') {
        Navigator.popUntil(context, (route) => route.isFirst);
      }
      Navigator.pushNamed(
        context,
        routeName,
        arguments: routeName == '/kuis' ? 'mental_health' : null,
      );
    }
    setState(() {
      _selectedIndex = index;
    });
  }

  void _handleFeatureCardTap(
      BuildContext context, String featureName, String routeName) {
    print('$featureName card tapped, navigating to $routeName');
    Navigator.pushNamed(context, routeName);
  }

  Widget _buildGridItemCard({
    required BuildContext context,
    required String title,
    String? subtitle,
    IconData? iconData,
    String? imagePath,
    required Gradient gradient,
    required String routeName,
    bool isImageLarge = false,
  }) {
    return Card(
      elevation: 2.5, // Elevation yang cukup
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)), // Border radius lebih kecil
      clipBehavior: Clip.antiAlias,
      child: InkWell(
        onTap: () => _handleFeatureCardTap(context, title, routeName),
        borderRadius: BorderRadius.circular(10),
        child: Container(
          decoration: BoxDecoration(gradient: gradient),
          padding: const EdgeInsets.all(8), // Padding internal kartu DIKURANGI LAGI
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center, // Konten di tengah vertikal
            crossAxisAlignment: CrossAxisAlignment.center, // Konten di tengah horizontal
            children: [
              if (imagePath != null)
                Padding(
                  padding: const EdgeInsets.only(bottom: 5.0), // Jarak dikurangi
                  child: Image.asset(
                    imagePath,
                    height: isImageLarge ? 32 : 26, // Ukuran gambar/ikon DIKURANGI LAGI
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
                  padding: const EdgeInsets.only(bottom: 5.0), // Jarak dikurangi
                  child: Icon(iconData, size: isImageLarge ? 32 : 26, color: Colors.white), // Ukuran ikon DIKURANGI LAGI
                ),
              Text(
                title,
                textAlign: TextAlign.center,
                style: const TextStyle(
                    fontSize: 12, // Ukuran font judul DIKURANGI LAGI
                    fontWeight: FontWeight.bold,
                    color: Colors.white),
                maxLines: 2,
                overflow: TextOverflow.ellipsis,
              ),
              if (subtitle != null && subtitle.isNotEmpty) ...[
                const SizedBox(height: 1), // Jarak subjudul sangat kecil
                Text(
                  subtitle,
                  textAlign: TextAlign.center,
                  style: TextStyle(
                      fontSize: 8, // Ukuran font subtitle DIKURANGI LAGI
                      color: Colors.white.withOpacity(0.8)),
                  maxLines: 2, // Subtitle bisa 2 baris jika perlu, tapi akan memakan tempat
                  overflow: TextOverflow.ellipsis,
                ),
              ],
            ],
          ),
        ),
      ),
    );
  }


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: ListView(
          padding: const EdgeInsets.only(bottom: 20.0),
          children: [
            _buildHeader(),
            const SizedBox(height: 20),
            _buildGreeting(),
            const SizedBox(height: 20),
            _buildSearchBar(),
            const SizedBox(height: 25),

            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16.0),
              child: GridView.count(
                crossAxisCount: 2,
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                crossAxisSpacing: 8, // Jarak antar kolom DIKURANGI LAGI
                mainAxisSpacing: 8,  // Jarak antar baris DIKURANGI LAGI
                childAspectRatio: 1.4, // NAIKKAN LAGI rasio aspek (misal 1.4 atau 1.5)
                                       // Semakin besar, kartu semakin pendek
                children: [
                  _buildGridItemCard(
                    context: context,
                    title: 'Mental Health',
                    subtitle: 'Cek kondisi mental', // Subtitle lebih singkat
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
            _buildAffirmationCard(),
            const SizedBox(height: 20),
          ],
        ),
      ),
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

  // --- DEFINISI HELPER WIDGET YANG SUDAH ADA (TETAP SAMA) ---
  Widget _buildHeader() {
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

  Widget _buildGreeting() {
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

  Widget _buildSearchBar() {
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

  Widget _buildMentalHealthCard() {
    // Definisi asli _buildMentalHealthCard Anda
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Container(
        padding: const EdgeInsets.all(20),
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
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            const Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text('Mental Health',
                      style: TextStyle(
                          fontSize: 19,
                          fontWeight: FontWeight.bold,
                          color: Colors.white)),
                  SizedBox(height: 8),
                  Text('Cek Mental Health kamu sekarang!',
                      style: TextStyle(
                          fontSize: 14, color: Colors.white70, height: 1.4)),
                ],
              ),
            ),
            const SizedBox(width: 10),
            Image.asset(
              'assets/images/mental_health_illustration.png',
              height: 95, width: 95, fit: BoxFit.contain,
              errorBuilder: (context, error, stackTrace) => Container(
                  height: 95,
                  width: 95,
                  decoration: BoxDecoration(
                      color: Colors.white.withOpacity(0.15),
                      borderRadius: BorderRadius.circular(10)),
                  child: Icon(Icons.psychology_alt_outlined,
                      color: Colors.white.withOpacity(0.6), size: 45)),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildFeatureCard({
    required BuildContext context,
    required String title,
    required String subtitle,
    required IconData iconData,
    required Gradient gradient,
    required String routeName,
  }) {
    // Definisi asli _buildFeatureCard Anda
     return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: InkWell(
        onTap: () => _handleFeatureCardTap(context, title, routeName),
        borderRadius: BorderRadius.circular(18.0),
        child: Container(
          padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 25),
          decoration: BoxDecoration(
            gradient: gradient,
            borderRadius: BorderRadius.circular(18.0),
            boxShadow: [
              BoxShadow(
                  color: Colors.black.withOpacity(0.1),
                  spreadRadius: 1,
                  blurRadius: 5,
                  offset: const Offset(0, 3))
            ],
          ),
          child: Row(
            children: [
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(title,
                        style: const TextStyle(
                            fontSize: 17,
                            fontWeight: FontWeight.bold,
                            color: Colors.white)),
                    const SizedBox(height: 6),
                    Text(subtitle,
                        style: TextStyle(
                            fontSize: 13,
                            color: Colors.white.withOpacity(0.9))),
                  ],
                ),
              ),
              const SizedBox(width: 15),
              Icon(iconData, color: Colors.white.withOpacity(0.9), size: 36),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildAffirmationCard() {
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
}