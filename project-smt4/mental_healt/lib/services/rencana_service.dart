// lib/services/rencana_service.dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart'; // Untuk mengambil token

// Sesuaikan path ke model dan ApiEndpoints Anda
import '../models/self_care_plan.dart';
import '../utils/api_endpoints.dart';

class RencanaService {
  // Helper untuk mengambil token dari SharedPreferences
  // Anda bisa pindahkan ini ke AuthService atau kelas helper terpisah jika mau
  Future<String?> _getAuthToken() async {
    final prefs = await SharedPreferences.getInstance();
    // Ganti 'auth_token' dengan key yang Anda gunakan saat menyimpan token setelah login
    return prefs.getString('token');
  }

  // Membuat header standar untuk setiap request, termasuk token jika ada
  Future<Map<String, String>> _getHeaders() async {
    String? token = await _getAuthToken();
    Map<String, String> headers = {
      'Content-Type': 'application/json; charset=UTF-8',
      'Accept': 'application/json',
    };
    if (token != null && token.isNotEmpty) {
      headers['Authorization'] = 'Bearer $token';
    }
    return headers;
  }

  // GET: Mengambil daftar semua rencana milik pengguna
  Future<List<SelfCarePlan>> getRencanaList() async {
    final headers = await _getHeaders();
    final String url = '${ApiEndpoints.baseUrl}${ApiEndpoints.rencana}';

    print('RencanaService: GET $url'); // Debugging

    final response = await http.get(Uri.parse(url), headers: headers);

    print('RencanaService: GET List Status: ${response.statusCode}');
    // print('RencanaService: GET List Body: ${response.body}'); // Hati-hati jika body besar

    if (response.statusCode == 200) {
      final Map<String, dynamic> responseData = json.decode(response.body);
      if (responseData['success'] == true && responseData['data'] != null && responseData['data'] is List) {
        List<dynamic> dataList = responseData['data'];
        return dataList.map((jsonItem) => SelfCarePlan.fromJson(jsonItem)).toList();
      } else {
        throw Exception(responseData['message'] ?? 'Gagal memuat daftar rencana: Format data tidak sesuai.');
      }
    } else if (response.statusCode == 401) {
      throw Exception('Akses ditolak (401). Sesi Anda mungkin telah berakhir. Silakan login kembali.');
    } else {
      String errorMessage = 'Gagal memuat daftar rencana.';
      try {
        final errorData = json.decode(response.body);
        errorMessage = errorData['message'] ?? errorMessage;
      } catch (e) {/* Biarkan errorMessage default */}
      throw Exception('$errorMessage Status: ${response.statusCode}');
    }
  }

  // GET: Mengambil detail satu rencana berdasarkan ID
  Future<SelfCarePlan> getRencanaDetail(String id) async {
    final headers = await _getHeaders();
    final String url = '${ApiEndpoints.baseUrl}${ApiEndpoints.rencana}/$id';
    print('RencanaService: GET $url');

    final response = await http.get(Uri.parse(url), headers: headers);
    print('RencanaService: GET Detail Status: ${response.statusCode}');

    if (response.statusCode == 200) {
      final Map<String, dynamic> responseData = json.decode(response.body);
      if (responseData['success'] == true && responseData['data'] != null) {
        return SelfCarePlan.fromJson(responseData['data']);
      } else {
        throw Exception(responseData['message'] ?? 'Gagal memuat detail rencana: Format data tidak sesuai.');
      }
    } else if (response.statusCode == 401) {
      throw Exception('Akses ditolak (401). Sesi Anda mungkin telah berakhir. Silakan login kembali.');
    } else {
      String errorMessage = 'Gagal memuat detail rencana.';
      try {
        final errorData = json.decode(response.body);
        errorMessage = errorData['message'] ?? errorMessage;
      } catch (e) {/* Biarkan errorMessage default */}
      throw Exception('$errorMessage Status: ${response.statusCode}');
    }
  }


