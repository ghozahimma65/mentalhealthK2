// lib/screen/PertanyaanScreen.dart

import 'package:flutter/material.dart';
import 'package:get/get.dart'; // Import GetX
import 'package:flutter_easyloading/flutter_easyloading.dart';
import '../models/diagnosis_result.dart';
import '../controller/diagnosis_controller.dart'; // Menggunakan DiagnosisController

class PertanyaanScreen extends StatefulWidget {
  const PertanyaanScreen({super.key});

  @override
  State<PertanyaanScreen> createState() => _PertanyaanScreenState();
}

class _PertanyaanScreenState extends State<PertanyaanScreen> {
  // Dapatkan instance controller menggunakan Get.find()
  final DiagnosisController _diagnosisController =
      Get.find<DiagnosisController>();

  List<Map<String, dynamic>> _questionsData = [];
  late List<dynamic>
      _answers; // Menggunakan dynamic untuk menampung int atau String (usia)
  String _currentTestType = 'Umum';

  final TextEditingController _ageController = TextEditingController();

  @override
  void initState() {
    super.initState();
    // _answers akan diinisialisasi di didChangeDependencies setelah _questionsData dimuat
  }

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    if (_questionsData.isEmpty) {
      // Ambil argumen dari GetX
      final String? testTypeArg = Get.arguments as String?;
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

  @override
  void dispose() {
    _ageController.dispose();
    super.dispose();
  }

  void _loadQuestionsBasedOnTestType(String testType) {
    print("Memuat pertanyaan untuk tipe tes: $testType");

    Future.delayed(const Duration(milliseconds: 100), () {
      if (testType.toLowerCase().contains('depresi') ||
          testType == 'mental_health' ||
          testType == 'umum') {
        _questionsData = [
          {
            "question": "Berapa usia Anda?",
            "type": "text_field", // input teks untuk usia
            "options": []
          },
          {
            "question": "Apa jenis kelamin Anda?",
            "type": "dropdown",
            "options": [
              {"value": 0, "label": "Laki-laki 👨"},
              {"value": 1, "label": "Perempuan 👩"}
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
          {
            "question": "Bagaimana Suasana Hati Anda Saat ini (AI-Detected)?",
            "type": "dropdown",
            "options": [
              {"value": 0, "label": "Cemas"},
              {"value": 1, "label": "Depresi"},
              {"value": 2, "label": "Gembira"},
              {"value": 3, "label": "Senang"},
              {"value": 4, "label": "Netral"},
              {"value": 5, "label": "Stres"}
            ]
          },
        ];
      } else if (testType.toLowerCase().contains('anxiety')) {
        _questionsData = [
          {
            "question": "Apakah Anda sering merasa gugup, cemas, atau tegang?",
            "type": "dropdown",
            "options": [
              {"value": 1, "label": "Tidak Pernah"},
              {"value": 2, "label": "Jarang"},
              {"value": 3, "label": "Kadang-kadang"},
              {"value": 4, "label": "Sering"},
              {"value": 5, "label": "Hampir Setiap Hari"}
            ]
          },
        ];
      } else {
        _questionsData = [
          {
            "question": "Pertanyaan default 1 untuk tes $testType?",
            "type": "dropdown",
            "options": [
              {"value": 1, "label": "Opsi A"},
              {"value": 2, "label": "Opsi B"},
              {"value": 3, "label": "Opsi C"}
            ]
          },
        ];
      }

      if (mounted) {
        setState(() {
          // Inisialisasi _answers dengan nilai default
          _answers = List<dynamic>.generate(_questionsData.length, (index) {
            final question = _questionsData[index];
            if (question['type'] == 'dropdown') {
              final options =
                  question['options'] as List<Map<String, dynamic>>;
              return options.isNotEmpty ? options[0]['value'] as int : null;
            } else if (question['type'] == 'text_field') {
              return ''; // Default string kosong untuk text field
            }
            return null; // Fallback jika tipe tidak dikenal
          });
        });
      }
    });
  }

  void _submitAnswers() async {
    // Validasi input usia (pertanyaan pertama)
    if (_answers.isEmpty ||
        _answers[0] == null ||
        _answers[0].toString().isEmpty ||
        int.tryParse(_answers[0].toString()) == null) {
      EasyLoading.showError('Mohon masukkan usia Anda.');
      return;
    }

    // Validasi semua dropdown sudah dipilih
    for (int i = 1; i < _questionsData.length; i++) {
      // Mulai dari index 1 karena index 0 adalah text_field
      if (_questionsData[i]['type'] == 'dropdown' && _answers[i] == null) {
        EasyLoading.showError('Mohon lengkapi semua pertanyaan.');
        return;
      }
    }

    try {
      // Pastikan urutan dan tipe data sesuai dengan model DiagnosisInput Anda
      final input = DiagnosisInput(
        age: int.parse(_answers[0].toString()),
        gender: _answers[1] as int,
        symptomSeverity: _answers[2] as int,
        moodScore: _answers[3] as int,
        sleepQuality: _answers[4] as int,
        physicalActivity:
            (_answers[5] as int).toDouble(), // Pastikan double jika diperlukan
        stressLevel: _answers[6] as int,
        aiDetectedEmotionalState: _answers[7] as int,
      );

      print("Mengirim data diagnosis: ${input.toJson()}");

      // Panggil metode performDiagnosis dari controller
      await _diagnosisController.performDiagnosis(input);

      // Setelah performDiagnosis selesai, cek hasil atau error dari controller
      if (_diagnosisController.latestDiagnosis != null) {
        // Navigasi ke halaman hasil dengan hasil prediksi dari API menggunakan GetX
        Get.offNamed(
          '/detailhasil', // Rute yang didefinisikan di GetMaterialApp
          arguments: {
            'rawDiagnosisResult':
                _diagnosisController.latestDiagnosis!.diagnosis
          }, // Mengirim Map sebagai argumen
        );
      } else if (_diagnosisController.errorMessage != null) {
        // Pesan error sudah ditangani dan ditampilkan oleh EasyLoading di dalam controller
        // Tidak perlu SnackBar tambahan di sini.
      }
    } catch (e) {
      EasyLoading.showError(
          'Terjadi kesalahan tidak terduga saat memproses jawaban: $e');
      print("Error in _submitAnswers: $e");
    }
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
        backgroundColor: Theme.of(context).primaryColor,
        foregroundColor: Colors.white,
      ),
      backgroundColor: Colors.grey.shade100,
      body: Obx(() {
        // Gunakan Obx untuk mendengarkan perubahan pada _isLoading di controller
        // Tampilkan indikator saat loading, atau jika data pertanyaan belum dimuat
        if (_diagnosisController.isLoading || _questionsData.isEmpty) {
          // EasyLoading sudah menangani indikator, jadi di sini cukup pesan teks atau SizedBox
          return const Center(
              child: Text('Memuat pertanyaan atau mengirim jawaban...'));
        }
        // Tampilkan pesan error jika ada
        if (_diagnosisController.errorMessage != null) {
          return Center(
              child: Text('Error: ${_diagnosisController.errorMessage}'));
        }

        // Tampilkan daftar pertanyaan jika tidak loading dan tidak ada error
        return ListView.builder(
          padding: const EdgeInsets.fromLTRB(16, 16, 16, 90),
          itemCount: _questionsData.length,
          itemBuilder: (context, index) {
            final questionItem = _questionsData[index];
            final questionText = '${index + 1}. ${questionItem['question']}';
            final questionType = questionItem['type'];

            Widget inputWidget;

           if (questionType == 'dropdown') {
              final options = questionItem['options'] as List<Map<String, dynamic>>;
              inputWidget = DropdownButtonFormField<int>(
                decoration: InputDecoration( // Langsung buat InputDecoration
                  hintText: 'Pilih jawaban...', // Atur hintText di sini
                ),
                value: _answers[index] is int ? _answers[index] as int? : null,
                items: options.map<DropdownMenuItem<int>>((option) {
                  return DropdownMenuItem<int>(
                    value: option['value'] as int,
                    child: Text(option['label'] as String),
                  );
                }).toList(),
                onChanged: (int? newValue) {
                  setState(() {
                    _answers[index] = newValue;
                  });
                },
              );
            } else if (questionType == 'text_field') {
              // Untuk pertanyaan usia (index 0)
              inputWidget = TextFormField(
                controller: _ageController,
                keyboardType: TextInputType.number,
                decoration: InputDecoration( // Langsung buat InputDecoration
                  hintText: "Masukkan usia Anda", // Atur hintText di sini
                ),
                onChanged: (newValue) {
                  setState(() {
                    _answers[index] = newValue; // Simpan nilai dari text field
                  });
                },
              );
            } else {
              inputWidget = Text("Tipe pertanyaan tidak dikenal: $questionType");
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
                    inputWidget,
                  ],
                ),
              ),
            );
          },
        );
      }),
      bottomNavigationBar: Obx(() {
        // Gunakan Obx untuk mendengarkan perubahan pada _isLoading
        return Padding(
          padding: const EdgeInsets.all(16.0),
          child: ElevatedButton(
            onPressed: _diagnosisController.isLoading
                ? null
                : _submitAnswers, // Nonaktifkan saat loading
            child: _diagnosisController.isLoading
                ? const SizedBox(
                    width: 20,
                    height: 20,
                    child: CircularProgressIndicator(
                      color: Colors.white,
                      strokeWidth: 2,
                    ),
                  )
                : const Text('Submit Jawaban'),
          ),
        );
      }),
    );
  }
}