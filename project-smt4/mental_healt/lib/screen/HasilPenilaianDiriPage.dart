// lib/screen/hasil_penilaian_diri_page.dart (GANTI NAMA FILE JIKA PERLU)
import 'package:flutter/material.dart';
// Pastikan path ke HomePage sudah benar sesuai struktur proyek Anda
import 'package:mobile_project/screen/home_page.dart'; // Contoh, sesuaikan jika perlu

class HasilPenilaianDiriPage extends StatelessWidget { // NAMA KELAS DIUBAH
  final int outcomePrediction;
  final Map<String, dynamic> answers;

  const HasilPenilaianDiriPage({ // KONSTRUKTOR DISESUAIKAN
    super.key,
    required this.outcomePrediction,
    required this.answers,
  });

  Map<String, dynamic> _getOutcomeDetails(int prediction) {
    switch (prediction) {
      case 0: // Deteriorated
        return {
          "title": "Kondisi Menurun",
          "highlightText": "KONDISI CENDERUNG MENURUN",
          "full_description":
              "Berdasarkan jawaban Anda, beberapa aspek memerlukan perhatian lebih lanjut. Pertimbangkan untuk mencari dukungan atau strategi baru untuk mengatasi tantangan yang ada. Jangan ragu untuk berkonsultasi dengan profesional jika Anda merasa perlu.",
          "color": Colors.orange.shade600,
        };
      case 1: // Improved
        return {
          "title": "Kondisi Membaik",
          "highlightText": "KONDISI CENDERUNG MEMBAIK",
          "full_description":
              "Selamat! Hasil menunjukkan adanya kemajuan yang positif dalam kondisi Anda. Terus pertahankan usaha dan strategi yang telah berhasil. Ini adalah pencapaian yang baik dalam perjalanan Anda menuju kesejahteraan.",
          "color": Colors.green.shade500,
        };
      case 2: // No Change
        return {
          "title": "Kondisi Stabil",
          "highlightText": "KONDISI CUKUP STABIL",
          "full_description":
              "Kondisi Anda tampak stabil saat ini. Ini bisa menjadi waktu yang baik untuk merefleksikan apa yang telah berjalan dengan baik dan area mana yang mungkin masih memerlukan sedikit penyesuaian atau perhatian. Tetaplah konsisten dengan praktik positif Anda.",
          "color": Colors.blue.shade400,
        };
      default:
        return {
          "title": "Hasil Tidak Diketahui",
          "highlightText": "TIDAK DIKETAHUI",
          "full_description":
              "Hasil tes tidak dapat ditentukan saat ini. Silakan coba lagi atau hubungi dukungan jika masalah berlanjut.",
          "color": Colors.grey.shade600,
        };
    }
  }

  @override
  Widget build(BuildContext context) {
    final outcomeDetails = _getOutcomeDetails(outcomePrediction);
    final String resultTitle = outcomeDetails["title"];
    final String resultHighlightText = outcomeDetails["highlightText"];
    final String resultFullDescription = outcomeDetails["full_description"];
    final Color resultColor = outcomeDetails["color"];

    print("Data Jawaban di Halaman Hasil Penilaian Diri: $answers");

    return Scaffold(
      body: Container(
        width: double.infinity,
        height: MediaQuery.of(context).size.height,
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [Colors.deepPurple.shade300, Colors.pinkAccent.shade100],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
        ),
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(vertical: 50, horizontal: 20),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              const Text(
                "Hasil Penilaian Diri",
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 28,
                  fontWeight: FontWeight.bold,
                  letterSpacing: 1.1,
                ),
              ),
              const SizedBox(height: 12),
              Text(
                "Berdasarkan tes yang telah Anda kerjakan, berikut adalah hasilnya:",
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: Colors.white.withOpacity(0.85),
                  fontSize: 17,
                ),
              ),
              const SizedBox(height: 35),
              Container(
                margin: const EdgeInsets.symmetric(horizontal: 0),
                padding: const EdgeInsets.all(25.0),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(20),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black.withOpacity(0.15),
                      spreadRadius: 2,
                      blurRadius: 12,
                      offset: const Offset(0, 6),
                    ),
                  ],
                ),
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      resultTitle,
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontSize: 19,
                        color: Colors.grey.shade700,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                    const SizedBox(height: 20),
                    AnimatedContainer(
                      duration: const Duration(milliseconds: 300),
                      curve: Curves.fastOutSlowIn,
                      width: double.infinity,
                      padding: const EdgeInsets.symmetric(vertical: 20, horizontal: 15),
                      decoration: BoxDecoration(
                        color: resultColor,
                        borderRadius: BorderRadius.circular(15),
                        boxShadow: [
                          BoxShadow(
                            color: resultColor.withOpacity(0.3),
                            spreadRadius: 1,
                            blurRadius: 10,
                            offset: const Offset(0, 5),
                          ),
                        ],
                      ),
                      child: Text(
                        resultHighlightText,
                        textAlign: TextAlign.center,
                        style: const TextStyle(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                          fontSize: 24,
                          letterSpacing: 1.5,
                           shadows: [
                            Shadow(
                              blurRadius: 3.0,
                              color: Colors.black26,
                              offset: Offset(1.0, 1.0),
                            ),
                          ],
                        ),
                      ),
                    ),
                    const SizedBox(height: 25),
                    Divider(color: Colors.grey.shade300, height: 20, thickness: 1),
                    const SizedBox(height: 15),
                    Text(
                      resultFullDescription,
                      textAlign: TextAlign.justify,
                      style: TextStyle(
                        fontSize: 15,
                        color: Colors.black.withOpacity(0.75),
                        height: 1.6,
                      ),
                    ),
                  ],
                ),
              ),
              const SizedBox(height: 35),
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16),
                child: Text(
                  'Informasi ini merupakan indikasi awal dan bukan diagnosis akhir. Untuk penanganan atau saran lebih lanjut, silahkan berkonsultasi dengan profesional kesehatan.',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    fontSize: 13,
                    color: Colors.white.withOpacity(0.8),
                    height: 1.4,
                  ),
                ),
              ),
              const SizedBox(height: 30),
              ElevatedButton.icon(
                onPressed: () {
                  Navigator.pushAndRemoveUntil(
                    context,
                    MaterialPageRoute(builder: (context) => HomePage()),
                    (Route<dynamic> route) => false,
                  );
                },
                style: ElevatedButton.styleFrom(
                  padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                  backgroundColor: Colors.white.withOpacity(0.9),
                  foregroundColor: Colors.deepPurple.shade700,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                  elevation: 4,
                ),
                icon: const Icon(Icons.home_rounded, size: 22),
                label: const Text(
                  'Kembali ke Home',
                  style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                ),
              ),
              const SizedBox(height: 30),
            ],
          ),
        ),
      ),
    );
  }
}