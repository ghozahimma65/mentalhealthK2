// lib/tes_form_screen.dart
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'dart:math'; // Untuk simulasi outcome

// [WAJIB] Import untuk HasilTesPage. Pastikan path ini benar dan menunjuk ke file hasil_tes_page.dart Anda.
import 'package:mobile_project/screen/HasilPenilaianDiriPage.dart'; // SESUAIKAN PATH INI JIKA PERLU

// --- Struktur Data untuk Pertanyaan (TETAP SAMA) ---
enum QuestionType { dropdown, numericDropdown, numberInput }

class Option<T> { // Membuat kelas Option menjadi generik untuk nilai (value)
  final T value;
  final String text;
  Option({required this.value, required this.text});
}

class Question {
  final String id;
  final String label;
  final QuestionType type;
  final List<Option<dynamic>>? options; // Menggunakan dynamic untuk opsi
  final Map<int, String>? numericOptionsMap;
  final double? minVal;
  final double? maxVal;
  final double? stepVal;
  final String? hintText;

  Question({
    required this.id,
    required this.label,
    required this.type,
    this.options,
    this.numericOptionsMap,
    this.minVal,
    this.maxVal,
    this.stepVal,
    this.hintText,
  });
}
// --- Akhir Struktur Data ---

class TesFormScreen extends StatefulWidget {
  const TesFormScreen({super.key});

  @override
  State<TesFormScreen> createState() => _TesFormScreenState();
}

