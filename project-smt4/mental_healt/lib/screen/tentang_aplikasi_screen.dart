// Nama file: lib/screen/tentang_aplikasi_screen.dart
import 'package:flutter/material.dart';
// Jika Anda ingin menampilkan versi aplikasi, Anda mungkin perlu package `package_info_plus`
// import 'package:package_info_plus/package_info_plus.dart';

class TentangAplikasiScreen extends StatefulWidget { // Diubah ke StatefulWidget untuk ambil versi
  const TentangAplikasiScreen({super.key});

  @override
  State<TentangAplikasiScreen> createState() => _TentangAplikasiScreenState();
}

class _TentangAplikasiScreenState extends State<TentangAplikasiScreen> {
  String _appVersion = "Memuat...";

  @override
  void initState() {
    super.initState();
    // _loadAppVersion(); // Uncomment jika menggunakan package_info_plus
    _appVersion = "1.0.0 (Contoh)"; // Versi contoh
  }

  // Future<void> _loadAppVersion() async {
  //   try {
  //     PackageInfo packageInfo = await PackageInfo.fromPlatform();
  //     setState(() {
  //       _appVersion = packageInfo.version;
  //     });
  //   } catch (e) {
  //     print("Gagal memuat versi aplikasi: $e");
  //     setState(() {
  //       _appVersion = "Tidak diketahui";
  //     });
  //   }
  // }


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Tentang Aplikasi'),
      ),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(20.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              // Ganti dengan logo aplikasi Anda
              Image.asset('assets/images/logo_aplikasi.png', height: 80, errorBuilder: (c,e,s) => Icon(Icons.healing, size: 80, color: Theme.of(context).primaryColor)),
              const SizedBox(height: 20),
              Text(
                'Mental Health App', // Ganti dengan nama aplikasi Anda
                style: Theme.of(context).textTheme.headlineSmall?.copyWith(fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 8),
              Text(
                'Versi $_appVersion',
                style: TextStyle(fontSize: 14, color: Colors.grey.shade600),
              ),
              const SizedBox(height: 24),
              const Text(
                'Aplikasi ini bertujuan untuk membantu Anda memantau dan meningkatkan kesehatan mental Anda melalui berbagai fitur tes, meditasi, dan rencana perawatan diri.',
                textAlign: TextAlign.center,
                style: TextStyle(fontSize: 15, height: 1.4),
              ),
              const SizedBox(height: 24),
              Text(
                '© ${DateTime.now().year} Nama Perusahaan/Developer Anda', // Ganti
                style: TextStyle(fontSize: 12, color: Colors.grey.shade500),
              ),
            ],
          ),
        ),
      ),
    );
  }
}