// lib/services/auth_service.dart

import 'dart:convert'; // Untuk json.encode dan json.decode
import 'package:http/http.dart' as http; // Package untuk HTTP requests
import 'package:shared_preferences/shared_preferences.dart'; // Untuk menyimpan data sesi
import '../utils/api_endpoints.dart'; // Path ke ApiEndpoints.dart Anda

class AuthService {
  // Method register Anda yang sudah ada (tidak diubah dari versi Anda)
  Future<Map<String, dynamic>> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    final String url = ApiEndpoints.baseUrl + ApiEndpoints.register;
    final Map<String, String> headers = {
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
    // print('AuthService [REGISTER]: Request Body: $body'); // Aktifkan jika perlu debug body

    try {
      final response = await http.post(
        Uri.parse(url),
        headers: headers,
        body: body,
      );
      final Map<String, dynamic> responseData = json.decode(response.body);
      print('AuthService [REGISTER]: Response Status: ${response.statusCode}');

      if (response.statusCode == 201 && responseData['success'] == true) {
        print('AuthService [REGISTER]: Successful. Server message: ${responseData['message']}');
        return responseData;
      } else if (response.statusCode == 422) {
        print('AuthService [REGISTER]: Validation errors. Server response: $responseData');
        String combinedErrors = responseData['message'] ?? "Validasi gagal:\n";
        if (responseData.containsKey('errors') && responseData['errors'] is Map) {
            (responseData['errors'] as Map).forEach((key, value) {
                if (value is List && value.isNotEmpty) {
                    combinedErrors += "\n- ${value[0]}";
                } else if (value is String) {
                    combinedErrors += "\n- $value";
                }
            });
        }
        throw Exception(combinedErrors.trim());
      } else {
        print('AuthService [REGISTER]: Failed. Server message: ${responseData['message']}');
        throw Exception(responseData['message'] ?? 'Registrasi gagal. Status: ${response.statusCode}');
      }
    } catch (e) {
      print('AuthService [REGISTER]: Exception: $e');
      if (e is FormatException) {
        throw Exception('Gagal memproses respons dari server (registrasi).');
      }
      throw Exception(e.toString().replaceFirst("Exception: ", ""));
    }
  }

  // Method login Anda yang sudah ada (tidak diubah dari versi Anda)
  Future<Map<String, dynamic>> login(String email, String password) async {
    final String url = ApiEndpoints.baseUrl + ApiEndpoints.login;
    final Map<String, String> headers = {
      'Content-Type': 'application/json; charset=UTF-8',
      'Accept': 'application/json',
    };
    final String body = json.encode({
      'email': email,
      'password': password,
    });

    print('AuthService [LOGIN]: Attempting login to URL: $url');
    // print('AuthService [LOGIN]: Request Body: $body'); // Aktifkan jika perlu debug body

    try {
      final response = await http.post(
        Uri.parse(url),
        headers: headers,
        body: body,
      );
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
            await prefs.setString('token', accessToken); // Kunci: 'auth_token'

            String userId = (userMap['id']?.toString() ?? 'id_tidak_ditemukan');
            String? userName = userMap['name'] as String?;
            String? userEmail = userMap['email'] as String?;
            String? userRole = userMap['role'] as String?;
            String? emailVerifiedAt = userMap['email_verified_at'] as String?;

            await prefs.setString('user_id', userId);
            if (userName != null) await prefs.setString('user_name', userName); else await prefs.remove('user_name');
            if (userEmail != null) await prefs.setString('user_email', userEmail); else await prefs.remove('user_email');
            if (userRole != null) await prefs.setString('user_role', userRole); else await prefs.remove('user_role');
            if (emailVerifiedAt != null) await prefs.setString('user_email_verified_at', emailVerifiedAt); else await prefs.remove('user_email_verified_at');
            
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
        if (responseData.containsKey('errors') && responseData['errors'] is Map) {
            (responseData['errors'] as Map).forEach((key, value) { /* ... parsing errors ... */ });
        }
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

  // ===== METHOD BARU UNTUK LUPA PASSWORD =====
  Future<Map<String, dynamic>> requestPasswordReset(String email) async {
    final String url = ApiEndpoints.baseUrl + ApiEndpoints.forgotPassword; // Pastikan ini ada di ApiEndpoints.dart
    final Map<String, String> headers = {
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
        return responseData; // Berisi {'success': true, 'message': '...'}
      } else if (response.statusCode == 422) {
        String errorMessage = responseData['errors']?['email']?[0] ?? 
                              responseData['message'] ?? 
                              'Email tidak valid atau tidak terdaftar.';
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

  // ===== METHOD BARU UNTUK SUBMIT PASSWORD BARU =====
  Future<Map<String, dynamic>> submitNewPassword({
    required String token,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    final String url = ApiEndpoints.baseUrl + ApiEndpoints.resetPassword; // Pastikan ini ada di ApiEndpoints.dart
    final Map<String, String> headers = {
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
        if (responseData.containsKey('errors') && responseData['errors'] is Map) {
            (responseData['errors'] as Map).forEach((key, value) { /* ... parsing errors ... */ });
        }
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

  // Method untuk Logout Anda yang sudah ada (tidak diubah dari versi Anda)
  Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('token');
    await prefs.remove('user_id');
    await prefs.remove('user_name');
    await prefs.remove('user_email');
    await prefs.remove('user_role');
    print('AuthService [LOGOUT]: User data and token cleared from SharedPreferences.');
    // ... (pemanggilan API logout server jika ada) ...
  }

  // Helper untuk mendapatkan token (PASTIKAN KEY SUDAH BENAR)
  Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('token'); // Key yang digunakan saat menyimpan di method login
  }

  // Helper untuk mendapatkan status login (PASTIKAN KEY SUDAH BENAR)
  Future<bool> isLoggedIn() async {
    final token = await getToken();
    return token != null && token.isNotEmpty;
  }
}