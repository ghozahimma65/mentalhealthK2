// lib/screens/quote_display_screen.dart
import 'package:flutter/material.dart';
import '../services/quote_service.dart';
import '../models/quote_model.dart'; // Model yang hanya content & category

class QuoteDisplayScreen extends StatefulWidget {
  const QuoteDisplayScreen({super.key});
  @override
  State<QuoteDisplayScreen> createState() => _QuoteDisplayScreenState();
}

class _QuoteDisplayScreenState extends State<QuoteDisplayScreen> {
  final QuoteService _quoteService = QuoteService();
  Future<List<Quote>>? _quotesListFuture;
  int _currentPage = 1;
  // Map<String, bool> _favoriteStatus = {}; // Dihapus karena fitur favorit dihilangkan
  // String? _currentCategoryFilter; // Dihilangkan jika tidak ada UI untuk filter kategori

  @override
  void initState() {
    super.initState();
    _fetchQuotesList();
  }

  void _fetchQuotesList() {
    setState(() {
      _quotesListFuture = _quoteService.getQuotesList(
        page: _currentPage,
        // category: _currentCategoryFilter, // Dihilangkan jika tidak ada filter
      );
    });
  }

  // Fungsi _toggleFavorite dihapus karena fitur favorit dihilangkan
  // Fungsi _setCategoryFilter dihapus jika tidak ada UI untuk filter kategori lagi

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Kutipan & Afirmasi'),
        backgroundColor: Colors.white,
        foregroundColor: Colors.black87,
        elevation: 1.0,
      ),
      backgroundColor: const Color(0xFFF8F9FA),
      body: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 8.0),
        child: FutureBuilder<List<Quote>>(
          future: _quotesListFuture,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const Center(child: CircularProgressIndicator());
            } else if (snapshot.hasError) {
              return Center( /* ... (Error message) ... */ );
            } else if (snapshot.hasData) {
              final List<Quote> quotes = snapshot.data!;
              if (quotes.isEmpty) {
                return const Center( /* ... (Pesan kosong) ... */ );
              }

              return ListView.builder(
                itemCount: quotes.length,
                padding: const EdgeInsets.only(top: 12.0, bottom: 80.0, left: 4.0, right: 4.0),
                itemBuilder: (context, index) {
                  final quote = quotes[index];

                  return Card(
                    elevation: 2.0,
                    margin: const EdgeInsets.symmetric(vertical: 8.0),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(12.0),
                    ),
                    color: Colors.white,
                    child: Padding(
                      padding: const EdgeInsets.all(16.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            '“', 
                            style: TextStyle(
                              fontSize: 48,
                              color: Theme.of(context).primaryColor.withOpacity(0.6),
                              height: 0.5,
                            ),
                          ),
                          const SizedBox(height: 8),
                          Text(
                            quote.content,
                            style: const TextStyle(
                              fontSize: 17.0,
                              height: 1.5,
                              color: Colors.black87,
                            ),
                            textAlign: TextAlign.start,
                          ),
                          const SizedBox(height: 16),
                          // Bagian untuk menampilkan kategori (tanpa ikon favorit)
                          if (quote.category != null && quote.category!.isNotEmpty)
                            Align( // Gunakan Align untuk meletakkan kategori di kanan jika itu satu-satunya item
                              alignment: Alignment.centerRight,
                              child: Text(
                                '- ${quote.category}',
                                style: TextStyle(
                                  fontSize: 13.0,
                                  color: Colors.grey[700],
                                  fontStyle: FontStyle.italic,
                                ),
                              ),
                            ),
                        ],
                      ),
                    ),
                  );
                },
              );
            }
            return const Center( /* ... (Pesan tidak ada data) ... */ );
          },
        ),
      ),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: () {
          _currentPage = 1;
          _fetchQuotesList();
        },
        tooltip: 'Muat Ulang',
        icon: const Icon(Icons.refresh),
        label: const Text("Muat Ulang"),
      ),
      floatingActionButtonLocation: FloatingActionButtonLocation.centerFloat,
    );
  }
}