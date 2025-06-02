// lib/models/diagnosis_result.dart

import 'dart:convert';

// Model untuk data input yang akan dikirim ke API
class DiagnosisInput {
  final int age;
  final int gender; // 0 for female, 1 for male (sesuai API)
  final int symptomSeverity; // 1-10
  final int moodScore; // 1-10
  final int sleepQuality; // 1-10
  final double physicalActivity; // 1-10 (gunakan double jika API mengharapkan float)
  final int stressLevel; // 1-10
  final int aiDetectedEmotionalState; // 0-5
  final String? userId; // <--- TAMBAH INI: Properti untuk user_id

  DiagnosisInput({
    required this.age,
    required this.gender,
    required this.symptomSeverity,
    required this.moodScore,
    required this.sleepQuality,
    required this.physicalActivity,
    required this.stressLevel,
    required this.aiDetectedEmotionalState,
    this.userId, // <--- TAMBAH INI: Pastikan ada di konstruktor
  });

  // Konversi objek DiagnosisInput ke format JSON (Map<String, dynamic>)
  Map<String, dynamic> toJson() {
    return {
      'age': age,
      'gender': gender,
      'symptom_severity': symptomSeverity,
      'mood_score': moodScore,
      'sleep_quality': sleepQuality,
      'physical_activity': physicalActivity,
      'stress_level': stressLevel,
      'ai_detected_emotional_state': aiDetectedEmotionalState,
      'user_id': userId, // <--- TAMBAH INI: Sertakan user_id dalam JSON
    };
  }
}

// Model untuk data hasil yang diterima dari API (tidak ada perubahan di sini)
class DiagnosisOutput {
  final int? diagnosis;
  final String? userId;
  final DateTime? timestamp;

  DiagnosisOutput({
    this.diagnosis,
    this.userId,
    this.timestamp,
  });

  factory DiagnosisOutput.fromJson(Map<String, dynamic> json) {
    return DiagnosisOutput(
      diagnosis: json['predicted_diagnosis'] as int?,
      userId: json['user_id'] as String?,
      timestamp: json['timestamp'] != null
          ? DateTime.tryParse(json['timestamp'])
          : null,
    );
  }
}