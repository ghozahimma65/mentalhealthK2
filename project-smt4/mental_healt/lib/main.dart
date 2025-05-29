// Nama file: main.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';

// Impor layar yang sudah ada (asumsikan semua path ini benar)
import 'package:mobile_project/screen/riwayat_hasil_tes.dart';

// --- Impor untuk Halaman Detail Hasil ---
// Pastikan path dan nama file ini sesuai dengan struktur proyek Anda,
// dan kelas di dalamnya sudah diganti namanya.
import 'package:mobile_project/screen/DetailHasilDiagnosaPage.dart'; // Berisi kelas DetailHasilDiagnosaPage
import 'package:mobile_project/screen/HasilPenilaianDiriPage.dart'; // Berisi kelas HasilPenilaianDiriPage

import 'package:mobile_project/screen/TesDiagnosaScreen.dart';
import 'package:mobile_project/screen/KuisScreen.dart';
import 'package:mobile_project/screen/PertanyaanScreen.dart';
import 'package:mobile_project/screen/login_screen.dart';
import 'package:mobile_project/screen/signup_screen.dart';
import 'package:mobile_project/screen/splash_screen.dart';
import 'package:mobile_project/screen/unboarding_screen.dart';
import 'package:mobile_project/screen/home_page.dart';
import 'package:mobile_project/screen/profile_screen.dart';
import 'package:mobile_project/screen/meditation_screen.dart';
import 'package:mobile_project/screen/quotes_screen.dart';
import 'package:mobile_project/screen/rencana_screen.dart';
import 'package:mobile_project/screen/edit_profile_screen.dart';
import 'package:mobile_project/screen/ubah_kata_sandi_screen.dart';
import 'package:mobile_project/screen/pengaturan_notifikasi_screen.dart';
import 'package:mobile_project/screen/bantuan_screen.dart';
import 'package:mobile_project/screen/tentang_aplikasi_screen.dart';
import 'package:mobile_project/screen/kebijakan_privasi_screen.dart';
import 'package:mobile_project/screen/tes_info_screen.dart';
import 'package:sp_util/sp_util.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await SpUtil.getInstance();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Diagnosa Mobile',
      initialRoute: '/splash_screen',
      builder: EasyLoading.init(),
      routes: {
        // Rute yang sudah ada (tidak diubah)
        '/splash_screen': (context) => const SplashScreen(),
        '/onboarding': (context) =>
            const unboarding_screen(), // Pastikan nama kelas jika ada typo (UnboardingScreen)
        '/login': (context) => const LoginScreen(),
        '/signup': (context) => const SignUpScreen(),
        '/tesdiagnosa': (context) => const TesDiagnosaScreen(),
        '/kuis': (context) =>
            const KuisScreen(),
        '/pertanyaan': (context) => const PertanyaanScreen(),
        '/hasil': (context) => const RiwayatHasilTesScreen(), // Rute ke RiwayatHasilTesScreen (sudah benar)
        '/homepage': (context) =>
            HomePage(),
        '/profile': (context) =>
            const ProfileScreen(),
        '/meditasi': (context) => const MeditationScreen(),
        '/quotes': (context) => const QuotesScreen(),
        '/rencana': (context) => const RencanaScreen(),
        '/tesperkembangan': (context) => const TesInfoScreen(), // Rute ke halaman info Tes Penilaian Diri (sudah benar)
        '/edit_profile': (context) => const EditProfileScreen(),
        '/ubah_kata_sandi': (context) => const UbahKataSandiScreen(),
        '/pengaturan_notifikasi': (context) =>
            const PengaturanNotifikasiScreen(),
        '/bantuan': (context) => const BantuanScreen(),
        '/tentang_aplikasi': (context) => const TentangAplikasiScreen(),
        '/kebijakan_privasi': (context) => const KebijakanPrivasiScreen(),

        // --- PENYESUAIAN PADA RUTE /detailhasil ---
        // Rute ini sekarang spesifik untuk DetailHasilDiagnosaPage
        // dan mengharapkan argumen 'rawDiagnosisResult'.
        // RiwayatHasilTesScreen yang baru tidak lagi menggunakan rute ini secara default
        // karena ia menavigasi langsung menggunakan MaterialPageRoute.
        // Rute ini dipertahankan JIKA ADA BAGIAN LAIN APLIKASI YANG MENGGUNAKANNYA.
        // Jika tidak, Anda bisa menghapusnya.
        '/detailhasil': (context) {
          final args = ModalRoute.of(context)?.settings.arguments;
          if (args is Map && args.containsKey('rawDiagnosisResult') && args['rawDiagnosisResult'] is String) {
            // Menggunakan DetailHasilDiagnosaPage yang diimpor
            return DetailHasilDiagnosaPage(rawDiagnosisResult: args['rawDiagnosisResult'] as String);
          } else if (args is Map && args.containsKey('testType') && args.containsKey('resultId')) {
            // Ini adalah blok untuk mencoba menangani format argumen LAMA jika masih ada yang memanggilnya.
            // Anda mungkin perlu logika kompleks di sini untuk memetakan 'testType' atau 'resultId'
            // ke 'rawDiagnosisResult' yang valid.
            // Contoh sangat sederhana (ASUMSI 'resultId' adalah 'rawDiagnosisResult'):
            print("PERINGATAN: Rute /detailhasil dipanggil dengan format argumen lama: $args. Mencoba fallback.");
            if (args['resultId'] is String) {
                 // return DetailHasilDiagnosaPage(rawDiagnosisResult: args['resultId'] as String);
            }
            // Jika tidak bisa dipetakan dengan aman, tampilkan error.
            return Scaffold(
              appBar: AppBar(title: const Text('Error Argumen Lama')),
              body: Center(child: Text('Rute /detailhasil dipanggil dengan argumen format lama yang tidak dapat diproses: $args')),
            );
          }
          // Fallback jika argumen tidak sesuai atau tidak ada
          print("ERROR: Rute /detailhasil dipanggil tanpa argumen 'rawDiagnosisResult' yang valid.");
          return Scaffold(
            appBar: AppBar(title: const Text('Error Argumen')),
            body: const Center(child: Text('Argumen tidak valid atau hilang untuk rute /detailhasil.')),
          );
        },

        // Anda TIDAK PERLU menambahkan rute bernama baru seperti '/hasilPenilaianDiri' di sini
        // jika RiwayatHasilTesScreen adalah satu-satunya tempat yang menavigasi ke sana
        // dan sudah menggunakan MaterialPageRoute secara langsung.
        // Contoh jika Anda tetap ingin menambahkannya (opsional):
        // '/hasilPenilaianDiri': (context) {
        //   final args = ModalRoute.of(context)?.settings.arguments;
        //   if (args is Map && args.containsKey('outcomePrediction') && args.containsKey('answers')) {
        //     return HasilPenilaianDiriPage( // Pastikan ini diimport
        //       outcomePrediction: args['outcomePrediction'] as int,
        //       answers: args['answers'] as Map<String, dynamic>,
        //     );
        //   }
        //   return Scaffold(
        //     appBar: AppBar(title: const Text('Error')),
        //     body: const Center(child: Text('Argumen tidak valid untuk /hasilPenilaianDiri')),
        //   );
        // },
      },
      onUnknownRoute: (settings) {
        return MaterialPageRoute(
          builder: (context) => Scaffold(
            appBar: AppBar(title: const Text('Halaman Tidak Ditemukan')),
            body: Center(
              child: Text('Oops! Rute ${settings.name} tidak ditemukan.'),
            ),
          ),
        );
      },
    );
  }
}