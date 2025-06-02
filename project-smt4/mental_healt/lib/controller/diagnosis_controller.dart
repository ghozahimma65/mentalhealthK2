// lib/controllers/diagnosis_controller.dart

import 'package:get/get.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';
import 'package:sp_util/sp_util.dart'; // <--- PASTIKAN SUDAH IMPORT SP_UTIL
import '../models/diagnosis_result.dart';
import '../services/diagnosis_api_service.dart';

class DiagnosisController extends GetxController {
  final DiagnosisApiService _apiService = DiagnosisApiService();

  final _isLoading = false.obs;
  final _errorMessage = Rx<String?>(null);
  final _latestDiagnosis = Rx<DiagnosisOutput?>(null);

  bool get isLoading => _isLoading.value;
  String? get errorMessage => _errorMessage.value;
  DiagnosisOutput? get latestDiagnosis => _latestDiagnosis.value;

  // Fungsi untuk melakukan diagnosis dan memanggil API
  Future<void> performDiagnosis(DiagnosisInput input) async {
    _isLoading.value = true;
    _errorMessage.value = null;
    _latestDiagnosis.value = null;

    EasyLoading.show(status: 'Mengirim jawaban...', dismissOnTap: false);

    try {
      // Ambil user_id dari SpUtil
      // Pastikan 'user_id' adalah kunci yang Anda gunakan saat menyimpan ID pengguna setelah login
      final String? loggedInUserId = SpUtil.getString('user_id');

      if (loggedInUserId == null) {
        // Handle case where user_id is not found (e.g., user not logged in)
        _errorMessage.value = 'User ID tidak ditemukan. Harap login kembali.';
        EasyLoading.showError(_errorMessage.value!, dismissOnTap: true);
        _isLoading.value = false;
        return; // Hentikan eksekusi jika user_id tidak ada
      }

      // Buat instance DiagnosisInput baru dengan user_id yang diambil
      final DiagnosisInput inputWithUserId = DiagnosisInput(
        age: input.age,
        gender: input.gender,
        symptomSeverity: input.symptomSeverity,
        moodScore: input.moodScore,
        sleepQuality: input.sleepQuality,
        physicalActivity: input.physicalActivity,
        stressLevel: input.stressLevel,
        aiDetectedEmotionalState: input.aiDetectedEmotionalState,
        userId: loggedInUserId, // <--- SERTAKAN USER_ID YANG DIAMBIL DARI SP_UTIL
      );

      final result = await _apiService.submitDiagnosis(inputWithUserId); // Kirim input yang sudah diperbarui
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

  void resetState() {
    _isLoading.value = false;
    _errorMessage.value = null;
    _latestDiagnosis.value = null;
  }
}