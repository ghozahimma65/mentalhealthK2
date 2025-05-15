// Nama file: lib/screen/meditation_screen.dart
import 'package:flutter/material.dart';
import 'package:audioplayers/audioplayers.dart'; // <-- Import audioplayers
import 'dart:async';
import 'dart:math'; // Untuk min()

// Model Data Lagu Meditasi (tetap sama)
class MeditationTrack {
  final String id;
  final String title;
  final String description;
  final String audioPath;
  final String? imagePath;

  MeditationTrack({
    required this.id,
    required this.title,
    required this.description,
    required this.audioPath,
    this.imagePath,
  });
}

class MeditationScreen extends StatefulWidget {
  const MeditationScreen({super.key});

  @override
  State<MeditationScreen> createState() => _MeditationScreenState();
}

class _MeditationScreenState extends State<MeditationScreen> {
  final AudioPlayer _player = AudioPlayer(); // Dari audioplayers
  bool _isLoading = false;
  bool _isPlaying = false;
  Duration _duration = Duration.zero;
  Duration _position = Duration.zero;

  StreamSubscription? _playerStateSubscription;
  StreamSubscription? _durationSubscription;
  StreamSubscription? _positionSubscription;
  StreamSubscription? _playerCompleteSubscription;


  final List<MeditationTrack> _meditationTracks = List.generate(10, (index) {
    return MeditationTrack(
      id: 'track_${index + 1}',
      title: 'Relaksasi Jiwa ${index + 1}', // Nama contoh baru
      description: 'Musik penenang pikiran #${index + 1}',
      // --- PASTIKAN PATH AUDIO INI BENAR ---
      audioPath: 'audio/meditasi_track_${index + 1}.mp3', // Path untuk AssetSource audioplayers
      // --- PASTIKAN PATH GAMBAR INI BENAR (jika dipakai) ---
      imagePath: 'images/meditasi_cover_${index + 1}.png',
    );
  });

  MeditationTrack? _currentTrack;

  @override
  void initState() {
    super.initState();
    print("[MeditationScreen audioplayers] initState");
    _setupPlayerListeners();
  }

  void _setupPlayerListeners() {
    _playerStateSubscription = _player.onPlayerStateChanged.listen((PlayerState state) {
      if (!mounted) return;
      print("[MeditationScreen audioplayers] Player state: $state");
      setState(() {
        _isPlaying = (state == PlayerState.playing);
      });
    });

    _durationSubscription = _player.onDurationChanged.listen((Duration d) {
      if (!mounted) return;
      print("[MeditationScreen audioplayers] Max duration: $d");
      setState(() { _duration = d; });
    });

    _positionSubscription = _player.onPositionChanged.listen((Duration p) {
      if (!mounted) return;
      setState(() { _position = p; });
    });

    _playerCompleteSubscription = _player.onPlayerComplete.listen((event) {
        if(!mounted) return;
        print("[MeditationScreen audioplayers] Audio Complete");
        setState(() {
            _isPlaying = false;
            _position = Duration.zero; // Kembali ke awal untuk UI slider
            // _currentTrack = null; // Opsional: reset track jika ingin player hilang
        });
    });
  }

