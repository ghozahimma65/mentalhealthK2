// Nama file: main.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';

// --- Impor untuk Layar ---
// Pastikan semua path dan nama file ini sesuai dengan struktur proyek Anda.

// Layar Inti & Autentikasi
import 'package:mobile_project/screen/splash_screen.dart';
import 'package:mobile_project/screen/unboarding_screen.dart';
import 'package:mobile_project/screen/login_screen.dart';
import 'package:mobile_project/screen/register_screen.dart';
import 'package:mobile_project/screen/forgot_password_screen.dart'; // <-- TAMBAHKAN IMPORT INI
import 'package:mobile_project/screen/reset_password_screen.dart';   // <-- TAMBAHKAN IMPORT INI

// Layar Utama & Fitur
import 'package:mobile_project/screen/home_page.dart';
import 'package:mobile_project/screen/profile_screen.dart';
import 'package:mobile_project/screen/meditation_screen.dart';
import 'package:mobile_project/screen/quotes_display_screen.dart';
import 'package:mobile_project/screen/rencana_screen.dart';

// Layar Tes & Hasil
// Layar Pengaturan & Lainnya
import 'package:mobile_project/screen/ubah_kata_sandi_screen.dart';
import 'package:mobile_project/screen/pengaturan_notifikasi_screen.dart';
import 'package:mobile_project/screen/bantuan_screen.dart';
import 'package:mobile_project/screen/tentang_aplikasi_screen.dart';
import 'package:mobile_project/screen/kebijakan_privasi_screen.dart';

import 'package:sp_util/sp_util.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await SpUtil.getInstance();
  runApp(const MyApp());
  configLoading();
}

void configLoading() {
  EasyLoading.instance
    ..displayDuration = const Duration(milliseconds: 2000)
    ..indicatorType = EasyLoadingIndicatorType.fadingCircle
    ..loadingStyle = EasyLoadingStyle.dark
    ..indicatorSize = 45.0
    ..radius = 10.0
    ..userInteractions = true
    ..dismissOnTap = false;
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
        // Rute Autentikasi & Onboarding
        '/splash_screen': (context) => const SplashScreen(),
        '/onboarding': (context) => const unboarding_screen(), // Periksa nama kelas (mungkin UnboardingScreen?)
        '/login': (context) => const LoginScreen(),
        '/signup': (context) => const RegisterScreen(), // Anda sudah punya ini

        // --- TAMBAHKAN RUTE UNTUK LUPA PASSWORD DI SINI ---
        '/forgot-password': (context) => const ForgotPasswordScreen(),
        '/reset-password': (context) {
  final args = ModalRoute.of(context)?.settings.arguments as Map<String, String>?;
  return ResetPasswordScreen(
    initialToken: args?['token'],
    initialEmail: args?['email'],
  );
},
        // ----------------------------------------------------

        // Rute Utama Setelah Login
        '/homepage': (context) => HomePage(),
        '/profile': (context) => const ProfileScreen(),

        // Rute Fitur
        '/meditasi': (context) => const MeditationScreen(),
        '/quotes': (context) => const QuoteDisplayScreen(),
        '/rencana': (context) => const RencanaScreen(),

        // Rute Pengaturan & Inf
        '/ubah_kata_sandi': (context) => const UbahKataSandiScreen(),
        '/pengaturan_notifikasi': (context) => const PengaturanNotifikasiScreen(),
        '/bantuan': (context) => const BantuanScreen(),
        '/tentang_aplikasi': (context) => const TentangAplikasiScreen(),
        '/kebijakan_privasi': (context) => const KebijakanPrivasiScreen(),
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