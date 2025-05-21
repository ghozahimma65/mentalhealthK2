import 'package:flutter/material.dart';
import 'package:pie_chart/pie_chart.dart';

// Ganti ini dengan import halaman home kamu
import 'home_page.dart'; // Pastikan HomePage() tersedia

class HasilTesPage extends StatelessWidget {
  const HasilTesPage({super.key}); 

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        width: double.infinity,
        height: MediaQuery.of(context).size.height, // full screen
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            colors: [Color(0xFF8E2DE2), Color(0xFFFF416C)],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
        ),
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(vertical: 40),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              const Text(
                "Hasil Tes Depresi Kamu",
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 22,
                  fontWeight: FontWeight.bold,
                ),
              ),

              const SizedBox(height: 30),

              // CONTOH PIE CHART (ganti dengan pie chart kamu sendiri)
              // PIE CHART DALAM CONTAINER
              Container(
              height: 250,
              width: 250,
              decoration: const BoxDecoration(
              shape: BoxShape.circle,
              color: Colors.white24,
              ),
              child: Padding(
                padding: const EdgeInsets.all(10.0),
                child: PieChart(
                  dataMap: {
                    "Depresi Sedang": 40,
                    "Depresi Ringan": 30,
                    "Depresi Berat": 30,
                    },
                    animationDuration: const Duration(milliseconds: 800),
                    chartType: ChartType.disc,
                    baseChartColor: Colors.transparent,
                    colorList: const [Colors.red, Colors.green, Colors.blue],
                    chartValuesOptions: const ChartValuesOptions(
                      showChartValuesInPercentage: true,
                      showChartValueBackground: false,
                      showChartValues: true,
                      decimalPlaces: 0,
                      ),
                      legendOptions: const LegendOptions(
                        showLegends: false, // legenda kita pindah ke luar container
                        ),
                        ),
                        ),
                        ),
            
              const SizedBox(height: 30),

              // LEGEND DI LUAR CONTAINER
              Wrap(
              spacing: 18,
              alignment: WrapAlignment.center,
              children: const [
                LegendItem(color: Colors.red, text: 'Bipolar Disorder'),
                LegendItem(color: Colors.blue, text: 'Major Depressive Disorder'),
                LegendItem(color: Colors.green, text: 'Generalized Anxiety Disorder'),
                LegendItem(color: Colors.yellow, text: 'Panic Disorder'),
                ],
                ),

                const SizedBox(height: 35),

              // CARD HASIL DIAGNOSA
              Card(
                margin: const EdgeInsets.symmetric(horizontal: 24),
                elevation: 8,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(16),
                ),
                child: Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    children: const [
                      Text(
                        'Kecenderungan kamu saat ini :',
                        style: TextStyle(
                          fontWeight: FontWeight.bold,
                          fontSize: 16,
                        ),
                      ),
                      SizedBox(height: 8),
                      Text(
                        'Depresi sedang',
                        style: TextStyle(
                          color: Colors.deepPurple,
                          fontWeight: FontWeight.w600,
                          fontSize: 18,
                          fontFamily: "Bahnschrift SemiBold",
                          letterSpacing: 2,
                        ),
                      ),
                      SizedBox(height: 4),
                      Text(
                        'Konsultasikan ke profesional bila perlu.',
                        textAlign: TextAlign.center,
                        style: TextStyle(
                          fontSize: 16,
                          color: Colors.black54,
                          fontFamily: 'Cascadia Code',
                        ),
                      ),
                    ],
                  ),
                ),
              ),

              const SizedBox(height: 30),

              // TOMBOL SIMPAN
              ElevatedButton.icon(
                onPressed: () {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (context) => HomePage()),
                  );
                },
                icon: const Icon(Icons.save),
                label: const Text('Simpan Hasil'),
                style: ElevatedButton.styleFrom(
                  padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                  backgroundColor: Colors.white,
                  foregroundColor: Colors.deepPurple,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(30),
                  ),
                  elevation: 4,
                ),
              ),

              const SizedBox(height: 40),
            ],
          ),
        ),
      ),
    );
  }
}

class LegendItem extends StatelessWidget {
  final Color color;
  final String text;

  const LegendItem({super.key, required this.color, required this.text});

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisSize: MainAxisSize.min,
      children: [
        Container(
          width: 12,
          height: 12,
          decoration: BoxDecoration(
            color: color,
            shape: BoxShape.circle,
          ),
        ),
        const SizedBox(width: 6),
        Text(
          text,
          style: const TextStyle(color: Colors.white),
        ),
      ],
    );
  }
}