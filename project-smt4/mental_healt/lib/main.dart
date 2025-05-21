// Nama file: main.dart
import 'package:flutter/material.dart';

// Impor layar yang sudah ada
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

// --- TAMBAHKAN IMPORT UNTUK LAYAR BARU PROFIL ---
import 'package:mobile_project/screen/edit_profile_screen.dart';
import 'package:mobile_project/screen/ubah_kata_sandi_screen.dart';
import 'package:mobile_project/screen/pengaturan_notifikasi_screen.dart';
import 'package:mobile_project/screen/bantuan_screen.dart';
import 'package:mobile_project/screen/tentang_aplikasi_screen.dart';
import 'package:mobile_project/screen/kebijakan_privasi_screen.dart';
// --- GANTI PATH JIKA PERLU ---

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
      initialRoute: '/splash_screen',
      routes: {
        // Rute yang sudah ada
        '/splash_screen': (context) => const SplashScreen(),
        '/onboarding': (context) => const unboarding_screen(),
        '/login': (context) => const LoginScreen(),
        '/signup': (context) => const SignUpScreen(),
        '/tesdiagnosa': (context) => const TesDiagnosaScreen(),
        '/kuis': (context) => const KuisScreen(),
        '/pertanyaan': (context) => const PertanyaanScreen(),
        '/hasil': (context) => const RiwayatHasilTesScreen(),
        '/detailhasil': (context) => const HasilTesPage(),
        '/homepage': (context) => HomePage(),
        '/profile': (context) => const ProfileScreen(),
        '/meditasi': (context) => const MeditationScreen(),
        '/quotes': (context) => const QuotesScreen(),
        '/rencana': (context) => const RencanaScreen(),

        // --- TAMBAHKAN RUTE BARU DI SINI ---
        '/edit_profile': (context) => const EditProfileScreen(),
        '/ubah_kata_sandi': (context) => const UbahKataSandiScreen(),
        '/pengaturan_notifikasi': (context) => const PengaturanNotifikasiScreen(),
        '/bantuan': (context) => const BantuanScreen(),
        '/tentang_aplikasi': (context) => const TentangAplikasiScreen(),
        '/kebijakan_privasi': (context) => const KebijakanPrivasiScreen(),
      },
    );
  }
}