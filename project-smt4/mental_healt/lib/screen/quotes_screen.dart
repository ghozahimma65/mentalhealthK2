// Nama file: lib/screen/quotes_screen.dart
import 'package:flutter/material.dart';
import 'dart:math'; // Untuk mengambil kutipan acak (opsional)

// Model sederhana untuk data kutipan
class Quote {
  final String text;
  final String author; // Opsional
  bool isFavorite; // Untuk fitur 'Suka'

  Quote({required this.text, this.author = "Pengingat Diri", this.isFavorite = false});
}

class QuotesScreen extends StatefulWidget {
  const QuotesScreen({super.key});

  @override
  State<QuotesScreen> createState() => _QuotesScreenState();
}

class _QuotesScreenState extends State<QuotesScreen> {
  // --- DATA KUTIPAN PENYEMANGAT KESEHATAN MENTAL ---
  final List<Quote> _quotes = [
    Quote(text: "Kamu tidak sendirian. Banyak yang peduli padamu.", author: "Dukungan"),
    Quote(text: "Setiap hari adalah awal yang baru. Lepaskan kemarin, sambut hari ini.", author: "Harapan"),
    Quote(text: "Tidak apa-apa untuk merasa tidak baik-baik saja. Itu manusiawi.", author: "Validasi Emosi"),
    Quote(text: "Kekuatan sejati adalah berani meminta bantuan saat kamu membutuhkannya.", author: "Keberanian"),
    Quote(text: "Kamu lebih kuat dari yang kamu pikirkan, dan kamu sudah melewati banyak hal.", author: "Kekuatan Batin"),
    Quote(text: "Merawat diri adalah produktivitas, bukan kemalasan.", author: "Self-Care"),
    Quote(text: "Setiap napas adalah kesempatan baru untuk memulai lagi.", author: "Kesadaran"),
    Quote(text: "Jangan bandingkan perjalananmu dengan orang lain. Setiap bunga mekar pada waktunya sendiri."),
    Quote(text: "Kamu berharga, apa pun yang pikiranmu katakan saat ini."),
    Quote(text: "Fokus pada satu langkah kecil ke depan, bukan seluruh tangga."),
    Quote(text: "Istirahat bukanlah menyerah, itu adalah bagian dari proses penyembuhan."),
    Quote(text: "Bicaralah pada dirimu dengan kelembutan yang sama seperti kamu berbicara pada sahabatmu."),
    Quote(text: "Pikiran negatif hanyalah awan, biarkan ia berlalu. Matahari masih ada di baliknya."),
    Quote(text: "Kamu sedang bertumbuh, bahkan di saat-saat tersulit sekalipun."),
    Quote(text: "Tidak ada yang salah denganmu karena merasa apa yang kamu rasakan."),
    Quote(text: "Memaafkan diri sendiri adalah langkah penting menuju kedamaian."),
    Quote(text: "Kamu diizinkan untuk menetapkan batasan demi kesehatan mentalmu."),
    Quote(text: "Kebaikan kecil yang kamu lakukan hari ini bisa mengubah duniamu dan dunia orang lain."),
    Quote(text: "Fokus pada apa yang bisa kamu kontrol, lepaskan sisanya."),
    Quote(text: "Menangis itu sehat. Itu adalah cara tubuhmu melepaskan beban."),
    Quote(text: "Tidak semua hari akan baik, tapi ada sesuatu yang baik di setiap hari."),
    Quote(text: "Kamu adalah karya seni yang sedang dalam proses. Nikmati perjalanannya."),
    Quote(text: "Jangan ragu untuk berkata 'tidak' demi menjaga energimu."),
    Quote(text: "Penyembuhan bukanlah garis lurus. Ada naik turun, dan itu normal."),
    Quote(text: "Cintai dirimu bahkan di hari-hari ketika kamu merasa sulit untuk melakukannya."),
    Quote(text: "Satu langkah kecil setiap hari bisa membawamu ke tempat yang luar biasa."),
    Quote(text: "Perasaanmu penting. Jangan pernah meremehkannya."),
    Quote(text: "Kamu memiliki ketahanan yang luar biasa. Kamu sudah membuktikannya berkali-kali."),
    Quote(text: "Berikan dirimu jeda. Kamu tidak harus selalu produktif."),
    Quote(text: "Cahaya selalu menemukan jalannya, bahkan di tempat tergelap sekalipun."),
    Quote(text: "Kamu berhak mendapatkan cinta dan kebahagiaan, sama seperti orang lain."),
    Quote(text: "Waktu akan menyembuhkan, tapi kamu juga perlu berusaha untuk sembuh."),
    Quote(text: "Setiap napas adalah pengingat bahwa kamu masih hidup dan punya kesempatan."),
    Quote(text: "Fokus pada hal-hal kecil yang membuatmu tersenyum hari ini."),
    Quote(text: "Jangan biarkan masa lalu mendikte masa depanmu. Kamu punya kendali."),
    Quote(text: "Kamu adalah arsitek dari kehidupanmu sendiri. Bangunlah sesuatu yang indah."),
    Quote(text: "Meminta bantuan adalah tanda kekuatan, bukan kelemahan."),
    Quote(text: "Progresmu mungkin lambat, tapi itu tetap progres. Hargai itu."),
    Quote(text: "Kamu tidak harus sempurna untuk menjadi luar biasa."),
    Quote(text: "Kegagalan adalah bagian dari pembelajaran menuju kesuksesan."),
    Quote(text: "Cintai dirimu apa adanya, dengan segala kelebihan dan kekuranganmu."),
    Quote(text: "Kamu adalah prioritas. Jaga dirimu baik-baik."),
    Quote(text: "Setiap tantangan adalah kesempatan untuk tumbuh lebih kuat."),
    Quote(text: "Jangan biarkan suara negatif orang lain meredupkan cahayamu."),
    Quote(text: "Hari ini mungkin sulit, tapi kamu lebih tangguh dari kesulitan itu."),
    Quote(text: "Kamu punya tujuan dan potensi yang unik di dunia ini."),
    Quote(text: "Tidak apa-apa untuk memulai dari awal, sebanyak apapun yang kamu butuhkan."),
    Quote(text: "Kelilingi dirimu dengan orang-orang yang mendukung dan mengangkatmu."),
    Quote(text: "Pikiranmu adalah taman, tanamlah bunga, bukan rumput liar."),
    Quote(text: "Kamu tidak harus selalu kuat. Kadang, mengakui kerapuhan adalah kekuatan."),
    Quote(text: "Setiap matahari terbit adalah janji hari baru yang penuh kemungkinan."),
    Quote(text: "Kamu adalah keajaiban. Jangan pernah lupakan itu."),
    Quote(text: "Teruslah berjalan, bahkan jika langkahmu terasa berat. Kamu akan sampai."),
    Quote(text: "Kesehatan mentalmu sama pentingnya dengan kesehatan fisikmu. Rawat keduanya."),
    Quote(text: "Kamu dicintai, bahkan ketika kamu merasa tidak demikian."),
  ];
  // -------------------------------------------------------------

