// lib/provider/meditation_provider.dart
import 'dart:async'; // Untuk TimeoutException
import 'dart:convert';
import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:mobile_project/models/meditation_track.dart'; // Path ke model Anda
import 'package:mobile_project/utils/api_endpoints.dart';   // Path ke API endpoints Anda
// import 'package:sp_util/sp_util.dart'; // Jika perlu token

class MeditationProvider {
  final int _timeoutDuration = 15; // Durasi timeout dalam detik

  Future<List<MeditationTrack>> fetchMeditationTracks() async {
    final String fullUrl = ApiEndpoints.baseUrl + ApiEndpoints.meditations;
    print('Flutter mencoba GET: $fullUrl');

    try {
      // final String? token = SpUtil.getString('token');
      final response = await http.get(
        Uri.parse(fullUrl),
        // headers: {
        //   if (token != null) 'Authorization': 'Bearer $token',
        //   'Accept': 'application/json',
        // },
      ).timeout(Duration(seconds: _timeoutDuration));

      if (response.statusCode == 200) {
        final responseBody = jsonDecode(response.body);
        if (responseBody['success'] == true && responseBody['data'] is List) {
          List<dynamic> bodyData = responseBody['data'];
          List<MeditationTrack> tracks = bodyData
              .map((dynamic item) => MeditationTrack.fromJson(item as Map<String, dynamic>))
              .toList();
          return tracks;
        } else {
          String message = responseBody['message'] ?? 'Format respons API tidak sesuai atau permintaan gagal.';
          throw Exception(message);
        }
      } else {
        String errorMessage = 'Gagal memuat trek meditasi: Status ${response.statusCode}';
        try {
          final errorBody = jsonDecode(response.body);
          if (errorBody != null && errorBody['message'] != null) {
            errorMessage += '. Pesan Server: ${errorBody['message']}';
          } else if (errorBody != null && errorBody['errors'] != null) {
            // Jika ada validation errors dari Laravel
            errorMessage += '. Detail: ${jsonEncode(errorBody['errors'])}';
          }
        } catch (_) {
          // Gagal parse body error, tambahkan body mentah jika tidak terlalu panjang
          if (response.body.length < 500) { // Batasi panjang body error mentah
             errorMessage += '. Body: ${response.body}';
          }
        }
        throw Exception(errorMessage);
      }
    } on TimeoutException catch (_) {
      throw Exception('Koneksi timeout saat mengambil data meditasi.');
    } on SocketException catch (e) { // Untuk error jaringan seperti 'Connection refused'
        throw Exception('Error jaringan saat mengambil data meditasi: ${e.message}');
    } catch (e) {
      // Untuk error tak terduga lainnya
      throw Exception('Error tidak diketahui saat mengambil trek meditasi: $e');
    }
  }

  Future<MeditationTrack> postMeditationTrack(MeditationTrack trackData) async {
    final String fullUrl = ApiEndpoints.baseUrl + ApiEndpoints.meditations;
    print('Flutter mencoba POST ke: $fullUrl dengan data: ${trackData.toJsonForCreate()}');

    try {
      // final String? token = SpUtil.getString('token');
      final response = await http.post(
        Uri.parse(fullUrl),
        headers: {
          // if (token != null) 'Authorization': 'Bearer $token',
          'Content-Type': 'application/json; charset=UTF-8', // Ditambahkan Content-Type
          'Accept': 'application/json',
        },
        body: jsonEncode(trackData.toJsonForCreate()),
      ).timeout(Duration(seconds: _timeoutDuration));

      if (response.statusCode == 201) { // 201 Created
        final responseBody = jsonDecode(response.body);
         if (responseBody['success'] == true && responseBody['data'] != null) {
           return MeditationTrack.fromJson(responseBody['data'] as Map<String, dynamic>);
         } else {
           String message = responseBody['message'] ?? 'Format respons API tidak sesuai atau post gagal.';
           throw Exception(message);
         }
      } else {
        String errorMessage = 'Gagal mengirim trek meditasi: Status ${response.statusCode}';
         try {
          final errorBody = jsonDecode(response.body);
          if (errorBody != null && errorBody['message'] != null) {
            errorMessage += '. Pesan Server: ${errorBody['message']}';
          } else if (errorBody != null && errorBody['errors'] != null) {
            errorMessage += '. Detail: ${jsonEncode(errorBody['errors'])}';
          }
        } catch (_) {
          if (response.body.length < 500) {
             errorMessage += '. Body: ${response.body}';
          }
        }
        throw Exception(errorMessage);
      }
    } on TimeoutException catch (_) {
      throw Exception('Koneksi timeout saat mengirim data meditasi.');
    } on SocketException catch (e) {
        throw Exception('Error jaringan saat mengirim data meditasi: ${e.message}');
    } catch (e) {
      throw Exception('Error tidak diketahui saat mengirim trek meditasi: $e');
    }
  }
}