class _TesFormScreenState extends State<TesFormScreen> {
  final _formKey = GlobalKey<FormState>();
  final Map<String, dynamic> _answers = {};
  late List<Question> _questions;
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    Future.delayed(const Duration(milliseconds: 20), () {
      _questions = _initializeQuestions();
      for (var question in _questions) {
        if (question.type == QuestionType.numberInput) {
          _answers[question.id] = '';
        } else {
          _answers[question.id] = null;
        }
      }
      if (mounted) {
        setState(() {
          _isLoading = false;
        });
      }
    });
  }

  List<Question> _initializeQuestions() {
    // **DAFTAR PERTANYAAN LENGKAP ANDA (8 PERTANYAAN)**
    return [
      Question(
        id: 'diagnosis',
        label: '1. Diagnosis terakhir Anda?',
        type: QuestionType.dropdown,
        options: [
          Option<int>(value: 0, text: 'Gangguan Bipolar'), // Diubah menjadi int
          Option<int>(value: 1, text: 'Gangguan Kecemasan Umum'), // Diubah menjadi int
          Option<int>(value: 2, text: 'Gangguan Depresi Mayor'), // Diubah menjadi int
          Option<int>(value: 3, text: 'Gangguan Panik'), // Diubah menjadi int
        ],
        hintText:
            'Pilih diagnosis yang Anda ketahui atau telah didapatkan sebelumnya.',
      ),
      Question(
        id: 'symptom_severity',
        label: '2. Seberapa parah gejala yang Anda rasakan saat ini?',
        type: QuestionType.numericDropdown,
        numericOptionsMap: {
          1: 'Sangat Ringan', 2: 'Ringan', 3: 'Sedang', 4: 'Agak Berat',
          5: 'Berat', 6: 'Sangat Berat', 7: 'Ekstrem', 8: 'Kritis',
          9: 'Sangat Kritis', 10: 'Maksimal'
        },
        hintText: 'Nilai 1 (sangat ringan) hingga 10 (maksimal).',
      ),
      Question(
        id: 'mood_score',
        label: '3. Bagaimana suasana hati Anda dalam seminggu terakhir?',
        type: QuestionType.numericDropdown,
        numericOptionsMap: {
          1: 'Sangat Buruk (Depresi/Sedih)', 2: 'Buruk (Cemas/Resah)',
          3: 'Agak Buruk (Kurang Bersemangat)', 4: 'Cukup Netral (Biasa Saja)',
          5: 'Netral (Stabil)', 6: 'Agak Baik (Cukup Bersemangat)',
          7: 'Baik (Senang)', 8: 'Sangat Baik (Gembira/Optimis)',
          9: 'Luar Biasa (Bahagia/Antusias)', 10: 'Maksimal (Euforia/Penuh Energi)'
        },
        hintText: 'Nilai 1 (sangat buruk) hingga 10 (sangat baik).',
      ),
      Question(
        id: 'physical_activity',
        label: '4. Rata-rata aktivitas fisik Anda per minggu (jam)?',
        type: QuestionType.numberInput,
        minVal: 0, maxVal: 168, stepVal: 0.5,
        hintText: 'Masukkan rata-rata jam aktivitas fisik/olahraga per minggu (misal: 3.5 jam).',
      ),
      Question(
        id: 'medication',
        label: '5. Jenis pengobatan/obat yang sedang Anda gunakan?',
        type: QuestionType.dropdown,
        options: [
          Option<int>(value: 0, text: 'Antidepressants (Antidepresan)'),
          Option<int>(value: 1, text: 'Antipsychotics (Antipsikotik)'),
          Option<int>(value: 2, text: 'Benzodiazepines (Benzodiazepin)'),
          Option<int>(value: 3, text: 'Mood Stabilizers (Penstabil Suasana Hati)'),
          Option<int>(value: 4, text: 'SSRIs (Selective Serotonin Reuptake Inhibitors)'),
          Option<int>(value: 5, text: 'Anxiolytics (Anxiolitik/Anti-kecemasan)'),
        ],
        hintText: 'Pilih jenis obat yang sedang Anda gunakan. Jika tidak ada, pilih opsi terakhir.',
      ),
      Question(
        id: 'therapy_type',
        label: '6. Jenis terapi yang sedang Anda jalani?',
        type: QuestionType.dropdown,
        options: [
          Option<int>(value: 0, text: 'Cognitive Behavioral Therapy (CBT)'),
          Option<int>(value: 1, text: 'Dialectical Behavioral Therapy (DBT)'),
          Option<int>(value: 2, text: 'Interpersonal Therapy (IPT)'),
          Option<int>(value: 3, text: 'Mindfulness-Based Therapy (Terapi Berbasis Kesadaran)'),
        ],
        hintText: 'Pilih jenis terapi yang sedang Anda jalani. Jika tidak ada, pilih opsi terakhir.',
      ),
      Question(
        id: 'treatment_duration',
        label: '7. Berapa lama Anda sudah menjalani pengobatan/terapi (dalam minggu)?',
        type: QuestionType.numberInput,
        minVal: 0, maxVal: 500,
        hintText: 'Masukkan durasi total pengobatan atau terapi Anda dalam minggu (misal: 12 minggu).',
      ),
      Question(
        id: 'stress_level',
        label: '8. Seberapa sering Anda merasa stres dalam seminggu terakhir?',
        type: QuestionType.numericDropdown,
        numericOptionsMap: {
          1: 'Sangat Rendah (Tidak Stres)', 2: 'Rendah', 3: 'Sedang',
          4: 'Cukup Tinggi', 5: 'Tinggi', 6: 'Sangat Tinggi',
          7: 'Berlebihan', 8: 'Kritis', 9: 'Parah',
          10: 'Sangat Parah (Tidak Terkendali)'
        },
        hintText: 'Nilai 1 (sangat rendah) hingga 10 (sangat parah).',
      ),
    ];
  }

  Widget _buildQuestionItem(BuildContext context, Question question, int index) {
    final String questionTextWithNumber = '${index + 1}. ${question.label.replaceFirst(RegExp(r'^\d+\.\s*'), '')}';
    InputDecoration inputDecoration = InputDecoration(
      hintText: "Pilih atau isi jawaban...",
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(8.0),
        borderSide: BorderSide.none,
      ),
      filled: true,
      fillColor: Colors.grey.shade200,
      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
    );

    Widget inputWidget;
    if (question.type == QuestionType.numberInput) {
      inputWidget = TextFormField(
        keyboardType: TextInputType.numberWithOptions(
            decimal: question.stepVal != null && question.stepVal! < 1),
        inputFormatters: question.stepVal != null && question.stepVal! < 1
            ? [FilteringTextInputFormatter.allow(RegExp(r'^\d*\.?\d*'))]
            : [FilteringTextInputFormatter.digitsOnly],
        decoration: inputDecoration.copyWith(
          hintText: question.hintText ?? "Masukkan angka",
        ),
        onChanged: (value) { // Menggunakan onChanged agar _answers terupdate saat diketik
          _answers[question.id] = value;
        },
        onSaved: (value) { // onSaved tetap untuk finalisasi saat submit
          if (value != null && value.isNotEmpty) {
            _answers[question.id] = question.stepVal != null && question.stepVal! < 1
                ? double.tryParse(value)
                : int.tryParse(value);
          } else {
            _answers[question.id] = null;
          }
        },
        validator: (value) {
          if (value == null || value.isEmpty) return 'Mohon isi bagian ini.';
          final num? number = num.tryParse(value);
          if (number == null) return 'Format angka tidak valid.';
          if (question.minVal != null && number < question.minVal!) return 'Nilai minimal adalah ${question.minVal}.';
          if (question.maxVal != null && number > question.maxVal!) return 'Nilai maksimal adalah ${question.maxVal}.';
          return null;
        },
      );
    } else if (question.type == QuestionType.dropdown) {
      // Menangani tipe dropdown secara kondisional berdasarkan ID pertanyaan
      if (question.id == 'diagnosis' || question.id == 'medication' || question.id == 'therapy_type') {
        inputWidget = DropdownButtonFormField<int>( // Menentukan tipe int untuk diagnosis, medication, dan therapy_type
          decoration: inputDecoration.copyWith(hintText: "Pilih salah satu..."),
          value: _answers[question.id] as int?, // Casting ke int?
          isExpanded: true,
          items: question.options
              ?.map((option) => DropdownMenuItem<int>(
                    value: option.value as int, // Casting nilai ke int
                    child: Text(option.text, style: const TextStyle(color: Colors.black87)),
                  ))
              .toList(),
          onChanged: (value) {
            setState(() {
              _answers[question.id] = value;
            });
          },
          validator: (value) => value == null ? 'Mohon pilih salah satu opsi.' : null,
        );
      } else {
        inputWidget = DropdownButtonFormField<String>( // Tetap String untuk dropdown lainnya jika ada
          decoration: inputDecoration.copyWith(hintText: "Pilih salah satu..."),
          value: _answers[question.id] as String?,
          isExpanded: true,
          items: question.options
              ?.map((option) => DropdownMenuItem<String>(
                    value: option.value as String,
                    child: Text(option.text, style: const TextStyle(color: Colors.black87)),
                  ))
              .toList(),
          onChanged: (value) {
            setState(() {
              _answers[question.id] = value;
            });
          },
          validator: (value) => value == null ? 'Mohon pilih salah satu opsi.' : null,
        );
      }
    } else if (question.type == QuestionType.numericDropdown) {
      inputWidget = DropdownButtonFormField<int>(
        decoration: inputDecoration.copyWith(hintText: "Pilih level..."),
        value: _answers[question.id] as int?,
        isExpanded: true,
        items: question.numericOptionsMap?.entries
            .map((entry) => DropdownMenuItem<int>(
                  value: entry.key,
                  child: Text(entry.value, style: const TextStyle(color: Colors.black87)),
                ))
            .toList(),
        onChanged: (value) {
          setState(() {
            _answers[question.id] = value;
          });
        },
        validator: (value) => value == null ? 'Mohon pilih salah satu level.' : null,
      );
    } else {
      inputWidget = const Text("Tipe pertanyaan tidak dikenal.");
    }

    return Card(
      elevation: 2.5,
      margin: const EdgeInsets.only(bottom: 16),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12.0)),
      color: Colors.white,
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              questionTextWithNumber,
              style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w500, color: Colors.black87),
            ),
            const SizedBox(height: 16),
            inputWidget,
          ],
        ),
      ),
    );
  }

  void _submitForm() {
    if (_formKey.currentState!.validate()) {
      _formKey.currentState!.save();
      int simulatedOutcomePrediction;
      final moodScore = _answers['mood_score'];
      if (moodScore != null && moodScore is int) {
        if (moodScore <= 3) simulatedOutcomePrediction = 0; // Kondisi untuk Depresi/Cemas
        else if (moodScore >= 7) simulatedOutcomePrediction = 1; // Kondisi untuk Baik/Euforia
        else simulatedOutcomePrediction = 2; // Kondisi untuk Netral/Stabil
      } else {
        // Jika mood_score tidak ada atau bukan int, berikan hasil acak
        simulatedOutcomePrediction = Random().nextInt(3);
      }
      print('Jawaban Terkumpul: $_answers');
      print('Simulated Outcome Prediction: $simulatedOutcomePrediction');

      // Memanggil HasilTesPage dari file yang diimport
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (context) => HasilPenilaianDiriPage( // Memastikan ini memanggil kelas dari file yang diimport
            outcomePrediction: simulatedOutcomePrediction,
            answers: Map<String, dynamic>.from(_answers),
          ),
        ),
      );
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Mohon lengkapi semua pertanyaan dengan benar.')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    final Color pageBackgroundColor = Colors.purple.shade50.withOpacity(0.5);
    return Scaffold(
      appBar: AppBar(
        title: const Text('Tes Mental Health'),
        backgroundColor: Colors.deepPurple,
        elevation: 0.5,
      ),
      backgroundColor: pageBackgroundColor,
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : Form(
              key: _formKey,
              child: ListView.builder(
                padding: const EdgeInsets.fromLTRB(16, 20, 16, 20),
                itemCount: _questions.length,
                itemBuilder: (context, index) {
                  final question = _questions[index];
                  return _buildQuestionItem(context, question, index);
                },
              ),
            ),
      bottomNavigationBar: Padding(
        padding: const EdgeInsets.all(16.0),
        child: ElevatedButton(
          style: ElevatedButton.styleFrom(
              minimumSize: const Size(double.infinity, 50),
              backgroundColor: Colors.deepPurple,
              foregroundColor: Colors.white,
              textStyle: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10))),
          onPressed: _isLoading ? null : _submitForm,
          child: const Text('Submit Jawaban'),
        ),
      ),
    );
  }
}