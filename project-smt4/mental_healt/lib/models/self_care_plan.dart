// lib/models/self_care_plan.dart
import 'dart:convert';

// Helper untuk deserialisasi list (jika API mengembalikan list di dalam field 'data')
List<SelfCarePlan> selfCarePlanListFromApiResponse(Map<String, dynamic> jsonResponse) {
  if (jsonResponse['success'] == true && jsonResponse['data'] != null) {
    List<dynamic> dataList = jsonResponse['data'];
    return List<SelfCarePlan>.from(dataList.map((x) => SelfCarePlan.fromJson(x)));
  }
  return []; // Kembalikan list kosong jika tidak sukses atau data null
}

// Helper untuk deserialisasi satu objek (jika API mengembalikan objek di dalam field 'data')
SelfCarePlan selfCarePlanFromApiResponse(Map<String, dynamic> jsonResponse) {
  if (jsonResponse['success'] == true && jsonResponse['data'] != null) {
    return SelfCarePlan.fromJson(jsonResponse['data']);
  }
  throw Exception(jsonResponse['message'] ?? 'Format respons tidak sesuai atau data null.');
}


class SelfCarePlan {
  String id; // ID dari MongoDB (string)
  String title;
  String description;
  bool isCompleted;
  DateTime? createdAt;
  DateTime? updatedAt;

  SelfCarePlan({
    required this.id,
    required this.title,
    this.description = '',
    this.isCompleted = false,
    this.createdAt,
    this.updatedAt,
  });

  // Untuk membuat objek dari data dummy atau sebelum dikirim ke API (ID bisa di-generate server)
  SelfCarePlan.create({
    required this.title,
    this.description = '',
    this.isCompleted = false,
  }) : id = '', // ID akan diisi oleh server saat pembuatan
       createdAt = DateTime.now(), // Placeholder, server akan menentukan
       updatedAt = DateTime.now(); // Placeholder

  factory SelfCarePlan.fromJson(Map<String, dynamic> json) {
    return SelfCarePlan(
      id: json['id'] as String? ?? json['_id'] as String? ?? DateTime.now().millisecondsSinceEpoch.toString(), // Fallback ID jika tidak ada
      title: json['title'] as String,
      description: json['description'] as String? ?? '',
      // Asumsi nama field di API adalah 'is_completed'. Jika berbeda, sesuaikan.
      isCompleted: json['is_completed'] as bool? ?? false,
      createdAt: json['created_at'] != null ? DateTime.parse(json['created_at'] as String) : null,
      updatedAt: json['updated_at'] != null ? DateTime.parse(json['updated_at'] as String) : null,
    );
  }

  Map<String, dynamic> toJson() {
    // Hanya kirim field yang bisa diubah/dibuat oleh klien
    // ID, createdAt, updatedAt biasanya di-handle server
    return {
      'title': title,
      'description': description,
      'is_completed': isCompleted, // Kirim status is_completed
    };
  }
}