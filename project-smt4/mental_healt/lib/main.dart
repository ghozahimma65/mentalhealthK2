// lib/main.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';
import 'package:sp_util/sp_util.dart'; // Untuk inisialisasi SpUtil

// --- Impor Controllers ---
import 'package:mobile_project/controller/diagnosis_controller.dart';
import 'package:mobile_project/controller/riwayat_controller.dart'; // Tetap dipertahankan, sesuaikan jika isinya digabung ke diagnosis/outcome
import 'package:mobile_project/controller/outcome_controller.dart'; // <--- Perhatikan 'controllers' bukan 'controller' di path

// --- Impor Layar ---
// Pastikan semua path dan nama file ini sesuai dengan struktur proyek Anda.

// Layar Inti & Autentikasi
import 'package:mobile_project/screen/splash_screen.dart';
import 'package:mobile_project/screen/unboarding_screen.dart';
import 'package:mobile_project/screen/login_screen.dart';
import 'package:mobile_project/screen/register_screen.dart';
import 'package:mobile_project/screen/forgot_password_screen.dart';
import 'package:mobile_project/screen/reset_password_screen.dart';

// Layar Utama & Fitur
import 'package:mobile_project/screen/home_page.dart';
import 'package:mobile_project/screen/profile_screen.dart';
import 'package:mobile_project/screen/meditation_screen.dart';
import 'package:mobile_project/screen/quotes_display_screen.dart';
import 'package:mobile_project/screen/rencana_screen.dart';

// Layar Tes & Hasil
import 'package:mobile_project/screen/riwayat_hasil_tes.dart'; // Ini akan menjadi halaman universal untuk riwayat tes
import 'package:mobile_project/screen/DetailHasilDiagnosaPage.dart'; // Pastikan ini diimpor dengan benar
import 'package:mobile_project/screen/HasilPenilaianDiriPage.dart'; // <--- Impor HasilPenilaianDiriPage (ini yang akan menampilkan hasil outcome)
import 'package:mobile_project/screen/TesDiagnosaScreen.dart';
import 'package:mobile_project/screen/KuisScreen.dart';
import 'package:mobile_project/screen/PertanyaanScreen.dart';
import 'package:mobile_project/screen/tes_info_screen.dart'; // Layar info sebelum tes (bisa untuk diagnosis atau outcome)

// Layar Baru untuk Fitur Outcome/Tes Perkembangan
import 'package:mobile_project/screen/tes_form_screen.dart'; // <--- Impor TesFormScreen (sesuai nama file tes_form_screen.dart)
// import 'package:mobile_project/screen/RiwayatOutcomeScreen.dart'; // <--- Ini DIHAPUS karena riwayat digabung ke riwayat_hasil_tes.dart


// Layar Pengaturan & Lainnya
import 'package:mobile_project/screen/edit_profile_screen.dart';
import 'package:mobile_project/screen/ubah_kata_sandi_screen.dart';
import 'package:mobile_project/screen/pengaturan_notifikasi_screen.dart';
import 'package:mobile_project/screen/bantuan_screen.dart';
import 'package:mobile_project/screen/tentang_aplikasi_screen.dart';
import 'package:mobile_project/screen/kebijakan_privasi_screen.dart';


