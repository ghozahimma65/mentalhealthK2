// Nama file: lib/screen/PertanyaanScreen.dart
import 'package:flutter/material.dart';

class PertanyaanScreen extends StatefulWidget {
  const PertanyaanScreen({super.key});

  @override
  State<PertanyaanScreen> createState() => _PertanyaanScreenState();
}

class _PertanyaanScreenState extends State<PertanyaanScreen> {
  // Daftar pertanyaan akan dimuat berdasarkan testType
  List<Map<String, dynamic>> _questionsData = [];
  // Menyimpan jawaban (nilai) untuk setiap pertanyaan
  late List<dynamic> _answers; // Changed to dynamic to accommodate String for text field
  // Menyimpan tipe tes yang sedang dikerjakan
  String _currentTestType = 'Umum'; // Default

  bool _isLoading = true; // Untuk memuat pertanyaan

  @override
  void initState() {
    super.initState();
    // _answers diinisialisasi di didChangeDependencies setelah _questionsData dimuat
  }

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    if (_questionsData.isEmpty) {
      final String? testTypeArg =
          ModalRoute.of(context)?.settings.arguments as String?;
      if (testTypeArg != null) {
        _currentTestType = testTypeArg;
        _loadQuestionsBasedOnTestType(_currentTestType);
      } else {
        _loadQuestionsBasedOnTestType('Umum');
        print(
            "WARNING: testTypeArg is null, loading default questions for 'Umum'");
      }
    }
  }

  void _loadQuestionsBasedOnTestType(String testType) {
    print("Memuat pertanyaan untuk tipe tes: $testType");
    setState(() {
      _isLoading = true; // Mulai loading
    });

    // Simulasi pengambilan data
    Future.delayed(const Duration(milliseconds: 100), () {
      if (testType.toLowerCase().contains('depresi') ||
          testType == 'mental_health' ||
          testType == 'Umum') {
        _questionsData = [
          {
            "question": "Berapa usia Anda?",
            "type": "text_field", // Changed to text_field
            "options": [] // No options for text field
          },
          {
            "question": "Apa jenis kelamin Anda?",
            "type": "dropdown",
            "options": [
              {"value": 0, "label": "Pria 👨"},
              {"value": 1, "label": "Wanita 👩"}
            ]
          },
           {
            "question": "Seberapa parah gejala yang Anda rasakan?",
            "type": "dropdown",
            "options": [
              {"value": 1, "label": "Sangat Ringan"},
              {"value": 2, "label": "Ringan"},
              {"value": 3, "label": "Sedang"},
              {"value": 4, "label": "Agak Berat"},
              {"value": 5, "label": "Berat"},
              {"value": 6, "label": "Sangat Berat"},
              {"value": 7, "label": "Ekstrem"},
              {"value": 8, "label": "Kritis"},
              {"value": 9, "label": "Sangat Kritis"},
              {"value": 10, "label": "Maksimal"}
            ]
          },
          {
            "question": "Bagaimana suasana hati Anda dalam seminggu terakhir?",
            "type": "dropdown",
            "options": [
              {"value": 1, "label": "Sangat Buruk (Depresi/Sedih)"},
              {"value": 2, "label": "Buruk (Cemas/Resah)"},
              {"value": 3, "label": "Agak Buruk (Kurang Bersemangat)"},
              {"value": 4, "label": "Cukup Netral (Biasa Saja)"},
              {"value": 5, "label": "Netral (Stabil)"},
              {"value": 6, "label": "Agak Baik (Cukup Bersemangat)"},
              {"value": 7, "label": "Baik (Senang)"},
              {"value": 8, "label": "Sangat Baik (Gembira/Optimis)"},
              {"value": 9, "label": "Luar Biasa (Bahagia/Antusias)"},
              {"value": 10, "label": "Maksimal (Euforia/Penuh Energi)"}
            ]
          },
          {
            "question": "Seberapa baik kualitas tidur Anda?",
            "type": "dropdown",
            "options": [
              {"value": 1, "label": "Sangat Buruk (Tidak Tidur Sama Sekali)"},
              {"value": 2, "label": "Buruk (Tidur Sangat Gelisah)"},
              {"value": 3, "label": "Agak Buruk (Sulit Tidur Nyenyak)"},
              {"value": 4, "label": "Cukup Buruk (Terbangun Berkali-kali)"},
              {"value": 5, "label": "Sedang (Tidur Biasa Saja)"},
              {"value": 6, "label": "Cukup Baik (Tidur Cukup Nyenyak)"},
              {"value": 7, "label": "Agak Baik (Tidur Pulas)"},
              {"value": 8, "label": "Baik (Tidur Sangat Nyenyak)"},
              {"value": 9, "label": "Sangat Baik (Tidur Berkualitas Tinggi)"},
              {"value": 10, "label": "Sangat Optimal (Tidur Sempurna dan Segar)"}
            ]
          },
          {
            "question": "Berapa sering Anda melakukan aktivitas fisik (olahraga)?",
            "type": "dropdown",
            "options": [
              {"value": 1, "label": "Sangat Jarang (Tidak Aktif)"},
              {"value": 2, "label": "Jarang (Sangat Sedikit Aktivitas)"},
              {"value": 3, "label": "Cukup (Aktivitas Ringan-Sedang)"},
              {"value": 4, "label": "Sering (Aktivitas Sedang-Tinggi)"},
              {"value": 5, "label": "Sangat Sering (Sangat Aktif)"},
              {"value": 6, "label": "Teratur (Aktivitas Terorganisir)"},
              {"value": 7, "label": "Aktif (Sering Berolahraga)"},
              {"value": 8, "label": "Sangat Aktif (Intensitas Tinggi)"},
              {"value": 9, "label": "Profesional (Latihan Ekstrem)"},
              {"value": 10, "label": "Atlet Elit (Aktivitas Maksimal)"}
            ]
          },
          // Question 8 (original index) "Apakah Anda sedang menjalani pengobatan (medikasi)?" has been removed.
          // Question 9 (original index) "Apakah Anda sedang menjalani terapi psikologis?" has been removed.
          // Question 10 (original index) "Berapa lama Anda sudah menjalani perawatan kesehatan mental?" has been removed.
          {
            "question": "Seberapa sering Anda merasa stres?",
            "type": "dropdown",
            "options": [
              {"value": 1, "label": "😌 Sangat Rendah (Tidak Stres)"},
              {"value": 2, "label": "😊 Rendah"},
              {"value": 3, "label": "😐 Sedang"},
              {"value": 4, "label": "😟 Cukup Tinggi"},
              {"value": 5, "label": "😰 Tinggi"},
              {"value": 6, "label": "😥 Sangat Tinggi"},
              {"value": 7, "label": "😩 Berlebihan"},
              {"value": 8, "label": "🤯 Kritis"},
              {"value": 9, "label": "😵 Parah"},
              {"value": 10, "label": "💀 Sangat Parah (Tidak Terkendali)"}
            ]
          },
          // Question 12 (original index) "Menurut Anda, apakah Anda mengalami kemajuan dalam perawatan Anda?" has been removed.
          // Question 13 (original index) "Seberapa sering Anda merasa emosi negatif seperti sedih, marah, atau cemas?" has been removed.
          // Question 14 (original index) "Seberapa patuh Anda mengikuti rencana perawatan atau pengobatan Anda?" has been removed.
          {
            "question": "Bagaimana Suasana Hati Anda Saat ini?",
            "type": "dropdown",
            "options": [
              {"value": 0, "label": "😟 Anxious (Cemas)"},
              {"value": 1, "label": "😔 Depressed (Sedih)"},
              {"value": 2, "label": "🤩 Excited (Gembira)"},
              {"value": 3, "label": "😊 Happy (Senang)"},
              {"value": 4, "label": "😐 Neutral (Netral)"},
              {"value": 5, "label": "😥 Stressed (Stres)"}
            ]
          },
        ];
      } else if (testType.toLowerCase().contains('anxiety')) {
        _questionsData = [
          {
            "question": "Apakah Anda sering merasa gugup, cemas, atau tegang?",
            "type": "likert",
            "options": ["1", "2", "3", "4", "5"]
          },
          {
            "question": "Apakah Anda tidak bisa menghentikan atau mengendalikan rasa khawatir?",
            "type": "likert",
            "options": ["1", "2", "3", "4", "5"]
          },
          {
            "question": "Apakah Anda terlalu banyak khawatir tentang berbagai hal yang berbeda?",
            "type": "likert",
            "options": ["1", "2", "3", "4", "5"]
          },
          {
            "question": "Apakah Anda merasa kesulitan untuk bersantai?",
            "type": "likert",
            "options": ["1", "2", "3", "4", "5"]
          },
        ];
      } else {
        // Default atau untuk tipe tes lain
        _questionsData = [
          {
            "question": "Pertanyaan default 1 untuk tes $testType?",
            "type": "likert",
            "options": ["1", "2", "3", "4", "5"]
          },
          {
            "question": "Pertanyaan default 2 untuk tes $testType?",
            "type": "likert",
            "options": ["1", "2", "3", "4", "5"]
          },
        ];
      }

      if (mounted) {
        setState(() {
          // Inisialisasi _answers dengan nilai default
          _answers = List<dynamic>.generate(_questionsData.length, (index) {
            final question = _questionsData[index];
            if (question['type'] == 'likert') {
              return 3; // Default 3 for likert
            } else if (question['type'] == 'dropdown') {
              final options = question['options'] as List<Map<String, dynamic>>;
              return options.isNotEmpty ? options[0]['value'] as int : 0; // Take first value for dropdown
            } else if (question['type'] == 'text_field') {
              return ''; // Default empty string for text field
            }
            return 0; // Default fallback
          });
          _isLoading = false; // Selesai loading
        });
      }
    });
  }

  // Fungsi untuk kalkulasi hasil tes
  // PENTING: GANTI DENGAN METODE SKORING VALID SESUAI JENIS TES
  Map<String, dynamic> _calculateResults() {
    if (_answers.isEmpty) {
      return {
        'scoreRingan': 0.0,
        'scoreSedang': 0.0,
        'scoreBerat': 0.0,
        'interpretasi': 'Tidak ada jawaban yang diberikan.',
      };
    }

    double totalScore = 0.0;
    int scoredQuestionsCount = 0;

    for (int i = 0; i < _questionsData.length; i++) {
      final question = _questionsData[i];
      final answer = _answers[i];

      // Only include 'likert' and 'dropdown' questions in the score calculation
      // You might need to adjust this logic based on how 'Usia' (TextField) should be handled if it's part of a scoring system.
      // For now, it's excluded from averageScore.
      if (question['type'] == 'likert' && answer is int) {
        totalScore += answer;
        scoredQuestionsCount++;
      } else if (question['type'] == 'dropdown' && answer is int) {
        totalScore += answer;
        scoredQuestionsCount++;
      }
    }

    double averageScore = scoredQuestionsCount > 0 ? totalScore / scoredQuestionsCount : 0.0;

    double scoreR = 0.0, scoreS = 0.0, scoreB = 0.0;
    String interpretasi = "Tidak ada interpretasi yang cocok.";

    // Contoh skoring SANGAT SEDERHANA, PERLU DISESUAIKAN!
    // Asumsi skor 1-5 (1=Tidak Pernah, 5=Hampir Setiap Hari)
    // Untuk dropdown dengan skala 1-10, perlu penyesuaian pada logika ini
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
          : _questionsData.isEmpty
              ? Center(
                  child: Text(
                      "Tidak ada pertanyaan untuk tes $_currentTestType.")) // Jika pertanyaan kosong setelah load
              : ListView.builder(
                  padding: const EdgeInsets.fromLTRB(
                      16, 16, 16, 90), // Padding untuk tombol submit
                  itemCount: _questionsData.length,
                  itemBuilder: (context, index) {
                    final questionItem = _questionsData[index];
                    final questionText =
                        '${index + 1}. ${questionItem['question']}';
                    final questionType = questionItem['type'];

                    Widget inputWidget;

                    if (questionType == 'likert') {
                      // Tampilan Radio Button untuk pertanyaan Likert 1-5
                      inputWidget = Row(
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
                                activeColor: Theme.of(context).primaryColor,
                              ),
                              Text("$value"),
                            ],
                          );
                        }),
                      );
                    } else if (questionType == 'dropdown') {
                      // Tampilan Dropdown untuk pertanyaan spesifik
                      final options =
                          questionItem['options'] as List<Map<String, dynamic>>;
                      inputWidget = DropdownButtonFormField<int>(
                        decoration: InputDecoration(
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(8.0),
                            borderSide: BorderSide.none,
                          ),
                          filled: true,
                          fillColor: Colors.grey[200],
                          contentPadding: const EdgeInsets.symmetric(
                              horizontal: 12, vertical: 8),
                        ),
                        value: _answers[index] is int ? _answers[index] : null, // Ensure value is int or null
                        items: options.map<DropdownMenuItem<int>>((option) {
                          return DropdownMenuItem<int>(
                            value: option['value'] as int,
                            child: Text(option['label'] as String),
                          );
                        }).toList(),
                        onChanged: (int? newValue) {
                          if (newValue != null) {
                            setState(() {
                              _answers[index] = newValue;
                            });
                          }
                        },
                      );
                    } else if (questionType == 'text_field') {
                      // Tampilan TextField untuk input teks (usia)
                      inputWidget = TextFormField(
                        keyboardType: TextInputType.number, // Suggest numeric keyboard for age
                        decoration: InputDecoration(
                          hintText: "Masukkan usia Anda",
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(8.0),
                            borderSide: BorderSide.none,
                          ),
                          filled: true,
                          fillColor: Colors.grey[200],
                          contentPadding: const EdgeInsets.symmetric(
                              horizontal: 12, vertical: 8),
                        ),
                        onChanged: (newValue) {
                          setState(() {
                            _answers[index] = newValue;
                          });
                        },
                        initialValue: _answers[index] is String ? _answers[index] : '', // Set initial value if already answered
                      );
                    }
                    else {
                      inputWidget = const Text("Tipe pertanyaan tidak dikenal.");
                    }

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
                              questionText,
                              style: const TextStyle(
                                  fontSize: 16, fontWeight: FontWeight.w500),
                            ),
                            const SizedBox(height: 16),
                            inputWidget, // Widget input yang dinamis
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
          onPressed: (_questionsData.isEmpty || _isLoading)
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