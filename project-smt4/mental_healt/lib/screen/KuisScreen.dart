import 'package:flutter/material.dart';

class KuisScreen extends StatelessWidget {
  const KuisScreen({super.key});

  // Helper widget untuk membuat poin informasi (opsional)
  Widget _buildInfoPoint(BuildContext context, IconData icon, String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8.0),
      child: Row(
        children: [
          Icon(icon,
              color: Theme.of(context).primaryColor.withOpacity(0.8), size: 20),
          const SizedBox(width: 10),
          Expanded(
              child: Text(text,
                  style: TextStyle(fontSize: 14, color: Colors.grey.shade700))),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    // Ambil argumen jenis tes (dari langkah sebelumnya)
    final String? testTypeArg =
        ModalRoute.of(context)?.settings.arguments as String?;
    final String testType = testTypeArg ?? 'Umum';

    // Tentukan judul dan deskripsi berdasarkan jenis tes
    String screenTitle = 'Informasi Tes';
    String description =
        'Tes ini akan berisi sejumlah pertanyaan untuk membantu mengukur tingkat kondisi mental Anda. Jawablah setiap pertanyaan dengan jujur sesuai kondisi Anda beberapa waktu terakhir.';
    String imagePath = 'assets/images/gambar_kuis.png'; // Gambar default

    if (testType == 'mental_health') {
      imagePath = 'assets/images/gambar_kuis.png';
    }
    // Sesuaikan konten berdasarkan testType

    // Tambahkan else if untuk tipe tes lainnya (mental_health, bipolar, dll)

    // Data dummy untuk poin informasi
    const int questionCount = 15; // Ganti dengan jumlah pertanyaan asli
    const String estimatedTime = "10 Menit"; // Ganti dengan perkiraan waktu

    return Scaffold(
      appBar: AppBar(
        title: Text(screenTitle),
        // backgroundColor: Colors.blueAccent, // Sesuaikan jika perlu
        elevation: 0.5, // Sedikit shadow
      ),
      body: ListView(
        // Ganti Column dengan ListView agar bisa scroll jika konten banyak
        padding: const EdgeInsets.all(20.0), // Padding lebih besar
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
                      child: Icon(Icons.image_not_supported,
                          size: 50, color: Colors.grey)),
                ),
              ),
            ),
          ),
          const SizedBox(height: 16),

          // Judul
          Text(
            screenTitle,
            style: Theme.of(context)
                .textTheme
                .headlineSmall
                ?.copyWith(fontWeight: FontWeight.bold, color: Colors.black87),
          ),
          const SizedBox(height: 16),

          // Deskripsi
          Text(
            description, // Gunakan deskripsi dinamis
            style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                color: Colors.black54, height: 1.5 // Jarak antar baris
                ),
          ),
          const SizedBox(height: 24),

          // --- Poin Informasi Penting ---
          Text(
            'Detail Tes:',
            style: Theme.of(context)
                .textTheme
                .titleMedium
                ?.copyWith(fontWeight: FontWeight.bold),
          ),
          const SizedBox(height: 12),
          _buildInfoPoint(
              context, Icons.timer_outlined, 'Perkiraan Waktu: $estimatedTime'),
          _buildInfoPoint(context, Icons.privacy_tip_outlined,
              'Jawaban Anda akan dijaga kerahasiaannya.'),
          // --- Akhir Poin Informasi ---

          const SizedBox(height: 40), // Spasi sebelum tombol

          // Tombol Mulai Tes (dibuat lebih besar dan jelas)
          ElevatedButton(
            style: ElevatedButton.styleFrom(
                minimumSize:
                    const Size(double.infinity, 50), // Lebar penuh, tinggi 50
                backgroundColor: Colors.deepPurple, // Warna utama tema
                foregroundColor: Colors.white,
                textStyle:
                    const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10) // Sedikit rounded
                    )),
            onPressed: () {
              // Navigasi ke halaman pertanyaan sambil mengirim jenis tes
              Navigator.pushNamed(
                context,
                '/pertanyaan',
                arguments: testType, // Teruskan jenis tes
              );
            },
            child: const Text('Mulai Tes!'),
          ),
          const SizedBox(height: 20), // Spasi di bawah
        ],
      ),
    );
  }
}
