// lib/screen/riwayat_hasil_tes.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:flutter_easyloading/flutter_easyloading.dart';

// Import halaman detail
import 'package:mobile_project/screen/DetailHasilDiagnosaPage.dart'; //
import 'package:mobile_project/screen/HasilPenilaianDiriPage.dart'; //

// Import model yang relevan
import 'package:mobile_project/models/diagnosis_result.dart';
import 'package:mobile_project/models/outcome_result.dart';

// Import controller
// Ganti RiwayatController dengan DiagnosisController dan OutcomeController
import 'package:mobile_project/controller/diagnosis_controller.dart';
import 'package:mobile_project/controller/outcome_controller.dart';


class RiwayatHasilTesScreen extends StatefulWidget {
  const RiwayatHasilTesScreen({super.key}); //

  @override
  State<RiwayatHasilTesScreen> createState() => _RiwayatHasilTesScreenState();
}

class _RiwayatHasilTesScreenState extends State<RiwayatHasilTesScreen> with SingleTickerProviderStateMixin {
  // Gunakan DiagnosisController dan OutcomeController
  final DiagnosisController _diagnosisController = Get.find<DiagnosisController>();
  final OutcomeController _outcomeController = Get.find<OutcomeController>();

  late TabController _tabController;

  @override
  void initState() { //
    super.initState(); //
    _tabController = TabController(length: 2, vsync: this); // 2 Tabs

    // Panggil fetch history untuk kedua controller
    // Asumsikan Anda akan menambahkan fetchDiagnosisHistory ke DiagnosisController
    // dan fetchOutcomeHistory sudah ada di OutcomeController
    _diagnosisController.fetchDiagnosisHistory(); // Anda perlu implementasi ini di DiagnosisController
    _outcomeController.fetchOutcomeHistory(); //
  }

  @override
  void dispose() {
    _tabController.dispose();
    super.dispose();
  }

  // Fungsi helper untuk Diagnosis (dari kode Anda)
  Color _getColorForDiagnosisCode(int? code) { //
    switch (code) { //
      case 0: return const Color(0xFFBA68C8); //
      case 1: return const Color(0xFF81C784); //
      case 2: return const Color(0xFF64B5F6); //
      case 3: return const Color(0xFFE57373); //
      default: return Colors.grey.shade600; //
    }
  }

  String _getSummaryForDiagnosisCode(int? code) { //
    switch (code) { //
      case 0: return 'Diagnosis: Gangguan Bipolar'; //
      case 1: return 'Diagnosis: Gangguan Kecemasan Umum (Anxiety)'; //
      case 2: return 'Diagnosis: Gangguan Panik (Panic Attack)'; //
      case 3: return 'Diagnosis: Gangguan Depresi Mayor'; //
      default: return 'Diagnosis: Tidak Dikenal'; //
    }
  }

  // Fungsi helper untuk Outcome
  Color _getColorForOutcomePrediction(int? prediction) {
    // Sesuaikan warna berdasarkan logika di HasilPenilaianDiriPage
    switch (prediction) {
      case 0: return Colors.orange.shade600; // Menurun
      case 1: return Colors.green.shade500;  // Membaik
      case 2: return Colors.blue.shade400;   // Stabil
      default: return Colors.grey.shade600;
    }
  }

  String _getSummaryForOutcomePrediction(int? prediction) {
    // Sesuaikan summary berdasarkan logika di HasilPenilaianDiriPage
    switch (prediction) {
      case 0: return 'Hasil: Kondisi Cenderung Menurun'; //
      case 1: return 'Hasil: Kondisi Cenderung Membaik'; //
      case 2: return 'Hasil: Kondisi Cukup Stabil'; //
      default: return 'Hasil: Tidak Diketahui';
    }
  }

