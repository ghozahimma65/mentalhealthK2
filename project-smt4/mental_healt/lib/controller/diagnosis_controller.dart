// lib/controller/diagnosis_controller.dart

import 'package:get/get.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';
import 'package:sp_util/sp_util.dart';
import '../models/diagnosis_result.dart';
import '../services/diagnosis_api_service.dart';

class DiagnosisController extends GetxController {
  final DiagnosisApiService _apiService = DiagnosisApiService();

  final _isLoading = false.obs;
  final _errorMessage = Rx<String?>(null);
  final _latestDiagnosis = Rx<DiagnosisOutput?>(null);

  // --- TAMBAHKAN INI ---
  final RxList<DiagnosisOutput> diagnosisHistoryList = <DiagnosisOutput>[].obs;
  // --- AKHIR PENAMBAHAN ---


  bool get isLoading => _isLoading.value;
  String? get errorMessage => _errorMessage.value;
  DiagnosisOutput? get latestDiagnosis => _latestDiagnosis.value;

  Future<void> performDiagnosis(DiagnosisInput input) async {
    _isLoading.value = true;
    _errorMessage.value = null;
    _latestDiagnosis.value = null;

    EasyLoading.show(status: 'Mengirim jawaban...', dismissOnTap: false);

    try {
      final String? loggedInUserId = SpUtil.getString('user_id');

      if (loggedInUserId == null) {
        _errorMessage.value = 'User ID tidak ditemukan. Harap login kembali.';
        EasyLoading.showError(_errorMessage.value!, dismissOnTap: true);
        _isLoading.value = false;
        return;
      }

      final DiagnosisInput inputWithUserId = DiagnosisInput(
        age: input.age,
        gender: input.gender,
        symptomSeverity: input.symptomSeverity,
        moodScore: input.moodScore,
        sleepQuality: input.sleepQuality,
        physicalActivity: input.physicalActivity,
        stressLevel: input.stressLevel,
        aiDetectedEmotionalState: input.aiDetectedEmotionalState,
        userId: loggedInUserId,
      );

      final result = await _apiService.submitDiagnosis(inputWithUserId);
      _latestDiagnosis.value = result;
      EasyLoading.dismiss();
    } catch (e) {
      _errorMessage.value = e.toString().replaceFirst('Exception: ', '');
      print("Error in DiagnosisController: ${_errorMessage.value}");
      EasyLoading.showError(_errorMessage.value ?? 'Terjadi kesalahan tidak dikenal!', dismissOnTap: true);
    } finally {
      _isLoading.value = false;
    }
  }

  // --- TAMBAHKAN METODE INI ---
  Future<void> fetchDiagnosisHistory() async {
    // Gunakan _isLoading untuk state loading umum, atau buat _isLoadingHistory khusus
    _isLoading.value = true;
    _errorMessage.value = null; // Atau _errorMessageHistory
    diagnosisHistoryList.clear();

    // EasyLoading bisa ditampilkan di sini jika diinginkan,
    // tapi mungkin lebih baik ditangani di UI jika ini hanya salah satu tab.
    // EasyLoading.show(status: 'Mengambil riwayat diagnosis...');

    try {
      final String? loggedInUserId = SpUtil.getString('user_id');
      if (loggedInUserId == null) {
        _errorMessage.value = 'ID Pengguna tidak ditemukan. Harap login kembali.';
        // EasyLoading.showError(_errorMessage.value!); // Mungkin tidak perlu EasyLoading di sini
        _isLoading.value = false;
        return;
      }

      final history = await _apiService.getDiagnosisHistory(); // Memanggil service
      diagnosisHistoryList.assignAll(history);
      // EasyLoading.dismiss(); // Jika EasyLoading digunakan
    } catch (e) {
      _errorMessage.value = e.toString().replaceFirst('Exception: ', '');
      print("Error mengambil riwayat diagnosis: ${_errorMessage.value}");
      // EasyLoading.showError(_errorMessage.value ?? 'Gagal memuat riwayat diagnosis!'); // Jika EasyLoading digunakan
    } finally {
      _isLoading.value = false;
      // EasyLoading.dismiss(); // Pastikan dismiss dipanggil
    }
  }
  // --- AKHIR PENAMBAHAN ---

  void resetState() {
    _isLoading.value = false;
    _errorMessage.value = null;
    _latestDiagnosis.value = null;
    diagnosisHistoryList.clear(); // Reset juga history list jika perlu
  }
}