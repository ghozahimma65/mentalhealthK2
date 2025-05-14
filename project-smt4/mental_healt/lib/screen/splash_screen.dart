import 'package:flutter/material.dart';
import 'unboarding_screen.dart';

class SplashScreen extends StatefulWidget {
  const SplashScreen({super.key});

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {

  @override
  void initState() {
    super.initState();
    Future.delayed(const Duration(seconds: 3), () {
      if (!mounted) return; // CEK MOUNTED SEBELUM NAVIGATOR
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => const unboarding_screen()),
      );
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Image.asset('assets/images/logo.png', width: 120),
            const SizedBox(height: 20),
          ],
        ),
      ),
    );
  }
}