  String _formatApiTimestamp(DateTime? timestamp) { // Mengubah parameter ke DateTime?
    if (timestamp == null) return 'Tidak diketahui'; //
    try { //
      // DateTime dt = DateTime.parse(timestamp); // Tidak perlu parse jika sudah DateTime
      return "${timestamp.day} ${[ //
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', //
        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des' //
      ][timestamp.month - 1]} ${timestamp.year} - ${timestamp.hour}:${timestamp.minute.toString().padLeft(2, '0')}"; //
    } catch (e) { //
      print('Error formatting timestamp: $e'); //
      return timestamp.toIso8601String(); // Fallback
    }
  }

  Widget _buildResultCard({ //
    required BuildContext context, //
    required String title, //
    required String dateTime, //
    required String summary, //
    required String actionText, //
    required String imagePath, //
    required VoidCallback onPressed, //
    Gradient? gradient, //
    IconData? leadingIcon, // Tambahan untuk ikon yang berbeda
  }) {
    return Card( //
      elevation: 3, //
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)), //
      margin: const EdgeInsets.symmetric(vertical: 8, horizontal: 16), //
      clipBehavior: Clip.antiAlias, //
      child: InkWell( //
        onTap: onPressed, //
        borderRadius: BorderRadius.circular(12), //
        child: Container( //
          decoration: BoxDecoration( //
            gradient: gradient ?? LinearGradient( //
              colors: [Colors.grey.shade300, Colors.grey.shade500], //
              begin: Alignment.topLeft, //
              end: Alignment.bottomRight, //
            ),
          ),
          padding: const EdgeInsets.all(16), //
          child: Row( //
            children: [ //
              if (leadingIcon != null) ...[
                Icon(leadingIcon, color: Colors.white, size: 30),
                const SizedBox(width: 12),
              ],
              Expanded( //
                child: Column( //
                  crossAxisAlignment: CrossAxisAlignment.start, //
                  children: [ //
                    Text( //
                      title, //
                      style: const TextStyle( //
                        fontSize: 17, //
                        fontWeight: FontWeight.bold, //
                        color: Colors.white, //
                      ),
                    ),
                    const SizedBox(height: 6), //
                    Text( //
                      dateTime, //
                      style: TextStyle(fontSize: 13, color: Colors.white.withOpacity(0.9)), //
                    ),
                    const SizedBox(height: 4), //
                    Text( //
                      summary, //
                      style: TextStyle(fontSize: 13, color: Colors.white.withOpacity(0.9)), //
                      maxLines: 2,
                      overflow: TextOverflow.ellipsis,
                    ),
                    const SizedBox(height: 10), //
                    Text( //
                      actionText, //
                      style: const TextStyle( //
                        fontSize: 13, //
                        fontWeight: FontWeight.bold, //
                        color: Colors.white, //
                        decoration: TextDecoration.underline, //
                        decorationColor: Colors.white, //
                      ),
                    ),
                  ],
                ),
              ),
              const SizedBox(width: 12), //
              ClipRRect( //
                borderRadius: BorderRadius.circular(8), //
                child: Container( //
                  width: 55, //
                  height: 55, //
                  color: Colors.white.withOpacity(0.2), //
                  child: Image.asset( //
                    imagePath, //
                    fit: BoxFit.contain, //
                    errorBuilder: (context, error, stackTrace) => Icon( //
                      Icons.notes_rounded, //
                      size: 30, //
                      color: Colors.white54, //
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

  Widget _buildDiagnosisHistoryList() {
    return Obx(() {
      // Gunakan _diagnosisController.diagnosisHistoryList (jika Anda menambahkannya)
      final List<DiagnosisOutput> history = _diagnosisController.diagnosisHistoryList; // Anda perlu menambahkan ini ke DiagnosisController

      if (_diagnosisController.isLoading && history.isEmpty) {
        return const Center(child: CircularProgressIndicator());
      }
      if (_diagnosisController.errorMessage != null && history.isEmpty) {
        return Center(child: Text('Error: ${_diagnosisController.errorMessage}'));
      }
      if (history.isEmpty) {
        return const Center(child: Text('Belum ada riwayat diagnosis.'));
      }

      return ListView.builder(
        padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
        itemCount: history.length,
        itemBuilder: (context, index) {
          final item = history[index];
          Color baseColor = _getColorForDiagnosisCode(item.diagnosis);
          return _buildResultCard(
            context: context,
            title: 'Tes Diagnosa',
            dateTime: _formatApiTimestamp(item.timestamp),
            summary: _getSummaryForDiagnosisCode(item.diagnosis),
            actionText: 'Lihat Detail Hasil',
            imagePath: 'assets/images/mental_health_illustration.png', // Sesuaikan path
            leadingIcon: Icons.medical_services_outlined,
            gradient: LinearGradient(colors: [baseColor.withOpacity(0.8), baseColor]),
            onPressed: () {
              if (item.diagnosis != null) {
                Get.toNamed('/detailhasil', arguments: {'rawDiagnosisResult': item.diagnosis.toString()});
              }
            },
          );
        },
      );
    });
  }

  Widget _buildPerkembanganHistoryList() {
    return Obx(() {
      final List<OutcomeOutput> history = _outcomeController.outcomeHistoryList; // Menggunakan RxList dari OutcomeController

      if (_outcomeController.isLoading && history.isEmpty) { //
        return const Center(child: CircularProgressIndicator());
      }
      if (_outcomeController.errorMessage != null && history.isEmpty) { //
        return Center(child: Text('Error: ${_outcomeController.errorMessage}')); //
      }
      if (history.isEmpty) {
        return const Center(child: Text('Belum ada riwayat tes perkembangan.'));
      }

      return ListView.builder(
        padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
        itemCount: history.length,
        itemBuilder: (context, index) {
          final item = history[index];
          Color baseColor = _getColorForOutcomePrediction(item.predictedOutcome);
          return _buildResultCard(
            context: context,
            title: 'Tes Perkembangan',
            dateTime: _formatApiTimestamp(item.timestamp),
            summary: _getSummaryForOutcomePrediction(item.predictedOutcome),
            actionText: 'Lihat Detail Penilaian',
            imagePath: 'assets/images/insights_illustration.png', // Sesuaikan path
            leadingIcon: Icons.trending_up_outlined,
            gradient: LinearGradient(colors: [baseColor.withOpacity(0.8), baseColor]),
            onPressed: () {
              // Navigasi ke HasilPenilaianDiriPage dengan data dari riwayat
              Get.toNamed(
                '/hasil_outcome',
                arguments: {
                  'outcomePrediction': item.predictedOutcome,
                  'answers': item.originalAnswers, // Pastikan API mengembalikan ini dan model menyimpannya
                  'timestamp': item.timestamp?.toIso8601String(),
                },
              );
            },
          );
        },
      );
    });
  }


  @override
  Widget build(BuildContext context) { //
    return Scaffold( //
      appBar: AppBar( //
        title: const Text('Riwayat Hasil Tes'), //
        backgroundColor: Theme.of(context).primaryColor, //
        foregroundColor: Colors.white, //
        bottom: TabBar(
          controller: _tabController,
          labelColor: Colors.white,
          unselectedLabelColor: Colors.white70,
          indicatorColor: Colors.amberAccent, // Warna indikator tab
          tabs: const [
            Tab(icon: Icon(Icons.medical_services_outlined), text: 'Diagnosa'),
            Tab(icon: Icon(Icons.trending_up_outlined), text: 'Perkembangan'),
          ],
        ),
      ),
      body: TabBarView(
        controller: _tabController,
        children: [
          _buildDiagnosisHistoryList(),    // Tab untuk riwayat diagnosis
          _buildPerkembanganHistoryList(), // Tab untuk riwayat perkembangan
        ],
      ),
       floatingActionButton: FloatingActionButton(
        onPressed: () {
          // Refresh data untuk tab yang aktif
          if (_tabController.index == 0) {
            _diagnosisController.fetchDiagnosisHistory(); // Anda perlu implementasi ini
          } else if (_tabController.index == 1) {
            _outcomeController.fetchOutcomeHistory(); //
          }
        },
        backgroundColor: Theme.of(context).colorScheme.secondary,
        foregroundColor: Colors.white,
        child: const Icon(Icons.refresh),
      ),
    );
  }
}