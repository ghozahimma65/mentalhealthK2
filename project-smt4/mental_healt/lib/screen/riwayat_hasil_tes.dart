// lib/riwayat_hasil_tes.dart
import 'package:flutter/material.dart';

// --- IMPORT HALAMAN DETAIL YANG SUDAH DIGANTI NAMANYA ---
// Pastikan path ini sesuai dengan struktur folder Anda
import 'package:mobile_project/screen/DetailHasilDiagnosaPage.dart';
import 'package:mobile_project/screen/HasilPenilaianDiriPage.dart';


// Enum untuk membedakan tipe tes yang dipilih di Riwayat
enum RiwayatViewType { diagnosa, perkembangan }

class RiwayatHasilTesScreen extends StatefulWidget {
  const RiwayatHasilTesScreen({super.key});

  @override
  State<RiwayatHasilTesScreen> createState() => _RiwayatHasilTesScreenState();
}

class _RiwayatHasilTesScreenState extends State<RiwayatHasilTesScreen> {
  RiwayatViewType _selectedViewType = RiwayatViewType.diagnosa; // Default

  Widget _buildResultCard({
    required BuildContext context,
    required String title, // Judul utama kartu, misal "Hasil Tes Diagnosa"
    required String dateTime, // Misal "27 Mei 2025 - 10:00"
    required String summary, // Misal "Diagnosis: Gangguan Kecemasan Umum" atau "Hasil: Kondisi Membaik"
    required String actionText, // Misal "Klik untuk lihat detail"
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
                    Text( // Menggantikan button internal dengan teks aksi
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
                      Icons.notes_rounded, // Ikon fallback
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
    // DATA DUMMY (GANTI DENGAN DATA ASLI ANDA)
    // Pastikan 'answers' untuk perkembangan berisi data yang valid jika diperlukan oleh HasilPenilaianDiriPage
    final List<Map<String, dynamic>> allDummyResults = [
      {
        'id': 'diag001',
        'viewType': RiwayatViewType.diagnosa,
        'title': 'Tes Diagnosa',
        'dateTime': '28 Mei 2025 - 10:30',
        'summary': 'Hasil: Gangguan Kecemasan Umum',
        'actionText': 'Lihat Detail Hasil',
        'imagePath': 'assets/images/mental_health_illustration.png', // GANTI DENGAN PATH ASLI
        'gradient': LinearGradient(colors: [Colors.blue.shade400, Colors.blue.shade600]),
        'data': {'rawDiagnosisResult': 'GAD'},
      },
      {
        'id': 'perk001',
        'viewType': RiwayatViewType.perkembangan,
        'title': 'Penilaian Diri',
        'dateTime': '28 Mei 2025 - 11:15',
        'summary': 'Hasil: Kondisi Cenderung Membaik',
        'actionText': 'Lihat Detail Hasil',
        'imagePath': 'assets/images/insights_illustration.png', // GANTI DENGAN PATH ASLI
        'gradient': LinearGradient(colors: [Colors.green.shade400, Colors.green.shade600]),
        'data': {'outcomePrediction': 1, 'answers': {'q1': 'value1', 'q2': 2}}, // Contoh answers
      },
      {
        'id': 'diag002',
        'viewType': RiwayatViewType.diagnosa,
        'title': 'Tes Diagnosa',
        'dateTime': '27 Mei 2025 - 15:00',
        'summary': 'Hasil: Gangguan Depresi Mayor',
        'actionText': 'Lihat Detail Hasil',
        'imagePath': 'assets/images/mental_health_illustration.png', // GANTI
        'gradient': LinearGradient(colors: [Colors.red.shade300, Colors.red.shade500]),
        'data': {'rawDiagnosisResult': 'MDD'},
      },
      {
        'id': 'perk002',
        'viewType': RiwayatViewType.perkembangan,
        'title': 'Penilaian Diri',
        'dateTime': '27 Mei 2025 - 09:00',
        'summary': 'Hasil: Kondisi Cukup Stabil',
        'actionText': 'Lihat Detail Hasil',
        'imagePath': 'assets/images/insights_illustration.png', // GANTI
        'gradient': LinearGradient(colors: [Colors.purple.shade300, Colors.purple.shade500]),
        'data': {'outcomePrediction': 2, 'answers': {'q1': 'valueX'}},
      },
    ];

    final List<Map<String, dynamic>> filteredResults = allDummyResults
        .where((result) => result['viewType'] == _selectedViewType)
        .toList();

    return Scaffold(
      appBar: AppBar(
        title: const Text('Riwayat Hasil Tes'),
        // elevation: 0,
        // backgroundColor: Theme.of(context).scaffoldBackgroundColor,
        // foregroundColor: Colors.black87,
      ),
      body: Column(
        children: [
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: SegmentedButton<RiwayatViewType>(
              style: SegmentedButton.styleFrom(
                // backgroundColor: Theme.of(context).colorScheme.surfaceVariant,
                // foregroundColor: Theme.of(context).colorScheme.onSurfaceVariant,
                // selectedForegroundColor: Theme.of(context).colorScheme.onPrimary,
                // selectedBackgroundColor: Theme.of(context).colorScheme.primary,
              ),
              segments: const <ButtonSegment<RiwayatViewType>>[
                ButtonSegment<RiwayatViewType>(
                    value: RiwayatViewType.diagnosa,
                    label: Text('Tes Diagnosa'),
                    icon: Icon(Icons.medical_information_outlined)), // Ikon disesuaikan
                ButtonSegment<RiwayatViewType>(
                    value: RiwayatViewType.perkembangan,
                    label: Text('Penilaian Diri'), // Label disesuaikan
                    icon: Icon(Icons.trending_up_rounded)), // Ikon disesuaikan
              ],
              selected: <RiwayatViewType>{_selectedViewType},
              onSelectionChanged: (Set<RiwayatViewType> newSelection) {
                setState(() {
                  _selectedViewType = newSelection.first;
                });
              },
            ),
          ),
          Expanded(
            child: filteredResults.isEmpty
                ? Center(
                    child: Text(
                      'Belum ada riwayat untuk kategori ini.',
                      style: TextStyle(fontSize: 16, color: Colors.grey.shade600),
                    ),
                  )
                : ListView.builder(
                    padding: const EdgeInsets.symmetric(horizontal: 16.0),
                    itemCount: filteredResults.length,
                    itemBuilder: (context, index) {
                      final result = filteredResults[index];
                      return _buildResultCard(
                        context: context,
                        title: result['title'],
                        dateTime: result['dateTime'],
                        summary: result['summary'],
                        actionText: result['actionText'],
                        imagePath: result['imagePath'],
                        gradient: result['gradient'],
                        onPressed: () {
                          if (result['viewType'] == RiwayatViewType.diagnosa) {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) => DetailHasilDiagnosaPage( // Panggil kelas yang sudah di-rename
                                  rawDiagnosisResult: (result['data'] as Map)['rawDiagnosisResult'] as String,
                                ),
                              ),
                            );
                          } else if (result['viewType'] == RiwayatViewType.perkembangan) {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) => HasilPenilaianDiriPage( // Panggil kelas yang sudah di-rename
                                  outcomePrediction: (result['data'] as Map)['outcomePrediction'] as int,
                                  answers: (result['data'] as Map)['answers'] as Map<String, dynamic>,
                                ),
                              ),
                            );
                          }
                        },
                      );
                    },
                  ),
          ),
        ],
      ),
    );
  }
}