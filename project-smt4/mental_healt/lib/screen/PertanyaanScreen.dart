// Nama file: lib/screen/PertanyaanScreen.dart
import 'package:flutter/material.dart';

class PertanyaanScreen extends StatefulWidget {
  const PertanyaanScreen({super.key});

  @override
  State<PertanyaanScreen> createState() => _PertanyaanScreenState();
}

class _PertanyaanScreenState extends State<PertanyaanScreen> {
  // Daftar pertanyaan akan dimuat berdasarkan testType
  List<String> _questions = [];
  // Menyimpan jawaban (nilai 1-5) untuk setiap pertanyaan
  late List<int> _answers;
  // Menyimpan tipe tes yang sedang dikerjakan
  String _currentTestType = 'Umum'; // Default

  bool _isLoading = true; // Untuk memuat pertanyaan

  // Label untuk pilihan jawaban Radio
  final List<String> _optionLabels = ["1", "2", "3", "4", "5"];
  // Anda bisa menggunakan label teks jika mau:
  // final List<String> _optionTextLabels = ["Sangat Jarang", "Jarang", "Kadang", "Sering", "Sangat Sering"];

  @override
  void initState() {
    super.initState();
    // _answers diinisialisasi di didChangeDependencies setelah _questions dimuat
  }

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    // Ambil argumen testType dari KuisScreen hanya sekali saat dependensi berubah
    // atau jika _questions masih kosong (untuk menghindari reload berlebihan)
    if (_questions.isEmpty) {
      final String? testTypeArg =
          ModalRoute.of(context)?.settings.arguments as String?;
      if (testTypeArg != null) {
        _currentTestType = testTypeArg;
        _loadQuestionsBasedOnTestType(_currentTestType);
      } else {
        // Jika tidak ada argumen, load pertanyaan default atau tampilkan error
        _loadQuestionsBasedOnTestType('Umum'); // Load default questions
        print(
            "WARNING: testTypeArg is null, loading default questions for 'Umum'");
      }
    }
  }

  void _loadQuestionsBasedOnTestType(String testType) {
    // TODO: Implementasikan logika untuk memuat pertanyaan dari database/API
    // berdasarkan testType. Untuk sekarang, kita pakai data hardcoded.
    print("Memuat pertanyaan untuk tipe tes: $testType");
    setState(() {
      _isLoading = true; // Mulai loading
    });

    // Simulasi pengambilan data
    Future.delayed(const Duration(milliseconds: 100), () {
      if (testType.toLowerCase().contains('depresi') ||
          testType == 'mental_health' ||
          testType == 'Umum') {
        _questions = [
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
      } else if (testType.toLowerCase().contains('anxiety')) {
        _questions = [
          "Apakah Anda sering merasa gugup, cemas, atau tegang?",
          "Apakah Anda tidak bisa menghentikan atau mengendalikan rasa khawatir?",
          "Apakah Anda terlalu banyak khawatir tentang berbagai hal yang berbeda?",
          "Apakah Anda merasa kesulitan untuk bersantai?",
          // Tambahkan pertanyaan spesifik anxiety lainnya
        ];
      } else {
        // Default atau untuk tipe tes lain
        _questions = [
          "Pertanyaan default 1 untuk tes $testType?",
          "Pertanyaan default 2 untuk tes $testType?",
        ];
      }

      if (mounted) {
        // Pastikan widget masih ada
        setState(() {
          _answers = List<int>.filled(
              _questions.length, 3); // Inisialisasi ulang _answers
          _isLoading = false; // Selesai loading
        });
      }
    });
  }

  // Fungsi untuk kalkulasi hasil tes
  // PENTING: GANTI DENGAN METODE SKORING VALID SESUAI JENIS TES
  Map<String, dynamic> _calculateResults() {
    if (_answers.isEmpty) {
      // Pengaman jika tidak ada jawaban
      return {
        'scoreRingan': 0.0,
        'scoreSedang': 0.0,
        'scoreBerat': 0.0,
        'interpretasi': 'Tidak ada jawaban yang diberikan.',
      };
    }

    double averageScore = _answers.reduce((a, b) => a + b) / _answers.length;
    double scoreR = 0.0, scoreS = 0.0, scoreB = 0.0;
    String interpretasi = "Tidak ada interpretasi yang cocok.";

    // Contoh skoring SANGAT SEDERHANA, PERLU DISESUAIKAN!
    // Asumsi skor 1-5 (1=Tidak Pernah, 5=Hampir Setiap Hari)
    if (_currentTestType.toLowerCase().contains('depresi') ||
        _currentTestType == 'mental_health' ||
        _currentTestType == 'Umum') {
      if (averageScore <= 2.0) {
        scoreR = 60;
        scoreS = 20;
        scoreB = 20;
        interpretasi =
            "Berdasarkan jawaban Anda, ada indikasi kecenderungan gejala ringan. Pertimbangkan untuk berbicara dengan teman atau keluarga, dan perhatikan pola perasaan Anda.";
      } else if (averageScore <= 3.5) {
        scoreR = 30;
        scoreS = 40;
        scoreB = 30;
        interpretasi =
            "Anda menunjukkan beberapa gejala pada tingkat sedang. Sangat disarankan untuk berkonsultasi dengan tenaga profesional (psikolog/psikiater) untuk pemahaman dan penanganan lebih lanjut.";
      } else {
        scoreR = 20;
        scoreS = 30;
        scoreB = 50;
        interpretasi =
            "Gejala yang Anda tunjukkan mengarah pada tingkat berat. Mohon segera cari bantuan profesional untuk evaluasi dan dukungan yang komprehensif.";
      }
    } else if (_currentTestType.toLowerCase().contains('anxiety')) {
      // TODO: Buat logika skoring spesifik untuk Anxiety
      if (averageScore <= 2.0) {
        scoreR = 70;
        scoreS = 20;
        scoreB = 10;
        interpretasi = "Indikasi kecemasan pada tingkat ringan.";
      } else if (averageScore <= 3.5) {
        scoreR = 30;
        scoreS = 50;
        scoreB = 20;
        interpretasi =
            "Indikasi kecemasan pada tingkat sedang. Pertimbangkan konsultasi.";
      } else {
        scoreR = 10;
        scoreS = 30;
        scoreB = 60;
        interpretasi =
            "Indikasi kecemasan pada tingkat berat. Segera konsultasi.";
      }
    } else {
      // Skoring default untuk tipe tes lain
      scoreR = 33.3;
      scoreS = 33.4;
      scoreB = 33.3;
      interpretasi =
          "Hasil tes untuk $_currentTestType. Silakan konsultasikan dengan ahli untuk interpretasi lebih lanjut.";
    }

    return {
      'scoreRingan': scoreR,
      'scoreSedang': scoreS,
      'scoreBerat': scoreB,
      'interpretasi': interpretasi,
    };
  }

  @override
  Widget build(BuildContext context) {
    String appBarTitle = 'Pertanyaan Tes';
    if (_currentTestType.isNotEmpty && _currentTestType != 'Umum') {
      appBarTitle = 'Tes ${_currentTestType.replaceAll('_', ' ')}';
    } else if (_currentTestType == 'mental_health') {
      appBarTitle = 'Tes Kesehatan Mental';
    }

    return Scaffold(
      appBar: AppBar(
        title: Text(appBarTitle),
      ),
      backgroundColor: Colors.grey.shade100,
      body: _isLoading
          ? const Center(
              child:
                  CircularProgressIndicator()) // Tampilkan loading jika pertanyaan belum siap
          : _questions.isEmpty
              ? Center(
                  child: Text(
                      "Tidak ada pertanyaan untuk tes $_currentTestType.")) // Jika pertanyaan kosong setelah load
              : ListView.builder(
                  padding: const EdgeInsets.fromLTRB(
                      16, 16, 16, 90), // Padding untuk tombol submit
                  itemCount: _questions.length,
                  itemBuilder: (context, index) {
                    return Card(
                      elevation: 2,
                      margin: const EdgeInsets.only(bottom: 16),
                      shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12)),
                      child: Padding(
                        padding: const EdgeInsets.all(16.0),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              '${index + 1}. ${_questions[index]}',
                              style: const TextStyle(
                                  fontSize: 16, fontWeight: FontWeight.w500),
                            ),
                            const SizedBox(height: 16),
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: List.generate(5, (i) {
                                int value = i + 1;
                                return Column(
                                  children: [
                                    Radio<int>(
                                      value: value,
                                      groupValue: _answers[index],
                                      onChanged: (val) {
                                        if (val != null) {
                                          setState(() {
                                            _answers[index] = val;
                                          });
                                        }
                                      },
                                      activeColor:
                                          Theme.of(context).primaryColor,
                                    ),
                                    Text(_optionLabels[
                                        i]), // Menggunakan _optionLabels
                                  ],
                                );
                              }),
                            ),
                          ],
                        ),
                      ),
                    );
                  },
                ),
      bottomNavigationBar: Padding(
        padding: const EdgeInsets.all(16.0),
        child: ElevatedButton(
          style: ElevatedButton.styleFrom(
              padding: const EdgeInsets.symmetric(vertical: 15),
              backgroundColor:
                  Theme.of(context).primaryColor, // Menggunakan warna tema
              foregroundColor: Colors.white,
              textStyle:
                  const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
              shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(10))),
          onPressed: (_questions.isEmpty || _isLoading)
              ? null
              : () {
                  // Nonaktifkan tombol jika loading/tidak ada pertanyaan
                  final results = _calculateResults();
                  final String idHasil = DateTime.now().toIso8601String();

                  Navigator.pushReplacementNamed(
                    context,
                    '/detailhasil',
                    arguments: {
                      'testType': _currentTestType,
                      'resultId': idHasil,
                      'scoreRingan': results['scoreRingan'],
                      'scoreSedang': results['scoreSedang'],
                      'scoreBerat': results['scoreBerat'],
                      'interpretasi': results['interpretasi'],
                    },
                  );
                },
          child: const Text('Submit Jawaban'),
        ),
      ),
    );
  }
}
