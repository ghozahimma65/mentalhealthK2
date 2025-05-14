// Nama file: PertanyaanScreen.dart
import 'package:flutter/material.dart';

class PertanyaanScreen extends StatefulWidget {
  const PertanyaanScreen({super.key});

  @override
  State<PertanyaanScreen> createState() => _PertanyaanScreenState();
}

class _PertanyaanScreenState extends State<PertanyaanScreen> {
  final List<String> questions = [
    "Apakah Anda sering merasa sedih, murung, atau tidak bersemangat dalam satu minggu terakhir?",
    "Apakah Anda merasa kehilangan minat atau kesenangan dalam melakukan hal-hal yang biasanya Anda nikmati?",
    "Apakah Anda mengalami kesulitan tidur atau tidur berlebihan akhir-akhir ini?",
    "Apakah Anda merasa cemas, khawatir berlebihan, atau sulit menenangkan pikiran Anda?",
    "Apakah Anda merasa lelah, tidak bertenaga, atau kehabisan energi meskipun tidak melakukan aktivitas berat?",
    "Apakah Anda merasa kesulitan berkonsentrasi saat membaca, bekerja, atau menonton sesuatu?",
    "Apakah Anda merasa tidak berguna, bersalah, atau menyalahkan diri sendiri secara berlebihan?",
    "Apakah Anda menjauh dari orang-orang atau enggan bersosialisasi seperti biasanya?",
    "Apakah Anda mengalami perubahan nafsu makan (menurun atau meningkat drastis)?",
    "Apakah Anda merasa hidup tidak berarti atau muncul pikiran untuk menyakiti diri sendiri?"
  ];

  late List<int> _answers;

  @override
  void initState() {
    super.initState();
    _answers = List<int>.filled(questions.length, 3); // Default: nilai tengah (3)
  }

  Map<String, dynamic> _calculateResults() {
    double averageScore =
        _answers.reduce((a, b) => a + b) / _answers.length;
    double scoreR = (averageScore <= 2.5) ? 60 : (averageScore <= 4.0 ? 30 : 20);
    double scoreS = (averageScore <= 2.5) ? 20 : (averageScore <= 4.0 ? 40 : 30);
    double scoreB = (averageScore <= 2.5) ? 20 : (averageScore <= 4.0 ? 30 : 50);
    String interpretasi = (averageScore <= 2.5)
        ? "Kecenderungan depresi ringan."
        : (averageScore <= 4.0)
            ? "Kecenderungan depresi sedang. Konsultasikan ke profesional bila perlu."
            : "Kecenderungan depresi berat. Segera cari bantuan profesional.";

    return {
      'scoreRingan': scoreR,
      'scoreSedang': scoreS,
      'scoreBerat': scoreB,
      'interpretasi': interpretasi,
    };
  }

  @override
  Widget build(BuildContext context) {
    const String testType = 'Depresi';

    return Scaffold(
      appBar: AppBar(
        title: Text('Pertanyaan Tes $testType'),
      ),
      backgroundColor: Colors.deepPurple,
      body: ListView.builder(
        padding: const EdgeInsets.fromLTRB(16, 16, 16, 80),
        itemCount: questions.length,
        itemBuilder: (context, index) {
          return Card(
            elevation: 2,
            margin: const EdgeInsets.only(bottom: 16),
            child: Padding(
              padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 12),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text('${index + 1}. ${questions[index]}',
                      style: const TextStyle(fontSize: 16)),
                  const SizedBox(height: 12),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                    children: List.generate(5, (i) {
                      int value = i + 1;
                      return Column(
                        children: [
                          Radio<int>(
                            value: value,
                            groupValue: _answers[index],
                            onChanged: (val) {
                              setState(() {
                                _answers[index] = val!;
                              });
                            },
                          ),
                          Text('$value'),
                        ],
                      );
                    }),
                  ),
                  const SizedBox(height: 4),
                ],
              ),
            ),
          );
        },
      ),
      bottomNavigationBar: Padding(
        padding: const EdgeInsets.all(16),
        child: ElevatedButton(
          style: ElevatedButton.styleFrom(
            padding: const EdgeInsets.symmetric(vertical: 15),
          ),
          onPressed: () {
            final results = _calculateResults();
            final String idHasil = DateTime.now().toIso8601String();

            Navigator.pushReplacementNamed(
              context,
              '/detailhasil',
              arguments: {
                'testType': testType,
                'resultId': idHasil,
                'scoreRingan': results['scoreRingan'],
                'scoreSedang': results['scoreSedang'],
                'scoreBerat': results['scoreBerat'],
                'interpretasi': results['interpretasi'],
              },
            );
          },
          child: const Text('Submit', style: TextStyle(fontSize: 16)),
        ),
      ),
    );
  }
}