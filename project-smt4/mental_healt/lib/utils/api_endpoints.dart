// lib/utils/api_endpoints.dart

class ApiEndpoints {
  // PASTIKAN ADA 'static const String' DI SINI
  static const String baseUrl = 'http://127.0.0.1:8000/api'; // atau http://localhost:8000/api untuk Flutter Web
                                                            // atau http://10.0.2.2:8000/api untuk Emulator Android

  static const String meditations = '/meditasi'; // Pastikan ini singular jika rute Laravel Anda singular
  static const String login = '/login';
  // ... endpoint lain ...
}