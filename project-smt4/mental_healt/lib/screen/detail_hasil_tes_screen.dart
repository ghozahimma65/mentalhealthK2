// Nama file: detail_hasil_tes_screen.dart
import 'package:flutter/material.dart';
// Import package fl_chart setelah menambahkannya ke pubspec.yaml
import 'package:fl_chart/fl_chart.dart';

class DetailHasilTesScreen extends StatelessWidget {
  const DetailHasilTesScreen({super.key});

  // Helper widget untuk membuat item legenda
  Widget _buildLegendItem(Color color, String text) {
    return Row(
      mainAxisSize: MainAxisSize.min,
      children: [
        Container(
          width: 16,
          height: 16,
          decoration: BoxDecoration(
            shape: BoxShape.circle,
            color: color,
          ),
        ),
        const SizedBox(width: 8),
        Text(text),
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    // --- Ambil Data Hasil Tes dari Arguments ---
    final arguments =
        ModalRoute.of(context)?.settings.arguments as Map<String, dynamic>? ??
            {};

    // Ambil data dari map, berikan nilai default jika tidak ada atau tipe salah
    final String testType = arguments['testType'] as String? ?? 'Tes';
    final double scoreRingan =
        (arguments['scoreRingan'] as num?)?.toDouble() ?? 0.0;
    final double scoreSedang =
        (arguments['scoreSedang'] as num?)?.toDouble() ?? 0.0;
    final double scoreBerat =
        (arguments['scoreBerat'] as num?)?.toDouble() ?? 0.0;
    final String interpretasi =
        arguments['interpretasi'] as String? ?? 'Tidak ada interpretasi.';

    // Definisikan warna sesuai kategori (samakan dengan gambar Anda)
    const Color colorRingan = Color(0xFF30A2FF); // Biru Muda
    const Color colorSedang = Color(0xFFF07575); // Merah Muda/Coral
    const Color colorBerat = Color(0xFF40F0A0); // Hijau Muda/Teal

    // Cek apakah ada data skor untuk ditampilkan di chart
    bool showChart = (scoreRingan + scoreSedang + scoreBerat) > 0;

    return Scaffold(
      appBar: AppBar(
        // Judul AppBar menggunakan tipe tes dari argumen
        title: Text('Hasil Tes $testType Kamu'),
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(20.0),
          child: Column(
            crossAxisAlignment:
                CrossAxisAlignment.stretch, // Agar elemen mengisi lebar
            children: [
              // --- Pie Chart (Hanya tampil jika ada skor > 0) ---
              if (showChart)
                SizedBox(
                  height: 250, // Atur tinggi area chart
                  width: 250, // Atur lebar area chart
                  child: PieChart(
                    PieChartData(
                      sectionsSpace: 2, // Jarak antar potongan pie
                      centerSpaceRadius: 50, // Ukuran lubang tengah
                      sections: [
                        // Potongan untuk Skor Ringan (hanya jika > 0)
                        if (scoreRingan > 0)
                          PieChartSectionData(
                            color: colorRingan,
                            value: scoreRingan, // Nilai dari argumen
                            title:
                                scoreRingan.toStringAsFixed(1), // Teks di potongan
                            radius: 70, // Ukuran potongan pie
                            titleStyle: const TextStyle(
                                fontSize: 14,
                                fontWeight: FontWeight.bold,
                                color: Colors.white),
                          ),
                        // Potongan untuk Skor Sedang (hanya jika > 0)
                        if (scoreSedang > 0)
                          PieChartSectionData(
                            color: colorSedang,
                            value: scoreSedang, // Nilai dari argumen
                            title: scoreSedang.toStringAsFixed(1),
                            radius: 70,
                            titleStyle: const TextStyle(
                                fontSize: 14,
                                fontWeight: FontWeight.bold,
                                color: Colors.white),
                          ),
                        // Potongan untuk Skor Berat (hanya jika > 0)
                        if (scoreBerat > 0)
                          PieChartSectionData(
                            color: colorBerat,
                            value: scoreBerat, // Nilai dari argumen
                            title: scoreBerat.toStringAsFixed(1),
                            radius: 70,
                            titleStyle: const TextStyle(
                                fontSize: 14,
                                fontWeight: FontWeight.bold,
                                color: Colors.white),
                          ),
                      ],
                      // Menonaktifkan interaksi sentuhan pada chart jika tidak perlu
                      pieTouchData: PieTouchData(
                        touchCallback: (FlTouchEvent event, pieTouchResponse) {
                          // Anda bisa tambahkan aksi saat potongan disentuh di sini
                        },
                      ),
                    ),
                    swapAnimationDuration:
                        const Duration(milliseconds: 150), // Animasi opsional
                    swapAnimationCurve: Curves.linear, // Kurva animasi opsional
                  ),
                )
              else // Jika tidak ada skor, tampilkan pesan
                const SizedBox(
                    height: 250,
                    child: Center(
                        child:
                            Text("Data skor tidak valid untuk ditampilkan."))),

              const SizedBox(height: 24),

              // --- Legenda ---
              Center(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Urutan dan warna disamakan dengan gambar Anda
                    _buildLegendItem(colorSedang, 'Depresi Sedang'), // Merah
                    const SizedBox(height: 6),
                    _buildLegendItem(colorRingan, 'Depresi Ringan'), // Biru
                    const SizedBox(height: 6),
                    _buildLegendItem(colorBerat, 'Depresi Berat'), // Hijau
                  ],
                ),
              ),
              const SizedBox(height: 32),

              // --- Interpretasi Teks ---
              Text(
                interpretasi, // Tampilkan interpretasi dari argumen
                textAlign: TextAlign.center,
                style: const TextStyle(fontSize: 16, height: 1.5),
              ),
              const SizedBox(height: 40),

              // --- Tombol Selesai ---
              Center(
                child: ElevatedButton(
                  onPressed: () {
                    // --- PERUBAHAN DI SINI ---
                    // Kode lama: Kembali ke layar sebelumnya (RiwayatHasilTesScreen)
                    // Navigator.pop(context);

                    // Kode baru: Kembali ke HomePage dan hapus semua layar sebelumnya
                    Navigator.pushNamedAndRemoveUntil(
                        context,
                        '/homepage', // Target adalah route HomePage
                        (Route<dynamic> route) =>
                            false // Predikat false menghapus semua route sebelumnya
                        );
                    // --- AKHIR PERUBAHAN ---
                  },
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.grey.shade300, // Warna tombol
                    foregroundColor: Colors.black87,
                    padding: const EdgeInsets.symmetric(
                        horizontal: 50, vertical: 15),
                    textStyle: const TextStyle(fontSize: 16),
                  ),
                  child: const Text('Selesai'),
                ),
              ),
              const SizedBox(height: 20), // Spasi di bawah
            ],
          ),
        ),
      ),
    );
  }
}