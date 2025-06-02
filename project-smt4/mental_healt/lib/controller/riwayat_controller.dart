// lib/controllers/riwayat_controller.dart

import 'package:get/get.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';
import 'package:sp_util/sp_util.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

// Anda mungkin perlu membuat model terpisah untuk item riwayat jika formatnya berbeda
// dari DiagnosisOutput, atau gunakan Map<String, dynamic> untuk fleksibilitas.

class RiwayatController extends GetxController {
  final String _baseUrl = 'http://localhost:8000'; // URL Laravel API Anda

  final _isLoadingHistory = false.obs;
  final _errorMessageHistory = Rx<String?>(null);
  final _diagnosisHistory = <Map<String, dynamic>>[].obs; // RxList untuk observasi
  final _perkembanganHistory = <Map<String, dynamic>>[].obs; // RxList untuk observasi

  // Getters
  bool get isLoadingHistory => _isLoadingHistory.value;
  String? get errorMessageHistory => _errorMessageHistory.value;
  List<Map<String, dynamic>> get diagnosisHistory => _diagnosisHistory.value;
  List<Map<String, dynamic>> get perkembanganHistory => _perkembanganHistory.value;


  // Fungsi untuk mengambil riwayat diagnosis
  Future<void> fetchDiagnosisHistory() async {
    _isLoadingHistory.value = true;
    _errorMessageHistory.value = null;

    final String? token = SpUtil.getString('token');
    if (token == null) {
      _errorMessageHistory.value = 'Anda belum login. Harap login terlebih dahulu.';
      EasyLoading.showError(_errorMessageHistory.value!);
      _isLoadingHistory.value = false;
      return;
    }

    try {
      final response = await http.get(
        Uri.parse('$_baseUrl/api/diagnosa/history'), // Endpoint Laravel
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final Map<String, dynamic> jsonResponse = jsonDecode(response.body);
        if (jsonResponse['success'] == true && jsonResponse.containsKey('data')) {
          // Asumsi 'data' berisi List<Map<String, dynamic>>
          _diagnosisHistory.assignAll(List<Map<String, dynamic>>.from(jsonResponse['data']));
        } else {
          _errorMessageHistory.value = jsonResponse['message'] ?? 'Data tidak valid dari server.';
        }
      } else if (response.statusCode == 401) {
        _errorMessageHistory.value = 'Sesi Anda telah berakhir. Harap login kembali.';
        EasyLoading.showError(_errorMessageHistory.value!);
        // Get.offAllNamed('/login'); // Opsional: arahkan ke login
      } else {
        final Map<String, dynamic> errorData = jsonDecode(response.body);
        _errorMessageHistory.value = errorData['message'] ?? 'Gagal mengambil riwayat diagnosis.';
      }
    } catch (e) {
      _errorMessageHistory.value = 'Terjadi kesalahan: $e';
      print('Error fetching diagnosis history: $e');
    } finally {
      _isLoadingHistory.value = false;
      EasyLoading.dismiss(); // Jika EasyLoading digunakan di awal
    }
  }

  // Fungsi untuk mengambil riwayat perkembangan (outcome)
  // Anda akan perlu endpoint API terpisah di Laravel untuk ini, misal: /api/outcome/history
  Future<void> fetchPerkembanganHistory() async {
    _isLoadingHistory.value = true;
    _errorMessageHistory.value = null;

    final String? token = SpUtil.getString('token');
    if (token == null) {
      _errorMessageHistory.value = 'Anda belum login. Harap login terlebih dahulu.';
      EasyLoading.showError(_errorMessageHistory.value!);
      _isLoadingHistory.value = false;
      return;
    }

    try {
      final response = await http.get(
        Uri.parse('$_baseUrl/api/outcome/history'), // Asumsi endpoint ini ada di Laravel
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      if (response.statusCode == 200) {
        final Map<String, dynamic> jsonResponse = jsonDecode(response.body);
        if (jsonResponse['success'] == true && jsonResponse.containsKey('data')) {
          _perkembanganHistory.assignAll(List<Map<String, dynamic>>.from(jsonResponse['data']));
        } else {
          _errorMessageHistory.value = jsonResponse['message'] ?? 'Data tidak valid dari server.';
        }
      } else if (response.statusCode == 401) {
        _errorMessageHistory.value = 'Sesi Anda telah berakhir. Harap login kembali.';
        EasyLoading.showError(_errorMessageHistory.value!);
      } else {
        final Map<String, dynamic> errorData = jsonDecode(response.body);
        _errorMessageHistory.value = errorData['message'] ?? 'Gagal mengambil riwayat perkembangan.';
      }
    } catch (e) {
      _errorMessageHistory.value = 'Terjadi kesalahan: $e';
      print('Error fetching perkembangan history: $e');
    } finally {
      _isLoadingHistory.value = false;
      EasyLoading.dismiss();
    }
  }

  // Fungsi untuk mereset state controller
  void resetState() {
    _isLoadingHistory.value = false;
    _errorMessageHistory.value = null;
    _diagnosisHistory.clear();
    _perkembanganHistory.clear();
  }
}