  // POST: Membuat rencana baru
  Future<SelfCarePlan> createRencana(SelfCarePlan plan) async {
    final headers = await _getHeaders();
    // Model SelfCarePlan.toJson() harus mengembalikan Map yang sesuai dengan field yang diharapkan backend
    // Untuk create, biasanya 'id', 'created_at', 'updated_at' tidak dikirim.
    // 'user_id' akan di-set oleh backend berdasarkan token.
    final body = json.encode(plan.toJson()); 
    final String url = '${ApiEndpoints.baseUrl}${ApiEndpoints.rencana}';

    print('RencanaService: POST $url');
    print('RencanaService: Create Body: $body');

    final response = await http.post(Uri.parse(url), headers: headers, body: body);

    print('RencanaService: POST Create Status: ${response.statusCode}');
    // print('RencanaService: POST Create Body: ${response.body}');

    if (response.statusCode == 201) { // 201 Created
      final Map<String, dynamic> responseData = json.decode(response.body);
      if (responseData['success'] == true && responseData['data'] != null) {
        return SelfCarePlan.fromJson(responseData['data']);
      } else {
        throw Exception(responseData['message'] ?? 'Gagal membuat rencana: Format respons tidak sesuai.');
      }
    } else if (response.statusCode == 401) {
      throw Exception('Akses ditolak (401). Sesi Anda mungkin telah berakhir. Silakan login kembali.');
    } else if (response.statusCode == 422) { // Error validasi
        final errorData = json.decode(response.body);
        // Anda bisa mem-parsing 'errors' field lebih detail jika perlu
        throw Exception('Gagal membuat rencana: ${errorData['message'] ?? 'Data tidak valid.'} (422)');
    }
    else {
      String errorMessage = 'Gagal membuat rencana.';
      try {
        final errorData = json.decode(response.body);
        errorMessage = errorData['message'] ?? errorMessage;
      } catch (e) {/* Biarkan errorMessage default */}
      throw Exception('$errorMessage Status: ${response.statusCode}');
    }
  }

  // PUT: Memperbarui rencana yang sudah ada
  Future<SelfCarePlan> updateRencana(String id, SelfCarePlan plan) async {
    final headers = await _getHeaders();
    final body = json.encode(plan.toJson()); // toJson() harus mengembalikan field yang bisa diupdate
    final String url = '${ApiEndpoints.baseUrl}${ApiEndpoints.rencana}/$id';

    print('RencanaService: PUT $url');
    print('RencanaService: Update Body: $body');

    final response = await http.put(Uri.parse(url), headers: headers, body: body);

    print('RencanaService: PUT Update Status: ${response.statusCode}');
    // print('RencanaService: PUT Update Body: ${response.body}');

    if (response.statusCode == 200) { // OK
      final Map<String, dynamic> responseData = json.decode(response.body);
      if (responseData['success'] == true && responseData['data'] != null) {
        return SelfCarePlan.fromJson(responseData['data']);
      } else {
        throw Exception(responseData['message'] ?? 'Gagal memperbarui rencana: Format respons tidak sesuai.');
      }
    } else if (response.statusCode == 401) {
      throw Exception('Akses ditolak (401). Sesi Anda mungkin telah berakhir. Silakan login kembali.');
    } else if (response.statusCode == 422) { // Error validasi
        final errorData = json.decode(response.body);
        throw Exception('Gagal memperbarui rencana: ${errorData['message'] ?? 'Data tidak valid.'} (422)');
    }
    else {
      String errorMessage = 'Gagal memperbarui rencana.';
      try {
        final errorData = json.decode(response.body);
        errorMessage = errorData['message'] ?? errorMessage;
      } catch (e) {/* Biarkan errorMessage default */}
      throw Exception('$errorMessage Status: ${response.statusCode}');
    }
  }

  // DELETE: Menghapus rencana
  Future<void> deleteRencana(String id) async {
    final headers = await _getHeaders();
    final String url = '${ApiEndpoints.baseUrl}${ApiEndpoints.rencana}/$id';

    print('RencanaService: DELETE $url');

    final response = await http.delete(Uri.parse(url), headers: headers);

    print('RencanaService: DELETE Status: ${response.statusCode}');
    // print('RencanaService: DELETE Body: ${response.body}');

    if (response.statusCode == 200 || response.statusCode == 204) { // OK atau No Content
      if (response.body.isNotEmpty) { // Cek jika ada body (API Anda mengembalikan 200 dengan body)
        final responseData = json.decode(response.body);
        if (responseData['success'] == true) {
          return; // Berhasil
        } else {
          throw Exception(responseData['message'] ?? 'Gagal menghapus rencana dari server.');
        }
      }
      return; // Jika 204 No Content, atau 200 tanpa body yang perlu dicek 'success' flag
    } else if (response.statusCode == 401) {
      throw Exception('Akses ditolak (401). Sesi Anda mungkin telah berakhir. Silakan login kembali.');
    } else {
      String errorMessage = 'Gagal menghapus rencana.';
      try {
        final errorData = json.decode(response.body);
        errorMessage = errorData['message'] ?? errorMessage;
      } catch (e) {/* Biarkan errorMessage default */}
      throw Exception('$errorMessage Status: ${response.statusCode}');
    }
  }
}