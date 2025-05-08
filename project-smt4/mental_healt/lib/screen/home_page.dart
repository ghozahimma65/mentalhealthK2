import 'package:flutter/material.dart';

// Pastikan Anda sudah mengimpor semua layar yang diperlukan di main.dart
// dan mendaftarkannya di 'routes'

// void main() { ... } // Asumsi main.dart sudah ada

// class MyApp extends StatelessWidget { ... } // Asumsi MyApp sudah ada

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  int _selectedIndex = 0; // Indeks untuk BottomNavigationBar (0 untuk Home)

  // Fungsi ini akan dipanggil ketika item BottomNavigationBar ditekan
  void _onItemTapped(int index) {
    // --- AWAL PERUBAHAN ---

    // 1. Cek apakah pengguna menekan tab yang sudah aktif
    //    Jika ya, tidak perlu lakukan navigasi lagi.
    if (_selectedIndex == index) {
      print("Already on tab index: $index"); // Pesan debug (opsional)
      return; // Keluar dari fungsi, tidak melakukan apa-apa
    }

    // 2. Update state untuk mengubah tampilan item yang aktif di BottomNavBar
    //    Penting: Pindahkan setState ke sini atau sebelum switch jika ingin
    //    highlight berubah *sebelum* navigasi dimulai.
    //    Jika diletakkan setelah switch, highlight baru berubah setelah
    //    kembali dari halaman lain (jika pakai push).
    //    Untuk konsistensi visual, biasanya ditaruh sebelum navigasi.
    setState(() {
      _selectedIndex = index;
    });


    // 3. Lakukan navigasi berdasarkan index yang ditekan
    switch (index) {
      case 0:
        // Index 0 adalah HomePage itu sendiri.
        // Biasanya tidak perlu navigasi jika sudah di HomePage.
        // Jika Anda menggunakan struktur halaman yang berbeda (misal body berubah
        // tanpa navigasi stack), Anda mungkin perlu logika lain di sini.
        print("Navigating to Home (already here or handled by state)");
        break;
      case 1:
        // Index 1 adalah 'Tes Diagnosa'
        print("Navigating to /kuis");
        // Gunakan pushNamed untuk navigasi ke route bernama '/tesdiagnosa'
        // Pengguna bisa kembali ke HomePage dengan tombol back.
        Navigator.pushNamed(context, '/kuis');
        break;
      case 2:
        // Index 2 adalah 'Hasil Tes'
        print("Navigating to /hasil");
        // Pastikan route '/hasil' sudah terdaftar di main.dart
        Navigator.pushNamed(context, '/hasil');
        break;
      case 3:
        // Index 3: My Profile -> Navigasi ke '/profile'
        print("Navigating to /profile"); // Pesan debug (opsional)
        Navigator.pushNamed(context, '/profile'); // Navigasi ke rute ProfileScreen
        break; // Penting: jangan lupa break
      default:
      // Seharusnya tidak terjadi jika item navbar hanya 4
       print("Error: Invalid index $index tapped.");
    }
    // --- AKHIR PERUBAHAN ---
  }


  @override
  Widget build(BuildContext context) {
    // Kode build method tetap sama seperti yang Anda berikan sebelumnya
    return Scaffold(
      body: SafeArea(
        child: ListView(
          padding: EdgeInsets.symmetric(vertical: 16.0),
          children: [
            _buildHeader(),
            SizedBox(height: 20),
            _buildGreeting(),
            SizedBox(height: 20),
            _buildSearchBar(),
            SizedBox(height: 25),
            _buildMentalHealthCard(),
            SizedBox(height: 30),
            _buildIconMenu(),
            SizedBox(height: 30),
            _buildRecommendationSection(),
            SizedBox(height: 20),
          ],
        ),
      ),
      bottomNavigationBar: BottomNavigationBar(
        // Konfigurasi BottomNavigationBar tetap sama
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(
            icon: Icon(Icons.home_filled),
            label: 'Home',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.play_circle_outline),
            label: 'Tes Diagnosa', // Index 1
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.library_books_outlined),
            label: 'Hasil Tes', // Index 2
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.person_outline),
            label: 'My Profile', // Index 3
          ),
        ],
        currentIndex: _selectedIndex, // Tetap gunakan _selectedIndex
        selectedItemColor: Colors.deepPurple,
        unselectedItemColor: Colors.grey,
        showUnselectedLabels: true,
        type: BottomNavigationBarType.fixed,
        onTap: _onItemTapped, // Tetap panggil _onItemTapped
        elevation: 5.0,
        backgroundColor: Colors.white,
      ),
    );
  }

  // --- Widget helper (_buildHeader, _buildGreeting, dst.) tetap sama ---
  // --- Pastikan widget-widget ini ada di bawah sini ---
  Widget _buildHeader() {
     // ... (kode _buildHeader Anda)
     return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              CircleAvatar(
                radius: 20,
                backgroundColor: Colors.grey.shade300,
                child: Icon(Icons.person, color: Colors.deepPurple, size: 24),
              ),
              SizedBox(width: 10),
            ],
          ),
          IconButton(
            icon:
                Icon(Icons.notifications_none, color: Colors.black54, size: 28),
            onPressed: () {},
          ),
        ],
      ),
    );
   }

   Widget _buildGreeting() {
     // ... (kode _buildGreeting Anda)
      return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'Hello, Dyahna', // Ganti dengan nama user
            style: TextStyle(
              fontSize: 24,
              fontWeight: FontWeight.bold,
              color: Colors.black87,
            ),
          ),
          SizedBox(height: 5),
          Text(
            'Bagaimana perasaanmu hari ini?',
            style: TextStyle(
              fontSize: 16,
              color: Colors.grey.shade600,
            ),
          ),
        ],
      ),
    );
   }

   Widget _buildSearchBar() {
     // ... (kode _buildSearchBar Anda)
     return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: TextField(
        decoration: InputDecoration(
          hintText: 'Search..',
          prefixIcon: Icon(Icons.search, color: Colors.grey.shade500),
          filled: true,
          fillColor: Colors.grey.shade100, // Warna latar search bar
          contentPadding:
              EdgeInsets.symmetric(vertical: 15.0), // Atur padding vertikal
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(30.0), // Membuat sudut rounded
            borderSide: BorderSide.none, // Menghilangkan border
          ),
          enabledBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(30.0),
            borderSide: BorderSide.none,
          ),
          focusedBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(30.0),
            borderSide: BorderSide(
                color: Colors.deepPurple.shade200), // Border saat fokus
          ),
        ),
      ),
    );
   }

   Widget _buildMentalHealthCard() {
     // ... (kode _buildMentalHealthCard Anda)
      return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Container(
        padding: EdgeInsets.all(20),
        decoration: BoxDecoration(
          color: Colors.deepPurple, // Warna background card
          borderRadius: BorderRadius.circular(15.0), // Sudut rounded
          boxShadow: [
            // Tambahkan bayangan halus
            BoxShadow(
              color: Colors.deepPurple.withOpacity(0.3),
              spreadRadius: 1,
              blurRadius: 5,
              offset: Offset(0, 3),
            ),
          ],
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Expanded(
              // Expanded agar teks bisa wrap jika panjang
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Mental Health',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                    ),
                  ),
                  SizedBox(height: 5),
                  Text(
                    'Cek Mental Health kamu sekarang!',
                    style: TextStyle(
                      fontSize: 14,
                      color: Colors.white.withOpacity(0.9),
                    ),
                  ),
                  SizedBox(height: 15),
                  ElevatedButton(
                    onPressed: () {
                      // Aksi ketika tombol "Tes Sekarang" ditekan
                       // Mungkin navigasi juga?
                       Navigator.pushNamed(context, '/tesdiagnosa');
                    },
                    style: ElevatedButton.styleFrom(
                      foregroundColor: Colors.deepPurple,
                      backgroundColor:
                          Colors.white, // Text color, Background color
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(20),
                      ),
                      padding:
                          EdgeInsets.symmetric(horizontal: 20, vertical: 10),
                    ),
                    child: Text('Tes Sekarang'),
                  ),
                ],
              ),
            ),
            SizedBox(width: 10), // Spasi antara teks dan gambar
            // Ganti Placeholder ini dengan Image.asset atau Image.network
            Image.asset(
              'assets/images/mental_health_illustration.png', // GANTI DENGAN PATH GAMBAR ANDA
              height: 80, // Sesuaikan ukuran gambar
              errorBuilder: (context, error, stackTrace) {
                // Widget pengganti jika gambar gagal dimuat
                return Container(
                  height: 80,
                  width: 60,
                  color: Colors.white.withOpacity(0.2),
                  child: Icon(Icons.image_not_supported, color: Colors.white54),
                );
              },
            ),
          ],
        ),
      ),
    );
   }

   Widget _buildIconMenu() {
     // ... (kode _buildIconMenu Anda)
     return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Row(
        mainAxisAlignment:
            MainAxisAlignment.spaceAround, // Sebar item secara merata
        children: [
          _buildMenuIconItem(Icons.spa_outlined, 'Meditasi'), // Sesuaikan ikon
          _buildMenuIconItem(
              Icons.format_quote_outlined, 'Quotes &\nAffirmation',
              textAlign: TextAlign.center), // Sesuaikan ikon
          _buildMenuIconItem(
              Icons.calendar_today_outlined, 'Rencana Self\nCare',
              textAlign: TextAlign.center), // Sesuaikan ikon
          _buildMenuIconItem(
              Icons.more_horiz_outlined, 'More'), // Sesuaikan ikon
        ],
      ),
    );
   }

    Widget _buildMenuIconItem(IconData icon, String label,
      {TextAlign textAlign = TextAlign.center}) {
        // ... (kode _buildMenuIconItem Anda)
        return Column(
      mainAxisSize:
          MainAxisSize.min, // Agar kolom tidak memakan tinggi berlebih
      children: [
        Container(
          padding: EdgeInsets.all(12),
          decoration: BoxDecoration(
            color: Colors.deepPurple.withOpacity(0.1), // Latar ikon
            shape: BoxShape.circle, // Buat jadi lingkaran
          ),
          child: Icon(icon, color: Colors.deepPurple, size: 28),
        ),
        SizedBox(height: 8),
        Text(
          label,
          style: TextStyle(fontSize: 12, color: Colors.black54),
          textAlign: textAlign, // Terapkan text align
        ),
      ],
    );
      }

   Widget _buildRecommendationSection() {
     // ... (kode _buildRecommendationSection Anda)
     return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 16.0),
          child: Text(
            'Recomended for you', // Typo di gambar 'Recomended', disesuaikan
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: Colors.black87,
            ),
          ),
        ),
        SizedBox(height: 15),
        SingleChildScrollView(
          scrollDirection: Axis.horizontal, // Scroll ke samping
          padding: EdgeInsets.only(
              left: 16.0, right: 6.0), // Padding kiri dan sedikit kanan
          child: Row(
            children: [
              _buildRecommendationCard(
                  'assets/images/meditation_focus.png', // GANTI PATH GAMBAR
                  'Focus',
                  'MEDITATION 3-10 MIN'),
              SizedBox(width: 10), // Spasi antar card
              _buildRecommendationCard(
                  'assets/images/meditation_happiness.png', // GANTI PATH GAMBAR
                  'Happiness',
                  'MEDITATION 3-10 MIN'),
              // Tambahkan card lain di sini jika perlu
               SizedBox(width: 10),
            ],
          ),
        ),
      ],
    );
   }

    Widget _buildRecommendationCard(
      String imagePath, String title, String subtitle) {
        // ... (kode _buildRecommendationCard Anda)
        return SizedBox(
      width: 160, // Lebar card
      child: Card(
        clipBehavior:
            Clip.antiAlias, // Agar gambar tidak keluar dari border radius Card
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(10.0),
        ),
        elevation: 2.0, // Sedikit bayangan
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Image.asset(
              imagePath,
              height: 100, // Tinggi gambar
              width: double.infinity, // Lebar penuh card
              fit: BoxFit.cover, // Agar gambar menutupi area
              errorBuilder: (context, error, stackTrace) {
                // Widget pengganti jika gambar gagal dimuat
                return Container(
                  height: 100,
                  width: double.infinity,
                  color: Colors.grey.shade200,
                  child: Icon(Icons.image_not_supported,
                      color: Colors.grey.shade400),
                );
              },
            ),
            Padding(
              padding: const EdgeInsets.all(10.0),
              child: Column(
                 crossAxisAlignment: CrossAxisAlignment.start,
                 children: [
                   Text(
                     title,
                     style: TextStyle(
                       fontSize: 15,
                       fontWeight: FontWeight.bold,
                       color: Colors.black87,
                     ),
                   ),
                   SizedBox(height: 4),
                   Text(
                     subtitle,
                     style: TextStyle(
                       fontSize: 11,
                       color: Colors.grey.shade600,
                     ),
                   ),
                 ],
              ),
            ),
          ],
        ),
      ),
    );
      }
} // Akhir dari _HomePageState