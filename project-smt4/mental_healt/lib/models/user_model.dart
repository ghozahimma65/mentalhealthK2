// lib/models/user_model.dart
import 'package:shared_preferences/shared_preferences.dart';

class UserModel {
  final String id;
  final String name;
  final String email;
  // Anda bisa menambahkan field lain yang mungkin Anda dapatkan dari API
  // misalnya: final String? role;
  // final String? profileImageUrl;

  UserModel({
    required this.id,
    required this.name,
    required this.email,
    // this.role,
    // this.profileImageUrl,
  });

  // Factory constructor untuk membuat instance UserModel dari SharedPreferences
  factory UserModel.fromPrefs(SharedPreferences prefs) {
    return UserModel(
      id: prefs.getString('user_id') ?? 'id_kosong_prefs', // Ambil dari SharedPreferences
      name: prefs.getString('user_name') ?? 'Pengguna',    // Ambil dari SharedPreferences
      email: prefs.getString('user_email') ?? 'email@example.com', // Ambil dari SharedPreferences
      // role: prefs.getString('user_role'),
      // profileImageUrl: prefs.getString('user_profile_image_url'),
    );
  }

  // Factory constructor untuk membuat instance UserModel dari data JSON (misalnya dari respons API)
  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      id: json['id']?.toString() ?? 'id_json_kosong', // Sesuaikan dengan kunci ID dari API Anda
      name: json['name'] as String? ?? 'Nama dari JSON',
      email: json['email'] as String? ?? 'email@json.com',
      // role: json['role'] as String?,
      // profileImageUrl: json['profile_image_url'] as String?,
    );
  }

  // Anda juga bisa menambahkan metode toJson jika perlu mengirim objek UserModel ke API
  // Map<String, dynamic> toJson() {
  //   return {
  //     'id': id,
  //     'name': name,
  //     'email': email,
  //     // 'role': role,
  //     // 'profileImageUrl': profileImageUrl,
  //   };
  // }
}