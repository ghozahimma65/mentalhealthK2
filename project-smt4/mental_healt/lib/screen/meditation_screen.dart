// lib/screen/meditation_screen.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:mobile_project/controller/meditation_controller.dart'; // Sesuaikan path jika perlu
import 'package:mobile_project/models/meditation_track.dart';     // Sesuaikan path jika perlu
import 'package:mobile_project/screen/meditation_player_page.dart';// Sesuaikan path jika perlu

class MeditationScreen extends StatelessWidget {
  const MeditationScreen({super.key});

  // Inisialisasi controller. Get.put() akan membuat instance baru jika belum ada,
  // atau menemukan yang sudah ada jika pernah dibuat di scope yang sama atau parent.
  // Jika controller sudah di-put di tempat lain (misal, di main.dart bindings),
  // Anda bisa menggunakan Get.find() di sini. Tapi untuk screen level, Get.put() aman.
  @override
  Widget build(BuildContext context) {
    // Gunakan Get.put() jika ini adalah entry point utama untuk controller ini di bagian UI ini.
    // Jika controller sudah di-inject di tempat lain (misal global binding), gunakan Get.find().
    final MeditationController controller = Get.put(MeditationController());

    return Scaffold(
      appBar: AppBar(
        title: const Text('Daftar Meditasi'),
        // Anda bisa tambahkan aksi refresh jika perlu
        // actions: [
        //   IconButton(
        //     icon: Icon(Icons.refresh),
        //     onPressed: () => controller.fetchTracks(),
        //   ),
        // ],
      ),
      body: Obx(() { // Obx akan merebuild widget hanya jika variabel .obs berubah
        if (controller.isLoading.value && controller.meditationTracks.isEmpty) {
          // Tampilkan loading hanya jika daftar masih kosong dan sedang loading awal
          return const Center(child: CircularProgressIndicator());
        }
        if (controller.meditationTracks.isEmpty && !controller.isLoading.value) {
          // Tampilkan pesan jika daftar kosong setelah selesai loading
          return const Center(child: Text('Tidak ada trek meditasi tersedia.'));
        }
        // Jika sedang loading tapi sudah ada data, Anda bisa tampilkan indikator di atas list
        // atau biarkan list tetap terlihat.

        return ListView.builder(
          itemCount: controller.meditationTracks.length,
          itemBuilder: (context, index) {
            final MeditationTrack track = controller.meditationTracks[index];
            return ListTile(
              // Anda bisa tambahkan leading (misal gambar) atau trailing icon
              title: Text(track.title),
              subtitle: Text(track.description.length > 50
                  ? '${track.description.substring(0, 50)}...'
                  : track.description), // Ringkasan deskripsi
              onTap: () {
                // Navigasi ke halaman player dengan mengirim data track
                Get.to(() => MeditationPlayerPage(track: track));
              },
            );
          },
        );
      }),
    );
  }
}