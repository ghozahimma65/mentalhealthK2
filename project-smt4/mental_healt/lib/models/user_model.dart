// lib/models/user_model.dart (buat file ini jika belum ada)
import 'dart:convert';

User userFromJson(String str) => User.fromJson(json.decode(str));
String userToJson(User data) => json.encode(data.toJson());

class User {
  final dynamic id; // Bisa String (dari MongoDB) atau int
  final String name;
  final String email;
  final String? role; // Opsional, tergantung data dari API Anda
  final DateTime? emailVerifiedAt; // Opsional
  final DateTime createdAt;
  final DateTime updatedAt;
  // Tambahkan field lain jika API Anda mengembalikannya dan Anda memerlukannya
  // final String? profilePhotoUrl; // Contoh jika ada foto profil

  User({
    required this.id,
    required this.name,
    required this.email,
    this.role,
    this.emailVerifiedAt,
    required this.createdAt,
    required this.updatedAt,
    // this.profilePhotoUrl,
  });

  factory User.fromJson(Map<String, dynamic> jsonMap) {
    return User(
      id: jsonMap["id"] ?? jsonMap["_id"], // Handle _id dari MongoDB atau id
      name: jsonMap["name"] ?? 'Pengguna', // Fallback jika nama null
      email: jsonMap["email"] ?? 'Tidak ada email', // Fallback jika email null
      role: jsonMap["role"],
      emailVerifiedAt: jsonMap["email_verified_at"] == null
          ? null
          : DateTime.tryParse(jsonMap["email_verified_at"].toString()),
      createdAt: DateTime.parse(jsonMap["created_at"]),
      updatedAt: DateTime.parse(jsonMap["updated_at"]),
      // profilePhotoUrl: jsonMap["profile_photo_url"],
    );
  }

  Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
        "email": email,
        "role": role,
        "email_verified_at": emailVerifiedAt?.toIso8601String(),
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        // "profile_photo_url": profilePhotoUrl,
      };
}