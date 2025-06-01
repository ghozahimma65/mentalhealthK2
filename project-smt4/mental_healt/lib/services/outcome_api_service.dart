// lib/services/outcome_api_service.dart

import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:sp_util/sp_util.dart';
import '../models/outcome_result.dart'; // Import model baru

class OutcomeApiService {
  final String _baseUrl = 'http://localhost:8000'; // GANTI DENGAN URL API LARAVEL ANDA!

  // Fungsi untuk mengirim data tes perkembangan ke API Laravel
  Future<OutcomeOutput> submitOutcome(OutcomeInput input) async {
    final url = Uri.parse('$_baseUrl/api/outcome/submit'); // Pastikan endpoint ini benar di Laravel

    final String? token = SpUtil.getString('token');

    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (token != null) {
      headers['Authorization'] = 'Bearer $token';
      print('Token dikirim: Bearer $token');
    } else {
      throw Exception('Autentikasi gagal: Token tidak ditemukan. Harap login kembali.');
    }

    print('Mengirim permintaan POST ke: $url');
    print('Header permintaan: $headers');
    print('Body permintaan: ${jsonEncode(input.toJson())}');

    try {
      final response = await http.post(
        url,
        headers: headers,
        body: jsonEncode(input.toJson()),
      );

      print('Status respons: ${response.statusCode}');
      print('Body respons: ${response.body}');

      if (response.statusCode == 200 || response.statusCode == 201) {
        final Map<String, dynamic> jsonResponse = jsonDecode(response.body);
        if (jsonResponse['success'] == true && jsonResponse.containsKey('predicted_outcome')) {
          return OutcomeOutput.fromJson(jsonResponse);
        } else {
          throw Exception(jsonResponse['message'] ?? 'Respons tidak valid dari server API.');
        }
      } else if (response.statusCode == 401) {
        throw Exception('Autentikasi gagal: Sesi Anda mungkin telah berakhir. Harap login ulang.');
      } else {
        String errorMessage = 'Gagal mengirim hasil tes perkembangan: ${response.statusCode}';
        try {
          final errorBody = jsonDecode(response.body);
          errorMessage = errorBody['message'] ?? errorBody['errors']?.values.first?.first ?? errorMessage;
        } catch (_) {
          // Biarkan errorMessage default jika body bukan JSON atau tidak ada 'message'
        }
        throw Exception(errorMessage);
      }
    } on http.ClientException catch (e) {
      print('HTTP Client Error dalam submitOutcome: $e');
      throw Exception('Gagal terhubung ke server. Periksa koneksi internet atau URL API Anda. Error: $e');
    } catch (e) {
      print('Kesalahan Umum dalam submitOutcome: $e');
      throw Exception('Terjadi kesalahan tidak terduga saat mengirim tes perkembangan: $e');
    }
  }

  // Fungsi untuk mengambil riwayat tes perkembangan dari API Laravel
  Future<List<OutcomeOutput>> fetchOutcomeHistory(String userId) async {
    final url = Uri.parse('$_baseUrl/api/outcome/history/$userId'); // Endpoint untuk mengambil riwayat

    final String? token = SpUtil.getString('token');

    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (token != null) {
      headers['Authorization'] = 'Bearer $token';
    } else {
      throw Exception('Autentikasi gagal: Token tidak ditemukan. Harap login kembali.');
    }

    print('Mengirim permintaan GET ke: $url');
    print('Header permintaan: $headers');

    try {
      final response = await http.get(
        url,
        headers: headers,
      );

      print('Status respons: ${response.statusCode}');
      print('Body respons: ${response.body}');

      if (response.statusCode == 200) {
        final Map<String, dynamic> jsonResponse = jsonDecode(response.body);
        if (jsonResponse['success'] == true && jsonResponse.containsKey('history')) {
          List<dynamic> historyData = jsonResponse['history'];
          return historyData.map((data) => OutcomeOutput.fromJson(data)).toList();
        } else {
          throw Exception(jsonResponse['message'] ?? 'Respons riwayat tidak valid dari server API.');
        }
      } else if (response.statusCode == 401) {
        throw Exception('Autentikasi gagal: Sesi Anda mungkin telah berakhir. Harap login ulang.');
      } else {
        String errorMessage = 'Gagal mengambil riwayat tes perkembangan: ${response.statusCode}';
        try {
          final errorBody = jsonDecode(response.body);
          errorMessage = errorBody['message'] ?? errorBody['errors']?.values.first?.first ?? errorMessage;
        } catch (_) {}
        throw Exception(errorMessage);
      }
    } on http.ClientException catch (e) {
      print('HTTP Client Error dalam fetchOutcomeHistory: $e');
      throw Exception('Gagal terhubung ke server. Periksa koneksi internet atau URL API Anda. Error: $e');
    } catch (e) {
      print('Kesalahan Umum dalam fetchOutcomeHistory: $e');
      throw Exception('Terjadi kesalahan tidak terduga saat mengambil riwayat tes perkembangan: $e');
    }
  }
}