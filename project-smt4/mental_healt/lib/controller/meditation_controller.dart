// lib/controller/meditation_controller.dart
import 'package:flutter/material.dart'; // Pastikan ini ada untuk Colors
import 'package:get/get.dart';
// Pastikan path dan nama model ini benar, dan model ini meng-override operator== dan hashCode
import 'package:mobile_project/models/meditation_track.dart';
import 'package:mobile_project/provider/meditation_provider.dart';
import 'package:audioplayers/audioplayers.dart';
import 'package:mobile_project/ApiVar.dart';

class MeditationController extends GetxController {
  final MeditationProvider _provider = MeditationProvider();
  final AudioPlayer audioPlayer = AudioPlayer();

  var isLoading = true.obs;
  var meditationTracks = <MeditationTrack>[].obs;
  var currentTrack = Rx<MeditationTrack?>(null);
  var playerState = PlayerState.stopped.obs;
  var currentPosition = Duration.zero.obs;
  var totalDuration = Duration.zero.obs;

  @override
  void onInit() {
    super.onInit();
    fetchTracks();
    _initAudioPlayerListeners();
  }

  @override
  void onClose() {
    audioPlayer.dispose();
    super.onClose();
  }

  void _initAudioPlayerListeners() {
    audioPlayer.onPlayerStateChanged.listen((state) {
      playerState.value = state;
    });
    audioPlayer.onDurationChanged.listen((duration) {
      totalDuration.value = duration;
    });
    audioPlayer.onPositionChanged.listen((position) {
      currentPosition.value = position;
    });
    audioPlayer.onPlayerComplete.listen((event) {
      playerState.value = PlayerState.stopped;
      currentPosition.value = Duration.zero;
      // Anda mungkin ingin currentTrack.value = null; di sini agar UI player kembali ke state awal
      // atau logika untuk memutar trek selanjutnya.
    });
  }

  void fetchTracks() async {
    try {
      isLoading(true);
      var tracks = await _provider.fetchMeditationTracks();
      meditationTracks.assignAll(tracks);
    } catch (e) {
      Get.snackbar('Error', 'Gagal memuat data meditasi: ${e.toString()}',
          backgroundColor: Colors.red, colorText: Colors.white);
    } finally {
      isLoading(false);
    }
  }

  Future<void> playTrack(MeditationTrack track) async {
    try {
      // Menggunakan perbandingan objek langsung karena MeditationTrack
      // diasumsikan sudah meng-override operator== dan hashCode.
      // Alternatif: if (currentTrack.value?.clientId == track.clientId && ...)
      if (currentTrack.value == track &&
          playerState.value == PlayerState.playing) {
        await pauseTrack();
      } else if (currentTrack.value == track &&
          playerState.value == PlayerState.paused) {
        await resumeTrack();
      } else {
        // Track baru atau track berbeda, atau track yang sama tapi sudah berhenti/selesai
        currentTrack.value = track;
        print(
            'Mencoba memutar audio dari URL: ${MainUrl}/storage/${track.audioPath}');
        if (track.audioPath.isNotEmpty && // 1. Periksa apakah audioPath tidak kosong
    Uri.tryParse('$MainUrl/storage/${track.audioPath}')?.isAbsolute == true) {
          await audioPlayer.stop(); // Hentikan dulu audio sebelumnya jika ada
          await audioPlayer.play(UrlSource(
              "${MainUrl}/storage/${track.audioPath}")); //pakai BASEURL ATAU MAINURL YA
          playerState.value = PlayerState.playing;
        } else {
          print(
              'Error: audioPath tidak valid atau bukan URL absolut: ${track.audioPath}');
          Get.snackbar('Error', 'URL audio tidak valid.',
              backgroundColor: Colors.orange, colorText: Colors.white);
          playerState.value = PlayerState.stopped;
        }
      }
    } catch (e) {
      print("Error playing track: $e"); // Untuk debugging di konsol
      Get.snackbar('Error', 'Gagal memulai meditasi: ${e.toString()}',
          backgroundColor: Colors.red, colorText: Colors.white);
      playerState.value =
          PlayerState.stopped; // Pastikan state diset jika ada error
    }
  }

  Future<void> pauseTrack() async {
    if (playerState.value == PlayerState.playing) {
      await audioPlayer.pause();
      // playerState.value = PlayerState.paused; // Di-handle oleh listener onPlayerStateChanged
    }
  }

  Future<void> resumeTrack() async {
    if (playerState.value == PlayerState.paused) {
      await audioPlayer.resume();
      // playerState.value = PlayerState.playing; // Di-handle oleh listener onPlayerStateChanged
    }
  }

  Future<void> stopTrack() async {
    await audioPlayer.stop();
    // playerState.value = PlayerState.stopped; // Di-handle oleh listener onPlayerStateChanged
    // currentPosition.value = Duration.zero; // Di-handle oleh listener onPlayerComplete atau onPositionChanged saat stop
    // currentTrack.value = null; // Opsional, tergantung behaviour yang diinginkan
  }

  void seekTrack(Duration position) {
    audioPlayer.seek(position);
  }
}
