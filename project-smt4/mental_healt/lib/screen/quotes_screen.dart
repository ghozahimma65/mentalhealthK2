// Nama file: quotes_screen.dart
import 'package:flutter/material.dart';
import 'dart:math'; // Untuk mengambil kutipan acak (contoh)

// Model sederhana untuk data kutipan
class Quote {
  final String text;
  final String author; // Opsional
  bool isFavorite; // Untuk fitur 'Suka'

  Quote({required this.text, this.author = "Anonim", this.isFavorite = false});
}

class QuotesScreen extends StatefulWidget {
  const QuotesScreen({super.key});

  @override
  State<QuotesScreen> createState() => _QuotesScreenState();
}

class _QuotesScreenState extends State<QuotesScreen> {
  // --- CONTOH DATA KUTIPAN (Ganti dengan sumber data Anda) ---
  final List<Quote> _quotes = [
  Quote(text: "Kamu tidak sendirian dalam perjuangan ini. Ada harapan dan bantuan tersedia.", author: "Pengingat"),
  Quote(text: "Setiap hari adalah kesempatan baru untuk merawat dirimu. Kamu berharga.", author: "Afirmasi Diri"),
  Quote(text: "Tidak apa-apa untuk tidak baik-baik saja. Izinkan dirimu merasakan, lalu bangkit perlahan.", author: "Kekuatan Batin"),
  Quote(text: "Kekuatan terbesarmu bukan pada tidak pernah jatuh, tapi pada kemampuan untuk bangkit setiap kali jatuh.", author: "Anonim"),
  Quote(text: "Kamu lebih kuat dari yang kamu bayangkan. Badai ini akan berlalu.", author: "Harapan"),
  Quote(text: "Merawat diri bukanlah tindakan egois, itu adalah kebutuhan esensial.", author: "Self-Care"),
  Quote(text: "Luka batinmu tidak mendefinisikan siapa dirimu. Kamu adalah pejuang.", author: "Semangat"),
  Quote(text: "Setiap langkah kecil menuju pemulihan adalah kemenangan besar.", author: "Proses Pemulihan"),
  Quote(text: "Bicaralah pada dirimu dengan kebaikan, seperti kamu berbicara pada sahabatmu.", author: "Kasih Sayang Diri"),
  Quote(text: "Kamu layak mendapatkan kedamaian dan kebahagiaan. Teruslah berjuang.", author: "Dukungan"),
  Quote(text: "Tidak ada kata terlambat untuk mencari bantuan dan memulai lembaran baru.", author: "Kesempatan Baru"),
  Quote(text: "Meski hari ini berat, ingatlah bahwa ada kekuatan dalam dirimu untuk melewatinya."),
  Quote(text: "Menerima diri sendiri adalah langkah awal menuju penyembuhan."),
  Quote(text: "Kamu sedang dalam proses. Bersabarlah dengan dirimu sendiri."),
  Quote(text: "Setiap emosi yang kamu rasakan valid. Jangan menyangkalnya, tapi kelola dengan baik."),
  ];
  // -------------------------------------------------------------

  // Untuk menampilkan satu kutipan acak di bagian atas (opsional)
  Quote? _featuredQuote;

  @override
  void initState() {
    super.initState();
    // Ambil satu kutipan acak saat halaman dibuka
    if (_quotes.isNotEmpty) {
      _featuredQuote = _quotes[Random().nextInt(_quotes.length)];
    }
  }

