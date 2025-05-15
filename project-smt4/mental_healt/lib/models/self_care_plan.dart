// Nama file: lib/models/self_care_plan.dart
// Tidak perlu import 'package:mobile_project/helpers/database_helper.dart'; di sini

class SelfCarePlan {
  String id; // Akan digunakan sebagai PRIMARY KEY (TEXT)
  String title;
  String description;
  bool isCompleted;
  // TimeOfDay? reminderTime; // Komentari dulu jika tidak langsung dipakai

  SelfCarePlan({
    required this.id,
    required this.title,
    this.description = '',
    this.isCompleted = false,
    // this.reminderTime,
  });

  // Konversi SelfCarePlan object ke Map object untuk database
  Map<String, dynamic> toMap() {
    return {
      'id': id, // Nama kolom di database helper nanti kita samakan 'id'
      'title': title,
      'description': description,
      'isCompleted': isCompleted ? 1 : 0, // Simpan boolean sebagai 0 atau 1
      // 'reminderTime': reminderTime != null ? '${reminderTime!.hour.toString().padLeft(2, '0')}:${reminderTime!.minute.toString().padLeft(2, '0')}' : null,
    };
  }

  // Factory constructor untuk membuat SelfCarePlan dari Map object dari database
  factory SelfCarePlan.fromMap(Map<String, dynamic> map) {
    // String? timeString = map['reminderTime'];
    // TimeOfDay? reminder;
    // if (timeString != null && timeString.isNotEmpty) {
    //   final parts = timeString.split(':');
    //   if (parts.length == 2) {
    //      reminder = TimeOfDay(hour: int.parse(parts[0]), minute: int.parse(parts[1]));
    //   }
    // }

    return SelfCarePlan(
      id: map['id'] as String,
      title: map['title'] as String,
      description: map['description'] as String? ?? '',
      isCompleted: (map['isCompleted'] as int) == 1,
      // reminderTime: reminder,
    );
  }

  @override
  String toString() {
    return 'SelfCarePlan{id: $id, title: "$title", isCompleted: $isCompleted, description: "$description"}';
  }
}