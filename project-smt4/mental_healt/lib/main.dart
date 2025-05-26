// Nama file: main.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart'; // 1. Impor GetX
import 'package:flutter_easyloading/flutter_easyloading.dart'; // 2. Impor EasyLoading

// Impor layar yang sudah ada (asumsikan semua path ini benar)
import 'package:mobile_project/screen/riwayat_hasil_tes.dart';
import 'package:mobile_project/screen/detail_hasil_tes_screen.dart';
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
import 'package:mobile_project/screen/tes_perkembangan.dart'; // Jika ini nama file untuk TesPerkembanganScreen
import 'package:sp_util/sp_util.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await SpUtil.getInstance(); // Pastikan SpUtil diinisialisasi jika masih digunakan
  // Pertimbangkan untuk inisialisasi GetX services di sini jika ada
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    // 3. Ganti MaterialApp menjadi GetMaterialApp
    return GetMaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Diagnosa Mobile', // Sesuaikan dengan judul aplikasi Anda
      initialRoute: '/splash_screen', // Rute awal Anda
      builder: EasyLoading.init(),
      // Anda bisa menggunakan 'routes' Flutter standar atau 'getPages' dari GetX.
      // Jika menggunakan 'routes' standar:
      routes: {
        // Rute yang sudah ada
        '/splash_screen': (context) => const SplashScreen(),
        '/onboarding': (context) =>
            const unboarding_screen(), // Perhatikan nama kelas jika ada typo (UnboardingScreen)
        '/login': (context) => const LoginScreen(),
        '/signup': (context) => const SignUpScreen(),
        '/tesdiagnosa': (context) => const TesDiagnosaScreen(),
        '/kuis': (context) =>
            const KuisScreen(),
        '/pertanyaan': (context) => const PertanyaanScreen(),
        '/hasil': (context) => const RiwayatHasilTesScreen(),
        '/detailhasil': (context) =>
            const HasilTesPage(), // Pastikan HasilTesPage memiliki constructor const jika StatelessWidget
        '/homepage': (context) =>
            HomePage(), // HomePage adalah StatefulWidget, jadi tidak pakai const di sini
        '/profile': (context) =>
            const ProfileScreen(),
        '/meditasi': (context) => const MeditationScreen(),
        '/quotes': (context) => const QuotesScreen(),
        '/rencana': (context) => const RencanaScreen(),
        '/tesperkembangan': (context) => const TesPerkembanganScreen(), // Asumsi memiliki constructor const
        '/edit_profile': (context) => const EditProfileScreen(),
        '/ubah_kata_sandi': (context) => const UbahKataSandiScreen(),
        '/pengaturan_notifikasi': (context) =>
            const PengaturanNotifikasiScreen(),
        '/bantuan': (context) => const BantuanScreen(),
        '/tentang_aplikasi': (context) => const TentangAplikasiScreen(),
        '/kebijakan_privasi': (context) => const KebijakanPrivasiScreen(),
      },
      
      // (Opsional) Tangani rute yang tidak ditemukan
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

      // 4. Panggil EasyLoading.init() di dalam builder dari GetMaterialApp
  
    );
  }
}