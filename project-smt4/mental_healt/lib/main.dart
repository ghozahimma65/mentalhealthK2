// Nama file: main.dart
import 'package:flutter/material.dart';

// --- Impor Semua Layar ---
// --- PASTIKAN PATH DAN NAMA FILE/CLASS SUDAH BENAR SEMUA ---
import 'package:mobile_project/screen/riwayat_hasil_tes.dart';
import 'package:mobile_project/screen/detail_hasil_tes_screen.dart';
import 'package:mobile_project/screen/TesDiagnosaScreen.dart';
import 'package:mobile_project/screen/KuisScreen.dart';
import 'package:mobile_project/screen/PertanyaanScreen.dart';
import 'package:mobile_project/screen/login_screen.dart';
import 'package:mobile_project/screen/signup_screen.dart';
import 'package:mobile_project/screen/splash_screen.dart';
// Import untuk Onboarding (pastikan nama file & class sudah benar: onboarding_screen.dart & OnboardingScreen)
import 'package:mobile_project/screen/unboarding_screen.dart'; // <-- Perbaiki path/nama file jika perlu
import 'package:mobile_project/screen/home_page.dart';
// Import untuk Profile Screen (yang baru)
import 'package:mobile_project/screen/profile_screen.dart';
// <-- Tambah ini

// --- GANTI 'package:mobile_project/screen/' jika path Anda berbeda ---

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Diagnosa Mobile',
      initialRoute: '/splash_screen', // Mulai dari Splash Screen
      routes: {
        // --- Definisi Semua Rute Aplikasi ---
        '/splash_screen': (context) => const SplashScreen(), // Perlu const constructor

        // Perbaiki nama class di sini jika belum
        '/onboarding': (context) => const unboarding_screen(), // <-- Perbaiki ini jika nama class beda

        '/login': (context) => const LoginScreen(), // Hapus const jika error / stateful
        '/signup': (context) => const SignUpScreen(), // Perlu const constructor
        '/tesdiagnosa': (context) => const TesDiagnosaScreen(), // Perlu const constructor
        '/kuis': (context) => const KuisScreen(), // Perlu const constructor
        '/pertanyaan': (context) => const PertanyaanScreen(), // Perlu const constructor

        // Rute untuk Riwayat Hasil Tes (daftar)
        '/hasil': (context) => const RiwayatHasilTesScreen(), // Perlu const constructor & nama class benar

        // Rute untuk Detail Hasil Tes (pie chart)
        '/detailhasil': (context) => const DetailHasilTesScreen(), // Perlu const constructor

        // Rute untuk Home Page
        '/homepage': (context) => HomePage(), // Mungkin tidak perlu const (Stateful)

        // Rute BARU untuk Profile Screen
        '/profile': (context) => const ProfileScreen(), // <-- Tambah ini (Hapus const jika error)
      },
    );
  }
}