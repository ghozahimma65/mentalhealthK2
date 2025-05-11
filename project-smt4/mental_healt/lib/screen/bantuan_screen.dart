// Nama file: lib/screen/bantuan_screen.dart
import 'package:flutter/material.dart';

class BantuanScreen extends StatelessWidget {
  const BantuanScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Bantuan & Dukungan'),
      ),
      body: ListView(
        padding: const EdgeInsets.all(16.0),
        children: <Widget>[
          Text(
            'Pertanyaan Umum (FAQ)',
            style: Theme.of(context).textTheme.titleLarge?.copyWith(fontWeight: FontWeight.bold),
          ),
          const SizedBox(height: 10),
          _buildFaqItem(
            'Bagaimana cara memulai tes diagnosa?',
            'Anda bisa memulai tes diagnosa dari halaman utama dengan menekan menu "Tes Diagnosa", lalu pilih jenis tes yang ingin Anda ambil.',
          ),
          _buildFaqItem(
            'Apakah data saya aman?',
            'Kami sangat menjaga privasi dan keamanan data Anda. Semua data hasil tes bersifat rahasia. Untuk lebih detail, silakan baca Kebijakan Privasi kami.',
          ),
           _buildFaqItem(
            'Bagaimana cara mengatur pengingat meditasi?',
            'Anda bisa pergi ke menu Profil > Pengaturan Notifikasi untuk mengaktifkan atau menonaktifkan pengingat sesi meditasi harian.',
          ),
          // Tambahkan FAQ lainnya
          const SizedBox(height: 24),
          Text(
            'Hubungi Kami',
             style: Theme.of(context).textTheme.titleLarge?.copyWith(fontWeight: FontWeight.bold),
          ),
          const SizedBox(height: 10),
          ListTile(
            leading: const Icon(Icons.email_outlined),
            title: const Text('Kirim Email'),
            subtitle: const Text('dukungan@aplikasimentalhealth.com'), // Ganti dengan email Anda
            onTap: () {
              // TODO: Implementasi buka email client
              print('Buka email client');
            },
          ),
          ListTile(
            leading: const Icon(Icons.report_problem_outlined),
            title: const Text('Laporkan Masalah'),
            subtitle: const Text('Jika Anda menemukan bug atau masalah teknis'),
            onTap: () {
              // TODO: Implementasi form laporan atau arahkan ke email
              print('Buka form laporan masalah');
            },
          ),
        ],
      ),
    );
  }

  Widget _buildFaqItem(String question, String answer) {
    return ExpansionTile( // Widget yang bisa diexpand untuk menampilkan jawaban
      title: Text(question, style: const TextStyle(fontWeight: FontWeight.w500)),
      children: <Widget>[
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 8.0),
          child: Text(answer, style: TextStyle(color: Colors.grey.shade700)),
        )
      ],
    );
  }
}