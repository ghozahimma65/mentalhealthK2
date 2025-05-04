// Nama file: riwayat_hasil_tes.dart
import 'package:flutter/material.dart';

// Nama class: RiwayatHasilTesScreen
class RiwayatHasilTesScreen extends StatelessWidget {
  // Constructor
  const RiwayatHasilTesScreen({super.key});

  // Helper Method untuk membuat KARTU HASIL tes
  Widget _buildResultCard({
    required BuildContext context,
    required String title,
    required String description,
    required String buttonText,
    required Color cardColor,
    required Color buttonBgColor,
    required Color buttonTextColor,
    required String imagePath,
    required VoidCallback onPressed,
    Gradient? gradient,
  }) {
    // --- Kode helper ini TIDAK diubah ---
    return Padding(
      padding: const EdgeInsets.only(bottom: 16.0),
      child: Container(
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
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
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Text(
                    title,
                    style: const TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
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
                    onPressed: onPressed,
                    style: ElevatedButton.styleFrom(
                        backgroundColor: buttonBgColor,
                        foregroundColor: buttonTextColor,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(20),
                        ),
                        padding: const EdgeInsets.symmetric(
                            horizontal: 18, vertical: 8),
                        textStyle: const TextStyle(
                            fontSize: 12, fontWeight: FontWeight.bold)),
                    child: Text(buttonText), // Tombol "Cek Hasil"
                  ),
                ],
              ),
            ),
            const SizedBox(width: 15),
            Image.asset(
              imagePath,
              height: 75,
              width: 75,
              fit: BoxFit.contain,
              errorBuilder: (context, error, stackTrace) {
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
    // --- Bagian data dummy TIDAK diubah ---
    final List<Map<String, dynamic>> dummyResults = [
      {
        'title': 'Depression',
        'description': 'Cek Tingkat Depresi Kamu sekarang!',
        'buttonText': 'Cek Hasil',
        'cardColor': Colors.blue,
        'buttonBgColor': Colors.white,
        'buttonTextColor': Colors.blue,
        'imagePath':
            'assets/images/test_depression.png', // GANTI PATH JIKA PERLU
        'gradient': LinearGradient(
          colors: [Colors.blue.shade400, Colors.blue.shade700],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        'resultId': 'depression_001' // Contoh ID unik
      },
    ];

    return Scaffold(
      // --- Perbaikan Hanya di Bagian AppBar ---
      appBar: AppBar(
        // Judul AppBar (saya perbaiki casingnya, Anda bisa hapus jika tidak mau)
        title: const Text(
          'Riwayat Hasil Tes', // Lebih sesuai dari 'hasil tes'
          style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold), // Style standar AppBar
        ),
        elevation: 0, // Biarkan flat
        backgroundColor:
            Theme.of(context).scaffoldBackgroundColor, // Biarkan menyatu
        foregroundColor: Colors.black87, // Warna ikon (termasuk back) & title

        // HAPUS atau KOMENTARI baris ini untuk memunculkan tombol kembali:
        // automaticallyImplyLeading: false,
      ),
      // --- Akhir Perbaikan AppBar ---

      // --- Bagian body TIDAK diubah ---
      body: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Judul Halaman
            const Padding(
              padding: EdgeInsets.only(top: 0, bottom: 20.0),
              child: Text(
                'Riwayat Hasil Tes', // Judul utama halaman
                style: TextStyle(
                  fontSize: 22,
                  fontWeight: FontWeight.bold,
                  color: Colors.black87,
                ),
              ),
            ),

            // Daftar Hasil Tes
            Expanded(
              child: dummyResults.isEmpty
                  ? const Center(
                      child: Text(
                        'Belum ada riwayat hasil tes.',
                        style: TextStyle(fontSize: 16, color: Colors.grey),
                      ),
                    )
                  : ListView.builder(
                      itemCount: dummyResults.length, // Jumlah data hasil
                      itemBuilder: (context, index) {
                        final result = dummyResults[index];
                        // Membuat kartu untuk setiap data hasil
                        return _buildResultCard(
                          context: context,
                          title: result['title'],
                          description: result['description'],
                          buttonText: result['buttonText'],
                          cardColor: result['cardColor'],
                          buttonBgColor: result['buttonBgColor'],
                          buttonTextColor: result['buttonTextColor'],
                          imagePath: result['imagePath'],
                          gradient: result['gradient'],
                          onPressed: () {
                            // Aksi saat tombol "Cek Hasil" ditekan
                            print(
                                'Tombol Cek Hasil ${result['title']} (${result['resultId']}) ditekan');
                            // Navigasi ke halaman detail hasil tes (pie chart)
                            Navigator.pushNamed(context,
                                '/detailhasil', // Route ke layar detail
                                arguments: {
                                  // Kirim data ke layar detail
                                  'testType': result['title'],
                                  'resultId': result['resultId'],
                                  // Nanti tambahkan data skor dll jika perlu
                                });
                          },
                        );
                      },
                    ),
            ),
          ],
        ),
      ),
    );
  }
} // Akhir Class RiwayatHasilTesScreen
