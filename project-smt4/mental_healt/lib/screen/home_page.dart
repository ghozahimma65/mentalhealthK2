// Nama file: home_page.dart
import 'package:flutter/material.dart';

// Diasumsikan file layar tujuan navigasi sudah ada dan route terdaftar
// di main.dart (/tesdiagnosa, /hasil, /profile, /meditasi, /quotes, /rencana)

class HomePage extends StatefulWidget {
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  int _selectedIndex = 0; // Indeks untuk BottomNavigationBar

  // Handler untuk klik item Bottom Navigation Bar
  void _onItemTapped(int index) {
    if (_selectedIndex == index && index != 0) return;

    String? routeName;
    switch (index) {
      case 0: print("Navigating to Home"); break;
      case 1: routeName = '/kuis'; break;
      case 2: routeName = '/hasil'; break;
      case 3: routeName = '/profile'; break;
      default: print("Invalid index: $index");
    }

    if (routeName != null) {
       print("Navigating to $routeName");
       // Cek jika kita tidak di HomePage sebelum popUntil
       if (ModalRoute.of(context)?.settings.name != '/homepage') {
         // Jika tidak sedang di HomePage, pop sampai root
          Navigator.popUntil(context, (route) => route.isFirst);
       }
       // Navigasi ke route tujuan (jika kita sudah di home, ini akan push)
       Navigator.pushNamed(
    context,
    routeName,
    arguments: routeName == '/kuis' ? 'mental_health' : null, // hanya untuk kuis
  );
    }
     // Update index terpilih untuk highlight bottom nav
     setState(() { _selectedIndex = index; });
  }

