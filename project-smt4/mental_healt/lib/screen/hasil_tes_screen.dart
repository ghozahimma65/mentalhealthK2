import 'package:flutter/material.dart';

// Nama class sesuai konvensi PascalCase
class HasilTesScreen extends StatelessWidget {
  // Tambahkan const constructor
  const HasilTesScreen({super.key});

  // Helper Method untuk membuat KARTU HASIL tes
  // Mirip dengan _buildTestCard, tapi tombolnya beda dan mungkin menampilkan info lain
  Widget _buildResultCard({
    required BuildContext context,
    required String title,
    required String
        description, // Mungkin nanti diganti ringkasan hasil/tanggal
    required String buttonText,
    required Color cardColor,
    required Color buttonBgColor,
    required Color buttonTextColor,
    required String imagePath,
    required VoidCallback onPressed, // Aksi saat tombol "Cek Hasil" ditekan
    Gradient? gradient,
  }) {
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
                    description, // Tampilkan deskripsi atau ringkasan hasil
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
    // Data hasil tes statis sebagai contoh
    // Di aplikasi nyata, data ini akan diambil dari database atau state management
    final List<Map<String, dynamic>> dummyResults = [
      {
        'title': 'Depression',
        'description':
            'Cek Tingkat Depresi Kamu sekarang!', // Ganti dengan hasil/tanggal tes
        'buttonText': 'Cek Hasil',
        'cardColor': Colors.blue,
        'buttonBgColor': Colors.white,
        'buttonTextColor': Colors.blue,
        'imagePath': 'assets/images/test_depression.png', // GANTI PATH GAMBAR
        'gradient': LinearGradient(
          colors: [Colors.blue.shade400, Colors.blue.shade700],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        'resultId': 'depression_001' // ID unik untuk hasil tes ini
      },
      // Tambahkan map lain di sini jika ada hasil tes lain
      // { 'title': 'Anxiety', ... },
    ];

    return Scaffold(
      // AppBar dibuat flat agar mirip desain
      appBar: AppBar(
        title: const Text(
          'hasil tes', // Judul di kiri atas sesuai gambar
          style: TextStyle(
              fontSize: 16, fontWeight: FontWeight.normal), // Style disesuaikan
        ),
        elevation: 0,
        backgroundColor: Theme.of(context).scaffoldBackgroundColor,
        foregroundColor: Colors.black87,
        automaticallyImplyLeading:
            false, // Hilangkan tombol back jika tidak perlu
      ),
      body: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Judul Utama Halaman
            const Padding(
              padding:
                  EdgeInsets.only(top: 0, bottom: 20.0), // Jarak dari app bar
              child: Text(
                'Riwayat Hasil Tes',
                style: TextStyle(
                  fontSize: 22,
                  fontWeight: FontWeight.bold,
                  color: Colors.black87,
                ),
              ),
            ),

            // Daftar Hasil Tes
            Expanded(
              // Gunakan Expanded agar ListView mengisi sisa ruang
              child: ListView.builder(
                itemCount: dummyResults.length, // Jumlah hasil tes
                itemBuilder: (context, index) {
                  final result = dummyResults[index];
                  // Buat kartu untuk setiap hasil tes
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
                      print(
                          'Tombol Cek Hasil ${result['title']} (${result['resultId']}) ditekan');
                      // TODO: Navigasi ke halaman detail hasil tes
                      // Mungkin perlu mengirim resultId atau data lain
                      // Navigator.pushNamed(context, '/detailhasil', arguments: result['resultId']);
                      ScaffoldMessenger.of(context).showSnackBar(
                        SnackBar(
                            content: Text(
                                'Lihat Detail Hasil ${result['title']} belum diimplementasikan')),
                      );
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
}
