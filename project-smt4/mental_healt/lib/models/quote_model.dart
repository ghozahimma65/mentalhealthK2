// lib/models/quote_model.dart

class Quote {
  final String id;
  final String content;
  final String? author;
  final String type;
  final String? category;
  final DateTime createdAt;
  final DateTime updatedAt;

  Quote({
    required this.id,
    required this.content,
    this.author,
    required this.type,
    this.category,
    required this.createdAt,
    required this.updatedAt,
  });

  factory Quote.fromJson(Map<String, dynamic> json) {
    return Quote(
      id: json['id'] as String? ?? json['_id'] as String? ?? 'N/A',
      content: json['content'] as String,
      author: json['author'] as String?,
      type: json['type'] as String? ?? 'quote',
      category: json['category'] as String?,
      createdAt: DateTime.parse(json['created_at'] as String),
      updatedAt: DateTime.parse(json['updated_at'] as String),
    );
  }

  Map<String, dynamic> toJson() {
    // ... (implementasi toJson jika perlu)
    return {
      'id': id,
      'content': content,
      'author': author,
      'type': type,
      'category': category,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
    };
  }
}