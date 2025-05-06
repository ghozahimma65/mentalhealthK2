import 'package:flutter/material.dart';

// Nama class sesuai konvensi PascalCase
class TesDiagnosaScreen extends StatelessWidget {
  // Tambahkan const constructor
  const TesDiagnosaScreen({super.key});

  // Helper Method untuk membuat satu kartu tes (agar tidak duplikat kode)
  Widget _buildTestCard({
    required BuildContext context, // Dibutuhkan untuk navigasi & styling
    required String title,
    required String description,
    required String buttonText,
    required Color cardColor, // Warna solid utama kartu
    required Color buttonBgColor, // Warna background tombol
    required Color buttonTextColor, // Warna teks tombol
    required String imagePath, // Path ke gambar ilustrasi
    required VoidCallback onPressed, // Aksi ketika tombol ditekan
    Gradient? gradient, // Gradient opsional untuk latar kartu
  }) {
    return Padding(
      // Beri jarak antar kartu
      padding: const EdgeInsets.only(bottom: 16.0),
      child: Container(
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
          // Gunakan gradient jika ada, jika tidak pakai warna solid
          gradient: gradient,
          color: gradient == null ? cardColor : null,
          borderRadius: BorderRadius.circular(15.0),
          boxShadow: [
            BoxShadow(
              color: cardColor.withOpacity(0.3),
              spreadRadius: 1,
              blurRadius: 6,
              offset: const Offset(0, 4),
            ),
          ],
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          crossAxisAlignment:
              CrossAxisAlignment.center, // Pusatkan item secara vertikal
          children: [
            // Kolom untuk Teks dan Tombol (disebelah kiri)
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment:
                    MainAxisAlignment.center, // Pusatkan teks & tombol
                children: [
                  Text(
                    title,
                    style: const TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Colors
                          .white, // Asumsi teks selalu putih di kartu berwarna
                    ),
                  ),
                  const SizedBox(height: 5),
                  Text(
                    description,
                    style: TextStyle(
                      fontSize: 14,
                      color: Colors.white.withOpacity(0.9),
                    ),
                  ),
                  const SizedBox(height: 15),
                  ElevatedButton(
                    onPressed:
                        onPressed, // Gunakan fungsi onPressed yang diberikan
                    style: ElevatedButton.styleFrom(
                        backgroundColor: buttonBgColor,
                        foregroundColor: buttonTextColor,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(20),
                        ),
                        padding: const EdgeInsets.symmetric(
                            horizontal: 18, vertical: 8),
                        textStyle: const TextStyle(
                            fontSize: 12,
                            fontWeight: FontWeight
                                .bold) // Ukuran teks tombol lebih kecil
                        ),
                    child: Text(buttonText),
                  ),
                ],
              ),
            ),
            const SizedBox(width: 15), // Spasi antara teks dan gambar

