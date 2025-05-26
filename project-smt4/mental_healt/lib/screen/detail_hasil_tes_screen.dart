import 'package:flutter/material.dart';

// Ganti ini dengan import halaman home kamu
import 'home_page.dart'; // Pastikan HomePage() tersedia

class HasilTesPage extends StatelessWidget {
  // Untuk contoh, kita akan asumsikan ada properti yang menerima hasil tes
  // Anda harus mengganti ini dengan cara Anda mendapatkan hasil tes yang sebenarnya
  final String rawDiagnosisResult; // Misalnya, "GAD", "MDD", "PD", "BD"

  const HasilTesPage({super.key, this.rawDiagnosisResult = "GAD"}); // Default for example

  // Helper function untuk mendapatkan detail diagnosis
  Map<String, dynamic> _getDiagnosisDetails(String rawResult) {
    switch (rawResult) {
      case "MDD":
        return {
          "name": "Major Depressive Disorder",
          "description": "Gangguan Depresi Mayor",
          "full_description": "Major Depressive Disorder atau gangguan depresi mayor adalah kondisi kesehatan mental yang ditandai dengan perasaan sedih yang mendalam, kehilangan minat atau kesenangan dalam aktivitas sehari-hari, perubahan pola tidur dan makan, kelelahan, rasa tidak berharga, hingga pikiran untuk bunuh diri. Ini bukan sekadar “sedih biasa”, melainkan gangguan serius yang memengaruhi fungsi harian seseorang secara signifikan.",
          "color": const Color(0xFFE57373), // Reddish-pink
        };
      case "PD":
        return {
          "name": "Panic Disorder",
          "description": "Gangguan Panik",
          "full_description": "Panic Disorder atau gangguan panik adalah gangguan kecemasan yang ditandai dengan serangan panik berulang dan tiba-tiba. Serangan panik adalah perasaan takut yang intens dan seringkali muncul tanpa pemicu jelas.",
          "color": const Color(0xFF64B5F6), // Light Blue
        };
      case "GAD":
        return {
          "name": "Generalized Anxiety Disorder",
          "description": "Gangguan Kecemasan Umum",
          "full_description": "Generalized Anxiety Disorder atau gangguan kecemasan umum adalah kondisi di mana seseorang mengalami kekhawatiran yang berlebihan dan terus-menerus terhadap berbagai hal, bahkan tanpa alasan yang jelas. Kecemasan ini sulit dikendalikan dan berlangsung selama berbulan-bulan atau bahkan bertahun-tahun.",
          "color": const Color(0xFF81C784), // Light Green
        };
      case "BD":
        return {
          "name": "Bipolar Disorder",
          "description": "Gangguan Bipolar",
          "full_description": "Bipolar Disorder atau gangguan bipolar adalah kondisi kesehatan mental yang menyebabkan perubahan suasana hati yang ekstrem, dari fase mania (sangat gembira atau energik) ke fase depresi (sangat sedih atau putus asa).",
          "color": const Color(0xFFBA68C8), // Light Purple
        };
      default:
        return {
          "name": "Tidak Teridentifikasi",
          "description": "Diagnosis Tidak Ditemukan",
          "full_description": "Tidak ada deskripsi yang tersedia untuk diagnosis ini.",
          "color": Colors.grey,
        };
    }
  }

  @override
  Widget build(BuildContext context) {
    final diagnosisDetails = _getDiagnosisDetails(rawDiagnosisResult);
    final String diagnosisName = diagnosisDetails["name"];
    final String diagnosisDescription = diagnosisDetails["description"];
    final String diagnosisFullDescription = diagnosisDetails["full_description"]; // Kembali menggunakan full_description
    final Color diagnosisColor = diagnosisDetails["color"];

    // allDiagnosisTypes tidak lagi diperlukan, karena kita hanya menampilkan deskripsi dari 1 kelas
    // final List<Map<String, String>> allDiagnosisTypes = [...];

    return Scaffold(
      body: Container(
        width: double.infinity,
        height: MediaQuery.of(context).size.height, // full screen
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            colors: [Color(0xFF8E2DE2), Color(0xFFFF416C)],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
        ),
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(vertical: 40),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              const Text(
                "Hasil Diagnosis",
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 28, // Lebih besar
                  fontWeight: FontWeight.bold,
                  letterSpacing: 1.2,
                ),
              ),
              const SizedBox(height: 15),
              const Text(
                "Berdasarkan tes yang telah Anda kerjakan, diagnosis anda adalah :",
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: Colors.white70,
                  fontSize: 18, // Lebih besar
                ),
              ),
              const SizedBox(height: 40), // Spasi lebih besar

