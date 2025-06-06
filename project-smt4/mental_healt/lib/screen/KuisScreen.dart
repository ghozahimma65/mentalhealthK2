// lib/screen/KuisScreen.dart (atau path file Anda)
import 'package:flutter/material.dart';

class KuisScreen extends StatelessWidget {
  const KuisScreen({super.key});

  // Menggunakan helper widget yang sama dengan tes_info_screen.dart untuk konsistensi tampilan
  Widget _buildDetailTesItem(
    BuildContext context,
    IconData icon,
    String text, {
    Color? textColor, // Opsional jika Anda ingin memberi warna khusus
    Color? iconColor,
  }) {
    // Warna default untuk teks dan ikon jika tidak ada yang diberikan
    final defaultTextColorFromTheme = Theme.of(context).textTheme.bodyMedium?.color ?? Colors.grey.shade700;
    final defaultIconColor = Colors.deepPurple.shade400; // Warna ikon default

    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.start,
        children: [
          Icon(
            icon,
            color: iconColor ?? defaultIconColor,
            size: 20
          ),
          const SizedBox(width: 12),
          Expanded(
            child: Text(
              text,
              style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    color: textColor ?? defaultTextColorFromTheme,
                  ),
            ),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    // Ambil argumen jenis tes (dari langkah sebelumnya)
    final String? testTypeArg =
        ModalRoute.of(context)?.settings.arguments as String?;
    // Default ke 'mental_health' jika argumen null, atau sesuaikan dengan logika Anda
    final String testType = testTypeArg ?? 'mental_health'; 

    // --- KONTEN SPESIFIK UNTUK KUISSCREEN (TES DIAGNOSA) ---
    String appBarTitle = 'Informasi Tes'; // Judul AppBar
    String mainContentTitle = 'Informasi Tes'; // Judul di bawah gambar
    String description =
        'Tes ini akan berisi sejumlah pertanyaan untuk membantu mengukur tingkat kondisi mental Anda. Jawablah setiap pertanyaan dengan jujur sesuai kondisi Anda beberapa waktu terakhir.';
    String imagePath = 'assets/images/gambar_kuis.png'; // Gambar default untuk KuisScreen

    // Anda bisa menambahkan logika if/else if di sini jika ingin konten sedikit berbeda
    // berdasarkan variasi `testType` untuk Tes Diagnosa, namun dasarnya akan sama.
    // Contoh:
    if (testType == 'mental_health') {
      mainContentTitle = 'Informasi Tes Kesehatan Mental';
      // imagePath tetap, deskripsi bisa sama atau sedikit disesuaikan
    } else if (testType == 'anxiety_test') { // Contoh tipe lain
      mainContentTitle = 'Informasi Tes Kecemasan';
      description = 'Tes ini fokus pada gejala kecemasan. Jawab dengan jujur.';
      // imagePath bisa diganti jika ada gambar spesifik
    }
    // Untuk saat ini, kita gunakan konten yang mirip dengan template Screenshot 2025-05-28 203102.png

    // Detail Tes untuk Tes Diagnosa
    const String estimatedTime = "10-15 Menit"; // Sesuaikan perkiraan waktu
    const String confidentialityText = 'Jawaban Anda akan dijaga kerahasiaannya.';
    const String honestyDisclaimer = 'Tes ini adalah alat bantu awal, bukan diagnosis medis.'; // Disclaimer penting

    const String buttonText = 'Mulai Tes!';
    // --- AKHIR KONTEN SPESIFIK ---

    return Scaffold(
      appBar: AppBar(
        title: Text(
          appBarTitle,
          style: const TextStyle(color: Colors.white),
        ),
        backgroundColor: Colors.deepPurple,
        elevation: 0.5,
        iconTheme: const IconThemeData( // Agar tombol kembali (jika ada) juga putih
          color: Colors.white,
        ),
      ),
      body: Padding(
        padding: const EdgeInsets.all(20.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            Expanded(
              child: ListView(
                children: [
                  const SizedBox(height: 20),
                  Image.asset(
                    imagePath,
                    height: 160,
                    fit: BoxFit.contain,
                    errorBuilder: (context, error, stackTrace) {
                      return Center(
                        child: Icon(
                          Icons.psychology_alt_outlined, // Ikon fallback
                          size: 120,
                          color: Colors.deepPurple.shade200,
                        ),
                      );
                    },
                  ),
                  const SizedBox(height: 30),
                  Text(
                    mainContentTitle,
                    textAlign: TextAlign.center,
                    style: Theme.of(context)
                        .textTheme
                        .headlineSmall
                        ?.copyWith(fontWeight: FontWeight.bold, color: Colors.black87),
                  ),
                  const SizedBox(height: 16),
                  Text(
                    description,
                    textAlign: TextAlign.center,
                    style: Theme.of(context)
                        .textTheme
                        .bodyLarge
                        ?.copyWith(color: Colors.black54, height: 1.5, fontSize: 15),
                  ),
                  const SizedBox(height: 30),
                  Text(
                    'Detail Tes :',
                     style: Theme.of(context).textTheme.titleMedium?.copyWith(fontWeight: FontWeight.bold, color: Colors.black87),
                  ),
                  const SizedBox(height: 8),
                  _buildDetailTesItem(
                    context,
                    Icons.timer_outlined,
                    'Perkiraan Waktu: $estimatedTime',
                  ),
                  _buildDetailTesItem(
                    context,
                    Icons.shield_outlined, // Mengganti Icons.privacy_tip_outlined agar lebih umum
                    confidentialityText,
                  ),
                  _buildDetailTesItem(
                    context,
                    Icons.info_outline, // Ikon untuk disclaimer
                    honestyDisclaimer,
                    // Anda bisa memberi warna khusus jika mau, misalnya:
                    // textColor: Colors.red.shade700,
                  ),
                  const SizedBox(height: 20),
                ],
              ),
            ),
            Padding(
               padding: const EdgeInsets.only(bottom: 20.0, top: 20.0),
               child: ElevatedButton(
                 style: ElevatedButton.styleFrom(
                     minimumSize: const Size(double.infinity, 50),
                     backgroundColor: Colors.deepPurple,
                     foregroundColor: Colors.white,
                     textStyle: const TextStyle(
                         fontSize: 16, fontWeight: FontWeight.bold),
                     shape: RoundedRectangleBorder(
                         borderRadius: BorderRadius.circular(10))),
                 onPressed: () {
                   // Navigasi ke halaman pertanyaan sambil mengirim jenis tes
                   // Ini adalah fungsi asli dari KuisScreen Anda
                   Navigator.pushNamed(
                     context,
                     '/pertanyaan', // Pastikan rute ini benar
                     arguments: testType, // Meneruskan jenis tes
                   );
                 },
                 child: Text(buttonText),
               ),
            ),
          ],
        ),
      ),
    );
  }
}