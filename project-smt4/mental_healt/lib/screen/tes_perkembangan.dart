// Contoh isi file tes_perkembangan_screen.dart (yang dimodifikasi)
import 'package:flutter/material.dart';

class TesPerkembanganScreen extends StatelessWidget {
  const TesPerkembanganScreen({super.key}); // Tambahkan constructor

  // Helper widget untuk membuat poin informasi (bisa di-refactor ke file terpisah jika dipakai di banyak tempat)
  Widget _buildInfoPoint(BuildContext context, IconData icon, String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8.0),
      child: Row(
        children: [
          Icon(icon,
              // Menggunakan colorScheme untuk konsistensi tema yang lebih baik
              color: Theme.of(context).colorScheme.primary.withOpacity(0.8), 
              size: 20),
          const SizedBox(width: 10),
          Expanded(
            child: Text(text,
                style: TextStyle(fontSize: 14, color: Colors.grey.shade700)),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    // Informasi spesifik untuk Tes Perkembangan
    const String screenTitle = 'Pantau Tumbuh Kembang Si Kecil'; // Judul yang lebih menarik dan spesifik
    const String description =
        'Tes ini berisi serangkaian pertanyaan observasi untuk membantu Anda memahami tahapan perkembangan anak berdasarkan usianya. Jawablah setiap pertanyaan dengan jujur sesuai dengan kemampuan dan kebiasaan anak Anda sehari-hari.';
    const String imagePath = 'assets/images/gambar_anak_bermain.png'; // Ganti dengan path gambar yang sesuai untuk tes perkembangan
    const String estimatedTime = "15-20 Menit";
    const int questionCount = 25; // Contoh jumlah pertanyaan/poin observasi
    const String testIdentifier = 'tes_perkembangan_anak_0_5_tahun'; // Identifier unik untuk navigasi

    return Scaffold(
      appBar: AppBar(
        title: const Text('Informasi Tes Perkembangan'), // Judul AppBar
        backgroundColor: Colors.deepPurple, // Sesuai dengan warna asli TesPerkembanganScreen
        elevation: 0.5, // Sedikit shadow seperti di KuisScreen
      ),
      body: ListView(
        padding: const EdgeInsets.all(20.0),
        children: [
          // Gambar Ilustrasi di Atas
          Padding(
            padding: const EdgeInsets.symmetric(vertical: 16.0),
            child: Center(
              child: Image.asset(
                imagePath, // Gunakan path gambar dinamis
                height: 180, // Ukuran gambar disesuaikan
                fit: BoxFit.contain,
                errorBuilder: (context, error, stackTrace) => const SizedBox(
                  height: 180,
                  child: Center(
                    child: Icon(Icons.sentiment_very_satisfied, // Icon yang lebih relevan jika gambar gagal
                        size: 60, color: Colors.grey),
                  ),
                ),
              ),
            ),
          ),
          const SizedBox(height: 16),

          // Judul Utama Tes
          Text(
            screenTitle,
            textAlign: TextAlign.center, // Agar lebih menonjol
            style: Theme.of(context)
                .textTheme
                .headlineSmall
                ?.copyWith(fontWeight: FontWeight.bold, color: Colors.black87),
          ),
          const SizedBox(height: 16),

          // Deskripsi Tes
          Text(
            description, // Gunakan deskripsi dinamis
            style: Theme.of(context)
                .textTheme
                .bodyLarge
                ?.copyWith(color: Colors.black54, height: 1.5, fontSize: 15),
            textAlign: TextAlign.justify, // Agar rapi
          ),
          const SizedBox(height: 24),

          // --- Poin Informasi Penting ---
          Text(
            'Panduan Tes:', // Judul bagian informasi
            style: Theme.of(context)
                .textTheme
                .titleMedium
                ?.copyWith(fontWeight: FontWeight.bold),
          ),
          const SizedBox(height: 12),
          _buildInfoPoint(context, Icons.child_friendly_outlined, // Icon yang relevan
              'Untuk anak usia 0-5 tahun (Contoh)'), // Sesuaikan dengan target usia
          _buildInfoPoint(
              context, Icons.checklist_rtl_outlined, 'Jumlah Poin Observasi: $questionCount'),
          _buildInfoPoint(
              context, Icons.timer_outlined, 'Perkiraan Waktu: $estimatedTime'),
          _buildInfoPoint(context, Icons.lightbulb_outline,
              'Fokus pada observasi perilaku dan kemampuan anak.'),
          _buildInfoPoint(context, Icons.info_outline, // Icon yang relevan
              'Hasil tes adalah panduan awal, konsultasikan dengan ahli jika ada kekhawatiran.'),
          // --- Akhir Poin Informasi ---

          const SizedBox(height: 40), // Spasi sebelum tombol

          // Tombol Mulai Tes
          ElevatedButton(
            style: ElevatedButton.styleFrom(
                minimumSize:
                    const Size(double.infinity, 50), 
                backgroundColor: Colors.deepPurple, // Konsisten dengan AppBar
                foregroundColor: Colors.white,
                textStyle:
                    const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10))),
            onPressed: () {
              // Navigasi ke halaman pertanyaan sambil mengirim identifier jenis tes
              Navigator.pushNamed(
                context,
                '/pertanyaan', // Atau rute spesifik: '/pertanyaan_perkembangan'
                arguments: testIdentifier, // Teruskan identifier spesifik
              );
            },
            child: const Text('Mulai Tes Perkembangan'), // Teks tombol yang spesifik
          ),
          const SizedBox(height: 20), // Spasi di bawah
        ],
      ),
    );
  }
}