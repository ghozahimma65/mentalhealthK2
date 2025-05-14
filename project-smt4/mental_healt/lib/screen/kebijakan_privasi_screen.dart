// Nama file: lib/screen/kebijakan_privasi_screen.dart
import 'package:flutter/material.dart';

class KebijakanPrivasiScreen extends StatelessWidget {
  const KebijakanPrivasiScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Kebijakan Privasi'),
      ),
      body: const SingleChildScrollView( // Agar teks panjang bisa di-scroll
        padding: EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: <Widget>[
            Text(
              'Kebijakan Privasi Mental Health App',
              style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 16),
            Text(
              'Terakhir diperbarui: 11 Mei 2025', // Ganti tanggal
              style: TextStyle(fontSize: 12, fontStyle: FontStyle.italic, color: Colors.grey),
            ),
            SizedBox(height: 16),
            Text(
              'Kami menghargai privasi Anda dan berkomitmen untuk melindungi informasi pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda saat Anda menggunakan aplikasi kami.',
              style: TextStyle(fontSize: 15, height: 1.5),
            ),
            SizedBox(height: 12),
            Text(
              '1. Informasi yang Kami Kumpulkan',
              style: TextStyle(fontSize: 17, fontWeight: FontWeight.w500),
            ),
            SizedBox(height: 8),
            Text(
              '   a. Informasi Akun: Nama, email, dan informasi profil lainnya yang Anda berikan.\n'
              '   b. Data Penggunaan: Hasil tes, progres meditasi, rencana self-care yang Anda buat.\n'
              '   c. Data Perangkat: Informasi teknis tentang perangkat Anda (opsional dan dengan izin).',
              style: TextStyle(fontSize: 15, height: 1.5),
            ),
            SizedBox(height: 12),
             Text(
              '2. Bagaimana Kami Menggunakan Informasi Anda',
              style: TextStyle(fontSize: 17, fontWeight: FontWeight.w500),
            ),
            SizedBox(height: 8),
            Text(
              '   a. Untuk menyediakan dan meningkatkan layanan aplikasi.\n'
              '   b. Untuk mempersonalisasi pengalaman Anda.\n'
              '   c. Untuk memberikan dukungan pelanggan.\n'
              '   d. Data Anda tidak akan kami jual atau bagikan ke pihak ketiga tanpa izin Anda, kecuali diwajibkan oleh hukum.',
              style: TextStyle(fontSize: 15, height: 1.5),
            ),
            // Tambahkan poin-poin lain dari kebijakan privasi Anda
            SizedBox(height: 16),
            Text(
              'Untuk informasi lebih lanjut, silakan hubungi kami di dukungan@aplikasimentalhealth.com.', // Ganti email
               style: TextStyle(fontSize: 15, height: 1.5),
            )
          ],
        ),
      ),
    );
  }
}