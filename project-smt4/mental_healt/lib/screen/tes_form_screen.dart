// lib/screen/tes_form_screen.dart
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart'; // Import GetX
import 'package:flutter_easyloading/flutter_easyloading.dart'; // Import EasyLoading

// Import model dan controller yang relevan
import '../models/outcome_result.dart'; //
import '../controller/outcome_controller.dart'; //

// Struktur Data untuk Pertanyaan (DARI FILE ANDA)
enum QuestionType { dropdown, numericDropdown, numberInput } //

class Option<T> { //
  final T value; //
  final String text; //
  Option({required this.value, required this.text}); //
}

class Question { //
  final String id; //
  final String label; //
  final QuestionType type; //
  final List<Option<dynamic>>? options; //
  final Map<int, String>? numericOptionsMap; //
  final double? minVal; //
  final double? maxVal; //
  final double? stepVal; //
  final String? hintText; //

  Question({ //
    required this.id, //
    required this.label, //
    required this.type, //
    this.options, //
    this.numericOptionsMap, //
    this.minVal, //
    this.maxVal, //
    this.stepVal, //
    this.hintText, //
  });
}
// --- Akhir Struktur Data ---

class TesFormScreen extends StatefulWidget {
  const TesFormScreen({super.key}); //

  @override
  State<TesFormScreen> createState() => _TesFormScreenState();
}

class _TesFormScreenState extends State<TesFormScreen> {
  final _formKey = GlobalKey<FormState>(); //
  final Map<String, dynamic> _answers = {}; //
  late List<Question> _questions; //
  bool _isLoadingQuestions = true; // Mengganti _isLoading menjadi _isLoadingQuestions

  // Dapatkan instance OutcomeController
  final OutcomeController _outcomeController = Get.find<OutcomeController>(); //

  @override
  void initState() { //
    super.initState(); //
    _outcomeController.resetState(); // Reset state controller saat halaman dimuat
    Future.delayed(const Duration(milliseconds: 20), () { //
      _questions = _initializeQuestions(); //
      for (var question in _questions) { //
        if (question.type == QuestionType.numberInput) { //
          _answers[question.id] = ''; // // Inisialisasi sebagai string kosong untuk TextFormField
        } else if (question.type == QuestionType.dropdown || question.type == QuestionType.numericDropdown) {
            // Set nilai default jika ada opsi pertama
            if (question.options != null && question.options!.isNotEmpty) {
                _answers[question.id] = question.options![0].value;
            } else if (question.numericOptionsMap != null && question.numericOptionsMap!.isNotEmpty) {
                 _answers[question.id] = question.numericOptionsMap!.keys.first;
            } else {
                _answers[question.id] = null; //
            }
        } else {
          _answers[question.id] = null; //
        }
      }
      if (mounted) { //
        setState(() { //
          _isLoadingQuestions = false; //
        });
      }
    });
  }

