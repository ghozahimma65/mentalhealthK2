// lib/models/outcome_result.dart

import 'dart:convert';

// Model untuk data input yang akan dikirim ke API
class OutcomeInput {
  final int? diagnosis;
  final int? symptomSeverity;
  final int? moodScore;
  final double? physicalActivity;
  final int? medication;
  final int? therapyType;
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

// Model untuk data hasil yang diterima dari API
class OutcomeOutput {
  final int? predictedOutcome; // **** DIUBAH KE int? ****
  final String? userId;
  final DateTime? timestamp;
  final Map<String, dynamic>? originalAnswers; // Untuk menampilkan jawaban asli jika API mengirimkannya


  OutcomeOutput({
    this.predictedOutcome,
    this.userId,
    this.timestamp,
    this.originalAnswers,

  });

  factory OutcomeOutput.fromJson(Map<String, dynamic> json) {
    return OutcomeOutput(
      predictedOutcome: json['predicted_outcome'] as int?, // **** DIPARSING SEBAGAI int? ****
      userId: json['user_id'] as String?,
      timestamp: json['timestamp'] != null
          ? DateTime.tryParse(json['timestamp'])
          : null,
      originalAnswers: json['input_data'] as Map<String, dynamic>?, // Sesuaikan dengan kunci dari API

    );
  }
}