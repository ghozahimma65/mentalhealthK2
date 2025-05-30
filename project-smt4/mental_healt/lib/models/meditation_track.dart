// lib/models/meditation_track.dart

class MeditationTrack {
  final String title;
  final String description;
  final String audioPath; // Akan diisi dari 'audio_url_full' atau 'audio_path' dari API

  // Kita bisa menambahkan ID sementara di sisi klien jika benar-benar tidak ada dari backend,
  // tapi ini hanya untuk keperluan UI sementara dan tidak persisten atau unik secara global.
  final String _clientId; // ID sementara yang dibuat di Flutter

  MeditationTrack({
    required this.title,
    required this.description,
    required this.audioPath,
  }) : _clientId = DateTime.now().millisecondsSinceEpoch.toString() + audioPath; // Contoh pembuatan ID sementara

  // Getter untuk ID sementara jika diperlukan di UI atau logika lain
  String get clientId => _clientId;

  factory MeditationTrack.fromJson(Map<String, dynamic> json) {
    return MeditationTrack(
      title: json['title'] ?? 'Tanpa Judul',
      description: json['description'] ?? 'Tanpa Deskripsi',
      // Utamakan 'audio_url_full' jika API Anda dimodifikasi untuk mengirimkannya,
      // jika tidak, gunakan 'audio_path'.
      audioPath: json['audio_url_full'] ?? json['audio_path'] ?? '',
    );
  }

  Map<String, dynamic> toJsonForCreate() {
    return {
      'title': title,
      'description': description,
      'audio_path': audioPath, // Untuk POST, ini mungkin path relatif atau nama file
    };
  }

  // Jika Anda perlu method toJson untuk update, Anda tidak memiliki ID backend untuk dikirim
  // Map<String, dynamic> toJson() {
  //   return {
  //     'title': title,
  //     'description': description,
  //     'audio_path': audioPath,
  //   };
  // }

  // Untuk perbandingan objek, jika tidak ada ID dari backend,
  // kita bisa override operator == dan hashCode berdasarkan field yang ada.
  // Ini akan membantu GetX atau logika lain untuk membedakan objek.
  @override
  bool operator ==(Object other) =>
      identical(this, other) ||
      other is MeditationTrack &&
          runtimeType == other.runtimeType &&
          title == other.title &&
          description == other.description &&
          audioPath == other.audioPath;

  @override
  int get hashCode => title.hashCode ^ description.hashCode ^ audioPath.hashCode;
}
