// lib/controller/auth_controller.dart
import 'package:flutter/material.dart'; // Diperlukan untuk Colors di Snackbar
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../services/auth_service.dart'; // Sesuaikan path jika perlu
import '../models/user_model.dart'; // <-- TAMBAHKAN IMPOR INI

class AuthController extends GetxController {
  final AuthService _authService = AuthService();
  Rx<UserModel?> user = Rx<UserModel?>(null); // Sekarang UserModel dikenali
  RxBool isLoggedIn = false.obs;

  @override
  void onInit() {
    super.onInit();
    checkLoginStatus();
  }

  Future<void> checkLoginStatus() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');
    if (token != null && token.isNotEmpty) {
      user.value = UserModel.fromPrefs(prefs); // Menggunakan factory dari UserModel
      isLoggedIn.value = true;
    } else {
      isLoggedIn.value = false;
      user.value = null;
    }
  }

  // Panggil ini setelah login berhasil dengan data dari API
  Future<void> loginSuccess(Map<String, dynamic> apiUserData, String token) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('token', token);

    // Membuat instance UserModel dari data API menggunakan factory UserModel.fromJson
    UserModel loggedInUser = UserModel.fromJson(apiUserData);

    await prefs.setString('user_id', loggedInUser.id);
    await prefs.setString('user_name', loggedInUser.name);
    await prefs.setString('user_email', loggedInUser.email);
    // Jika ada field lain di UserModel, simpan juga ke SharedPreferences jika perlu
    // await prefs.setString('user_role', loggedInUser.role ?? '');

    user.value = loggedInUser;
    isLoggedIn.value = true;
  }

  Future<void> logout() async {
    await _authService.logout(); // Ini akan membersihkan SharedPreferences
    user.value = null;
    isLoggedIn.value = false;
    Get.offAllNamed('/login'); 

    Get.snackbar(
      "Logout Berhasil",
      "Anda telah keluar.",
      snackPosition: SnackPosition.BOTTOM,
      backgroundColor: Colors.green.shade600,
      colorText: Colors.white,
      borderRadius: 8,
      margin: const EdgeInsets.all(10),
      icon: const Icon(Icons.check_circle_outline, color: Colors.white),
      shouldIconPulse: true,
      barBlur: 20,
      isDismissible: true,
      duration: const Duration(seconds: 3),
    );
  }

  // Panggil ini saat aplikasi dimulai atau saat data pengguna mungkin berubah
  Future<void> loadUserData() async {
     final prefs = await SharedPreferences.getInstance();
     final token = prefs.getString('token');
     if (token != null && token.isNotEmpty) {
        user.value = UserModel.fromPrefs(prefs); // Menggunakan factory dari UserModel
        isLoggedIn.value = true;
     } else {
        isLoggedIn.value = false;
        user.value = null;
     }
  }
}