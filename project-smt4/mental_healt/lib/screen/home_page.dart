// Nama file: home_page.dart
import 'package:flutter/material.dart';
import 'package:sp_util/sp_util.dart';

// Diasumsikan file layar tujuan navigasi sudah ada dan route terdaftar
// di main.dart (/tesdiagnosa -> diganti /kuis, /hasil, /profile, /meditasi, /quotes, /rencana)
// DAN SEKARANG TAMBAH /tesperkembangan UNTUK SCREEN BARU

class HomePage extends StatefulWidget {
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  String? name = SpUtil.getString('nama');
  int _selectedIndex = 0; // Indeks untuk BottomNavigationBar

  // Handler untuk klik item Bottom Navigation Bar
  void _onItemTapped(int index) {
    // Jika item yang sama diklik lagi (kecuali home), tidak melakukan apa-apa
    // Untuk home, kita biarkan agar bisa "refresh" atau kembali ke state awal home jika diperlukan
    // if (_selectedIndex == index && index != 0) return; // Logika ini bisa disesuaikan

    String? routeName;
    switch (index) {
      case 0: // Home
        // Jika sudah di HomePage dan tombol Home ditekan, mungkin tidak perlu navigasi ulang
        // atau bisa scroll ke atas jika itu diinginkan.
        // Untuk saat ini, jika sudah di home, kita tidak melakukan pushNamed.
        if (ModalRoute.of(context)?.settings.name == '/homepage' ||
            ModalRoute.of(context)?.settings.name == '/') {
          print("Already on Home");
          // Set state tetap dilakukan untuk update highlight
        } else {
          // Jika tidak sedang di HomePage, pop sampai root lalu push /homepage atau hanya popUntil root
          Navigator.popUntil(context, (route) => route.isFirst);
          // Jika aplikasi Anda menggunakan '/' sebagai rute home di main.dart, sesuaikan.
          // Navigator.pushNamed(context, '/homepage');
        }
        break;
      case 1: // Tes Perkembangan (ITEM BARU)
        routeName =
            '/tesperkembangan'; // Pastikan route ini terdaftar di main.dart
        break;
      case 2: // Tes Diagnosa (sebelumnya indeks 1)
        routeName =
            '/kuis'; // Tetap menggunakan '/kuis' sesuai kode asli Anda untuk Tes Diagnosa
        break;
      case 3: // Hasil Tes (sebelumnya indeks 2)
        routeName = '/hasil';
        break;
      case 4: // My Profile (sebelumnya indeks 3)
        routeName = '/profile';
        break;
      default:
        print("Invalid index: $index");
    }

    if (routeName != null) {
      print(
          "Navigating to $routeName from current index $_selectedIndex to $index");
      // Cek jika kita tidak di HomePage sebelum popUntil (jika navigasi dari item non-home ke item non-home lain)
      // Atau jika kita ingin selalu kembali ke root sebelum push route baru dari bottom nav
      if (ModalRoute.of(context)?.settings.name != '/homepage' &&
          ModalRoute.of(context)?.settings.name != '/') {
        Navigator.popUntil(context, (route) => route.isFirst);
      }
      Navigator.pushNamed(
        context,
        routeName,
        arguments:
            routeName == '/kuis' ? 'mental_health' : null, // hanya untuk kuis
      );
    }
    // Update index terpilih untuk highlight bottom nav
    // Ini harus selalu dijalankan agar UI bottom nav terupdate
    setState(() {
      _selectedIndex = index;
    });
  }

  // Handler untuk klik kartu fitur (pindah ke halaman lain)
  void _handleFeatureCardTap(
      BuildContext context, String featureName, String routeName) {
    print('$featureName card tapped, navigating to $routeName');
    Navigator.pushNamed(context, routeName);
  }

  @override
  Widget build(BuildContext context) {
    // Set _selectedIndex berdasarkan route saat ini jika memungkinkan,
    // ini membantu menjaga bottom nav tetap sinkron jika navigasi terjadi dari tempat lain.
    // Contoh sederhana:
    // final String? currentRouteName = ModalRoute.of(context)?.settings.name;
    // if (currentRouteName == '/tesperkembangan' && _selectedIndex != 1) {
    //   _selectedIndex = 1;
    // } else if (currentRouteName == '/kuis' && _selectedIndex != 2) {
    //   _selectedIndex = 2;
    // } // ... dan seterusnya. Ini bisa jadi lebih kompleks.

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
            _buildMentalHealthCard(),
            const SizedBox(height: 30),
            _buildFeatureCard(
              context: context,
              title: 'Meditasi',
              subtitle: 'Temukan ketenangan dalam diri',
              iconData: Icons.self_improvement_rounded,
              gradient: const LinearGradient(
                  colors: [Color(0xFF6A1B9A), Color(0xFF8E24AA)],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight),
              routeName: '/meditasi',
            ),
            const SizedBox(height: 15),
            _buildFeatureCard(
              context: context,
              title: 'Quotes & Affirmation',
              subtitle: 'Kutipan harian untuk inspirasi',
              iconData: Icons.format_quote_rounded,
              gradient: const LinearGradient(
                  colors: [Color(0xFF00796B), Color(0xFF00897B)],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight),
              routeName: '/quotes',
            ),
            const SizedBox(height: 15),
            _buildFeatureCard(
              context: context,
              title: 'Rencana Self Care',
              subtitle: 'Jadwalkan aktivitas baikmu',
              iconData: Icons.event_note_rounded,
              gradient: const LinearGradient(
                  colors: [Color(0xFFEF6C00), Color(0xFFF57C00)],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight),
              routeName: '/rencana',
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
          // ITEM BARU: Tes Perkembangan
          BottomNavigationBarItem(
              icon: Icon(Icons
                  .insights_rounded), // Ganti dengan ikon yang sesuai, misal Icons.insights_rounded atau Icons.analytics_outlined
              label: 'Tes Perkembangan'),
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

  // --- DEFINISI LENGKAP HELPER WIDGET (TETAP SAMA) ---

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
    String? userName = name ?? ""; // TODO: Ganti nama user
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
              'assets/images/mental_health_illustration.png', // <-- PASTIKAN PATH BENAR
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
        "Setiap langkah kecilmu adalah kemajuan yang berarti."; // TODO: Buat dinamis
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
} // Akhir _HomePageState
