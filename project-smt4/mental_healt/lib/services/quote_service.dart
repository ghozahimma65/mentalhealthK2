// lib/services/quote_service.dart
import 'dart:convert';
import 'dart:math'; // Untuk memilih elemen acak
import 'package:http/http.dart' as http;
import '../models/quote_model.dart';
import '../utils/api_endpoints.dart';

class QuoteService {
  Future<Quote> getRandomQuote({String? category}) async {
    String url = '${ApiEndpoints.baseUrl}${ApiEndpoints.quotes}'; // Memanggil endpoint list
    List<String> queryParams = [];
    
    if (category != null) {
      queryParams.add('category=$category');
    }
    // Anda bisa tambahkan parameter pagination di sini jika API mendukung dan Anda hanya ingin mengambil sebagian kecil data
    // queryParams.add('page=1'); 
    // queryParams.add('per_page=20'); 

    if (queryParams.isNotEmpty) {
      url += '?${queryParams.join('&')}';
    }

    print('Fetching quotes from URL (for random selection): $url');

    final response = await http.get(Uri.parse(url));

    if (response.statusCode == 200) {
      // 1. Dekode JSON ke tipe 'dynamic' terlebih dahulu
      final dynamic decodedBody = json.decode(response.body);
      
      List<dynamic> dataList;

      // 2. Periksa apakah hasil decode adalah Map (struktur pagination Laravel)
      if (decodedBody is Map<String, dynamic> && decodedBody.containsKey('data') && decodedBody['data'] is List) {
        dataList = decodedBody['data'];
      } 
      // 3. Atau periksa apakah hasil decode adalah List secara langsung
      else if (decodedBody is List) {
        dataList = decodedBody;
      } 
      // 4. Jika bukan keduanya, berarti struktur JSON tidak terduga
      else {
        print('Unexpected JSON structure for list: $decodedBody');
        throw Exception('Failed to parse quotes list for random selection: Unexpected JSON structure.');
      }

      if (dataList.isEmpty) {
        print('No quotes found in the list for random selection (URL: $url).');
        throw Exception('Kutipan tidak ditemukan (daftar kosong).');
      }

      final List<Quote> quotes = dataList.map((jsonData) => Quote.fromJson(jsonData as Map<String, dynamic>)).toList(); // Pastikan jsonData di-cast
      
      final _random = Random();
      return quotes[_random.nextInt(quotes.length)];

    } else if (response.statusCode == 404) {
        // Ini seharusnya tidak terjadi jika endpoint /api/quotes ada
        // Mungkin terjadi jika ada filter kategori yang sangat spesifik dan endpointnya merespons 404.
        final body = json.decode(response.body); // Aman di-decode karena kita sudah dapat respons
        print('Error 404 fetching list for random: ${body['message']} (URL: $url)');
        throw Exception('Failed to load quotes for random. Status: ${response.statusCode}, Message: ${body['message']}');
    } else {
      print('Error fetching list for random: ${response.statusCode}, Body: ${response.body} (URL: $url)');
      throw Exception('Failed to load quotes for random. Status: ${response.statusCode}, Body: ${response.body}');
    }
  }

  // Pastikan getQuotesList juga dimodifikasi dengan cara yang sama jika perlu
  Future<List<Quote>> getQuotesList({int page = 1, String? category}) async {
    String url = '${ApiEndpoints.baseUrl}${ApiEndpoints.quotes}?page=$page';
    List<String> queryParams = [];
    if (category != null) {
      queryParams.add('category=$category');
    }
    if (queryParams.isNotEmpty) {
      url += '&${queryParams.join('&')}';
    }
    
    final response = await http.get(Uri.parse(url));
    if (response.statusCode == 200) {
        final dynamic decodedBody = json.decode(response.body); // Dekode ke dynamic
        List<dynamic> dataList;

        if (decodedBody is Map<String, dynamic> && decodedBody.containsKey('data') && decodedBody['data'] is List) {
            dataList = decodedBody['data']; // Khas pagination Laravel
        } else if (decodedBody is List) {
            dataList = decodedBody; // API langsung mengembalikan list
        } else {
            throw Exception('Unexpected JSON structure for quotes list.');
        }
        return dataList.map((jsonData) => Quote.fromJson(jsonData as Map<String, dynamic>)).toList(); // Cast jsonData
    } else {
        throw Exception('Failed to load quotes list. Status: ${response.statusCode}');
    }
  }
}