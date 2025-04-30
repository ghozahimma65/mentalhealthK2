import 'package:flutter/material.dart';

class TesDiagnosaScreen extends StatelessWidget {
  const TesDiagnosaScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Tes Diagnosa'),
        backgroundColor: Colors.blueAccent,
      ),
      body: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          buildTesCard(context, 'Mental Health', 'Cek kondisi mental secara umum', Colors.purple, '/kuis'),
          const SizedBox(height: 16),
          buildTesCard(context, 'Depression', 'Cek tingkat depresi kamu', Colors.blue, '/kuis'),
          const SizedBox(height: 16),
          buildTesCard(context, 'Bipolar', 'Cek tingkat bipolar', Colors.green, '/kuis'),
          const SizedBox(height: 16),
          buildTesCard(context, 'Anxiety Disorder', 'Cek tingkat kecemasan', Colors.orange, '/kuis'),
        ],
      ),
    );
  }

  Widget buildTesCard(BuildContext context, String title, String subtitle, Color color, String routeName) {
    return Card(
      color: color,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: ListTile(
        onTap: () {
          Navigator.pushNamed(context, routeName);
        },
        title: Text(
          title,
          style: const TextStyle(color: Colors.white, fontSize: 20, fontWeight: FontWeight.bold),
        ),
        subtitle: Text(
          subtitle,
          style: const TextStyle(color: Colors.white70),
        ),
        trailing: const Icon(Icons.arrow_forward_ios, color: Colors.white),
      ),
    );
  }
}