  Future<void> _loadAndPlayTrack(MeditationTrack track) async {
    if (!mounted) return;

    // Jika track yang sama ditekan
    if (_currentTrack?.id == track.id) {
      if (_isPlaying) {
        print("[MeditationScreen audioplayers] Pausing current track");
        await _player.pause();
      } else {
        print("[MeditationScreen audioplayers] Resuming current track");
        await _player.resume();
      }
      return;
    }

    // Jika track berbeda atau belum ada track
    setState(() {
      _currentTrack = track;
      _isLoading = true;
      _isPlaying = false;
      _position = Duration.zero;
      _duration = Duration.zero;
    });

    print("[MeditationScreen audioplayers] Trying to load asset: '${track.audioPath}' (for audioplayers, path is relative to assets folder)");
    try {
      // audioplayers menggunakan AssetSource dan pathnya relatif dari folder assets
      // Jadi 'assets/audio/file.mp3' menjadi 'audio/file.mp3'
      await _player.play(AssetSource(track.audioPath));
      print("[MeditationScreen audioplayers] play(AssetSource) called for '${track.title}'.");
      // _isLoading akan dihandle oleh listener PlayerState.loading/buffering
      // setState(() { _isLoading = false; }); // Dihapus karena listener sudah ada
    } catch (e, s) {
      print("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
      print("!!! ERROR from audioplayers for '${track.audioPath}': $e");
      print("!!! StackTrace: $s");
      print("!!! PERIKSA: 1.Path aset di pubspec.yaml. 2.Path di kode (relatif dari assets). 3.File fisik ada. 4.Format MP3 valid?");
      print("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
      if (mounted) {
        setState(() { _isLoading = false; _currentTrack = null; });
        ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Gagal memuat: ${track.title}. Error: ${e.toString().substring(0, min(e.toString().length, 70))}...'))
        );
      }
    }
  }

  @override
  void dispose() {
    print("[MeditationScreen audioplayers] dispose called");
    _playerStateSubscription?.cancel();
    _durationSubscription?.cancel();
    _positionSubscription?.cancel();
    _playerCompleteSubscription?.cancel();
    _player.release(); // atau _player.dispose(); tergantung versi API
    _player.dispose();
    super.dispose();
  }

  String _formatDuration(Duration duration) {
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
    print("[MeditationScreen audioplayers] build. CurrentTrack: ${_currentTrack?.title}, Loading: $_isLoading, Playing: $_isPlaying");
    return Scaffold(
      appBar: AppBar(
        title: const Text('Pilih Meditasi (audioplayers)'),
      ),
      body: Column(
        children: [
          Expanded(
            child: _meditationTracks.isEmpty
              ? const Center(child: Text("Belum ada track meditasi tersedia."))
              : ListView.builder(
                  padding: const EdgeInsets.symmetric(vertical: 8.0),
                  itemCount: _meditationTracks.length,
                  itemBuilder: (context, index) {
                    final track = _meditationTracks[index];
                    bool isCurrentlySelectedTrack = _currentTrack?.id == track.id;
                    return Card(
                      margin: const EdgeInsets.symmetric(horizontal: 12, vertical: 5),
                      elevation: isCurrentlySelectedTrack ? 3 : 1.5,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(10),
                        side: BorderSide(color: isCurrentlySelectedTrack ? Theme.of(context).primaryColor.withOpacity(0.6) : Colors.transparent, width: 1.5)
                      ),
                      child: ListTile(
                        leading: Icon( Icons.music_note_rounded, color: isCurrentlySelectedTrack ? Theme.of(context).primaryColor : Colors.grey.shade700),
                        title: Text(track.title, style: TextStyle(fontWeight: isCurrentlySelectedTrack ? FontWeight.bold : FontWeight.normal, color: isCurrentlySelectedTrack ? Theme.of(context).primaryColor : Colors.black87)),
                        subtitle: Text(track.description, maxLines: 1, overflow: TextOverflow.ellipsis),
                        trailing: (isCurrentlySelectedTrack && !_isLoading)
                            ? Icon(_isPlaying ? Icons.pause_circle_filled_rounded : Icons.play_circle_filled_rounded, color: Theme.of(context).primaryColor, size: 28)
                            : (isCurrentlySelectedTrack && _isLoading)
                               ? const SizedBox(width: 24, height: 24, child: CircularProgressIndicator(strokeWidth: 2))
                               : Icon(Icons.play_arrow_rounded, color: Colors.grey.shade400, size: 28),
                        onTap: () => _loadAndPlayTrack(track),
                        selected: isCurrentlySelectedTrack,
                        selectedTileColor: Theme.of(context).primaryColor.withOpacity(0.08),
                      ),
                    );
                  },
            ),
          ),

          if (_currentTrack != null)
            Container( /* ... UI Player Kontrol sama seperti sebelumnya (tanpa gambar) ... */
              padding: const EdgeInsets.symmetric(horizontal:16.0, vertical: 12.0),
              decoration: BoxDecoration(color: Colors.white, boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.1), blurRadius: 8, offset: const Offset(0, -2))]),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  const SizedBox(height: 8),
                  Text(_currentTrack!.title, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold), textAlign: TextAlign.center, maxLines: 1, overflow: TextOverflow.ellipsis,),
                  const SizedBox(height: 0),
                  Slider(
                    min: 0, max: _duration.inMilliseconds.toDouble().clamp(1.0, double.infinity),
                    value: _position.inMilliseconds.toDouble().clamp(0.0, _duration.inMilliseconds.toDouble()),
                    onChanged: (value) async { await _player.seek(Duration(milliseconds: value.toInt())); },
                    activeColor: Colors.deepPurple.shade300, inactiveColor: Colors.deepPurple.shade100,
                  ),
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 10.0),
                    child: Row( mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [Text(_formatDuration(_position), style: const TextStyle(fontSize: 12)), Text(_formatDuration(_duration), style: const TextStyle(fontSize: 12))],
                    ),
                  ),
                  _isLoading
                      ? const SizedBox(height: 60, child: Center(child: CircularProgressIndicator()))
                      : IconButton(
                          icon: Icon(_isPlaying ? Icons.pause_circle_filled_rounded : Icons.play_circle_filled_rounded, size: 56.0, color: Colors.deepPurple),
                          onPressed: () {
                            if (_isPlaying) { _player.pause(); }
                            else { _player.resume(); /* atau player.play(AssetSource(...)) lagi jika perlu */ }
                          },
                        ),
                ],
              ),
            ),
        ],
      ),
    );
  }
}