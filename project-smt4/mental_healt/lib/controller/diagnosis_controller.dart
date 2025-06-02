// Di dalam file DiagnosisController.dart Anda
// Jangan lupa impor yang dibutuhkan:
import 'dart:convert'; // Untuk jsonEncode
import 'package:get/get.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';
import '../models/diagnosis_result.dart'; // Sesuaikan path
import '../services/diagnosis_api_service.dart'; // Sesuaikan path
// ... impor lainnya ...

class DiagnosisController extends GetxController {
  final DiagnosisApiService _apiService = DiagnosisApiService();

  final _isLoading = false.obs;
  final _errorMessage = Rx<String?>(null);
  final _latestDiagnosis = Rx<DiagnosisOutput?>(null); // Menyimpan hasil diagnosis sebagai objek

  bool get isLoading => _isLoading.value;
  String? get errorMessage => _errorMessage.value;
  DiagnosisOutput? get latestDiagnosis => _latestDiagnosis.value;

  // Anda mungkin memiliki method seperti ini:
  Future<void> submitDiagnosisAndShowResult(DiagnosisInput inputData) async {
    _isLoading.value = true;
    _errorMessage.value = null;
    _latestDiagnosis.value = null;

    EasyLoading.show(status: 'Mengirim data diagnosis...', dismissOnTap: false);

    try {
      // Di sini Anda akan memanggil API service Anda, misalnya:
      // final String? loggedInUserId = SpUtil.getString('user_id');
      // final DiagnosisInput inputWithUserId = DiagnosisInput(
      //   // ... isi field dari inputData ...
      //   userId: inputData.userId ?? loggedInUserId,
      // );
      // final DiagnosisOutput diagnosisResultFromServer = await _apiService.submitDiagnosis(inputWithUserId);

      // --- UNTUK CONTOH, KITA BUAT DATA HASIL DIAGNOSIS DUMMY ---
      // GANTI BAGIAN INI DENGAN HASIL ASLI DARI API ANDA
      // Anggap API mengembalikan objek DiagnosisOutput
      final DiagnosisOutput diagnosisResultFromServer = DiagnosisOutput(
        diagnosis: 1, // Contoh: 1 untuk "Depresi Ringan"
        userId: "user123",
        timestamp: DateTime.now(),
      );
      // --- BATAS DATA DUMMY ---

      _latestDiagnosis.value = diagnosisResultFromServer; // Simpan hasil jika perlu diakses di tempat lain

      // Persiapkan argumen 'rawDiagnosisResult' sebagai String
      // Rute '/detailhasil' Anda mengharapkan String. Kemungkinan besar ini adalah JSON String.
      String rawDiagnosisResultString;

      if (diagnosisResultFromServer != null) {
        // Anda perlu mengonversi objek diagnosisResultFromServer menjadi JSON String.
        // Pastikan model DiagnosisOutput Anda memiliki method toJson()
        // atau Anda buat Map secara manual di sini.
        Map<String, dynamic> dataUntukJson = {
          'predicted_diagnosis': diagnosisResultFromServer.diagnosis,
          'user_id': diagnosisResultFromServer.userId,
          'timestamp': diagnosisResultFromServer.timestamp?.toIso8601String(),
          // Tambahkan field lain dari DiagnosisOutput yang ingin Anda kirim
          // dan yang diharapkan akan diparse oleh DetailHasilDiagnosaPage
        };
        rawDiagnosisResultString = jsonEncode(dataUntukJson); // Menggunakan dart:convert
      } else {
        // Jika hasil null, jangan navigasi atau tampilkan error
        _errorMessage.value = "Data hasil diagnosis tidak ditemukan.";
        EasyLoading.showError(_errorMessage.value!);
        _isLoading.value = false;
        return;
      }

      EasyLoading.dismiss(); // Hentikan loading sebelum navigasi

      // --- IMPLEMENTASI NAVIGASI YANG BENAR KE /detailhasil ---
      Get.toNamed(
        '/detailhasil',
        arguments: {
          'rawDiagnosisResult': rawDiagnosisResultString, // Kirim Map dengan key 'rawDiagnosisResult' dan value String
        },
      );
      // --- BATAS IMPLEMENTASI NAVIGASI ---

    } catch (e) {
      _errorMessage.value = e.toString().replaceFirst('Exception: ', '');
      print("Error di DiagnosisController: ${_errorMessage.value}");
      EasyLoading.showError(_errorMessage.value ?? 'Terjadi kesalahan saat diagnosis!');
    } finally {
      _isLoading.value = false;
    }
  }
}