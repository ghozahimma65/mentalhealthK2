// Nama file: lib/screen/pengaturan_notifikasi_screen.dart
import 'package:flutter/material.dart';

class PengaturanNotifikasiScreen extends StatefulWidget {
  const PengaturanNotifikasiScreen({super.key});

  @override
  State<PengaturanNotifikasiScreen> createState() => _PengaturanNotifikasiScreenState();
}

class _PengaturanNotifikasiScreenState extends State<PengaturanNotifikasiScreen> {
  // Contoh state untuk switch notifikasi
  bool _pengingatMeditasi = true;
  bool _kutipanHarian = true;
  bool _updateRencana = false;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Pengaturan Notifikasi'),
      ),
      body: ListView(
        padding: const EdgeInsets.symmetric(vertical: 10.0),
        children: <Widget>[
          SwitchListTile(
            title: const Text('Pengingat Sesi Meditasi'),
            subtitle: const Text('Dapatkan pengingat untuk jadwal meditasi Anda'),
            value: _pengingatMeditasi,
            onChanged: (bool value) {
              setState(() {
                _pengingatMeditasi = value;
                // TODO: Simpan preferensi ini
              });
            },
            activeColor: Theme.of(context).primaryColor,
            secondary: const Icon(Icons.self_improvement_rounded),
          ),
          const Divider(),
          SwitchListTile(
            title: const Text('Kutipan Harian'),
            subtitle: const Text('Terima kutipan inspiratif setiap hari'),
            value: _kutipanHarian,
            onChanged: (bool value) {
              setState(() {
                _kutipanHarian = value;
                // TODO: Simpan preferensi ini
              });
            },
            activeColor: Theme.of(context).primaryColor,
            secondary: const Icon(Icons.format_quote_rounded),
          ),
          const Divider(),
          SwitchListTile(
            title: const Text('Update Rencana Self Care'),
            subtitle: const Text('Notifikasi terkait progres atau jadwal rencana Anda'),
            value: _updateRencana,
            onChanged: (bool value) {
              setState(() {
                _updateRencana = value;
                // TODO: Simpan preferensi ini
              });
            },
            activeColor: Theme.of(context).primaryColor,
            secondary: const Icon(Icons.event_note_rounded),
          ),
           const Divider(),
           // Tambahkan pengaturan notifikasi lainnya jika ada
        ],
      ),
    );
  }
}