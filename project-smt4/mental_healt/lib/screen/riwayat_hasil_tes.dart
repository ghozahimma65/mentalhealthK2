import 'package:flutter/material.dart';

class RiwayatHasilTesScreen extends StatelessWidget {
  const RiwayatHasilTesScreen({super.key});

  Widget _buildResultCard({
    required BuildContext context,
    required String title,
    required String description,
    required String buttonText,
    required Color cardColor,
    required Color buttonBgColor,
    required Color buttonTextColor,
    required String imagePath,
    required VoidCallback onPressed,
    Gradient? gradient,
  }) {
    // Pisahkan deskripsi berdasarkan baris
    final lines = description.split('\n');

    return Card(
      elevation: 4,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
      margin: const EdgeInsets.symmetric(vertical: 10),
      child: InkWell(
        onTap: onPressed,
        borderRadius: BorderRadius.circular(15),
        child: Container(
          decoration: BoxDecoration(
            gradient: gradient,
            borderRadius: BorderRadius.circular(15),
          ),
          padding: const EdgeInsets.all(20),
          child: Row(
            children: [
              // Text Section
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: const TextStyle(
                        fontSize: 18,
                        fontWeight: FontWeight.bold,
                        color: Colors.white,
                      ),
                    ),
                    const SizedBox(height: 6),

                    // Deskripsi yang sudah dipecah dan diatur stylenya
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          lines[0],
                          style: TextStyle(
                            fontSize: 14,
                            color: Colors.white.withOpacity(0.9),
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          lines[1],
                          style: TextStyle(
                            fontSize: 14,
                            color: Colors.white.withOpacity(0.9),
                          ),
                        ),
                        const SizedBox(height: 10), // Jarak bawah lebih besar
                        Text(
                          lines[2],
                          style: const TextStyle(
                            fontSize: 14,
                            fontWeight: FontWeight.bold,
                            color: Colors.white,
                          ),
                        ),
                      ],
                    ),

                    const SizedBox(height: 12),
                    ElevatedButton(
                      onPressed: onPressed,
                      style: ElevatedButton.styleFrom(
                        backgroundColor: buttonBgColor,
                        foregroundColor: buttonTextColor,
                        padding: const EdgeInsets.symmetric(
                            horizontal: 16, vertical: 8),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(20),
                        ),
                      ),
                      child: Text(
                        buttonText,
                        style: const TextStyle(fontWeight: FontWeight.bold),
                      ),
                    ),
                  ],
                ),
              ),

              const SizedBox(width: 12),

              // Image Section
              ClipRRect(
                borderRadius: BorderRadius.circular(10),
                child: Container(
                  width: 70,
                  height: 70,
                  color: Colors.white.withOpacity(0.2),
                  child: Image.asset(
                    imagePath,
                    fit: BoxFit.contain,
                    errorBuilder: (context, error, stackTrace) => Icon(
                      Icons.health_and_safety,
                      size: 40,
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
    final List<Map<String, dynamic>> dummyResults = [
      {
        'title': 'Pelaksanaan Tes',
        'description': 'Tanggal Tes : 20 Mei 2025\nJam : 03.00 pm\nCek Riwayat Tes Kamu Sekarang',
        'buttonText': 'Cek Hasil',
        'cardColor': Colors.blue,
        'buttonBgColor': Colors.white,
        'buttonTextColor': Colors.blue,
        'imagePath': 'assets/images/test_depression.png',
        'gradient': LinearGradient(
          colors: [Colors.blue.shade400, Colors.blue.shade700],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        'resultId': 'depression_001'
      },
    ];

    return Scaffold(
      appBar: AppBar(
        title: const Text(
          'Riwayat Hasil Tes',
          style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
        ),
        elevation: 0,
        backgroundColor: Theme.of(context).scaffoldBackgroundColor,
        foregroundColor: Colors.black87,
      ),
      body: LayoutBuilder(
        builder: (context, constraints) {
          return Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 12),
            child: dummyResults.isEmpty
                ? const Center(
                    child: Text(
                      'Belum ada riwayat hasil tes.',
                      style: TextStyle(fontSize: 16, color: Colors.grey),
                    ),
                  )
                : ListView.builder(
                    itemCount: dummyResults.length,
                    itemBuilder: (context, index) {
                      final result = dummyResults[index];
                      return _buildResultCard(
                        context: context,
                        title: result['title'],
                        description: result['description'],
                        buttonText: result['buttonText'],
                        cardColor: result['cardColor'],
                        buttonBgColor: result['buttonBgColor'],
                        buttonTextColor: result['buttonTextColor'],
                        imagePath: result['imagePath'],
                        gradient: result['gradient'],
                        onPressed: () {
                          Navigator.pushNamed(
                            context,
                            '/detailhasil',
                            arguments: {
                              'testType': result['title'],
                              'resultId': result['resultId'],
                            },
                          );
                        },
                      );
                    },
                  ),
          );
        },
      ),
    );
  }
}