  List<Question> _initializeQuestions() { //
    return [ //
      Question( //
        id: 'diagnosis', //
        label: '1. Diagnosis terakhir Anda?', //
        type: QuestionType.dropdown, //
        options: [ //
          Option<int>(value: 0, text: 'Gangguan Bipolar'), //
          Option<int>(value: 1, text: 'Gangguan Kecemasan Umum'), //
          Option<int>(value: 2, text: 'Gangguan Depresi Mayor'), //
          Option<int>(value: 3, text: 'Gangguan Panik'), //
        ],
        hintText: //
            'Pilih diagnosis yang Anda ketahui atau telah didapatkan sebelumnya.', //
      ),
      Question( //
        id: 'symptom_severity', //
        label: '2. Seberapa parah gejala yang Anda rasakan saat ini?', //
        type: QuestionType.numericDropdown, //
        numericOptionsMap: { //
          1: 'Sangat Ringan', 2: 'Ringan', 3: 'Sedang', 4: 'Agak Berat', //
          5: 'Berat', 6: 'Sangat Berat', 7: 'Ekstrem', 8: 'Kritis', //
          9: 'Sangat Kritis', 10: 'Maksimal' //
        },
        hintText: 'Nilai 1 (sangat ringan) hingga 10 (maksimal).', //
      ),
      Question( //
        id: 'mood_score', //
        label: '3. Bagaimana suasana hati Anda dalam seminggu terakhir?', //
        type: QuestionType.numericDropdown, //
        numericOptionsMap: { //
          1: 'Sangat Buruk (Depresi/Sedih)', 2: 'Buruk (Cemas/Resah)', //
          3: 'Agak Buruk (Kurang Bersemangat)', 4: 'Cukup Netral (Biasa Saja)', //
          5: 'Netral (Stabil)', 6: 'Agak Baik (Cukup Bersemangat)', //
          7: 'Baik (Senang)', 8: 'Sangat Baik (Gembira/Optimis)', //
          9: 'Luar Biasa (Bahagia/Antusias)', 10: 'Maksimal (Euforia/Penuh Energi)' //
        },
        hintText: 'Nilai 1 (sangat buruk) hingga 10 (sangat baik).', //
      ),
      Question( //
        id: 'physical_activity', //
        label: '4. Rata-rata aktivitas fisik Anda per minggu (jam)?', //
        type: QuestionType.numberInput, //
        minVal: 0, maxVal: 168, stepVal: 0.5, //
        hintText: 'Masukkan rata-rata jam aktivitas fisik/olahraga per minggu (misal: 3.5 jam).', //
      ),
      Question( //
        id: 'medication', //
        label: '5. Jenis pengobatan/obat yang sedang Anda gunakan?', //
        type: QuestionType.dropdown, //
        options: [ //
          Option<int>(value: 0, text: 'Antidepressants (Antidepresan)'), //
          Option<int>(value: 1, text: 'Antipsychotics (Antipsikotik)'), //
          Option<int>(value: 2, text: 'Benzodiazepines (Benzodiazepin)'), //
          Option<int>(value: 3, text: 'Mood Stabilizers (Penstabil Suasana Hati)'), //
          Option<int>(value: 4, text: 'SSRIs (Selective Serotonin Reuptake Inhibitors)'), //
          Option<int>(value: 5, text: 'Anxiolytics (Anxiolitik/Anti-kecemasan)'), //
        ],
        hintText: 'Pilih jenis obat yang sedang Anda gunakan. Jika tidak ada, pilih opsi terakhir.', //
      ),
      Question( //
        id: 'therapy_type', //
        label: '6. Jenis terapi yang sedang Anda jalani?', //
        type: QuestionType.dropdown, //
        options: [ //
          Option<int>(value: 0, text: 'Cognitive Behavioral Therapy (CBT)'), //
          Option<int>(value: 1, text: 'Dialectical Behavioral Therapy (DBT)'), //
          Option<int>(value: 2, text: 'Interpersonal Therapy (IPT)'), //
          Option<int>(value: 3, text: 'Mindfulness-Based Therapy (Terapi Berbasis Kesadaran)'), //
        ],
        hintText: 'Pilih jenis terapi yang sedang Anda jalani. Jika tidak ada, pilih opsi terakhir.', //
      ),
      Question( //
        id: 'treatment_duration', //
        label: '7. Berapa lama Anda sudah menjalani pengobatan/terapi (dalam minggu)?', //
        type: QuestionType.numberInput, //
        minVal: 0, maxVal: 500, //
        hintText: 'Masukkan durasi total pengobatan atau terapi Anda dalam minggu (misal: 12 minggu).', //
      ),
      Question( //
        id: 'stress_level', //
        label: '8. Seberapa sering Anda merasa stres dalam seminggu terakhir?', //
        type: QuestionType.numericDropdown, //
        numericOptionsMap: { //
          1: 'Sangat Rendah (Tidak Stres)', 2: 'Rendah', 3: 'Sedang', //
          4: 'Cukup Tinggi', 5: 'Tinggi', 6: 'Sangat Tinggi', //
          7: 'Berlebihan', 8: 'Kritis', 9: 'Parah', //
          10: 'Sangat Parah (Tidak Terkendali)' //
        },
        hintText: 'Nilai 1 (sangat rendah) hingga 10 (sangat parah).', //
      ),
    ];
  }

  Widget _buildQuestionItem(BuildContext context, Question question, int index) { //
    final String questionTextWithNumber = '${index + 1}. ${question.label.replaceFirst(RegExp(r'^\d+\.\s*'), '')}'; //
    InputDecoration inputDecoration = InputDecoration( //
      hintText: "Pilih atau isi jawaban...", //
      border: OutlineInputBorder( //
        borderRadius: BorderRadius.circular(8.0), //
        borderSide: BorderSide.none, //
      ),
      filled: true, //
      fillColor: Colors.grey.shade200, //
      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16), //
    );

