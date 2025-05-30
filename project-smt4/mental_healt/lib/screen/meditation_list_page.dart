// lib/screen/meditation_list_page.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:mobile_project/controller/meditation_controller.dart';
import 'package:mobile_project/models/meditation_track.dart';     // Pastikan model diimpor
import 'package:mobile_project/screen/meditation_player_page.dart'; // Pastikan halaman player diimpor

class MeditationListPage extends StatelessWidget {
  // Inisialisasi controller.
  // Jika MeditationController sudah di-put di tempat lain (misal, main.dart atau binding global),
  // Anda mungkin ingin menggunakan Get.find<MeditationController>() di sini.
  // Namun, jika ini adalah entry point utama untuk fitur meditasi, Get.put() juga bisa.
  // Untuk konsistensi dengan contoh Anda sebelumnya, kita gunakan Get.put().
  final MeditationController controller = Get.put(MeditationController());

  MeditationListPage({super.key}); // Tambahkan super.key

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Meditasi')), // Menggunakan const
      body: Obx(() { // Obx untuk merebuild widget saat observable berubah
        if (controller.isLoading.value && controller.meditationTracks.isEmpty) {
          // Tampilkan loading hanya jika daftar masih kosong dan sedang loading awal
          return const Center(child: CircularProgressIndicator());
        }
        if (controller.meditationTracks.isEmpty && !controller.isLoading.value) {
          // Tampilkan pesan jika daftar kosong setelah selesai loading
          return const Center(child: Text('Tidak ada trek meditasi tersedia.'));
        }
        return ListView.builder(
          itemCount: controller.meditationTracks.length,
          itemBuilder: (context, index) {
            final MeditationTrack track = controller.meditationTracks[index];
            return ListTile(
              // --- SESUAIKAN BAGIAN INI ---
              leading: const Icon(Icons.music_note), // Selalu tampilkan ikon musik
              title: Text(track.title),
              // Gunakan deskripsi sebagai subtitle (mungkin dipotong jika terlalu panjang)
              subtitle: Text(
                track.description.length > 80 // Batas panjang karakter untuk subtitle
                    ? '${track.description.substring(0, 80)}...'
                    : track.description,
                maxLines: 2, // Batasi maksimal 2 baris
                overflow: TextOverflow.ellipsis, // Tambahkan elipsis jika teks terpotong
              ),
              // -----------------------------
              onTap: () {
                Get.to(() => MeditationPlayerPage(track: track)); // Navigasi ke player page
              },
            );
          },
        );
      }),
    );
  }
}