// lib/riwayat_hasil_tes.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart';
// Jika Anda memindahkan http dan jsonDecode ke riwayat_controller, Anda mungkin tidak butuh ini di sini
// import 'package:http/http.dart' as http;
// import 'dart:convert';
// import 'package:sp_util/sp_util.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';

// --- IMPORT HALAMAN DETAIL ---
import 'package:mobile_project/screen/DetailHasilDiagnosaPage.dart';
import 'package:mobile_project/screen/HasilPenilaianDiriPage.dart';

// Import controller
import 'package:mobile_project/controller/riwayat_controller.dart';

// Karena untuk sementara hanya ada diagnosis, kita bisa menyederhanakan enum
// enum RiwayatViewType { diagnosa, perkembangan }
enum RiwayatViewType { diagnosa } // <--- UBAH: Hanya 'diagnosa' untuk sementara

class RiwayatHasilTesScreen extends StatefulWidget {
  const RiwayatHasilTesScreen({super.key});

  @override
  State<RiwayatHasilTesScreen> createState() => _RiwayatHasilTesScreenState();
}

class _RiwayatHasilTesScreenState extends State<RiwayatHasilTesScreen> {
  // Langsung set ke diagnosa dan tidak ada opsi lain
  RiwayatViewType _selectedViewType = RiwayatViewType.diagnosa;

  final RiwayatController _riwayatController = Get.find<RiwayatController>();

  @override
  void initState() {
    super.initState();
    _riwayatController.fetchDiagnosisHistory();
    // _riwayatController.fetchPerkembanganHistory(); // TIDAK DIPANGGIL DULU
  }

  // Fungsi untuk mendapatkan warna dasar berdasarkan kode diagnosis
  Color _getColorForDiagnosisCode(int? code) {
    switch (code) {
      case 0: return const Color(0xFFBA68C8); // Gangguan Bipolar (Purple)
      case 1: return const Color(0xFF81C784); // Gangguan Kecemasan Umum (Light Green)
      case 2: return const Color(0xFF64B5F6); // Gangguan Panik (Light Blue)
      case 3: return const Color(0xFFE57373); // Gangguan Depresi Mayor (Reddish-pink)
      default: return Colors.grey.shade600; // Default grey for unknown or null
    }
  }

  // Fungsi untuk mendapatkan summary (ringkasan) berdasarkan kode diagnosis
  String _getSummaryForDiagnosisCode(int? code) {
    switch (code) {
      case 0: return 'Diagnosis: Gangguan Bipolar';
      case 1: return 'Diagnosis: Gangguan Kecemasan Umum (Anxiety)';
      case 2: return 'Diagnosis: Gangguan Panik (Panic Attack)';
      case 3: return 'Diagnosis: Gangguan Depresi Mayor';
      default: return 'Diagnosis: Tidak Dikenal';
    }
  }

