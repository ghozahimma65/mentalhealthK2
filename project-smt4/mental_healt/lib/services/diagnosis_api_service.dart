// lib/services/diagnosis_api_service.dart

import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:sp_util/sp_util.dart';
import '../models/diagnosis_result.dart';

class DiagnosisApiService {
  final String _baseUrl = 'http://localhost:8000'; // GANTI DENGAN URL API LARAVEL ANDA!

  Future<DiagnosisOutput> submitDiagnosis(DiagnosisInput input) async {
    final url = Uri.parse('$_baseUrl/api/diagnosa/submit');
    final String? token = SpUtil.getString('token');
    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (token != null) {
      headers['Authorization'] = 'Bearer $token';
    } else {
      throw Exception('Autentikasi gagal: Token tidak ditemukan. Harap login ulang.');
    }

    print('Sending POST request to (Diagnosis): $url');
    print('Request headers (Diagnosis): $headers');
    print('Request body (Diagnosis): ${jsonEncode(input.toJson())}');

    try {
      final response = await http.post(
        url,
        headers: headers,
        body: jsonEncode(input.toJson()),
      );

      print('Response status (Diagnosis): ${response.statusCode}');
      print('Response body (Diagnosis): ${response.body}');

      if (response.statusCode == 200 || response.statusCode == 201) {
        final Map<String, dynamic> jsonResponse = jsonDecode(response.body);
        if (jsonResponse['success'] == true && jsonResponse.containsKey('predicted_diagnosis')) {
          return DiagnosisOutput.fromJson(jsonResponse);
        } else {
          throw Exception(jsonResponse['message'] ?? 'Respons tidak valid dari server API (Diagnosis).');
        }
      } else if (response.statusCode == 401) {
        throw Exception('Autentikasi gagal (Diagnosis): Sesi Anda mungkin telah berakhir. Harap login ulang.');
      } else {
        String errorMessage = 'Gagal mengirim diagnosis: ${response.statusCode}';
        try {
          final errorBody = jsonDecode(response.body);
          errorMessage = errorBody['message'] ?? errorBody['errors']?.values.first?.first ?? errorMessage;
        } catch (_) {
          // Biarkan errorMessage default
        }
        throw Exception(errorMessage);
      }
    } on http.ClientException catch (e) {
      print('HTTP Client Error in submitDiagnosis: $e');
      throw Exception('Gagal terhubung ke server (Diagnosis). Periksa koneksi internet atau URL API. Error: $e');
    } catch (e) {
      print('General Error in submitDiagnosis: $e');
      throw Exception('Terjadi kesalahan tidak terduga saat mengirim diagnosis: $e');
    }
  }

  // --- TAMBAHKAN METODE INI ---
  Future<List<DiagnosisOutput>> getDiagnosisHistory() async {
    final url = Uri.parse('$_baseUrl/api/diagnosa/history'); // Endpoint riwayat diagnosis Anda
    final String? token = SpUtil.getString('token');
    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (token != null) {
      headers['Authorization'] = 'Bearer $token';
    } else {
      throw Exception('Autentikasi gagal: Token tidak ditemukan.');
    }

    print('Sending GET request to (Diagnosis History): $url');
    print('Request headers (Diagnosis History): $headers');

    try {
      final response = await http.get(url, headers: headers);
      print('Response status (Diagnosis History): ${response.statusCode}');
      print('Response body (Diagnosis History): ${response.body}');

      if (response.statusCode == 200) {
        final Map<String, dynamic> jsonResponse = jsonDecode(response.body);
        if (jsonResponse['success'] == true && jsonResponse['data'] is List) {
          List<dynamic> data = jsonResponse['data'];
          print(data);
          // Pastikan format 'data' dari API Anda sesuai dengan yang diharapkan DiagnosisOutput.fromJson
          // Jika API Anda mengembalikan input_data juga, dan Anda ingin menampilkannya di riwayat,
          // pastikan DiagnosisOutput.fromJson bisa menerimanya atau Anda memetakannya di sini.
          return data.map((item) => DiagnosisOutput.fromJson(item as Map<String, dynamic>)).toList();
        } else {
          throw Exception(jsonResponse['message'] ?? 'Gagal memuat riwayat diagnosis.');
        }
      } else {
        throw Exception('Gagal memuat riwayat diagnosis: Status ${response.statusCode}');
      }
    } catch (e) {
      print('Error fetching diagnosis history: $e');
      throw Exception('Terjadi kesalahan saat memuat riwayat diagnosis: $e');
    }
  }
  // --- AKHIR PENAMBAHAN ---
}