            // Gambar Ilustrasi (disebelah kanan)
            Image.asset(
              imagePath,
              height: 90, // Sesuaikan ukuran gambar
              width: 90, // Sesuaikan ukuran gambar
              fit: BoxFit.contain, // Agar gambar tidak terpotong aneh
              errorBuilder: (context, error, stackTrace) {
                // Pengganti jika gambar tidak ada/error
                return Container(
                  height: 75,
                  width: 75,
                  decoration: BoxDecoration(
                      color: Colors.white.withOpacity(0.2),
                      borderRadius: BorderRadius.circular(8)),
                  child: const Icon(Icons.image_not_supported,
                      color: Colors.white54, size: 40),
                );
              },
            ),
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('TES DIAGNOSA'),
        // Hapus // jika ingin warna AppBar konsisten
        // backgroundColor: Colors.deepPurple,
        // foregroundColor: Colors.white,
        elevation: 0, // Hilangkan bayangan jika desainnya flat
        backgroundColor: Theme.of(context)
            .scaffoldBackgroundColor, // Samakan dengan latar body
        foregroundColor: Colors.black87, // Warna teks & ikon appbar jadi gelap
      ),
      body: ListView(
        // Gunakan ListView agar bisa discroll jika banyak tes
        padding: const EdgeInsets.all(16.0), // Padding di sekeliling list
        children: [
          // Panggil helper method untuk setiap kartu tes
          _buildTestCard(
            context: context,
            title: 'Mental Health',
            description: 'Cek Mental Health Kamu sekarang!',
            buttonText: 'Tes Sekarang',
            cardColor: Colors.deepPurple, // Warna ungu
            buttonBgColor: Colors.white,
            buttonTextColor: Colors.deepPurple,
            imagePath:
                'assets/images/mental_health.png', // GANTI PATH GAMBAR
            gradient: LinearGradient(
              // Contoh Gradient Ungu
              colors: [Colors.deepPurple.shade400, Colors.deepPurple.shade700],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
            onPressed: () {
              print('Tombol Mental Health ditekan');
              // Navigasi ke kuis spesifik atau umum
              Navigator.pushNamed(context, '/kuis',
                  arguments: 'mental_health'); // Kirim argumen (opsional)
            },
          ),

          _buildTestCard(
            context: context,
            title: 'Depression',
            description: 'Cek Tingkat Depresi Kamu sekarang!',
            buttonText: 'Tes Sekarang',
            cardColor: Colors.blue, // Warna biru
            buttonBgColor: Colors.white,
            buttonTextColor: Colors.blue,
            imagePath: 'assets/images/depression.png', // GANTI PATH GAMBAR
            gradient: LinearGradient(
              // Contoh Gradient Biru
              colors: [Colors.blue.shade400, Colors.blue.shade700],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
            onPressed: () {
              print('Tombol Depression ditekan');
              Navigator.pushNamed(context, '/kuis',
                  arguments: 'depression'); // Kirim argumen (opsional)
            },
          ),

          _buildTestCard(
            context: context,
            title: 'BIPOLAR',
            description: 'Cek Tingkat Bipolar Kamu sekarang!',
            buttonText: 'Tes Sekarang',
            cardColor: Colors.teal, // Warna hijau toska/teal
            buttonBgColor: Colors.white,
            buttonTextColor: Colors.teal,
            imagePath: 'assets/images/bipolar.png', // GANTI PATH GAMBAR
            gradient: LinearGradient(
              // Contoh Gradient Teal
              colors: [Colors.teal.shade400, Colors.teal.shade700],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
            onPressed: () {
              print('Tombol Bipolar ditekan');
              Navigator.pushNamed(context, '/kuis',
                  arguments: 'bipolar'); // Kirim argumen (opsional)
            },
          ),

          _buildTestCard(
            context: context,
            title: 'Anxiety Disorder',
            description: 'Cek Tingkat Kecemasan Kamu sekarang!',
            buttonText: 'Tes Sekarang',
            cardColor: Colors.orange, // Warna oranye
            buttonBgColor: Colors.white,
            buttonTextColor: Colors.orange,
            imagePath: 'assets/images/anxiety_disorder.png', // GANTI PATH GAMBAR
            gradient: LinearGradient(
              // Contoh Gradient Orange
              colors: [Colors.orange.shade400, Colors.orange.shade700],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
            onPressed: () {
              print('Tombol Anxiety Disorder ditekan');
              Navigator.pushNamed(context, '/kuis',
                  arguments: 'anxiety'); // Kirim argumen (opsional)
            },
          ),

          // Tambahkan kartu lain jika perlu di sini
        ],
      ),
      // BottomNavigationBar biasanya tidak diletakkan di halaman detail seperti ini
      // jika Anda menggunakan Navigator.pushNamed dari HomePage.
      // BottomNavigationBar akan tetap terlihat di HomePage.
      // Jika Anda ingin BottomNav ada di SEMUA halaman, strukturnya harus diubah
      // (misalnya, Scaffold utama ada di luar dan body-nya yang berganti).
    );
  }
}