  // Fungsi untuk memformat timestamp dari API
  String _formatApiTimestamp(String? timestamp) {
    if (timestamp == null) return 'Tidak diketahui';
    try {
      DateTime dt = DateTime.parse(timestamp);
      return "${dt.day} ${[
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
      ][dt.month - 1]} ${dt.year} - ${dt.hour}:${dt.minute.toString().padLeft(2, '0')}";
    } catch (e) {
      print('Error parsing timestamp: $e');
      return timestamp;
    }
  }

  Widget _buildResultCard({
    required BuildContext context,
    required String title,
    required String dateTime,
    required String summary,
    required String actionText,
    required String imagePath,
    required VoidCallback onPressed,
    Gradient? gradient,
  }) {
    return Card(
      elevation: 3,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      margin: const EdgeInsets.symmetric(vertical: 8),
      clipBehavior: Clip.antiAlias,
      child: InkWell(
        onTap: onPressed,
        borderRadius: BorderRadius.circular(12),
        child: Container(
          decoration: BoxDecoration(
            gradient: gradient ?? LinearGradient(
              colors: [Colors.grey.shade300, Colors.grey.shade500],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
          ),
          padding: const EdgeInsets.all(16),
          child: Row(
            children: [
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: const TextStyle(
                        fontSize: 17,
                        fontWeight: FontWeight.bold,
                        color: Colors.white,
                      ),
                    ),
                    const SizedBox(height: 6),
                    Text(
                      dateTime,
                      style: TextStyle(fontSize: 13, color: Colors.white.withOpacity(0.9)),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      summary,
                      style: TextStyle(fontSize: 13, color: Colors.white.withOpacity(0.9)),
                    ),
                    const SizedBox(height: 10),
                    Text(
                      actionText,
                      style: const TextStyle(
                        fontSize: 13,
                        fontWeight: FontWeight.bold,
                        color: Colors.white,
                        decoration: TextDecoration.underline,
                        decorationColor: Colors.white,
                      ),
                    ),
                  ],
                ),
              ),
              const SizedBox(width: 12),
              ClipRRect(
                borderRadius: BorderRadius.circular(8),
                child: Container(
                  width: 55,
                  height: 55,
                  color: Colors.white.withOpacity(0.2),
                  child: Image.asset(
                    imagePath,
                    fit: BoxFit.contain,
                    errorBuilder: (context, error, stackTrace) => Icon(
                      Icons.notes_rounded,
                      size: 30,
                      color: Colors.white54,
                    ),
                  ),
                ),
              )
            ],
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Riwayat Hasil Tes'),
        backgroundColor: Theme.of(context).primaryColor,
        foregroundColor: Colors.white,
      ),
      body: Column(
        children: [
          Padding(
            padding: const EdgeInsets.all(16.0),
            // --- UBAH SEGMENTED BUTTON: Hanya tampilkan opsi 'Tes Diagnosa' ---
            child: SegmentedButton<RiwayatViewType>(
              segments: const <ButtonSegment<RiwayatViewType>>[
                ButtonSegment<RiwayatViewType>(
                    value: RiwayatViewType.diagnosa,
                    label: Text('Tes Diagnosa'),
                    icon: Icon(Icons.medical_information_outlined)),
                // HAPUS ButtonSegment untuk RiwayatViewType.perkembangan
              ],
              selected: <RiwayatViewType>{_selectedViewType},
              onSelectionChanged: (Set<RiwayatViewType> newSelection) {
                setState(() {
                  _selectedViewType = newSelection.first;
                  // Tidak perlu memanggil fetch lagi jika hanya ada satu tab
                  // atau jika Anda hanya ingin fetch sekali di initState
                });
              },
            ),
          ),
          Expanded(
            child: Obx(() {
              // displayedResults akan selalu menjadi diagnosisHistory
              List<Map<String, dynamic>> displayedResults = _riwayatController.diagnosisHistory;

              if (_riwayatController.isLoadingHistory) {
                return const Center(child: CircularProgressIndicator());
              } else if (_riwayatController.errorMessageHistory != null) {
                return Center(child: Text('Error: ${_riwayatController.errorMessageHistory!}'));
              } else if (displayedResults.isEmpty) {
                return Center(
                  child: Text(
                    'Belum ada riwayat untuk kategori ini.',
                    style: TextStyle(fontSize: 16, color: Colors.grey.shade600),
                  ),
                );
              } else {
                return ListView.builder(
                  padding: const EdgeInsets.symmetric(horizontal: 16.0),
                  itemCount: displayedResults.length,
                  itemBuilder: (context, index) {
                    final result = displayedResults[index];
                    int? predictedDiagnosisCode = result['predicted_diagnosis'] is int
                        ? result['predicted_diagnosis'] as int?
                        : (result['predicted_diagnosis'] != null
                            ? int.tryParse(result['predicted_diagnosis'].toString())
                            : null);

                    Color baseColor = _getColorForDiagnosisCode(predictedDiagnosisCode);

                    return _buildResultCard(
                      context: context,
                      title: result['title'] ?? 'Tes Diagnosa', // Pastikan title ada dari API atau default
                      dateTime: _formatApiTimestamp(result['timestamp']),
                      summary: _getSummaryForDiagnosisCode(predictedDiagnosisCode),
                      actionText: 'Lihat Detail Hasil',
                      imagePath: 'assets/images/mental_health_illustration.png',
                      gradient: LinearGradient(colors: [
                        baseColor.withOpacity(0.8),
                        baseColor,
                      ]),
                      onPressed: () {
                        // Karena hanya ada satu tipe, kita bisa langsung navigasi ke DetailHasilDiagnosaPage
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => DetailHasilDiagnosaPage(
                              rawDiagnosisResultCode: predictedDiagnosisCode,
                            ),
                          ),
                        );
                      },
                    );
                  },
                );
              }
            }),
          ),
        ],
      ),
    );
  }
}