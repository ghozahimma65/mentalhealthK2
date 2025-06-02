// lib/models/outcome_result.dart

import 'dart:convert';

// Model untuk data input yang akan dikirim ke API
class OutcomeInput {
  // Mengubah tipe data menjadi int
  final int? diagnosis; // Tipe int karena value di Option sekarang int
  final int? symptomSeverity;
  final int? moodScore;
  final double? physicalActivity; // Tipe double untuk mendukung desimal
  // Mengubah tipe data menjadi int
  final int? medication; // Tipe int
  // Mengubah tipe data menjadi int
  final int? therapyType; // Tipe int
  final int? treatmentDuration;
  final int? stressLevel;
  final String? userId;

  OutcomeInput({
    this.diagnosis,
    this.symptomSeverity,
    this.moodScore,
    this.physicalActivity,
    this.medication,
    this.therapyType,
    this.treatmentDuration,
    this.stressLevel,
    this.userId,
  });

  // Konversi objek OutcomeInput ke format JSON (Map<String, dynamic>)
  Map<String, dynamic> toJson() {
    return {
      'diagnosis': diagnosis,
      'symptom_severity': symptomSeverity,
      'mood_score': moodScore,
      'physical_activity': physicalActivity,
      'medication': medication,
      'therapy_type': therapyType,
      'treatment_duration': treatmentDuration,
      'stress_level': stressLevel,
      'user_id': userId,
    };
  }
}

// Model untuk data hasil yang diterima dari API (tidak ada perubahan signifikan)
class OutcomeOutput {
  final String? predictedOutcome; // String karena hasil AI bisa berupa kategori teks
  final String? userId;
  final DateTime? timestamp;

  OutcomeOutput({
    this.predictedOutcome,
    this.userId,
    this.timestamp,
  });

  factory OutcomeOutput.fromJson(Map<String, dynamic> json) {
    return OutcomeOutput(
      predictedOutcome: json['predicted_outcome'] as String?,
      userId: json['user_id'] as String?,
      timestamp: json['timestamp'] != null
          ? DateTime.tryParse(json['timestamp'])
          : null,
    );
  }
}