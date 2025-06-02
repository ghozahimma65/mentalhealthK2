// lib/screen/KuisScreen.dart

import 'package:flutter/material.dart';
import 'package:get/get.dart'; // Import GetX for navigation

class KuisScreen extends StatelessWidget {
  const KuisScreen({super.key});

  Widget _buildDetailTesItem(
      BuildContext context,
      IconData icon,
      String text, {
        Color? textColor,
        Color? iconColor,
      }) {
    final defaultTextColorFromTheme = Theme.of(context).textTheme.bodyMedium?.color ?? Colors.grey.shade700;
    final defaultIconColor = Theme.of(context).primaryColor;

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
    final String? testTypeArg = Get.arguments as String?; // Menggunakan Get.arguments
    final String testType = testTypeArg ?? 'mental_health';

    String appBarTitle = 'Informasi Tes';
    String mainContentTitle = 'Informasi Tes';
    String description =
        'Tes ini akan berisi sejumlah pertanyaan untuk membantu mengukur tingkat kondisi mental Anda. Jawablah setiap pertanyaan dengan jujur sesuai kondisi Anda beberapa waktu terakhir.';
    String imagePath = 'assets/images/gambar_kuis.png';

    if (testType == 'mental_health') {
      mainContentTitle = 'Informasi Tes Kesehatan Mental';
    } else if (testType == 'anxiety_test') { // Contoh tipe lain
      mainContentTitle = 'Informasi Tes Kecemasan';
      description = 'Tes ini fokus pada gejala kecemasan. Jawab dengan jujur.';
    }

    const String estimatedTime = "10-15 Menit";
    const String confidentialityText = 'Jawaban Anda akan dijaga kerahasiaannya.';
    const String honestyDisclaimer = 'Tes ini adalah alat bantu awal, bukan diagnosis medis.';

    const String buttonText = 'Mulai Tes!';

    return Scaffold(
      appBar: AppBar(
        title: Text(
          appBarTitle,
          style: const TextStyle(color: Colors.white),
        ),
        backgroundColor: Theme.of(context).primaryColor,
        elevation: 0.5,
        iconTheme: const IconThemeData(
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
                          Icons.psychology_alt_outlined,
                          size: 120,
                          color: Theme.of(context).primaryColor.withOpacity(0.5),
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
                    Icons.shield_outlined,
                    confidentialityText,
                  ),
                  _buildDetailTesItem(
                    context,
                    Icons.info_outline,
                    honestyDisclaimer,
                  ),
                  const SizedBox(height: 20),
                ],
              ),
            ),
            Padding(
              padding: const EdgeInsets.only(bottom: 20.0, top: 20.0),
              child: ElevatedButton(
                onPressed: () {
                  // Navigasi ke halaman pertanyaan sambil mengirim jenis tes menggunakan GetX
                  Get.toNamed('/pertanyaan', arguments: testType);
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