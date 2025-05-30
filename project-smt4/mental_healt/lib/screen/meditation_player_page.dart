// lib/screen/meditation_player_page.dart
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:mobile_project/controller/meditation_controller.dart';
import 'package:mobile_project/models/meditation_track.dart';
import 'package:audioplayers/audioplayers.dart'; // Untuk PlayerState

class MeditationPlayerPage extends StatelessWidget {
  final MeditationTrack track;
  // Temukan instance controller yang sudah ada.
  // Pastikan controller ini sudah di-Get.put() oleh halaman sebelumnya (misal MeditationScreen)
  // atau melalui GetX Bindings.
  final MeditationController controller = Get.find<MeditationController>();

  MeditationPlayerPage({super.key, required this.track});

  String _formatDuration(Duration duration) {
    String twoDigits(int n) => n.toString().padLeft(2, '0');
    final hours = twoDigits(duration.inHours);
    final minutes = twoDigits(duration.inMinutes.remainder(60));
    final seconds = twoDigits(duration.inSeconds.remainder(60));
    return [
      if (duration.inHours > 0) hours,
      minutes,
      seconds,
    ].join(':');
  }

  @override
  Widget build(BuildContext context) {
    // Logika untuk auto-play saat halaman pertama kali dibuka atau jika track berbeda/selesai.
    // Ini akan dipanggil setelah frame pertama selesai di-render.
    WidgetsBinding.instance.addPostFrameCallback((_) {
      // Perbandingan objek 'track' dengan 'controller.currentTrack.value'
      // bergantung pada implementasi operator== di model MeditationTrack Anda.
      // Jika MeditationTrack punya 'clientId' yang unik, Anda bisa juga bandingkan:
      // controller.currentTrack.value?.clientId != track.clientId
      if (controller.currentTrack.value != track ||
          controller.playerState.value == PlayerState.stopped ||
          controller.playerState.value == PlayerState.completed) {
        // Pastikan track yang diterima controller adalah instance yang sama
        // atau memiliki cara perbandingan yang konsisten.
        controller.playTrack(track);
      }
    });

    return Scaffold(
      appBar: AppBar(
        title: Text(track.title),
        leading: IconButton( // Tombol kembali standar
          icon: Icon(Icons.arrow_back),
          onPressed: () {
            // Pertimbangkan untuk menghentikan audio saat kembali,
            // atau biarkan controller yang mengatur lifecycle audio.
            // controller.stopTrack(); // Opsional, tergantung kebutuhan UX
            Get.back();
          },
        ),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            // Bagian untuk menampilkan gambar sudah dihapus sesuai keputusan.
            // Jika ingin ada placeholder visual:
            // Container(
            //   height: 200,
            //   width: double.infinity,
            //   color: Colors.grey[300],
            //   child: Icon(Icons.music_note, size: 100, color: Colors.grey[700]),
            // ),
            // SizedBox(height: 20),

            Text(
              track.title,
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
              textAlign: TextAlign.center,
            ),
            SizedBox(height: 12),
            Expanded(
              child: SingleChildScrollView(
                child: Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16.0),
                  child: Text(
                    track.description,
                    style: TextStyle(fontSize: 16),
                    textAlign: TextAlign.center,
                  ),
                ),
              ),
            ),
            SizedBox(height: 30),
            Obx(() => Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(_formatDuration(controller.currentPosition.value)),
                    Text(_formatDuration(controller.totalDuration.value)),
                  ],
                )),
            Obx(() => Slider(
                  value: (controller.totalDuration.value.inSeconds > 0 &&
                          controller.currentPosition.value.inSeconds <= controller.totalDuration.value.inSeconds)
                      ? controller.currentPosition.value.inSeconds.toDouble()
                      : 0.0,
                  max: controller.totalDuration.value.inSeconds.toDouble() > 0
                      ? controller.totalDuration.value.inSeconds.toDouble()
                      : 1.0,
                  onChanged: (value) {
                    controller.seekTrack(Duration(seconds: value.toInt()));
                  },
                )),
            Obx(() {
              final playerState = controller.playerState.value;
              bool isPlaying = playerState == PlayerState.playing;

              return Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  IconButton(
                    icon: Icon(
                      isPlaying ? Icons.pause_circle_filled : Icons.play_circle_filled,
                      size: 64,
                      color: Theme.of(context).primaryColor, // Gunakan warna tema
                    ),
                    onPressed: () {
                      // Controller akan menangani apakah ini play baru, resume, atau pause.
                      controller.playTrack(track);
                    },
                  ),
                  SizedBox(width: 20), // Beri jarak antar tombol
                  IconButton(
                    icon: Icon(Icons.stop_circle_outlined, size: 64, color: Colors.grey[700]),
                    onPressed: () {
                      controller.stopTrack();
                    },
                  ),
                ],
              );
            }),
            SizedBox(height: 20),
          ],
        ),
      ),
    );
  }
}
