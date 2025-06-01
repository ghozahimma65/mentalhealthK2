// lib/main.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';
import 'package:sp_util/sp_util.dart'; // Untuk inisialisasi SpUtil

// --- Impor Controllers ---
import 'package:mobile_project/controller/diagnosis_controller.dart';
import 'package:mobile_project/controller/riwayat_controller.dart'; // <--- TAMBAH IMPORT INI

// --- Impor Layar Aplikasi Anda ---
// Pastikan semua path dan nama kelas sesuai dengan proyek Anda.
import 'package:mobile_project/screen/riwayat_hasil_tes.dart';
import 'package:mobile_project/screen/DetailHasilDiagnosaPage.dart';
import 'package:mobile_project/screen/HasilPenilaianDiriPage.dart'; // Jika masih digunakan
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


void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await SpUtil.getInstance(); // Inisialisasi SpUtil

  // Inisialisasi GetX Controllers yang akan digunakan secara global
  // Get.put() akan membuat instance controller dan mendaftarkannya
  // sehingga bisa diakses dari mana saja menggunakan Get.find()
  Get.put(DiagnosisController());
  Get.put(RiwayatController()); // <--- TAMBAH INI: Inisialisasi RiwayatController

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
      builder: EasyLoading.init(), // Inisialisasi EasyLoading
      theme: ThemeData(
        primarySwatch: Colors.deepPurple, // Warna tema utama
        primaryColor: Colors.deepPurple, // Warna utama eksplisit
        hintColor: Colors.deepPurpleAccent, // Warna aksen
        fontFamily: 'Roboto', // Contoh font family
        appBarTheme: const AppBarTheme(
          backgroundColor: Colors.deepPurple, // Warna AppBar
          foregroundColor: Colors.white, // Warna teks dan ikon di AppBar
          elevation: 0, // Tanpa shadow di AppBar
        ),
        elevatedButtonTheme: ElevatedButtonThemeData(
          style: ElevatedButton.styleFrom(
            backgroundColor: Colors.deepPurple,
            foregroundColor: Colors.white,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(10),
            ),
            padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 15),
            textStyle: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
          ),
        ),
        cardTheme: CardTheme(
          elevation: 4,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
        ),
        inputDecorationTheme: InputDecorationTheme(
          filled: true,
          fillColor: Colors.grey[100],
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(8),
            borderSide: BorderSide.none,
          ),
          enabledBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(8),
            borderSide: BorderSide.none,
          ),
          focusedBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(8),
            borderSide: BorderSide(color: Colors.deepPurple, width: 2),
          ),
          contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
        ),
      ),
      getPages: [
        // Daftar semua rute aplikasi Anda menggunakan GetPage
        GetPage(name: '/splash_screen', page: () => const SplashScreen()),
        GetPage(name: '/onboarding', page: () => const unboarding_screen()),
        GetPage(name: '/login', page: () => const LoginScreen()),
        GetPage(name: '/signup', page: () => const SignUpScreen()),
        GetPage(name: '/homepage', page: () => HomePage()),
        GetPage(name: '/tesdiagnosa', page: () => const TesDiagnosaScreen()),
        GetPage(name: '/kuis', page: () => const KuisScreen()),
        GetPage(name: '/pertanyaan', page: () => const PertanyaanScreen()),
        GetPage(name: '/riwayat_hasil_tes', page: () => const RiwayatHasilTesScreen()), // Perbarui nama rute jika perlu
        GetPage(name: '/profile', page: () => const ProfileScreen()),
        GetPage(name: '/meditasi', page: () => const MeditationScreen()),
        GetPage(name: '/quotes', page: () => const QuotesScreen()),
        GetPage(name: '/rencana', page: () => const RencanaScreen()),
        GetPage(name: '/tesperkembangan', page: () => const TesInfoScreen()),
        GetPage(name: '/edit_profile', page: () => const EditProfileScreen()),
        GetPage(name: '/ubah_kata_sandi', page: () => const UbahKataSandiScreen()),
        GetPage(name: '/pengaturan_notifikasi', page: () => const PengaturanNotifikasiScreen()),
        GetPage(name: '/bantuan', page: () => const BantuanScreen()),
        GetPage(name: '/tentang_aplikasi', page: () => const TentangAplikasiScreen()),
        GetPage(name: '/kebijakan_privasi', page: () => const KebijakanPrivasiScreen()),

        GetPage(
          name: '/detailhasil',
          page: () {
            final args = Get.arguments;
            if (args != null && args is Map && args.containsKey('rawDiagnosisResult') && args['rawDiagnosisResult'] is int) {
              return DetailHasilDiagnosaPage(rawDiagnosisResultCode: args['rawDiagnosisResult'] as int?);
            }
            return Scaffold(
              appBar: AppBar(title: const Text('Error')),
              body: const Center(child: Text('Argumen tidak valid atau hilang untuk rute /detailhasil.')),
            );
          },
        ),
        GetPage(name: '/hasilPenilaianDiri', page: () {
          final args = Get.arguments;
          if (args != null && args is Map && args.containsKey('outcomePrediction') && args.containsKey('answers')) {
            return HasilPenilaianDiriPage(
              outcomePrediction: args['outcomePrediction'] as int,
              answers: args['answers'] as Map<String, dynamic>,
            );
          }
          return Scaffold(
            appBar: AppBar(title: const Text('Error')),
            body: const Center(child: Text('Argumen tidak valid untuk /hasilPenilaianDiri')),
          );
        }),
      ],
    );
  }
}