// lib/screen/DetailHasilDiagnosaPage.dart

import 'package:flutter/material.dart';
import 'package:get/get.dart'; // Import GetX untuk navigasi

class DetailHasilDiagnosaPage extends StatelessWidget {
  // Ubah tipe data dari String menjadi int?
  final int? rawDiagnosisResultCode; // Nama variabel lebih jelas

  const DetailHasilDiagnosaPage({super.key, required this.rawDiagnosisResultCode});

  // Fungsi untuk mendapatkan detail diagnosis dari kode int
  Map<String, dynamic> _getDiagnosisDetails(int? resultCode) {
    if (resultCode == null) {
      return {
        "name": "Diagnosis Tidak Tersedia",
        "description": "Hasil Tidak Jelas",
        "full_description": "Hasil diagnosis tidak dapat diidentifikasi atau terjadi kesalahan pada proses diagnosis. Mohon coba lagi atau hubungi dukungan.",
        "color": Colors.grey, // Warna default untuk hasil yang tidak jelas
      };
    }
    // Sesuaikan dengan int yang mungkin dikembalikan oleh Flask API Anda
    // Berdasarkan daftar pertanyaan AI-Detected Emotional State:
    // 0: Cemas, 1: Depresi, 2: Gembira, 3: Senang, 4: Netral, 5: Stres
    // Atau jika ini adalah label diagnosis dari Flask:
    // 0: MDD, 1: PD, 2: GAD, 3: BD (sesuaikan mapping sesuai Flask Anda)
    switch (resultCode) {
      case 0: // Gangguan Bipolar
        return {
          "name": "Gangguan Bipolar",
          "description": "Bipolar Disorder",
          "full_description": "Gangguan bipolar adalah kondisi kesehatan mental yang menyebabkan perubahan suasana hati yang ekstrem, meliputi pasang surut emosional (mania/hipomania dan depresi). Perubahan ini dapat memengaruhi energi, tingkat aktivitas, tidur, dan perilaku.",
          "color": const Color(0xFFBA68C8), // Purple for Bipolar
        };
      case 1: // Gangguan Kecemasan Umum (Anxiety)
        return {
          "name": "Gangguan Kecemasan Umum",
          "description": "Generalized Anxiety Disorder (GAD)",
          "full_description": "Gangguan kecemasan umum ditandai dengan kekhawatiran dan ketegangan yang berlebihan dan persisten terhadap berbagai peristiwa atau aktivitas. Kekhawatiran ini seringkali sulit dikendalikan dan disertai dengan gejala fisik seperti gelisah, mudah lelah, sulit konsentrasi, dan masalah tidur.",
          "color": const Color(0xFF81C784), // Light Green for GAD
        };
      case 2: // Gangguan Panik (Panic Attack)
        return {
          "name": "Gangguan Panik",
          "description": "Panic Disorder",
          "full_description": "Gangguan panik melibatkan serangan panik yang tak terduga dan berulang. Serangan panik adalah periode intens ketakutan atau ketidaknyamanan yang tiba-tiba, disertai gejala fisik dan kognitif seperti detak jantung cepat, sesak napas, pusing, dan rasa takut kehilangan kendali atau akan mati.",
          "color": const Color(0xFF64B5F6), // Light Blue for Panic Disorder
        };
      case 3: // Gangguan Depresi Mayor
        return {
          "name": "Gangguan Depresi Mayor",
          "description": "Major Depressive Disorder (MDD)",
          "full_description": "Major Depressive Disorder atau gangguan depresi mayor adalah kondisi kesehatan mental yang ditandai dengan perasaan sedih yang mendalam, kehilangan minat atau kesenangan dalam aktivitas sehari-hari, perubahan pola tidur dan makan, kelelahan, rasa tidak berharga, hingga pikiran untuk bunuh diri. Ini bukan sekadar “sedih biasa”, melainkan gangguan serius yang memengaruhi fungsi harian seseorang secara signifikan.",
          "color": const Color(0xFFE57373), // Reddish-pink for MDD
        };
      default:
        return {
          "name": "Diagnosis Tidak Dikenal",
          "description": "Kode Diagnosis Tidak Valid",
          "full_description": "Kode diagnosis yang diterima tidak dapat diinterpretasikan. Mohon hubungi dukungan jika masalah berlanjut. Kode: $resultCode",
          "color": Colors.deepOrange, // Warna untuk kasus tidak dikenal
        };
    }
  }

  @override
  Widget build(BuildContext context) {
    final details = _getDiagnosisDetails(rawDiagnosisResultCode); // Menggunakan int?

    return Scaffold(
      appBar: AppBar(
        title: const Text('Hasil Diagnosis'),
        backgroundColor: details['color'],
        foregroundColor: Colors.white,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            Container(
              padding: const EdgeInsets.all(20.0),
              decoration: BoxDecoration(
                color: details['color']?.withOpacity(0.1) ?? Colors.grey.withOpacity(0.1),
                borderRadius: BorderRadius.circular(15.0),
                border: Border.all(color: details['color'] ?? Colors.grey, width: 2),
              ),
              child: Column(
                children: [
                  Icon(
                    Icons.psychology_alt_outlined,
                    size: 80,
                    color: details['color'],
                  ),
                  const SizedBox(height: 20),
                  Text(
                    'Anda mungkin mengalami:',
                    style: Theme.of(context).textTheme.titleMedium?.copyWith(
                          color: Colors.black54,
                          fontWeight: FontWeight.normal,
                        ),
                    textAlign: TextAlign.center,
                  ),
                  const SizedBox(height: 10),
                  Text(
                    details['name'],
                    style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                          fontWeight: FontWeight.bold,
                          color: details['color'],
                        ),
                    textAlign: TextAlign.center,
                  ),
                  const SizedBox(height: 5),
                  Text(
                    '(${details['description']})',
                    style: Theme.of(context).textTheme.titleMedium?.copyWith(
                          fontStyle: FontStyle.italic,
                          color: Colors.black54,
                        ),
                    textAlign: TextAlign.center,
                  ),
                ],
              ),
            ),
            const SizedBox(height: 30),
            Text(
              'Deskripsi Singkat:',
              style: Theme.of(context).textTheme.titleLarge?.copyWith(fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 10),
            Text(
              details['full_description'],
              style: Theme.of(context).textTheme.bodyLarge?.copyWith(fontSize: 16, height: 1.5),
              textAlign: TextAlign.justify,
            ),
            const SizedBox(height: 30),
            Text(
              'Penting:',
              style: Theme.of(context).textTheme.titleLarge?.copyWith(fontWeight: FontWeight.bold, color: Colors.orange.shade700),
            ),
            const SizedBox(height: 10),
            Text(
              'Hasil tes ini adalah perkiraan awal dan bukan diagnosis medis. Selalu konsultasikan dengan profesional kesehatan mental untuk diagnosis dan rencana perawatan yang akurat.',
              style: Theme.of(context).textTheme.bodyMedium?.copyWith(fontStyle: FontStyle.italic, color: Colors.black87),
              textAlign: TextAlign.justify,
            ),
            const SizedBox(height: 40),
            ElevatedButton(
              onPressed: () {
                Get.offAllNamed('/homepage'); // Menggunakan GetX untuk kembali ke Home Page
              },
              child: const Text('Kembali ke Beranda'),
            ),
          ],
        ),
      ),
    );
  }
}