    Widget inputWidget; //
    if (question.type == QuestionType.numberInput) { //
      inputWidget = TextFormField( //
        // Gunakan TextEditingController jika perlu nilai awal dari _answers
        // initialValue: _answers[question.id]?.toString() ?? '', // Hati-hati jika _answers[question.id] bukan string
        keyboardType: TextInputType.numberWithOptions( //
            decimal: question.stepVal != null && question.stepVal! < 1), //
        inputFormatters: question.stepVal != null && question.stepVal! < 1 //
            ? [FilteringTextInputFormatter.allow(RegExp(r'^\d*\.?\d*'))] //
            : [FilteringTextInputFormatter.digitsOnly], //
        decoration: inputDecoration.copyWith( //
          hintText: question.hintText ?? "Masukkan angka", //
        ),
        onChanged: (value) { //
           // Langsung simpan sebagai string, konversi dilakukan saat submit
          _answers[question.id] = value; //
        },
        // onSaved tidak diperlukan jika onChanged sudah menyimpan string,
        // dan validasi serta parsing dilakukan di _submitForm
        validator: (value) { //
          if (value == null || value.isEmpty) return 'Mohon isi bagian ini.'; //
          final num? number = num.tryParse(value); //
          if (number == null) return 'Format angka tidak valid.'; //
          if (question.minVal != null && number < question.minVal!) return 'Nilai minimal adalah ${question.minVal}.'; //
          if (question.maxVal != null && number > question.maxVal!) return 'Nilai maksimal adalah ${question.maxVal}.'; //
          return null; //
        },
      );
    } else if (question.type == QuestionType.dropdown) { //
       inputWidget = DropdownButtonFormField<int>( // Semua dropdown di OutcomeInput adalah int
          decoration: inputDecoration.copyWith(hintText: "Pilih salah satu..."), //
          value: _answers[question.id] as int?, //
          isExpanded: true, //
          items: question.options //
              ?.map((option) => DropdownMenuItem<int>( //
                    value: option.value as int, //
                    child: Text(option.text, style: const TextStyle(color: Colors.black87)), //
                  ))
              .toList(),
          onChanged: (value) { //
            setState(() { //
              _answers[question.id] = value; //
            });
          },
          validator: (value) => value == null ? 'Mohon pilih salah satu opsi.' : null, //
        );
    } else if (question.type == QuestionType.numericDropdown) { //
      inputWidget = DropdownButtonFormField<int>( //
        decoration: inputDecoration.copyWith(hintText: "Pilih level..."), //
        value: _answers[question.id] as int?, //
        isExpanded: true, //
        items: question.numericOptionsMap?.entries //
            .map((entry) => DropdownMenuItem<int>( //
                  value: entry.key, //
                  child: Text(entry.value, style: const TextStyle(color: Colors.black87)), //
                ))
            .toList(),
        onChanged: (value) { //
          setState(() { //
            _answers[question.id] = value; //
          });
        },
        validator: (value) => value == null ? 'Mohon pilih salah satu level.' : null, //
      );
    } else {
      inputWidget = const Text("Tipe pertanyaan tidak dikenal."); //
    }

