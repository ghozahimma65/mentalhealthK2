import 'package:flutter/material.dart';
import 'package:mental_healt/screens/unboarding_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Diagnosa',
      home: unboarding_screen(),
      debugShowCheckedModeBanner: false,
    );
  }
}