  // Untuk menampilkan satu kutipan acak di bagian atas (opsional, bisa dihapus jika tidak mau)
  Quote? _featuredQuote;

  @override
  void initState() {
    super.initState();
    // Ambil satu kutipan acak saat halaman dibuka jika list tidak kosong
    if (_quotes.isNotEmpty) {
      _featuredQuote = _quotes[Random().nextInt(_quotes.length)];
    }
  }

  // Helper untuk membangun satu kartu kutipan
  Widget _buildQuoteCard(BuildContext context, Quote quote, int index) {
    return Card(
      elevation: 2.5, // Sedikit shadow
      margin: const EdgeInsets.symmetric(vertical: 8.0, horizontal: 0),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12.0)),
      color: Colors.white, // Latar kartu
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Icon(Icons.format_quote_rounded, size: 30, color: Theme.of(context).primaryColor.withOpacity(0.8)),
            const SizedBox(height: 10),
            Text(
              quote.text,
              style: Theme.of(context).textTheme.titleMedium?.copyWith(
                    fontStyle: FontStyle.italic,
                    height: 1.45, // Jarak antar baris
                    color: Colors.black.withOpacity(0.75), // Warna teks kutipan
                  ),
            ),
            if (quote.author.isNotEmpty && quote.author != "Anonim") ...[ // Tampilkan author jika ada dan bukan "Anonim"
              const SizedBox(height: 12),
              Align(
                alignment: Alignment.centerRight,
                child: Text(
                  "- ${quote.author}",
                  style: Theme.of(context).textTheme.bodySmall?.copyWith(
                        fontWeight: FontWeight.w500,
                        color: Theme.of(context).primaryColor.withOpacity(0.9),
                      ),
                ),
              ),
            ],
            const SizedBox(height: 10),
            // Hanya tombol favorit
            Align(
              alignment: Alignment.centerRight,
              child: IconButton(
                icon: Icon(
                  quote.isFavorite ? Icons.favorite_rounded : Icons.favorite_border_rounded,
                  color: quote.isFavorite ? Colors.redAccent.shade200 : Colors.grey.shade400,
                  size: 26,
                ),
                tooltip: quote.isFavorite ? 'Hapus dari favorit' : 'Tambah ke favorit',
                onPressed: () {
                  setState(() {
                    _quotes[index].isFavorite = !_quotes[index].isFavorite;
                    // TODO: Simpan status favorit ini ke database/shared_preferences
                  });
                  ScaffoldMessenger.of(context).showSnackBar(
                    SnackBar(
                      content: Text(quote.isFavorite ? 'Ditambahkan ke favorit!' : 'Dihapus dari favorit.'),
                      duration: const Duration(seconds: 1),
                      behavior: SnackBarBehavior.floating, // Agar lebih modern
                    ),
                  );
                },
              ),
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
        title: const Text('Kutipan & Afirmasi'),
        // backgroundColor: Theme.of(context).primaryColor, // Contoh warna AppBar
        // foregroundColor: Colors.white,
      ),
      body: _quotes.isEmpty
          ? const Center(child: Text("Belum ada kutipan tersedia."))
          : ListView.builder(
              padding: const EdgeInsets.all(16.0),
              itemCount: _quotes.length,
              itemBuilder: (context, index) {
                // Logika untuk featured quote bisa dihilangkan jika hanya ingin list biasa
                // if (index == 0 && _featuredQuote != null && _quotes.length > 1) {
                //   return Column(
                //     children: [
                //       _buildQuoteCard(context, _featuredQuote!, -1), // -1 untuk index featured
                //       _buildQuoteCard(context, _quotes[index], index),
                //     ],
                //   );
                // }
                return _buildQuoteCard(context, _quotes[index], index);
              },
            ),
      // FloatingActionButton untuk refresh (opsional)
      // floatingActionButton: FloatingActionButton(
      //   onPressed: () {
      //     setState(() {
      //        if (_quotes.isNotEmpty) {
      //          _featuredQuote = _quotes[Random().nextInt(_quotes.length)];
      //          // Jika Anda ingin listnya juga diacak:
      //          // _quotes.shuffle();
      //        }
      //     });
      //      ScaffoldMessenger.of(context).showSnackBar(
      //       const SnackBar(content: Text('Kutipan disegarkan!'), duration: Duration(seconds: 1)),
      //     );
      //   },
      //   tooltip: 'Segarkan Kutipan',
      //   child: const Icon(Icons.refresh_rounded),
      // ),
    );
  }
}