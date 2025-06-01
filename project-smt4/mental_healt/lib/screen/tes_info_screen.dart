// lib/tes_info_screen.dart
import 'package:flutter/material.dart';
import 'tes_form_screen.dart'; // Import halaman formulir

class TesInfoScreen extends StatelessWidget {
  const TesInfoScreen({super.key});

  // Fungsi _buildDetailTesItem tetap sama seperti yang sudah kita diskusikan
  // untuk perubahan warna teks item spesifik jika Anda sudah menerapkannya.
  // Jika belum, dan Anda ingin warna teks item juga putih, Anda bisa
  // memodifikasinya di sini atau menggunakan parameter seperti contoh sebelumnya.
  Widget _buildDetailTesItem(
    BuildContext context,
    IconData icon,
    String text, {
    Color? textColor,
    Color? iconColor,
  }) {
    final defaultTextColorFromTheme = Theme.of(context).textTheme.bodyMedium?.color ?? Colors.grey.shade700;
    final defaultIconColor = Colors.deepPurple.shade400;

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
    const String imagePath = 'assets/images/insights_illustration.png'; // GANTI INI JIKA PERLU

    return Scaffold(
      appBar: AppBar(
        // V V V PERUBAHAN ADA DI SINI V V V
        title: const Text(
          'Informasi Tes',
          style: TextStyle(color: Colors.white), // Tambahkan style ini untuk warna teks putih
        ),
        // ^ ^ ^ AKHIR PERUBAHAN ^ ^ ^
        backgroundColor: Colors.deepPurple,
        elevation: 0.5,
        // Jika Anda ingin ikon back (jika ada) juga berwarna putih, tambahkan:
        // iconTheme: IconThemeData(color: Colors.white),
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
                          Icons.insights_rounded,
                          size: 120,
                          color: Colors.deepPurple.shade200,
                        ),
                      );
                    },
                  ),
                  const SizedBox(height: 30),
                  Text(
                    'Tes Perkembangan',
                    textAlign: TextAlign.center,
                    style: Theme.of(context)
                        .textTheme
                        .headlineSmall
                        ?.copyWith(fontWeight: FontWeight.bold, color: Colors.black87),
                  ),
                  const SizedBox(height: 30),
                  Text(
                    'Informasi Tes :',
                     style: Theme.of(context).textTheme.titleMedium?.copyWith(fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    'Terima kasih telah menyelesaikan Tes Diagnosa. Sekarang, mari kita lihat bagaimana perkembangan Anda. Halaman ini berisi pertanyaan-pertanyaan untuk membantu Anda mengevaluasi kondisi dan perasaan Anda saat ini terkait dengan apa yang telah Anda lalui. Kejujuran Anda akan memberikan gambaran yang lebih jelas untuk langkah selanjutnya.',
                    style: Theme.of(context)
                        .textTheme
                        .bodyLarge
                        ?.copyWith(color: Colors.black54, height: 1.5, fontSize: 15),
                  ),
                  const SizedBox(height: 15),
                  Text(
                    'Detail Tes :',
                     style: Theme.of(context).textTheme.titleMedium?.copyWith(fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 8),
                  _buildDetailTesItem(
                    context,
                    Icons.timer_outlined,
                    'Perkiraan waktu : 8-10 menit',
                    // Jika Anda ingin item ini juga putih, tambahkan textColor: Colors.white
                  ),
                  _buildDetailTesItem(
                    context,
                    Icons.shield_outlined,
                    'Jawaban anda akan dijaga kerahasiaannya.',
                    // textColor: Colors.white,
                  ),
                  _buildDetailTesItem(
                    context,
                    Icons.priority_high,
                    'Jawablah dengan jujur sesuai dengan kondisi anda.',
                    // textColor: Colors.white, // Jika Anda sudah set ini menjadi putih sebelumnya, biarkan saja
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
                   Navigator.push(
                     context,
                     MaterialPageRoute(builder: (context) => const TesFormScreen()),
                   );
                 },
                 child: const Text('Mulai Tes'),
               ),
            ),
          ],
        ),
      ),
    );
  }
}