              // CARD HASIL DIAGNOSA UTAMA
              Container(
                margin: const EdgeInsets.symmetric(horizontal: 24),
                padding: const EdgeInsets.all(30.0), // Padding lebih besar
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(20), // Sudut lebih membulat
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black.withOpacity(0.2), // Shadow lebih jelas
                      spreadRadius: 3,
                      blurRadius: 10,
                      offset: const Offset(0, 5),
                    ),
                  ],
                ),
                child: Column(
                  mainAxisSize: MainAxisSize.min, // Sesuaikan ukuran kolom
                  children: [
                    Text(
                      diagnosisDescription, // Deskripsi diagnosis (e.g., Gangguan Kecemasan Umum)
                      textAlign: TextAlign.center,
                      style: const TextStyle(
                        fontSize: 20, // Ukuran teks deskripsi
                        color: Colors.black54,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                    const SizedBox(height: 25), // Spasi lebih besar

                    // Kotak nama diagnosis utama
                    AnimatedContainer(
                      duration: const Duration(milliseconds: 500),
                      curve: Curves.easeInOut,
                      width: double.infinity,
                      padding: const EdgeInsets.symmetric(vertical: 25, horizontal: 15),
                      decoration: BoxDecoration(
                        color: diagnosisColor, // Warna dinamis berdasarkan diagnosis
                        borderRadius: BorderRadius.circular(15),
                        boxShadow: [
                          BoxShadow(
                            color: diagnosisColor.withOpacity(0.4),
                            spreadRadius: 2,
                            blurRadius: 8,
                            offset: const Offset(0, 4),
                          ),
                        ],
                      ),
                      child: Text(
                        diagnosisName, // Nama diagnosis (e.g., Generalized Anxiety Disorder)
                        textAlign: TextAlign.center,
                        style: const TextStyle(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                          fontSize: 28,
                          letterSpacing: 2,
                          shadows: [
                            Shadow(
                              blurRadius: 4.0,
                              color: Colors.black38,
                              offset: Offset(1.0, 1.0),
                            ),
                          ],
                        ),
                      ),
                    ),
                    const SizedBox(height: 20), // Spasi sebelum deskripsi lengkap

                    // Deskripsi lengkap diagnosis utama
                    const Divider(color: Colors.grey, height: 30), // Divider di sini
                    Text(
                      diagnosisFullDescription, // Deskripsi lengkap hanya untuk diagnosis hasil
                      textAlign: TextAlign.justify,
                      style: const TextStyle(
                        fontSize: 16,
                        color: Colors.black87,
                        height: 1.5,
                      ),
                    ),
                  ],
                ),
              ),

              // Bagian "Mengenal Lebih Jauh Jenis Diagnosis" dan daftar Cards-nya telah DIHAPUS SEPENUHNYA
              // Jadi, tidak ada lagi kode yang dirender di sini.

              const SizedBox(height: 40), // Spasi setelah card utama sebelum disclaimer

              // Disclaimer
              const Padding(
                padding: EdgeInsets.symmetric(horizontal: 24),
                child: Text(
                  'Informasi ini merupakan indikasi awal dan bukan diagnosis akhir. Untuk penanganan atau saran lebih lanjut, silahkan berkonsultasi dengan profesional kesehatan mental.',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    fontSize: 14,
                    color: Colors.white70,
                  ),
                ),
              ),

              const SizedBox(height: 30),

              // TOMBOL "Simpan Hasil" dengan ikon
              ElevatedButton.icon(
                onPressed: () {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (context) => HomePage()),
                  );
                },
                style: ElevatedButton.styleFrom(
                  padding: const EdgeInsets.symmetric(horizontal: 30, vertical: 15),
                  backgroundColor: const Color(0xFF424242), // Warna abu-abu gelap
                  foregroundColor: Colors.white,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                  elevation: 6,
                ),
                icon: const Icon(Icons.save, size: 24), // Ikon simpan
                label: const Text(
                  'Simpan Hasil',
                  style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                ),
              ),

              const SizedBox(height: 40),
            ],
          ),
        ),
      ),
    );
  }
}