import 'package:flutter/material.dart';

import 'package:mobile_project/screen/HasilTesScreen.dart';
import 'package:mobile_project/screen/KuisScreen.dart';
import 'package:mobile_project/screen/PertanyaanScreen.dart';
import 'package:mobile_project/screen/TesDiagnosaScreen.dart';
import 'package:mobile_project/screen/login_screen.dart';
import 'package:mobile_project/screen/signup_screen.dart';
import 'package:mobile_project/screen/splash_screen.dart';
import 'package:mobile_project/screen/unboarding_screen.dart';

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
      initialRoute: '/splash_screen', // <-- ubah ke splash
      routes: {
        '/splash_screen': (context) => const SplashScreen(), // <-- splash sebagai awal
        '/onboarding': (context) => const unboarding_screen(),
        '/login': (context) => const LoginScreen(),
        '/signup': (context) => const SignUpScreen(),
        '/tesdiagnosa': (context) => const TesDiagnosaScreen(),
        '/kuis': (context) => const KuisScreen(),
        '/pertanyaan': (context) => const PertanyaanScreen(),
        '/hasil': (context) => const HasilTesScreen(),
      },
    );
  }
}
