// lib/models/quote_model.dart

class Quote {
  final String id; // _id dari MongoDB, diserialisasikan sebagai 'id'
  final String content; // Isi dari quote atau inspirasi
  final String? category; // Kategori, bisa juga null jika tidak selalu ada
  final DateTime createdAt;
  final DateTime updatedAt;

  Quote({
    required this.id,
    required this.content,
    this.category,
    required this.createdAt,
    required this.updatedAt,
  });

  factory Quote.fromJson(Map<String, dynamic> json) {
    return Quote(
      id: json['id'] as String? ?? json['_id'] as String? ?? 'N/A_ID',
      content: json['content'] as String,
      category: json['category'] as String?, // Tetap nullable untuk fleksibilitas
      createdAt: DateTime.parse(json['created_at'] as String),
      updatedAt: DateTime.parse(json['updated_at'] as String),
    );
  }
}