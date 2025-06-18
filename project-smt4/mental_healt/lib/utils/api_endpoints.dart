// lib/utils/api_endpoints.dart

class ApiEndpoints {
  // PASTIKAN ADA 'static const String' DI SINI
   static const String baseUrl = 'https://b163-103-109-209-253.ngrok-free.app/api';
   //http://127.0.0.1:8000/api';
   
  // static const String baseUrl = 'http://127.0.0.1:8000https://b163-103-109-209-253.ngrok-free.app/api';

  static const String meditations =
      '/meditasi'; // Pastikan ini singular jika rute Laravel Anda singular
  static const String login =
      '/auth/login'; // Ini sudah benar jika login Anda juga di bawah /auth
  static const String register = '/auth/register';
  static const String quotes = '/quotes'; // Untuk GET all dan POST (jika ada)
  static const String rencana = '/rencana'; // Untuk fitur Rencana Self Care

  // Endpoint untuk Lupa & Reset Password
  static const String forgotPassword =
      '/auth/password/email'; // Sesuaikan jika path di Laravel berbeda
  static const String resetPassword =
      '/auth/password/reset'; // Sesuaikan jika path di Laravel berbeda


  // --- Endpoint untuk Diagnosis ---
  static const String submitDiagnosis = '/diagnosa/submit';
  static const String historyDiagnosis = '/diagnosa/history';

  // --- Endpoint untuk Tes Perkembangan (Outcome) ---
  static const String submitOutcome = '/outcome/submit';
  static const String historyOutcome = '/outcome/history';
  // ... endpoint lain ...
}
