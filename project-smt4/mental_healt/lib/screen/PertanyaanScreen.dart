import 'package:flutter/material.dart';

class PertanyaanScreen extends StatelessWidget {
  const PertanyaanScreen({super.key});

  @override
  Widget build(BuildContext context) {
    // Dummy daftar pertanyaan
    List<String> questions = [
      "Saya merasa sedih hampir sepanjang hari.",
      "Saya sulit menikmati hal-hal yang biasanya saya sukai.",
      "Saya merasa lelah tanpa alasan.",
      "Saya sulit berkonsentrasi pada tugas harian.",
      "Saya merasa tidak berharga atau bersalah.",
    ];

    return Scaffold(
      appBar: AppBar(
        title: const Text('Pertanyaan Tes'),
        backgroundColor: Colors.blueAccent,
      ),
      body: ListView.builder(
        padding: const EdgeInsets.all(16),
        itemCount: questions.length,
        itemBuilder: (context, index) {
          return Card(
            elevation: 2,
            margin: const EdgeInsets.only(bottom: 16),
            child: ListTile(
              title: Text(questions[index]),
              subtitle: Slider(
                value: 2,
                min: 1,
                max: 5,
                divisions: 4,
                onChanged: (value) {},
              ),
            ),
          );
        },
      ),
      bottomNavigationBar: Padding(
        padding: const EdgeInsets.all(16),
        child: ElevatedButton(
          onPressed: () {
            Navigator.pushNamed(context, '/hasil');
          },
          child: const Text('Submit'),
        ),
      ),
    );
  }
}