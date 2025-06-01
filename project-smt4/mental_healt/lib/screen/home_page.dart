// Nama file: home_page.dart
import 'package:flutter/material.dart';
import 'package:sp_util/sp_util.dart'; // Anda menggunakan SpUtil

// Diasumsikan file layar tujuan navigasi sudah ada dan route terdaftar
// di main.dart

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  // Hapus inisialisasi 'name' langsung di sini
  // String? name = SpUtil.getString('nama'); 

  // Tambahkan variabel state untuk nama pengguna dan status loadingnya
  String? _loggedInUserName;
  bool _isLoadingName = true; // Mulai dengan true untuk menunjukkan sedang loading

  int _selectedIndex = 0;

  @override
  void initState() {
    super.initState();
    print("HomePage: initState() called - loading user name.");
    _loadUserName(); // Panggil fungsi untuk memuat nama pengguna
  }

  Future<void> _loadUserName() async {
    if (!mounted) return;
    // Tidak perlu setState untuk _isLoadingName = true di sini karena sudah true awalnya
    // dan kita hanya set false setelah selesai atau error.

    try {
      // PENTING: Pastikan key 'user_name' ini SAMA PERSIS 
      // dengan key yang Anda gunakan saat menyimpan nama di AuthService.login()
      String? nameFromPrefs = SpUtil.getString('user_name'); 
      
      print("HomePage: User name retrieved from SpUtil ('user_name'): $nameFromPrefs");

      if (mounted) {
        setState(() {
          _loggedInUserName = nameFromPrefs;
          _isLoadingName = false; // Selesai loading
        });
      }
    } catch (e) {
      print("HomePage: Error loading user name: $e");
      if (mounted) {
        setState(() {
          _loggedInUserName = null; // Atau "Guest" atau pesan error
          _isLoadingName = false;
        });
      }
    }
  }

  // --- METHOD _onItemTapped ANDA TETAP SAMA ---
  void _onItemTapped(int index) {
    String? routeName;
    switch (index) {
      case 0: // Home
        if (ModalRoute.of(context)?.settings.name == '/homepage' ||
            ModalRoute.of(context)?.settings.name == '/') {
          print("Already on Home");
        } else {
          Navigator.popUntil(context, (route) => route.isFirst);
        }
        break;
      case 1: // Tes Perkembangan (Penilaian Diri)
        routeName = '/tesperkembangan';
        break;
      case 2: // Tes Diagnosa
        routeName = '/kuis';
        break;
      case 3: // Hasil Tes
        routeName = '/hasil';
        break;
      case 4: // My Profile
        routeName = '/profile';
        break;
      default:
        print("Invalid index: $index");
    }

    if (routeName != null) {
      print("Navigating to $routeName from current index $_selectedIndex to $index");
      if (ModalRoute.of(context)?.settings.name != '/homepage' &&
          ModalRoute.of(context)?.settings.name != '/') {
        Navigator.popUntil(context, (route) => route.isFirst);
      }
      Navigator.pushNamed(
        context,
        routeName,
        arguments: routeName == '/kuis' ? 'mental_health' : null,
      );
    }
    // setState untuk _selectedIndex tidak perlu memanggil _loadUserName lagi
    // kecuali jika pindah ke halaman home (index 0) dan Anda ingin memastikan refresh.
    // Tapi karena ini BottomNavBar di HomePage itu sendiri, _loadUserName cukup di initState.
    if (mounted) { // Pastikan widget masih ada sebelum panggil setState
        setState(() {
         _selectedIndex = index;
        });
    }
  }

  // --- METHOD _handleFeatureCardTap ANDA TETAP SAMA ---
  void _handleFeatureCardTap(
      BuildContext context, String featureName, String routeName) {
    print('$featureName card tapped, navigating to $routeName');
    Navigator.pushNamed(context, routeName);
  }

  // --- METHOD _buildGridItemCard ANDA TETAP SAMA ---
  Widget _buildGridItemCard({
    required BuildContext context,
    required String title,
    String? subtitle,
    IconData? iconData,
    String? imagePath,
    required Gradient gradient,
    required String routeName,
    bool isImageLarge = false,
  }) {
    // ... (kode _buildGridItemCard Anda yang sudah ada) ...
    // Untuk singkatnya, saya tidak salin ulang di sini, tapi di kode Anda tetap ada
    return Card(
      elevation: 2.5,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      clipBehavior: Clip.antiAlias,
      child: InkWell(
        onTap: () => _handleFeatureCardTap(context, title, routeName),
        borderRadius: BorderRadius.circular(10),
        child: Container(
          decoration: BoxDecoration(gradient: gradient),
          padding: const EdgeInsets.all(8),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              if (imagePath != null)
                Padding(
                  padding: const EdgeInsets.only(bottom: 5.0),
                  child: Image.asset(
                    imagePath,
                    height: isImageLarge ? 32 : 26,
                    width: isImageLarge ? 32 : 26,
                    fit: BoxFit.contain,
                      errorBuilder: (context, error, stackTrace) => Icon(
                      iconData ?? Icons.help_outline,
                      size: isImageLarge ? 32 : 26,
                      color: Colors.white70,
                    ),
                  ),
                )
              else if (iconData != null)
                Padding(
                  padding: const EdgeInsets.only(bottom: 5.0),
                  child: Icon(iconData, size: isImageLarge ? 32 : 26, color: Colors.white),
                ),
              Text(
                title,
                textAlign: TextAlign.center,
                style: const TextStyle(
                    fontSize: 12, 
                    fontWeight: FontWeight.bold,
                    color: Colors.white),
                maxLines: 2,
                overflow: TextOverflow.ellipsis,
              ),
              if (subtitle != null && subtitle.isNotEmpty) ...[
                const SizedBox(height: 1),
                Text(
                  subtitle,
                  textAlign: TextAlign.center,
                  style: TextStyle(
                      fontSize: 8, 
                      color: Colors.white.withOpacity(0.8)),
                  maxLines: 2,
                  overflow: TextOverflow.ellipsis,
                ),
              ],
            ],
          ),
        ),
      ),
    );
  }

  // --- DEFINISI HELPER WIDGET YANG SUDAH ADA (HEADER, SEARCHBAR, AFFIRMATIONCARD) TETAP SAMA ---
  Widget _buildHeader() {
    // ... (kode _buildHeader Anda yang sudah ada) ...
    return Padding(
      padding: const EdgeInsets.only(left: 16.0, right: 16.0, top: 16.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          const CircleAvatar(
            radius: 22,
            backgroundColor: Color(0xFFE8EAF6),
            child:
                Icon(Icons.person_outline, color: Color(0xFF7E57C2), size: 26),
          ),
          IconButton(
            icon: const Icon(Icons.notifications_none_outlined,
                color: Colors.black54, size: 28),
            onPressed: () {/* Aksi notifikasi */},
          ),
        ],
      ),
    );
  }

  Widget _buildSearchBar() {
    // ... (kode _buildSearchBar Anda yang sudah ada) ...
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 10.0),
      child: TextField(
        decoration: InputDecoration(
          hintText: 'Search..',
          hintStyle: TextStyle(color: Colors.grey.shade500),
          prefixIcon:
              Icon(Icons.search_rounded, color: Colors.grey.shade500, size: 24),
          filled: true,
          fillColor: Colors.grey.shade100,
          contentPadding:
              const EdgeInsets.symmetric(vertical: 16.0, horizontal: 20.0),
          border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(30.0),
              borderSide: BorderSide.none),
          enabledBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(30.0),
              borderSide: BorderSide.none),
          focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(30.0),
              borderSide:
                  BorderSide(color: Colors.deepPurple.shade300, width: 1.5)),
        ),
      ),
    );
  }
  
  Widget _buildAffirmationCard() {
    // ... (kode _buildAffirmationCard Anda yang sudah ada) ...
     const String affirmation = "Setiap langkah kecilmu adalah kemajuan yang berarti.";
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 25),
        decoration: BoxDecoration(
          gradient: LinearGradient(
              colors: [Colors.deepPurple.shade400, Colors.deepPurple.shade600],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight),
          borderRadius: BorderRadius.circular(18.0),
          boxShadow: [
            BoxShadow(
                color: Colors.deepPurple.withOpacity(0.25),
                spreadRadius: 2,
                blurRadius: 8,
                offset: const Offset(0, 4))
          ],
        ),
        child: Row(
          children: [
            Icon(Icons.lightbulb_outline_rounded,
                color: Colors.white.withOpacity(0.8), size: 32),
            const SizedBox(width: 15),
            Expanded(
              child: Text(affirmation,
                  style: const TextStyle(
                      fontSize: 15,
                      color: Colors.white,
                      height: 1.5,
                      fontWeight: FontWeight.w500)),
            ),
          ],
        ),
      ),
    );
  }

  // --- MODIFIKASI WIDGET _buildGreeting ---
  Widget _buildGreeting() {
    // String? userName = name ?? ""; // HAPUS BARIS INI (variabel 'name' sudah dihapus)
    String userNameToDisplay = _loggedInUserName ?? ""; // Gunakan _loggedInUserName dari state

    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _isLoadingName 
            ? Row( // Tampilkan teks "Hello, " diikuti loading indicator jika nama sedang dimuat
                children: [
                  Text('Hello, ', style: Theme.of(context).textTheme.headlineMedium?.copyWith(
                      fontWeight: FontWeight.bold, color: Colors.black87)),
                  SizedBox(
                    width: Theme.of(context).textTheme.headlineMedium?.fontSize ?? 28, // Sesuaikan ukuran agar mirip teks
                    height: Theme.of(context).textTheme.headlineMedium?.fontSize ?? 28,
                    child: const CircularProgressIndicator(strokeWidth: 2.5),
                  )
                ],
              )
            : Text( // Jika tidak loading, tampilkan nama
                'Hello, ${userNameToDisplay.isNotEmpty ? userNameToDisplay : 'Pengguna'}', // Fallback ke 'Pengguna' jika nama kosong
                style: Theme.of(context).textTheme.headlineMedium?.copyWith(
                    fontWeight: FontWeight.bold, color: Colors.black87)),
          const SizedBox(height: 5),
          Text('Bagaimana perasaanmu hari ini?',
              style: Theme.of(context)
                  .textTheme
                  .titleMedium
                  ?.copyWith(color: Colors.grey.shade700)),
        ],
      ),
    );
  }

  // --- METHOD build ANDA TETAP SAMA STRUKTURNYA ---
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: ListView(
          padding: const EdgeInsets.only(bottom: 20.0),
          children: [
            _buildHeader(),
            const SizedBox(height: 20),
            _buildGreeting(), // Ini akan memanggil _buildGreeting yang sudah dimodifikasi
            const SizedBox(height: 20),
            _buildSearchBar(),
            const SizedBox(height: 25),
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16.0),
              child: GridView.count(
                crossAxisCount: 2,
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                crossAxisSpacing: 8,
                mainAxisSpacing: 8,  
                childAspectRatio: 1.4, 
                children: [
                  _buildGridItemCard(
                    context: context,
                    title: 'Mental Health',
                    subtitle: 'Cek kondisi mental',
                    imagePath: 'assets/images/mental_health_illustration.png',
                    isImageLarge: true,
                    gradient: LinearGradient(
                        colors: [Colors.deepPurple.shade400, Colors.deepPurple.shade600],
                        begin: Alignment.topLeft,
                        end: Alignment.bottomRight),
                    routeName: '/kuis',
                  ),
                  _buildGridItemCard(
                    context: context,
                    title: 'Meditasi',
                    subtitle: 'Temukan tenang',
                    iconData: Icons.self_improvement_rounded,
                    gradient: const LinearGradient(
                        colors: [Color(0xFF6A1B9A), Color(0xFF8E24AA)],
                        begin: Alignment.topLeft,
                        end: Alignment.bottomRight),
                    routeName: '/meditasi',
                  ),
                  _buildGridItemCard(
                    context: context,
                    title: 'Quotes',
                    subtitle: 'Inspirasi harian',
                    iconData: Icons.format_quote_rounded,
                    gradient: const LinearGradient(
                        colors: [Color(0xFF00796B), Color(0xFF00897B)],
                        begin: Alignment.topLeft,
                        end: Alignment.bottomRight),
                    routeName: '/quotes',
                  ),
                  _buildGridItemCard(
                    context: context,
                    title: 'Self Care',
                    subtitle: 'Jadwalkan aktivitas',
                    iconData: Icons.event_note_rounded,
                    gradient: const LinearGradient(
                        colors: [Color(0xFFEF6C00), Color(0xFFF57C00)],
                        begin: Alignment.topLeft,
                        end: Alignment.bottomRight),
                    routeName: '/rencana',
                  ),
                ],
              ),
            ),
            const SizedBox(height: 30),
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16.0),
              child: Text(
                'Pengingat Untukmu',
                style: Theme.of(context).textTheme.titleLarge?.copyWith(
                      fontWeight: FontWeight.bold,
                      color: Colors.black.withOpacity(0.8),
                    ),
              ),
            ),
            const SizedBox(height: 15),
            _buildAffirmationCard(),
            const SizedBox(height: 20),
          ],
        ),
      ),
      bottomNavigationBar: BottomNavigationBar(
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(icon: Icon(Icons.home_filled), label: 'Home'),
          BottomNavigationBarItem(
              icon: Icon(Icons.insights_rounded), label: 'Tes Perkembangan'),
          BottomNavigationBarItem(
              icon: Icon(Icons.play_circle_outline), label: 'Tes Diagnosa'),
          BottomNavigationBarItem(
              icon: Icon(Icons.library_books_outlined), label: 'Hasil Tes'),
          BottomNavigationBarItem(
              icon: Icon(Icons.person_outline), label: 'My Profile'),
        ],
        currentIndex: _selectedIndex,
        selectedItemColor: Colors.deepPurple,
        unselectedItemColor: Colors.grey,
        showUnselectedLabels: true,
        type: BottomNavigationBarType.fixed,
        onTap: _onItemTapped,
        elevation: 5.0,
        backgroundColor: Colors.white,
      ),
    );
  }
}