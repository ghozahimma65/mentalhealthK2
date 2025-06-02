// lib/controller/outcome_controller.dart

import 'package:get/get.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';
import 'package:sp_util/sp_util.dart';
import '../models/outcome_result.dart'; //
import '../services/outcome_api_service.dart';

class OutcomeController extends GetxController { //
  final OutcomeApiService _apiService = OutcomeApiService(); //

  final _isLoading = false.obs; //
  final _errorMessage = Rx<String?>(null); //
  final _latestOutcome = Rx<OutcomeOutput?>(null); //
  // Mengganti nama _outcomeHistory menjadi outcomeHistoryList agar konsisten dengan RiwayatHasilTesScreen
  final RxList<OutcomeOutput> outcomeHistoryList = <OutcomeOutput>[].obs; //

  bool get isLoading => _isLoading.value; //
  String? get errorMessage => _errorMessage.value; //
  OutcomeOutput? get latestOutcome => _latestOutcome.value; //
  // Mengganti getter agar sesuai dengan nama RxList
  List<OutcomeOutput> get outcomeHistory => outcomeHistoryList.toList(); //

  // Fungsi untuk melakukan tes perkembangan dan memanggil API
  Future<void> performOutcomeTest(OutcomeInput input) async { //
    _isLoading.value = true; //
    _errorMessage.value = null; //
    _latestOutcome.value = null; //

    EasyLoading.show(status: 'Mengirim jawaban...', dismissOnTap: false); //

    try {
      final String? loggedInUserId = SpUtil.getString('user_id'); //

      if (loggedInUserId == null) { //
        _errorMessage.value = 'ID Pengguna tidak ditemukan. Harap login kembali.'; //
        EasyLoading.showError(_errorMessage.value!, dismissOnTap: true); //
        _isLoading.value = false; //
        return; //
      }

      // Buat instance baru dari OutcomeInput, pastikan semua field dari 'input'
      // dan 'loggedInUserId' di-pass dengan benar.
      // Konstruktor OutcomeInput di outcome_result.dart adalah yang utama.
      final OutcomeInput inputWithUserId = OutcomeInput( //
        diagnosis: input.diagnosis, //
        symptomSeverity: input.symptomSeverity, //
        moodScore: input.moodScore, //
        physicalActivity: input.physicalActivity, //
        medication: input.medication, //
        therapyType: input.therapyType, //
        treatmentDuration: input.treatmentDuration, //
        stressLevel: input.stressLevel, //
        userId: loggedInUserId, //
      );

      final result = await _apiService.submitOutcome(inputWithUserId); //
      _latestOutcome.value = result; //
      EasyLoading.dismiss(); //
    } catch (e) {
      _errorMessage.value = e.toString().replaceFirst('Exception: ', ''); //
      print("Error di OutcomeController: ${_errorMessage.value}"); //
      EasyLoading.showError(_errorMessage.value ?? 'Terjadi kesalahan tidak dikenal!', dismissOnTap: true); //
    } finally {
      _isLoading.value = false; //
    }
  }

  // Fungsi untuk mengambil riwayat tes perkembangan
  Future<void> fetchOutcomeHistory() async { //
    _isLoading.value = true; //
    _errorMessage.value = null; //
    outcomeHistoryList.clear(); // Menggunakan outcomeHistoryList

    EasyLoading.show(status: 'Mengambil riwayat...', dismissOnTap: false); //

    try {
      final String? loggedInUserId = SpUtil.getString('user_id'); //

      if (loggedInUserId == null) { //
        _errorMessage.value = 'ID Pengguna tidak ditemukan. Harap login kembali.'; //
        EasyLoading.showError(_errorMessage.value!, dismissOnTap: true); //
        _isLoading.value = false; //
        return; //
      }

      // Pastikan _apiService.fetchOutcomeHistory tidak memerlukan userId jika API mengambil dari token
      final history = await _apiService.fetchOutcomeHistory(loggedInUserId); //
      outcomeHistoryList.assignAll(history); // Menggunakan outcomeHistoryList
      EasyLoading.dismiss(); //
    } catch (e) {
      _errorMessage.value = e.toString().replaceFirst('Exception: ', ''); //
      print("Error mengambil riwayat tes perkembangan: ${_errorMessage.value}"); //
      EasyLoading.showError(_errorMessage.value ?? 'Gagal memuat riwayat!', dismissOnTap: true); //
    } finally {
      _isLoading.value = false; //
    }
  }

  void resetState() { //
    _isLoading.value = false; //
    _errorMessage.value = null; //
    _latestOutcome.value = null; //
  }
}