import 'package:flutter/material.dart';
import 'package:fl_chart/fl_chart.dart';

class HasilTesScreen extends StatelessWidget {
  final Map<String, double> data; // e.g. {'Depresi Ringan': 30, 'Depresi Sedang': 40, 'Depresi Berat': 30}
  final String message; // e.g. "Kecenderungan depresi sedang..."
  
  const HasilTesScreen({
    super.key,
    required this.data,
    required this.message,
  });

  @override
  Widget build(BuildContext context) {
    final List<Color> sectionColors = [
      Colors.lightBlueAccent,
      Colors.orangeAccent,
      Colors.redAccent,
    ];

    return Scaffold(
      appBar: AppBar(
        title: const Text('Hasil Tes Depresi'),
        backgroundColor: Colors.transparent,
        elevation: 0,
      ),
      extendBodyBehindAppBar: true,
      body: Container(
        width: double.infinity,
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [Colors.purple.shade50, Colors.purple.shade200],
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
          ),
        ),
        child: SafeArea(
          child: Column(
            children: [
              const SizedBox(height: 20),

              // Kartu Chart
              Card(
                margin: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
                elevation: 6,
                child: Padding(
                  padding: const EdgeInsets.all(16),
                  child: Column(
                    children: [
                      const Text(
                        'Distribusi Skor',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      const SizedBox(height: 16),
                      SizedBox(
                        height: 200,
                        child: PieChart(
                          PieChartData(
                            sectionsSpace: 4,
                            centerSpaceRadius: 40,
                            startDegreeOffset: -90,
                            sections: List.generate(data.length, (i) {
                              final entry = data.entries.elementAt(i);
                              return PieChartSectionData(
                                value: entry.value,
                                title: '${entry.value.toStringAsFixed(1)}%',
                                color: sectionColors[i % sectionColors.length],
                                radius: 80,
                                titleStyle: const TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white,
                                ),
                              );
                            }),
                          ),
                          swapAnimationDuration: const Duration(milliseconds: 800),
                          swapAnimationCurve: Curves.easeInOut,
                        ),
                      ),
                      const SizedBox(height: 16),
                      // Legend
                      Wrap(
                        spacing: 12,
                        runSpacing: 8,
                        alignment: WrapAlignment.center,
                        children: List.generate(data.length, (i) {
                          final entry = data.entries.elementAt(i);
                          return _LegendItem(
                            color: sectionColors[i % sectionColors.length],
                            text: entry.key,
                          );
                        }),
                      ),
                    ],
                  ),
                ),
              ),

              const SizedBox(height: 20),

              // Kartu Pesan
              Card(
                margin: const EdgeInsets.symmetric(horizontal: 20),
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
                color: Colors.white,
                elevation: 4,
                child: Padding(
                  padding: const EdgeInsets.all(16),
                  child: Text(
                    message,
                    style: const TextStyle(fontSize: 16),
                    textAlign: TextAlign.center,
                  ),
                ),
              ),

              const Spacer(),

              // Tombol Selesai
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 40, vertical: 20),
                child: SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                    onPressed: () => Navigator.pop(context),
                    style: ElevatedButton.styleFrom(
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(30)),
                    ),
                    child: const Text(
                      'Selesai',
                      style: TextStyle(fontSize: 16),
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class _LegendItem extends StatelessWidget {
  final Color color;
  final String text;
  const _LegendItem({required this.color, required this.text});

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisSize: MainAxisSize.min,
      children: [
        Container(width: 16, height: 16, decoration: BoxDecoration(color: color, shape: BoxShape.circle)),
        const SizedBox(width: 6),
        Text(text),
      ],
    );
  }
}