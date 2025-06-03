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
  final int? predictedOutcome; // DIUBAH KE int? agar sesuai HasilPenilaianDiriPage
  final String? userId;
  final DateTime? timestamp;
  final Map<String, dynamic>? originalAnswers; // Opsional: jika API mengembalikan input
  final String? feedbackMessage; // Opsional: jika API memberikan pesan feedback

  OutcomeOutput({
    this.predictedOutcome,
    this.userId,
    this.timestamp,
    this.originalAnswers,
    this.feedbackMessage,
  });

  factory OutcomeOutput.fromJson(Map<String, dynamic> json) {
    return OutcomeOutput(
      predictedOutcome: json['predicted_outcome'] as int?, // Pastikan API mengirim int
      userId: json['user_id'] as String?,
      timestamp: json['timestamp'] != null
          ? DateTime.tryParse(json['timestamp'])
          : null,
      originalAnswers: json['input_data'] as Map<String, dynamic>?, // Jika API mengirim input kembali
      feedbackMessage: json['feedback_message'] as String?, // Pesan feedback dari API
    );
  }
}