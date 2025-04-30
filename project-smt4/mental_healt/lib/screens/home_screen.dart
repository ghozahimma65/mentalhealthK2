// import 'package:flutter/material.dart';

// class HomeScreen extends StatelessWidget {
//   const HomeScreen({super.key});

//   @override
//   Widget build(BuildContext context) {
//     return Scaffold(
//       bottomNavigationBar: BottomNavigationBar(
//         type: BottomNavigationBarType.fixed,
//         selectedItemColor: Colors.blueAccent,
//         unselectedItemColor: Colors.grey,
//         items: const [
//           BottomNavigationBarItem(icon: Icon(Icons.home), label: 'Home'),
//           BottomNavigationBarItem(icon: Icon(Icons.favorite), label: 'Tes Diagnose'),
//           BottomNavigationBarItem(icon: Icon(Icons.trending_up), label: 'New Tips'),
//           BottomNavigationBarItem(icon: Icon(Icons.person), label: 'My Profile'),
//         ],
//       ),
//       body: SafeArea(
//         child: Padding(
//           padding: const EdgeInsets.symmetric(horizontal: 16),
//           child: ListView(
//             children: [
//               const SizedBox(height: 20),
//               Row(
//                 mainAxisAlignment: MainAxisAlignment.spaceBetween,
//                 children: const [
//                   CircleAvatar(
//                     backgroundColor: Colors.grey,
//                     radius: 20,
//                     child: Icon(Icons.person, color: Colors.white),
//                   ),
//                   Icon(Icons.notifications_none),
//                 ],
//               ),
//               const SizedBox(height: 20),
//               const Text(
//                 'Hello, Dyahna',
//                 style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
//               ),
//               const SizedBox(height: 4),
//               const Text('Bagaimana perasaanmu hari ini?'),
//               const SizedBox(height: 16),
//               TextField(
//                 decoration: InputDecoration(
//                   prefixIcon: const Icon(Icons.search),
//                   hintText: 'Search..',
//                   border: OutlineInputBorder(
//                     borderRadius: BorderRadius.circular(12),
//                   ),
//                   contentPadding: const EdgeInsets.all(0),
//                 ),
//               ),
//               const SizedBox(height: 16),
//               Container(
//                 padding: const EdgeInsets.all(16),
//                 decoration: BoxDecoration(
//                   color: Colors.purple.shade200,
//                   borderRadius: BorderRadius.circular(16),
//                 ),
//                 child: Row(
//                   children: [
//                     Expanded(
//                       child: Column(
//                         crossAxisAlignment: CrossAxisAlignment.start,
//                         children: const [
//                           Text(
//                             'Mental Health',
//                             style: TextStyle(
//                                 fontWeight: FontWeight.bold,
//                                 fontSize: 16,
//                                 color: Colors.white),
//                           ),
//                           SizedBox(height: 8),
//                           Text(
//                             'Cek Mental Health kamu sekarang!',
//                             style: TextStyle(color: Colors.white),
//                           ),
//                           SizedBox(height: 12),
//                           ElevatedButton(
//                             style: ElevatedButton.styleFrom(
//                                 backgroundColor: Colors.purple),
//                             onPressed: null, // Ganti dengan aksi nanti
//                             child: Text('Tes Sekarang'),
//                           )
//                         ],
//                       ),
//                     ),
//                     const SizedBox(width: 10),
//                     Image.asset(
//                       'assets/images/mentalhealth.png',
//                       height: 100,
//                     ),
//                   ],
//                 ),
//               ),
//               const SizedBox(height: 24),
//               Row(
//                 mainAxisAlignment: MainAxisAlignment.spaceAround,
//                 children: const [
//                   _IconOption(icon: Icons.play_circle_fill, label: 'Meditasi'),
//                   _IconOption(icon: Icons.format_quote, label: 'Quotes'),
//                   _IconOption(icon: Icons.calendar_today, label: 'Rencana'),
//                   _IconOption(icon: Icons.more_horiz, label: 'More'),
//                 ],
//               ),
//               const SizedBox(height: 24),
//               const Text(
//                 'Recommended for you',
//                 style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
//               ),
//               const SizedBox(height: 16),
//               Row(
//                 children: [
//                   _CardRecommendation(
//                     title: 'Focus',
//                     subtitle: 'MEDITATION • 3-10 MIN',
//                     color: Colors.teal.shade100,
//                     image: 'assets/images/focus.png',
//                   ),
//                   const SizedBox(width: 16),
//                   _CardRecommendation(
//                     title: 'Happiness',
//                     subtitle: 'MEDITATION • 5-10 MIN',
//                     color: Colors.orange.shade100,
//                     image: 'assets/images/happy.png',
//                   ),
//                 ],
//               )
//             ],
//           ),
//         ),
//       ),
//     );
//   }
// }

// class _IconOption extends StatelessWidget {
//   final IconData icon;
//   final String label;

//   const _IconOption({required this.icon, required this.label});

//   @override
//   Widget build(BuildContext context) {
//     return Column(
//       children: [
//         CircleAvatar(
//           radius: 28,
//           backgroundColor: Colors.grey.shade200,
//           child: Icon(icon, color: Colors.blueAccent),
//         ),
//         const SizedBox(height: 8),
//         Text(label, style: const TextStyle(fontSize: 12)),
//       ],
//     );
//   }
// }

// class _CardRecommendation extends StatelessWidget {
//   final String title;
//   final String subtitle;
//   final Color color;
//   final String image;

//   const _CardRecommendation({
//     required this.title,
//     required this.subtitle,
//     required this.color,
//     required this.image,
//   });

//   @override
//   Widget build(BuildContext context) {
//     return Expanded(
//       child: Container(
//         height: 140,
//         padding: const EdgeInsets.all(12),
//         decoration: BoxDecoration(
//           color: color,
//           borderRadius: BorderRadius.circular(16),
//         ),
//         child: Column(
//           crossAxisAlignment: CrossAxisAlignment.start,
//           children: [
//             Image.asset(image, height: 50),
//             const SizedBox(height: 8),
//             Text(title,
//                 style: const TextStyle(
//                     fontSize: 16, fontWeight: FontWeight.bold)),
//             const SizedBox(height: 4),
//             Text(subtitle, style: const TextStyle(fontSize: 12)),
//           ],
//         ),
//       ),
//     );
//   }
// }
