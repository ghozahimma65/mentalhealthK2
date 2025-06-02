// lib/services/diagnosis_api_service.dart

import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:sp_util/sp_util.dart'; // <--- IMPORT SP_UTIL
import '../models/diagnosis_result.dart'; // Import model yang sudah dibuat

class DiagnosisApiService {
  // GANTI DENGAN URL API LARAVEL ANDA!
  // Contoh: 'http://10.0.2.2:8000' untuk emulator Android ke localhost
  //         'http://localhost:8000' untuk simulator iOS atau desktop
  //         'http://<IP_KOMPUTER_ANDA>:8000' jika di perangkat fisik di jaringan yang sama
  final String _baseUrl = 'http://127.0.0.1:8000/api'; // Contoh: GANTI DENGAN IP Anda

  // Fungsi untuk mengirim data diagnosis ke API Laravel
  Future<DiagnosisOutput> submitDiagnosis(DiagnosisInput input) async {
    final url = Uri.parse('$_baseUrl/api/diagnosa/submit'); // Pastikan endpoint ini benar di Laravel

    // --- Ambil token dari SpUtil ---
    final String? token = SpUtil.getString('token'); // Asumsi 'token' adalah key untuk menyimpan token di SpUtil

    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    // --- Tambahkan token ke header jika ada ---
    if (token != null) {
      headers['Authorization'] = 'Bearer $token';
      print('Token sent: Bearer $token'); // Log token yang dikirim
    } else {
      // Jika token null, ini berarti pengguna belum login atau token tidak tersimpan.
      // Karena aplikasi wajib login, ini mengindikasikan masalah di proses login Flutter.
      throw Exception('Autentikasi gagal: Token tidak ditemukan. Harap login ulang.');
    }

    print('Sending POST request to: $url');
    print('Request headers: $headers'); // Log semua header
    print('Request body: ${jsonEncode(input.toJson())}'); // Log request body

    try {
      final response = await http.post(
        url,
        headers: headers, // <-- GUNAKAN HEADERS YANG SUDAH TERMASUK TOKEN
        body: jsonEncode(input.toJson()),
      );

      print('Response status: ${response.statusCode}');
      print('Response body: ${response.body}');

      if (response.statusCode == 200 || response.statusCode == 201) {
        final Map<String, dynamic> jsonResponse = jsonDecode(response.body);
        if (jsonResponse['success'] == true && jsonResponse.containsKey('predicted_diagnosis')) {
          return DiagnosisOutput.fromJson(jsonResponse);
        } else {
          throw Exception(jsonResponse['message'] ?? 'Respons tidak valid dari server API.');
        }
      } else if (response.statusCode == 401) {
        // Tangani khusus error Unauthenticated/Unauthorized
        throw Exception('Autentikasi gagal: Sesi Anda mungkin telah berakhir. Harap login ulang.');
      }
      else {
        // Tangani error lainnya (misal 422 Validasi, 500 Internal Server Error)
        String errorMessage = 'Failed to submit diagnosis: ${response.statusCode}';
        try {
          final errorBody = jsonDecode(response.body);
          errorMessage = errorBody['message'] ?? errorBody['errors']?.values.first?.first ?? errorMessage;
        } catch (_) {
          // Biarkan errorMessage default jika body bukan JSON atau tidak ada 'message'
        }
        throw Exception(errorMessage);
      }
    } on http.ClientException catch (e) {
      print('HTTP Client Error in submitDiagnosis: $e');
      throw Exception('Gagal terhubung ke server. Periksa koneksi internet atau URL API Anda. Error: $e');
    } catch (e) {
      print('General Error in submitDiagnosis: $e');
      throw Exception('Terjadi kesalahan tidak terduga saat mengirim diagnosis: $e');
    }
  }
}