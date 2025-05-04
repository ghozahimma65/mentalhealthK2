// Nama file: PertanyaanScreen.dart (atau nama file Anda)
import 'package:flutter/material.dart';

class PertanyaanScreen extends StatefulWidget {
  const PertanyaanScreen({super.key});

  @override
  State<PertanyaanScreen> createState() => _PertanyaanScreenState();
}

class _PertanyaanScreenState extends State<PertanyaanScreen> {
  final List<String> questions = [
    "Saya merasa sedih hampir sepanjang hari.",
    "Saya sulit menikmati hal-hal yang biasanya saya sukai.",
    "Saya merasa lelah tanpa alasan.",
    "Saya sulit berkonsentrasi pada tugas harian.",
    "Saya merasa tidak berharga atau bersalah.",
  ];
  late List<double> _answers;

  @override
  void initState() {
    super.initState();
    _answers =
        List<double>.filled(questions.length, 3.0); // Default value tengah
  }

  // --- GANTI LOGIKA INI DENGAN PERHITUNGAN SKOR ANDA ---
  Map<String, dynamic> _calculateResults() {
    print(
        "PERHATIAN: Menggunakan kalkulasi hasil placeholder!"); // Hapus saat implementasi
    // Implementasikan cara Anda menghitung skor Ringan, Sedang, Berat
    // dan menentukan interpretasi berdasarkan _answers list.
    double averageScore = _answers.reduce((a, b) => a + b) / _answers.length;
    double scoreR =
        (averageScore <= 2.5) ? 60 : (averageScore <= 4.0 ? 30 : 20);
    double scoreS =
        (averageScore <= 2.5) ? 20 : (averageScore <= 4.0 ? 40 : 30);
    double scoreB =
        (averageScore <= 2.5) ? 20 : (averageScore <= 4.0 ? 30 : 50);
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
  // --- AKHIR BAGIAN YANG HARUS DIGANTI ---

  @override
  Widget build(BuildContext context) {
    const String testType = 'Depresi'; // Asumsi tipe tes

    return Scaffold(
      appBar: AppBar(
        title: Text('Pertanyaan Tes $testType'),
      ),
      body: ListView.builder(
        padding: const EdgeInsets.fromLTRB(16, 16, 16, 80), // Padding bawah
        itemCount: questions.length,
        itemBuilder: (context, index) {
          return Card(
            elevation: 2,
            margin: const EdgeInsets.only(bottom: 16),
            child: Padding(
              padding:
                  const EdgeInsets.symmetric(vertical: 8.0, horizontal: 12.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text('${index + 1}. ${questions[index]}',
                      style: const TextStyle(fontSize: 16)),
                  const SizedBox(height: 8),
                  Slider(
                    value: _answers[index],
                    min: 1,
                    max: 5,
                    divisions: 4,
                    label: _answers[index].round().toString(),
                    onChanged: (value) {
                      setState(() {
                        _answers[index] = value;
                      });
                    },
                  ),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: const [
                      Text('Sgt. Jarang',
                          style: TextStyle(fontSize: 12, color: Colors.grey)),
                      Text('Sgt. Sering',
                          style: TextStyle(fontSize: 12, color: Colors.grey)),
                    ],
                  )
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
            final results = _calculateResults(); // Hitung hasil
            final String idHasil = DateTime.now().toIso8601String();

            // Navigasi ke detail hasil dengan data
            Navigator.pushReplacementNamed(
              context,
              '/detailhasil', // Target: layar pie chart
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
