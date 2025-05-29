// lib/screen/detail_hasil_diagnosa_screen.dart (GANTI NAMA FILE JIKA PERLU)
import 'package:flutter/material.dart';
// Ganti ini dengan import halaman home kamu
import 'package:mobile_project/screen/home_page.dart'; // Pastikan HomePage() tersedia

class DetailHasilDiagnosaPage extends StatelessWidget { // NAMA KELAS DIUBAH
  final String rawDiagnosisResult;

  const DetailHasilDiagnosaPage({super.key, required this.rawDiagnosisResult}); // KONSTRUKTOR DISESUAIKAN

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
    final String diagnosisFullDescription = diagnosisDetails["full_description"];
    final Color diagnosisColor = diagnosisDetails["color"];

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
                  fontSize: 28,
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
                  fontSize: 18,
                ),
              ),
              const SizedBox(height: 40),
              Container(
                margin: const EdgeInsets.symmetric(horizontal: 24),
                padding: const EdgeInsets.all(30.0),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(20),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black.withOpacity(0.2),
                      spreadRadius: 3,
                      blurRadius: 10,
                      offset: const Offset(0, 5),
                    ),
                  ],
                ),
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      diagnosisDescription,
                      textAlign: TextAlign.center,
                      style: const TextStyle(
                        fontSize: 20,
                        color: Colors.black54,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                    const SizedBox(height: 25),
                    AnimatedContainer(
                      duration: const Duration(milliseconds: 500),
                      curve: Curves.easeInOut,
                      width: double.infinity,
                      padding: const EdgeInsets.symmetric(vertical: 25, horizontal: 15),
                      decoration: BoxDecoration(
                        color: diagnosisColor,
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
                        diagnosisName,
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
                    const SizedBox(height: 20),
                    const Divider(color: Colors.grey, height: 30),
                    Text(
                      diagnosisFullDescription,
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
              const SizedBox(height: 40),
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
              ElevatedButton.icon(
                onPressed: () {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (context) => HomePage()),
                  );
                },
                style: ElevatedButton.styleFrom(
                  padding: const EdgeInsets.symmetric(horizontal: 30, vertical: 15),
                  backgroundColor: const Color(0xFF424242),
                  foregroundColor: Colors.white,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                  elevation: 6,
                ),
                icon: const Icon(Icons.save, size: 24), // Anda mungkin ingin mengganti ikon ini menjadi home atau lainnya
                label: const Text(
                  'Kembali ke Home', // Diubah dari 'Simpan Hasil'
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