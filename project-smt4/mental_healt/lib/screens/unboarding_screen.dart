import 'package:flutter/material.dart';
import 'package:smooth_page_indicator/smooth_page_indicator.dart';

class unboarding_screen extends StatefulWidget {
  const unboarding_screen({super.key});

  @override
  State<unboarding_screen> createState() => _OnboardingScreenState();
}

class _OnboardingScreenState extends State<unboarding_screen> {
  final PageController _controller = PageController();
  bool onLastPage = false;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          PageView(
            controller: _controller,
            onPageChanged: (index) {
              setState(() {
                onLastPage = (index == 2);
              });
            },
            children: [
              buildPage(
                  image: 'assets/images/onboarding1.png',
                  title: 'Welcome to Diagnosa Mobile',
                  desc:
                      'Selamat datang di ruang tenangmu. Di sini, kamu tak sendiri. Mari jaga kesehatan mental bersama, satu langkah kecil setiap harinya.'),
              buildPage(
                  image: 'assets/images/onboarding2.png',
                  title: 'Your Health, Simplified',
                  desc:
                      'Kesehatan mental adalah perjalanan, bukan perlombaan. Terima kasih sudah memilih melangkah hari ini. Kami siap menemanimu di setiap langkahnya.'),
              buildPage(
                  image: 'assets/images/onboarding3.png',
                  title: 'Get Started with Diagnosa Mobile',
                  desc:
                      'Sekarang saatnya mulai perjalananmu bersama Diagnosa Mobile. Yuk, kenali dirimu lebih dalam dan jaga kesehatan mentalmu, mulai dari hari ini.'),
            ],
          ),

          // Indikator Halaman
          Positioned(
            bottom: 100, // sedikit naik
            left: 0,
            right: 0,
            child: Center(
              child: SmoothPageIndicator(
                controller: _controller,
                count: 3,
                effect: WormEffect(
                  dotColor: Colors.grey,
                  activeDotColor: Colors.blue,
                  dotHeight: 10,
                  dotWidth: 10,
                ),
              ),
            ),
          ),

          // Tombol Selanjutnya/Mulai
          Positioned(
            bottom: 40, // naikkan posisi tombol
            left: 40,
            right: 40,
            child: ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.blue, // ubah warna tombol jadi biru
                padding: const EdgeInsets.symmetric(vertical: 16),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
              ),
              onPressed: () {
                if (onLastPage) {
                  Navigator.pushReplacementNamed(context, '/login');
                } else {
                  _controller.nextPage(
                    duration: const Duration(milliseconds: 500),
                    curve: Curves.easeIn,
                  );
                }
              },
              child: Text(
                onLastPage ? 'Mulai' : 'Selanjutnya',
                style: const TextStyle(
                  fontSize: 16,
                  color: Colors.white,
                ),
              ),
            ),
          )
        ],
      ),
    );
  }

  Widget buildPage({required String image, required String title, required String desc}) {
    return Padding(
      padding: const EdgeInsets.all(40),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Image.asset(image, height: 250),
          const SizedBox(height: 30),
          Text(
            title,
            style: const TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 20),
          Text(
            desc,
            style: const TextStyle(
              fontSize: 16,
              color: Colors.black54,
              fontFamily: 'itim',
              fontStyle: FontStyle.italic,
              letterSpacing: 0.5,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }
}