// lib/services/outcome_api_service.dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:sp_util/sp_util.dart';
import '../models/outcome_result.dart';

class OutcomeApiService {
  // GANTI DENGAN URL API LARAVEL ANDA!
  final String _baseUrl = 'http://localhost:8000'; // Sesuaikan dengan IP Anda

  // Fungsi untuk mengirim data tes perkembangan ke API Laravel
  Future<OutcomeOutput> submitOutcome(OutcomeInput input) async {
    final url = Uri.parse('$_baseUrl/api/outcome/submit'); // Endpoint baru
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

    print('Sending POST request to (Outcome): $url');
    print('Request headers (Outcome): $headers');
    print('Request body (Outcome): ${jsonEncode(input.toJson())}');

    try {
      final response = await http.post(
        url,
        headers: headers,
        body: jsonEncode(input.toJson()),
      );

      print('Response status (Outcome): ${response.statusCode}');
      print('Response body (Outcome): ${response.body}');

      if (response.statusCode == 200 || response.statusCode == 201) {
        final Map<String, dynamic> jsonResponse = jsonDecode(response.body);
        if (jsonResponse['success'] == true && jsonResponse.containsKey('predicted_outcome')) {
          // Jika API Anda mengembalikan 'input_data' juga, pastikan itu disertakan
          // untuk ditampilkan di halaman hasil jika perlu.
          Map<String, dynamic> dataToParse = Map.from(jsonResponse);
          if (jsonResponse.containsKey('input_data')) {
             dataToParse['input_data'] = jsonResponse['input_data'];
          }
          return OutcomeOutput.fromJson(dataToParse);
        } else {
          throw Exception(jsonResponse['message'] ?? 'Respons tidak valid dari server API (Outcome).');
        }
      } else if (response.statusCode == 401) {
        throw Exception('Autentikasi gagal (Outcome): Sesi Anda mungkin telah berakhir. Harap login ulang.');
      } else {
        String errorMessage = 'Gagal mengirim tes perkembangan: ${response.statusCode}';
        try {
          final errorBody = jsonDecode(response.body);
          errorMessage = errorBody['message'] ?? errorBody['errors']?.values.first?.first ?? errorMessage;
        } catch (_) {
          // Biarkan errorMessage default
        }
        throw Exception(errorMessage);
      }
    } on http.ClientException catch (e) {
      print('HTTP Client Error in submitOutcome: $e');
      throw Exception('Gagal terhubung ke server (Outcome). Periksa koneksi internet atau URL API. Error: $e');
    } catch (e) {
      print('General Error in submitOutcome: $e');
      throw Exception('Terjadi kesalahan tidak terduga saat mengirim tes perkembangan: $e');
    }
  }

  // Fungsi untuk mengambil riwayat tes perkembangan
  Future<List<OutcomeOutput>> fetchOutcomeHistory(String userId) async { // userId mungkin tidak diperlukan jika API mengambil dari token
    final url = Uri.parse('$_baseUrl/api/outcome/history'); // Endpoint baru
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

    try {
      final response = await http.get(url, headers: headers);
      print('Response status (Outcome History): ${response.statusCode}');
      print('Response body (Outcome History): ${response.body}');

      if (response.statusCode == 200) {
        final Map<String, dynamic> jsonResponse = jsonDecode(response.body);
        if (jsonResponse['success'] == true && jsonResponse['data'] is List) {
          List<dynamic> data = jsonResponse['data'];
          return data.map((item) => OutcomeOutput.fromJson(item as Map<String, dynamic>)).toList();
        } else {
          throw Exception(jsonResponse['message'] ?? 'Gagal memuat riwayat perkembangan.');
        }
      } else {
        throw Exception('Gagal memuat riwayat perkembangan: Status ${response.statusCode}');
      }
    } catch (e) {
      print('Error fetching outcome history: $e');
      throw Exception('Terjadi kesalahan saat memuat riwayat perkembangan: $e');
    }
  }
}