    return Card( //
      elevation: 2.5, //
      margin: const EdgeInsets.only(bottom: 16), //
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12.0)), //
      color: Colors.white, //
      child: Padding( //
        padding: const EdgeInsets.all(16.0), //
        child: Column( //
          crossAxisAlignment: CrossAxisAlignment.start, //
          children: [ //
            Text( //
              questionTextWithNumber, //
              style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w500, color: Colors.black87), //
            ),
            const SizedBox(height: 16), //
            inputWidget, //
          ],
        ),
      ),
    );
  }

  void _submitForm() async { // Diubah menjadi async
    if (_formKey.currentState!.validate()) { //
      _formKey.currentState!.save(); // Panggil save untuk TextFormField
      print('Jawaban Terkumpul Sebelum Konversi: $_answers'); //

      // Konversi nilai 'physical_activity' dan 'treatment_duration' yang mungkin masih String dari TextFormField
      double? physicalActivityValue;
      if (_answers['physical_activity'] != null && _answers['physical_activity'].toString().isNotEmpty) {
        physicalActivityValue = double.tryParse(_answers['physical_activity'].toString());
      }

      int? treatmentDurationValue;
      if (_answers['treatment_duration'] != null && _answers['treatment_duration'].toString().isNotEmpty) {
        treatmentDurationValue = int.tryParse(_answers['treatment_duration'].toString());
      }

      // Membuat instance OutcomeInput dengan data yang sudah divalidasi dan dikonversi
      final outcomeInputData = OutcomeInput( //
        diagnosis: _answers['diagnosis'] as int?,
        symptomSeverity: _answers['symptom_severity'] as int?,
        moodScore: _answers['mood_score'] as int?,
        physicalActivity: physicalActivityValue, // Gunakan nilai yang sudah di-parse
        medication: _answers['medication'] as int?,
        therapyType: _answers['therapy_type'] as int?,
        treatmentDuration: treatmentDurationValue, // Gunakan nilai yang sudah di-parse
        stressLevel: _answers['stress_level'] as int?,
        // userId akan ditambahkan oleh controller
      );

      print('Data untuk API (OutcomeInput): ${outcomeInputData.toJson()}');

      // Panggil controller untuk submit ke API
      await _outcomeController.performOutcomeTest(outcomeInputData); //

      // Cek hasil dari controller
      if (_outcomeController.latestOutcome != null) {
        // Navigasi ke HasilPenilaianDiriPage dengan data dari API
        Get.offNamed(
          '/hasil_outcome', // Pastikan rute ini terdaftar di main.dart
          arguments: {
            'outcomePrediction': _outcomeController.latestOutcome!.predictedOutcome, // Dari API (int?)
            'answers': Map<String, dynamic>.from(_answers), // Jawaban asli pengguna
            'timestamp': _outcomeController.latestOutcome!.timestamp?.toIso8601String(), // Dari API
          },
        );
      } else if (_outcomeController.errorMessage != null) {
        // Error message sudah ditangani oleh EasyLoading di controller
        print("Gagal mengirim tes perkembangan: ${_outcomeController.errorMessage}");
      } else {
        // Fallback jika tidak ada hasil dan tidak ada error (seharusnya jarang terjadi)
        EasyLoading.showError('Gagal memproses hasil tes perkembangan. Silakan coba lagi.');
      }

    } else {
      ScaffoldMessenger.of(context).showSnackBar( //
        const SnackBar(content: Text('Mohon lengkapi semua pertanyaan dengan benar.')), //
      );
    }
  }


  @override
  Widget build(BuildContext context) { //
    final Color pageBackgroundColor = Colors.purple.shade50.withOpacity(0.5); //
    return Scaffold( //
      appBar: AppBar( //
        title: const Text('Tes Perkembangan Diri'), // Judul diubah
        backgroundColor: Colors.deepPurple, //
        elevation: 0.5, //
        foregroundColor: Colors.white, // Agar ikon back putih
      ),
      backgroundColor: pageBackgroundColor, //
      body: _isLoadingQuestions // Menggunakan _isLoadingQuestions
          ? const Center(child: CircularProgressIndicator()) //
          : Form( //
              key: _formKey, //
              child: ListView.builder( //
                padding: const EdgeInsets.fromLTRB(16, 20, 16, 20), //
                itemCount: _questions.length, //
                itemBuilder: (context, index) { //
                  final question = _questions[index]; //
                  return _buildQuestionItem(context, question, index); //
                },
              ),
            ),
      bottomNavigationBar: Padding( //
        padding: const EdgeInsets.all(16.0), //
        child: Obx(() => ElevatedButton( // Tambahkan Obx untuk memantau _outcomeController.isLoading
              style: ElevatedButton.styleFrom( //
                  minimumSize: const Size(double.infinity, 50), //
                  backgroundColor: Colors.deepPurple, //
                  foregroundColor: Colors.white, //
                  textStyle: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold), //
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10))), //
              onPressed: _isLoadingQuestions || _outcomeController.isLoading ? null : _submitForm, //
              child: _outcomeController.isLoading
                  ? const SizedBox(
                      width: 20, height: 20,
                      child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                    )
                  : const Text('Submit Jawaban'), //
            )),
      ),
    );
  }
}