void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await SpUtil.getInstance(); // Inisialisasi SpUtil

  // Inisialisasi GetX Controllers yang akan digunakan secara global
  Get.put(DiagnosisController());
  Get.put(RiwayatController());
  Get.put(OutcomeController()); // <--- Inisialisasi OutcomeController

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
        '/onboarding': (context) => const unboarding_screen(), // Pastikan nama kelas jika ada typo (UnboardingScreen)
        '/login': (context) => const LoginScreen(),
        '/signup': (context) => const RegisterScreen(),
        '/forgot-password': (context) => const ForgotPasswordScreen(),
        '/reset-password': (context) {
          final args = ModalRoute.of(context)?.settings.arguments as Map<String, String>?;
          return ResetPasswordScreen(
            initialToken: args?['token'],
            initialEmail: args?['email'],
          );
        },

        // Rute Utama Setelah Login
        '/homepage': (context) => const HomePage(),
        '/profile': (context) => const ProfileScreen(),

        // Rute Fitur
        '/meditasi': (context) => const MeditationScreen(),
        '/quotes': (context) => const QuoteDisplayScreen(),
        '/rencana': (context) => const RencanaScreen(),

        // Rute Tes & Hasil
        '/tesdiagnosa': (context) => const TesDiagnosaScreen(),
        '/kuis': (context) => const KuisScreen(),
        '/pertanyaan': (context) => const PertanyaanScreen(),
        '/hasil': (context) => const RiwayatHasilTesScreen(), // <--- Riwayat universal untuk diagnosis & outcome
        '/tesperkembangan': (context) => const TesInfoScreen(), // Bisa menjadi info sebelum tes outcome

        // --- RUTE BARU UNTUK FITUR OUTCOME/TES PERKEMBANGAN ---
        '/tes_outcome': (context) => const TesFormScreen(), // UI untuk mengisi kuesioner tes perkembangan
        '/hasil_outcome': (context) {
          // Logika untuk mengambil argumen dan meneruskannya ke HasilPenilaianDiriPage
          final args = ModalRoute.of(context)?.settings.arguments as Map<String, dynamic>?;

          if (args != null && args.containsKey('outcomePrediction') && args.containsKey('answers')) {
            // Karena parameter `outcomePrediction` dan `answers` bersifat dinamis,
            // kita TIDAK BISA menggunakan `const` di depan `HasilPenilaianDiriPage`.
            return HasilPenilaianDiriPage(
              outcomePrediction: args['outcomePrediction'] as int,
              answers: args['answers'] as Map<String, dynamic>,
            );
          } else {
            // Fallback jika argumen tidak valid atau hilang
            print("ERROR: Rute /hasil_outcome dipanggil tanpa argumen yang valid. Argumen asli: $args");
            return const Scaffold(
              appBar: AppBar(title: const Text('Error')), // <--- Hapus 'const' di sini: appBar: const AppBar(...)
              body: Center(child: const Text('Argumen hasil tes perkembangan tidak valid atau hilang.')), // <--- Hapus 'const' di sini: body: const Center(...)
            );
          }
        },
        // Rute '/riwayat_outcome' dihapus karena '/hasil' sudah menangani kedua jenis riwayat.

        // --- PENANGANAN RUTE '/detailhasil' ---
        '/detailhasil': (context) {
          final args = ModalRoute.of(context)?.settings.arguments;

          int? resultCode;

          if (args is Map && args.containsKey('rawDiagnosisResult') && args['rawDiagnosisResult'] is String) {
            resultCode = int.tryParse(args['rawDiagnosisResult'] as String);
            print("INFO: Rute /detailhasil menerima 'rawDiagnosisResult' (String). Konversi ke int: $resultCode");
          }
          else if (args is Map && args.containsKey('testType') && args.containsKey('resultId')) {
            print("PERINGATAN: Rute /detailhasil dipanggil dengan format argumen lama: $args. Mencoba mengonversi 'resultId' ke int.");
            if (args['resultId'] is String) {
              resultCode = int.tryParse(args['resultId'] as String);
            } else if (args['resultId'] is int) {
              resultCode = args['resultId'] as int;
            }
            print("INFO: Hasil konversi 'resultId' ke int: $resultCode");
          }
          else if (args is int) {
            resultCode = args;
            print("INFO: Rute /detailhasil menerima argumen langsung int: $resultCode");
          }


          if (resultCode != null) {
            return DetailHasilDiagnosaPage(rawDiagnosisResultCode: resultCode);
          } else {
            print("ERROR: Rute /detailhasil dipanggil tanpa argumen kode diagnosis yang valid atau dapat dikonversi. Argumen asli: $args");
            return const Scaffold(
              appBar: AppBar(title: const Text('Error')), // <--- Hapus 'const' di sini: appBar: const AppBar(...)
              body: Center(child: const Text('Argumen kode diagnosis tidak valid atau hilang.')), // <--- Hapus 'const' di sini: body: const Center(...)
            );
          }
        },

        // Rute Pengaturan & Info
        '/edit_profile': (context) => const EditProfileScreen(),
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