  // Helper untuk membangun satu kartu kutipan
  Widget _buildQuoteCard(BuildContext context, Quote quote, int index) {
    return Card(
      elevation: 3.0,
      margin: const EdgeInsets.symmetric(vertical: 8.0, horizontal: 0),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12.0)),
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Icon(Icons.format_quote_rounded, size: 30, color: Theme.of(context).primaryColor.withOpacity(0.7)),
            const SizedBox(height: 10),
            Text(
              quote.text,
              style: Theme.of(context).textTheme.titleMedium?.copyWith(
                    fontStyle: FontStyle.italic,
                    height: 1.4, // Jarak antar baris
                  ),
            ),
            if (quote.author != "Anonim") ...[
              const SizedBox(height: 10),
              Align(
                alignment: Alignment.centerRight,
                child: Text(
                  "- ${quote.author}",
                  style: Theme.of(context).textTheme.bodySmall?.copyWith(fontWeight: FontWeight.w500),
                ),
              ),
            ],
            const SizedBox(height: 10),
            Row( // Tombol aksi
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                IconButton(
                  icon: Icon(
                    quote.isFavorite ? Icons.favorite_rounded : Icons.favorite_border_rounded,
                    color: quote.isFavorite ? Colors.redAccent : Colors.grey,
                  ),
                  onPressed: () {
                    setState(() {
                      // Toggle status favorit
                      _quotes[index].isFavorite = !_quotes[index].isFavorite;
                      // TODO: Simpan status favorit ini ke database/shared_preferences
                    });
                    ScaffoldMessenger.of(context).showSnackBar(
                      SnackBar(content: Text(quote.isFavorite ? 'Ditambahkan ke favorit!' : 'Dihapus dari favorit.'), duration: Duration(seconds: 1)),
                    );
                  },
                ),
                IconButton(
                  icon: const Icon(Icons.share_rounded, color: Colors.grey),
                  onPressed: () {
                    // TODO: Implementasi fitur bagikan
                    print("Bagikan: ${quote.text}");
                     ScaffoldMessenger.of(context).showSnackBar(
                      const SnackBar(content: Text('Fitur bagikan belum diimplementasikan.'), duration: Duration(seconds: 1)),
                    );
                  },
                ),
              ],
            )
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Quotes & Affirmation'),
        // backgroundColor: Colors.teal, // Contoh warna
        // foregroundColor: Colors.white,
      ),
      body: ListView.builder(
        padding: const EdgeInsets.all(16.0),
        itemCount: _quotes.length, // Jumlah kutipan
        itemBuilder: (context, index) {
          // Jika ini item pertama dan ada featuredQuote, tampilkan dulu (opsional)
          if (index == 0 && _featuredQuote != null && _quotes.length > 1) { // Hanya jika ada >1 quote
            return Column(
              children: [
                // Bagian Featured Quote (Contoh)
                // Card(
                //   color: Theme.of(context).primaryColor.withOpacity(0.1),
                //   elevation: 0,
                //   margin: const EdgeInsets.only(bottom: 20),
                //   child: Padding(
                //     padding: const EdgeInsets.all(20.0),
                //     child: Column(
                //       children: [
                //         Text("Kutipan Hari Ini:", style: Theme.of(context).textTheme.titleSmall?.copyWith(color: Theme.of(context).primaryColor)),
                //         SizedBox(height: 8),
                //         Text(_featuredQuote!.text, style: Theme.of(context).textTheme.titleMedium?.copyWith(fontStyle: FontStyle.italic), textAlign: TextAlign.center),
                //         if(_featuredQuote!.author != "Anonim") SizedBox(height: 8),
                //         if(_featuredQuote!.author != "Anonim") Text("- ${_featuredQuote!.author}", style: Theme.of(context).textTheme.bodySmall, textAlign: TextAlign.center),
                //       ],
                //     ),
                //   ),
                // ),
                _buildQuoteCard(context, _quotes[index], index), // Tampilkan kartu pertama dari list
              ],
            );
          }
          return _buildQuoteCard(context, _quotes[index], index); // Tampilkan sisa kartu
        },
      ),
      // Opsional: Tombol untuk menambah kutipan baru atau refresh
      // floatingActionButton: FloatingActionButton(
      //   onPressed: () {
      //     // TODO: Aksi refresh kutipan atau tambah baru
      //     setState(() {
      //        if (_quotes.isNotEmpty) {
      //          _featuredQuote = _quotes[Random().nextInt(_quotes.length)];
      //        }
      //     });
      //   },
      //   child: const Icon(Icons.refresh),
      // ),
    );
  }
}