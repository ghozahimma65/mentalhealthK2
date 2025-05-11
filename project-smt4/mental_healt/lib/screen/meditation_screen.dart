// Nama file: meditation_screen.dart
import 'package:flutter/material.dart';
import 'package:just_audio/just_audio.dart'; // <-- Pastikan import ini ada
import 'dart:async'; // <-- Pastikan import ini ada

class MeditationScreen extends StatefulWidget {
  const MeditationScreen({super.key});

  @override
  State<MeditationScreen> createState() => _MeditationScreenState();
}

class _MeditationScreenState extends State<MeditationScreen> {
  final AudioPlayer _player = AudioPlayer();
  bool _isLoading = true;
  bool _isPlaying = false;
  Duration _duration = Duration.zero;
  Duration _position = Duration.zero;

  StreamSubscription? _playerStateSubscription;
  StreamSubscription? _durationSubscription;
  StreamSubscription? _positionSubscription;

  @override
  void initState() {
    super.initState();
    print("[MeditationScreen] initState called"); // Log initState
    _initAudioPlayer();
  }

  Future<void> _initAudioPlayer() async {
    print("[MeditationScreen] _initAudioPlayer started...");
    if (!mounted) return; // Cek jika widget masih mounted
    setState(() {
      _isLoading = true;
    });

    // --- PATH AUDIO ANDA ---
    // --- PASTIKAN INI 100% BENAR SESUAI LOKASI & NAMA FILE ANDA ---
    const String audioPath = 'assets/audio/meditasi_tenang.mp3';
    // ------------------------

    print("[MeditationScreen] Trying to load asset: '$audioPath'");

    try {
      // Coba load aset
      await _player.setAsset(audioPath);
      print("[MeditationScreen] setAsset completed successfully.");

      // Setup listeners HANYA JIKA setAsset berhasil
      _playerStateSubscription = _player.playerStateStream.listen((state) {
        if (!mounted) return;
        print(
            "[MeditationScreen] Player state changed: ${state.processingState}, Playing: ${state.playing}");
        setState(() {
          _isPlaying = state.playing;
          switch (state.processingState) {
            case ProcessingState.idle:
            case ProcessingState.loading:
            case ProcessingState.buffering:
              _isLoading = true;
              break;
            case ProcessingState.ready:
            case ProcessingState.completed:
              _isLoading = false;
              break;
          }
        });
      });

      _durationSubscription = _player.durationStream.listen((duration) {
        if (mounted && duration != null) {
          print("[MeditationScreen] Duration received: $duration");
          setState(() {
            _duration = duration;
          });
        }
      });

      _positionSubscription = _player.positionStream.listen((position) {
        if (mounted) {
          // Log posisi bisa dimatikan jika terlalu ramai
          // print("[MeditationScreen] Position changed: $position");
          setState(() {
            _position = position;
          });
        }
      });

      // Cek state setelah listener (mungkin sudah ready)
      if (_player.processingState == ProcessingState.ready && mounted) {
        print("[MeditationScreen] Player already ready after listener setup.");
        setState(() {
          _isLoading = false;
        });
      } else if (mounted) {
        print(
            "[MeditationScreen] Player not immediately ready. Waiting for listener. State: ${_player.processingState}");
      }
    } catch (e, s) {
      // Tangani error spesifik saat setAsset
      print("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
      print("!!! ERROR loading audio source '$audioPath': $e");
      print("!!! StackTrace: $s");
      print("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
      if (mounted) {
        setState(() {
          _isLoading = false;
        });
        // Di dalam catch(e, s) di _initAudioPlayer

        ScaffoldMessenger.of(context).showSnackBar(
            // Versi BARU (lebih aman):
            SnackBar(
                content: Text(
                    'Gagal memuat audio: ${e.toString()}')) // <-- Tampilkan error lengkap
            );
      }
    }
  }

  @override
  void dispose() {
    print("[MeditationScreen] dispose called");
    // Batalkan listener dan dispose player
    _playerStateSubscription?.cancel();
    _durationSubscription?.cancel();
    _positionSubscription?.cancel();
    _player.dispose();
    super.dispose();
  }

  // Fungsi format durasi (tetap sama)
  String _formatDuration(Duration duration) {
    // ... (kode _formatDuration tetap sama) ...
    String twoDigits(int n) => n.toString().padLeft(2, '0');
    final hours = duration.inHours;
    final minutes = duration.inMinutes.remainder(60);
    final seconds = duration.inSeconds.remainder(60);
    if (hours > 0) {
      return "${twoDigits(hours)}:${twoDigits(minutes)}:${twoDigits(seconds)}";
    } else {
      return "${twoDigits(minutes)}:${twoDigits(seconds)}";
    }
  }

  @override
  Widget build(BuildContext context) {
    print(
        "[MeditationScreen] build method called. IsLoading: $_isLoading, IsPlaying: $_isPlaying");
    return Scaffold(
      appBar: AppBar(
        title: const Text('Meditasi'),
      ),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(20.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              // Gambar Meditasi
              Image.asset(
                'assets/images/meditation_placeholder.png', // <-- GANTI PATH GAMBAR
                height: 200,
                errorBuilder: (context, error, stackTrace) => const SizedBox(
                    height: 200,
                    child: Center(
                        child: Icon(Icons.spa, size: 100, color: Colors.grey))),
              ),
              const SizedBox(height: 24),
              // Judul Track
              const Text('Meditasi Ketenangan Hati',
                  style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
                  textAlign: TextAlign.center),
              const SizedBox(height: 8),
              // Deskripsi Track
              const Text('Panduan relaksasi untuk memulai hari',
                  style: TextStyle(fontSize: 16, color: Colors.grey),
                  textAlign: TextAlign.center),
              const SizedBox(height: 32),
              // Slider Progress
              Slider(
                min: 0,
                max: _duration.inSeconds
                    .toDouble()
                    .clamp(1.0, double.infinity), // Max minimal 1.0
                value: _position.inSeconds
                    .toDouble()
                    .clamp(0.0, _duration.inSeconds.toDouble()),
                onChanged: (value) {
                  final newPosition = Duration(seconds: value.toInt());
                  print(
                      "[MeditationScreen] Slider seeking to: $newPosition"); // Log seek
                  _player.seek(newPosition);
                },
                activeColor: Colors.deepPurple.shade300,
                inactiveColor: Colors.deepPurple.shade100,
              ),
              // Tampilan Durasi
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16.0),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(_formatDuration(_position)),
                    Text(_formatDuration(_duration))
                  ],
                ),
              ),
              const SizedBox(height: 20),
              // Tombol Kontrol Play/Pause
              _isLoading
                  ? const CircularProgressIndicator() // Tampilkan loading
                  : IconButton(
                      icon: Icon(
                          _isPlaying
                              ? Icons.pause_circle_filled
                              : Icons.play_circle_filled,
                          size: 64.0,
                          color: Colors.deepPurple),
                      onPressed: () {
                        if (_isPlaying) {
                          print("[MeditationScreen] Pausing player.");
                          _player.pause();
                        } else {
                          print(
                              "[MeditationScreen] Playing player. Current state: ${_player.processingState}");
                          if (_player.processingState ==
                              ProcessingState.completed) {
                            print("[MeditationScreen] Re-seeking to zero.");
                            _player.seek(Duration.zero);
                            // Mungkin perlu sedikit delay sebelum play jika ada masalah race condition
                            // Future.delayed(Duration(milliseconds: 100), () => _player.play());
                          } else {
                            _player.play();
                          }
                        }
                      },
                    ),
            ],
          ),
        ),
      ),
    );
  }
}
