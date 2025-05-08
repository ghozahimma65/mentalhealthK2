import 'package:flutter/material.dart';

class KuisScreen extends StatelessWidget {
  const KuisScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Informasi Tes'),
        backgroundColor: Colors.blueAccent,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Informasi Tes',
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 16),
            const Text(
              'Tes ini membantu mengukur tingkat depresi, kecemasan, dan kondisi mental lainnya. Jawablah setiap pertanyaan dengan jujur.',
              style: TextStyle(fontSize: 16),
            ),
            const Spacer(),
            Center(
              child: ElevatedButton(
                onPressed: () {
                  Navigator.pushNamed(context, '/pertanyaan');
                },
                child: const Text('Mulai Tes!'),
              ),
            ),
          ],
        ),
      ),
    );
  }
}