  // Handler untuk klik kartu fitur (pindah ke halaman lain)
  void _handleFeatureCardTap(BuildContext context, String featureName, String routeName) {
    print('$featureName card tapped, navigating to $routeName');
    Navigator.pushNamed(context, routeName);
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
            _buildMentalHealthCard(), // Kartu utama Tes Mental Health
            const SizedBox(height: 30),

            // --- BAGIAN ICON MENU DIGANTI DENGAN KARTU FITUR ---
            // Pemanggilan _buildIconMenu() DIHAPUS dari sini

            // Panggil kartu fitur satu per satu
            _buildFeatureCard( // Kartu Meditasi
              context: context,
              title: 'Meditasi',
              subtitle: 'Temukan ketenangan dalam diri',
              iconData: Icons.self_improvement_rounded,
              gradient: const LinearGradient( colors: [Color(0xFF6A1B9A), Color(0xFF8E24AA)], begin: Alignment.topLeft, end: Alignment.bottomRight),
              routeName: '/meditasi',
            ),
            const SizedBox(height: 15), // Jarak antar kartu fitur

            _buildFeatureCard( // Kartu Quotes
              context: context,
              title: 'Quotes & Affirmation',
              subtitle: 'Kutipan harian untuk inspirasi',
              iconData: Icons.format_quote_rounded,
              gradient: const LinearGradient( colors: [Color(0xFF00796B), Color(0xFF00897B)], begin: Alignment.topLeft, end: Alignment.bottomRight),
              routeName: '/quotes',
            ),
             const SizedBox(height: 15), // Jarak antar kartu fitur

            _buildFeatureCard( // Kartu Rencana
              context: context,
              title: 'Rencana Self Care',
              subtitle: 'Jadwalkan aktivitas baikmu',
              iconData: Icons.event_note_rounded,
              gradient: const LinearGradient( colors: [Color(0xFFEF6C00), Color(0xFFF57C00)], begin: Alignment.topLeft, end: Alignment.bottomRight),
              routeName: '/rencana',
            ),
            // --- AKHIR BAGIAN KARTU FITUR ---

            const SizedBox(height: 30), // Jarak sebelum bagian afirmasi

            // Judul untuk bagian afirmasi
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
            _buildAffirmationCard(), // Kartu afirmasi ungu (dari kode Anda sebelumnya)
            const SizedBox(height: 20),
          ],
        ),
      ),
      bottomNavigationBar: BottomNavigationBar(
         items: const <BottomNavigationBarItem>[
           BottomNavigationBarItem(icon: Icon(Icons.home_filled), label: 'Home'),
           BottomNavigationBarItem(icon: Icon(Icons.play_circle_outline), label: 'Tes Diagnosa'),
           BottomNavigationBarItem(icon: Icon(Icons.library_books_outlined), label: 'Hasil Tes'),
           BottomNavigationBarItem(icon: Icon(Icons.person_outline), label: 'My Profile'),
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

  // --- DEFINISI LENGKAP HELPER WIDGET ---

  Widget _buildHeader() {
    // Implementasi lengkap _buildHeader Anda (dari kode yang Anda kirim)
    return Padding(
      padding: const EdgeInsets.only(left: 16.0, right: 16.0, top: 16.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          const CircleAvatar(
            radius: 22, backgroundColor: Color(0xFFE8EAF6),
            child: Icon(Icons.person_outline, color: Color(0xFF7E57C2), size: 26),
          ),
          IconButton(
            icon: const Icon(Icons.notifications_none_outlined, color: Colors.black54, size: 28),
            onPressed: () {/* Aksi notifikasi */},
          ),
        ],
      ),
    );
  }

  Widget _buildGreeting() {
    // Implementasi lengkap _buildGreeting Anda (dari kode yang Anda kirim)
    const String userName = "Dyahna"; // TODO: Ganti nama user
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text( 'Hello, $userName', style: Theme.of(context).textTheme.headlineMedium?.copyWith(fontWeight: FontWeight.bold, color: Colors.black87)),
          const SizedBox(height: 5),
          Text('Bagaimana perasaanmu hari ini?', style: Theme.of(context).textTheme.titleMedium?.copyWith(color: Colors.grey.shade700)),
        ],
      ),
    );
  }

  Widget _buildSearchBar() {
    // Implementasi lengkap _buildSearchBar Anda (dari kode yang Anda kirim)
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 10.0),
      child: TextField(
        decoration: InputDecoration(
          hintText: 'Search..', hintStyle: TextStyle(color: Colors.grey.shade500),
          prefixIcon: Icon(Icons.search_rounded, color: Colors.grey.shade500, size: 24),
          filled: true, fillColor: Colors.grey.shade100,
          contentPadding: const EdgeInsets.symmetric(vertical: 16.0, horizontal: 20.0),
          border: OutlineInputBorder( borderRadius: BorderRadius.circular(30.0), borderSide: BorderSide.none),
          enabledBorder: OutlineInputBorder( borderRadius: BorderRadius.circular(30.0), borderSide: BorderSide.none),
          focusedBorder: OutlineInputBorder( borderRadius: BorderRadius.circular(30.0), borderSide: BorderSide(color: Colors.deepPurple.shade300, width: 1.5)),
        ),
      ),
    );
  }

  Widget _buildMentalHealthCard() {
    // Implementasi lengkap _buildMentalHealthCard Anda (dari kode yang Anda kirim)
     return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Container(
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
          gradient: LinearGradient( colors: [Colors.deepPurple.shade400, Colors.deepPurple.shade600], begin: Alignment.topLeft, end: Alignment.bottomRight),
          borderRadius: BorderRadius.circular(18.0),
          boxShadow: [ BoxShadow( color: Colors.deepPurple.withOpacity(0.25), spreadRadius: 2, blurRadius: 8, offset: const Offset(0, 4)) ],
        ),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            const Expanded(
              child: Column( crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text( 'Mental Health', style: TextStyle(fontSize: 19, fontWeight: FontWeight.bold, color: Colors.white)),
                  SizedBox(height: 8),
                  Text( 'Cek Mental Health kamu sekarang!', style: TextStyle(fontSize: 14, color: Colors.white70, height: 1.4)),
                  // Tombol tidak ada di desain asli kartu ini
                ],
              ),
            ),
             const SizedBox(width: 10),
             Image.asset( 'assets/images/mental_health_illustration.png', // <-- PASTIKAN PATH BENAR
               height: 95, width: 95, fit: BoxFit.contain,
               errorBuilder: (context, error, stackTrace) => Container( height: 95, width: 95, decoration: BoxDecoration(color: Colors.white.withOpacity(0.15), borderRadius: BorderRadius.circular(10)), child: Icon(Icons.psychology_alt_outlined, color: Colors.white.withOpacity(0.6), size: 45)),
             ),
          ],
        ),
      ),
    );
  }

  // --- FUNGSI BARU UNTUK KARTU FITUR ---
  Widget _buildFeatureCard({
    required BuildContext context,
    required String title,
    required String subtitle,
    required IconData iconData,
    required Gradient gradient,
    required String routeName,
  }) {
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
            boxShadow: [ BoxShadow( color: Colors.black.withOpacity(0.1), spreadRadius: 1, blurRadius: 5, offset: const Offset(0, 3)) ],
          ),
          child: Row(
            children: [
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text( title, style: const TextStyle(fontSize: 17, fontWeight: FontWeight.bold, color: Colors.white)),
                    const SizedBox(height: 6),
                    Text( subtitle, style: TextStyle(fontSize: 13, color: Colors.white.withOpacity(0.9))),
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
  // --- AKHIR FUNGSI KARTU FITUR ---

  // Fungsi Kartu Afirmasi (dari kode Anda sebelumnya)
  Widget _buildAffirmationCard() {
    const String affirmation = "Setiap langkah kecilmu adalah kemajuan yang berarti."; // TODO: Buat dinamis
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 25),
        decoration: BoxDecoration(
          gradient: LinearGradient( colors: [Colors.deepPurple.shade400, Colors.deepPurple.shade600], begin: Alignment.topLeft, end: Alignment.bottomRight),
          borderRadius: BorderRadius.circular(18.0),
          boxShadow: [ BoxShadow( color: Colors.deepPurple.withOpacity(0.25), spreadRadius: 2, blurRadius: 8, offset: const Offset(0, 4)) ],
        ),
        child: Row(
          children: [
            Icon(Icons.lightbulb_outline_rounded, color: Colors.white.withOpacity(0.8), size: 32),
            const SizedBox(width: 15),
            Expanded(
              child: Text( affirmation, style: const TextStyle(fontSize: 15, color: Colors.white, height: 1.5, fontWeight: FontWeight.w500)),
            ),
          ],
        ),
      ),
    );
  }

  // Fungsi _buildIconMenu dan _buildMenuIconItem sudah tidak dipanggil

} // Akhir _HomePageState