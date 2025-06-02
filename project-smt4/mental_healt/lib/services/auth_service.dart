// lib/services/auth_service.dart

import 'dart:convert'; // Untuk json.encode dan json.decode
import 'package:http/http.dart' as http; // Package untuk HTTP requests
import 'package:shared_preferences/shared_preferences.dart'; // Untuk menyimpan data sesi
import '../utils/api_endpoints.dart'; // Path ke ApiEndpoints.dart Anda
import '../models/user_model.dart';   // Path ke User model Dart Anda

class AuthService {
  // Helper untuk mendapatkan token dari SharedPreferences
  Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    // Pastikan key ini SAMA dengan yang Anda gunakan saat menyimpan token setelah login
    return prefs.getString('token'); 
  }

  // Helper untuk membuat header standar, termasuk token jika ada
  Future<Map<String, String>> _getHeaders() async {
    String? token = await getToken();
    Map<String, String> headers = {
      'Content-Type': 'application/json; charset=UTF-8',
      'Accept': 'application/json',
    };
    if (token != null && token.isNotEmpty) {
      headers['Authorization'] = 'Bearer $token';
      print('AuthService [_getHeaders]: Sending token: Bearer $token');
    } else {
      print('AuthService [_getHeaders]: No auth token found for request.');
    }
    return headers;
  }

  // Method untuk Registrasi Pengguna Baru
  Future<Map<String, dynamic>> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    final String url = ApiEndpoints.baseUrl + ApiEndpoints.register;
    final headers = { // Untuk registrasi, biasanya tidak memerlukan token
      'Content-Type': 'application/json; charset=UTF-8',
      'Accept': 'application/json',
    };
    final String body = json.encode({
      'name': name,
      'email': email,
      'password': password,
      'password_confirmation': passwordConfirmation,
    });

    print('AuthService [REGISTER]: Attempting registration to URL: $url');
    print('AuthService [REGISTER]: Request Body: $body');

    try {
      final response = await http.post(Uri.parse(url), headers: headers, body: body);
      final Map<String, dynamic> responseData = json.decode(response.body);
      print('AuthService [REGISTER]: Response Status: ${response.statusCode}');

      if (response.statusCode == 201 && responseData['success'] == true) {
        print('AuthService [REGISTER]: Successful. Server message: ${responseData['message']}');
        return responseData;
      } else if (response.statusCode == 422) { // Error validasi
        print('AuthService [REGISTER]: Validation errors. Server response: $responseData');
        String combinedErrors = responseData['message'] ?? "Validasi gagal:\n";
        if (responseData.containsKey('errors') && responseData['errors'] is Map) {
          (responseData['errors'] as Map).forEach((key, value) {
            if (value is List && value.isNotEmpty) combinedErrors += "\n- ${value[0]}";
            else if (value is String) combinedErrors += "\n- $value";
          });
        }
        throw Exception(combinedErrors.trim());
      } else {
        print('AuthService [REGISTER]: Failed. Server message: ${responseData['message']}');
        throw Exception(responseData['message'] ?? 'Registrasi gagal. Status: ${response.statusCode}');
      }
    } catch (e) {
      print('AuthService [REGISTER]: Exception: $e');
      if (e is FormatException) throw Exception('Gagal memproses respons dari server (registrasi).');
      throw Exception(e.toString().replaceFirst("Exception: ", ""));
    }
  }

  // Method untuk Login Pengguna
  Future<Map<String, dynamic>> login(String email, String password) async {
    final String url = ApiEndpoints.baseUrl + ApiEndpoints.login;
     final Map<String, String> headers = { // Login tidak memerlukan token auth sebelumnya
      'Content-Type': 'application/json; charset=UTF-8',
      'Accept': 'application/json',
    };
    final String body = json.encode({'email': email, 'password': password});

    print('AuthService [LOGIN]: Attempting login to URL: $url');
    print('AuthService [LOGIN]: Request Body: $body');

    try {
      final response = await http.post(Uri.parse(url), headers: headers, body: body);
      final Map<String, dynamic> responseData = json.decode(response.body);
      print('AuthService [LOGIN]: Response Status: ${response.statusCode}');

      if (response.statusCode == 200 && responseData['success'] == true) {
        print('AuthService [LOGIN]: Successful. Server response: $responseData');
        final Map<String, dynamic>? data = responseData['data'] as Map<String, dynamic>?;

        if (data != null) {
          final String? accessToken = data['access_token'] as String?;
          final Map<String, dynamic>? userMap = data['user'] as Map<String, dynamic>?;

          if (accessToken != null && accessToken.isNotEmpty && userMap != null) {
            final prefs = await SharedPreferences.getInstance();
            await prefs.setString('token', accessToken); // Kunci untuk token

            String userId = (userMap['id']?.toString() ?? 'id_tidak_ditemukan');
            String? userName = userMap['name'] as String?;
            String? userEmail = userMap['email'] as String?;
            String? userRole = userMap['role'] as String?;

            await prefs.setString('user_id', userId);
            if (userName != null) await prefs.setString('user_name', userName); else await prefs.remove('user_name');
            if (userEmail != null) await prefs.setString('user_email', userEmail); else await prefs.remove('user_email');
            if (userRole != null) await prefs.setString('user_role', userRole); else await prefs.remove('user_role');
            
            print('AuthService [LOGIN]: Token and user data saved. User Name: $userName');
            return responseData;
          } else {
            throw Exception('Login gagal: Respons server tidak lengkap (token/user).');
          }
        } else {
          throw Exception('Login gagal: Format respons server ("data") tidak dikenali.');
        }
      } else if (response.statusCode == 401) {
        throw Exception(responseData['message'] ?? 'Email atau password salah.');
      } else if (response.statusCode == 422) {
        String combinedErrors = responseData['message'] ?? "Validasi gagal:\n";
        if (responseData.containsKey('errors') && responseData['errors'] is Map) { /* ... parsing errors ... */ }
        throw Exception(combinedErrors.trim());
      } else {
        throw Exception(responseData['message'] ?? 'Login gagal. Status: ${response.statusCode}');
      }
    } catch (e) {
      print('AuthService [LOGIN]: Exception: $e');
      if (e is FormatException) throw Exception('Gagal memproses respons dari server (login).');
      throw Exception(e.toString().replaceFirst("Exception: ", ""));
    }
  }

  // Method untuk Logout Pengguna
  Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    // Hapus token dan data pengguna yang relevan
    await prefs.remove('token');
    await prefs.remove('user_id');
    await prefs.remove('user_name');
    await prefs.remove('user_email');
    await prefs.remove('user_role');
    print('AuthService [LOGOUT]: User data and token cleared from SharedPreferences.');

    // Opsional: Panggil API logout di server Laravel untuk menginvalidasi token di sisi server
    // final String url = ApiEndpoints.baseUrl + '/logout'; // Asumsi ada endpoint /api/logout
    // final headers = await _getHeaders(); // Ini akan mengirim token yang akan diinvalidasi
    // try {
    //   final response = await http.post(Uri.parse(url), headers: headers);
    //   if (response.statusCode == 200) {
    //     print('AuthService [LOGOUT]: Successfully logged out from server.');
    //   } else {
    //     print('AuthService [LOGOUT]: Server logout failed. Status: ${response.statusCode}');
    //   }
    // } catch (e) {
    //   print('AuthService [LOGOUT]: Error calling server logout endpoint: $e');
    // }
  }

  // Method untuk mengambil profil pengguna yang sedang login
  Future<User> getUserProfile() async {
    final headers = await _getHeaders();
    final String url = '${ApiEndpoints.baseUrl}/user'; // Endpoint standar Laravel untuk user terautentikasi

    print('AuthService [GET_PROFILE]: Fetching from $url');
    
    try {
      final response = await http.get(Uri.parse(url), headers: headers);
      print('AuthService [GET_PROFILE]: Response Status: ${response.statusCode}');

      if (response.statusCode == 200) {
        final Map<String, dynamic> responseData = json.decode(response.body);
        // Rute /api/user Laravel biasanya langsung mengembalikan objek user
        return User.fromJson(responseData);
      } else if (response.statusCode == 401) {
        // Token tidak valid, mungkin logout otomatis atau minta login ulang
        // await logout(); 
        throw Exception('Sesi Anda telah berakhir (401). Silakan login kembali.');
      } else {
        String errorMessage = 'Gagal memuat data profil.';
        try {
          final errorData = json.decode(response.body);
          errorMessage = errorData['message'] ?? errorMessage;
        } catch (e) { /* Biarkan errorMessage default */ }
        throw Exception('$errorMessage Status: ${response.statusCode}');
      }
    } catch (e) {
      print('AuthService [GET_PROFILE]: Exception: $e');
      if (e is FormatException) throw Exception('Gagal memproses respons dari server (profil).');
      throw Exception(e.toString().replaceFirst("Exception: ", ""));
    }
  }

  // Method untuk meminta link reset password
  Future<Map<String, dynamic>> requestPasswordReset(String email) async {
    final String url = ApiEndpoints.baseUrl + ApiEndpoints.forgotPassword;
    final Map<String, String> headers = { // Tidak perlu token untuk request ini
      'Content-Type': 'application/json; charset=UTF-8',
      'Accept': 'application/json',
    };
    final String body = json.encode({'email': email});

    print('AuthService [FORGOT_PW]: Requesting to $url with body: $body');
    try {
      final response = await http.post(Uri.parse(url), headers: headers, body: body);
      final Map<String, dynamic> responseData = json.decode(response.body);
      print('AuthService [FORGOT_PW]: Response Status: ${response.statusCode}');

      if (response.statusCode == 200 && responseData['success'] == true) {
        return responseData;
      } else if (response.statusCode == 422) {
        String errorMessage = responseData['errors']?['email']?[0] ?? responseData['message'] ?? 'Email tidak valid/terdaftar.';
        throw Exception(errorMessage);
      } else {
        throw Exception(responseData['message'] ?? 'Gagal mengirim permintaan reset. Status: ${response.statusCode}');
      }
    } catch (e) {
      print('AuthService [FORGOT_PW]: Exception: $e');
      if (e is FormatException) throw Exception('Gagal memproses respons server (forgot password).');
      throw Exception(e.toString().replaceFirst("Exception: ", ""));
    }
  }

  // Method untuk submit password baru dengan token
  Future<Map<String, dynamic>> submitNewPassword({
    required String token,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    final String url = ApiEndpoints.baseUrl + ApiEndpoints.resetPassword;
     final Map<String, String> headers = { // Tidak perlu token auth untuk request ini
      'Content-Type': 'application/json; charset=UTF-8',
      'Accept': 'application/json',
    };
    final String body = json.encode({
      'token': token,
      'email': email,
      'password': password,
      'password_confirmation': passwordConfirmation,
    });

    print('AuthService [RESET_PW]: Submitting to $url with body: $body');
    try {
      final response = await http.post(Uri.parse(url), headers: headers, body: body);
      final Map<String, dynamic> responseData = json.decode(response.body);
      print('AuthService [RESET_PW]: Response Status: ${response.statusCode}');

      if (response.statusCode == 200 && responseData['success'] == true) {
        return responseData;
      } else if (response.statusCode == 422) {
        String combinedErrors = responseData['message'] ?? "Validasi gagal:\n";
        if (responseData.containsKey('errors') && responseData['errors'] is Map) { /* ... parsing errors ... */ }
        throw Exception(combinedErrors.trim());
      } else {
        throw Exception(responseData['message'] ?? 'Gagal mereset password. Token/email mungkin tidak valid. Status: ${response.statusCode}');
      }
    } catch (e) {
      print('AuthService [RESET_PW]: Exception: $e');
      if (e is FormatException) throw Exception('Gagal memproses respons server (reset password).');
      throw Exception(e.toString().replaceFirst("Exception: ", ""));
    }
  }

  // Helper untuk mendapatkan status login
  Future<bool> isLoggedIn() async {
    final token = await getToken();
    return token != null && token.isNotEmpty;
  }
}