// lib/screens/login_screen.dart
import 'package:flutter/material.dart';
import '../services/auth_service.dart'; // Sesuaikan path jika perlu

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final AuthService _authService = AuthService();

  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  bool _isLoading = false;
  String? _errorMessage;
  bool _obscurePassword = true;

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  Future<void> _attemptLogin() async {
    if (mounted) {
      setState(() {
        _errorMessage = null; // Bersihkan error lama
      });
    }

    if (_formKey.currentState?.validate() ?? false) {
      if (mounted) {
        setState(() {
          _isLoading = true;
        });
      }

      try {
        final response = await _authService.login(
          _emailController.text.trim(),
          _passwordController.text,
        );

        if (mounted) {
          print('LoginScreen: Login Berhasil! Data: $response');
          // Di sini, Anda tidak perlu menampilkan SnackBar sukses jika langsung navigasi.
          // Cukup navigasi ke halaman utama.
          Navigator.pushReplacementNamed(context, '/homepage'); // Ganti dengan nama rute home Anda
        }
      } catch (e) {
        if (mounted) {
          setState(() {
            _errorMessage = e.toString().replaceFirst("Exception: ", "");
          });
        }
      } finally {
        if (mounted) {
          setState(() {
            _isLoading = false;
          });
        }
      }
    } else {
      if (mounted) {
        setState(() {
          _errorMessage = "Harap isi email dan password dengan benar.";
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 24.0, vertical: 16.0),
          child: ConstrainedBox(
            constraints: const BoxConstraints(maxWidth: 400), // Batasan lebar untuk tampilan web/tablet
            child: Form(
              key: _formKey,
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  // Logo dan Judul
                  Image.asset(
                    'assets/images/logo.png', // Pastikan path logo ini benar
                    height: 80, // Ukuran disesuaikan
                    errorBuilder: (context, error, stackTrace) => 
                        const Icon(Icons.health_and_safety, size: 80, color: Colors.blueAccent),
                  ),
                  const SizedBox(height: 20),
                  const Text(
                    'Diagnosa', // Atau 'Selamat Datang Kembali'
                    textAlign: TextAlign.center,
                    style: TextStyle(fontSize: 28, fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 8),
                  const Text(
                    'Silakan masuk ke akun Anda.',
                    textAlign: TextAlign.center,
                    style: TextStyle(fontSize: 16, color: Colors.grey),
                  ),
                  const SizedBox(height: 40),

                  // Input Email
                  TextFormField(
                    controller: _emailController,
                    decoration: InputDecoration(
                      labelText: 'Email Address',
                      prefixIcon: const Icon(Icons.email_outlined),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(10.0)),
                    ),
                    keyboardType: TextInputType.emailAddress,
                    validator: (value) {
                      if (value == null || value.trim().isEmpty) return 'Email tidak boleh kosong';
                      if (!RegExp(r"^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[a-zA-Z]+").hasMatch(value)) {
                        return 'Format email tidak valid';
                      }
                      return null;
                    },
                    textInputAction: TextInputAction.next,
                    enabled: !_isLoading,
                  ),
                  const SizedBox(height: 20),

                  // Input Password
                  TextFormField(
                    controller: _passwordController,
                    obscureText: _obscurePassword,
                    decoration: InputDecoration(
                      labelText: 'Password',
                      prefixIcon: const Icon(Icons.lock_outline),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(10.0)),
                      suffixIcon: IconButton(
                        icon: Icon(_obscurePassword ? Icons.visibility_off_outlined : Icons.visibility_outlined),
                        onPressed: () => setState(() => _obscurePassword = !_obscurePassword),
                      ),
                    ),
                    validator: (value) {
                      if (value == null || value.isEmpty) return 'Password tidak boleh kosong';
                      // if (value.length < 6) return 'Password minimal 6 karakter'; // Sesuaikan jika perlu
                      return null;
                    },
                    textInputAction: TextInputAction.done,
                    onFieldSubmitted: (_) => _isLoading ? null : _attemptLogin(),
                    enabled: !_isLoading,
                  ),
                  const SizedBox(height: 10),

                  // Forgot Password
                  Align(
                    alignment: Alignment.centerRight,
                    child: TextButton(
                      // Tombol akan dinonaktifkan jika _isLoading true
                      onPressed: _isLoading ? null : () {
                        print("LoginScreen: Tombol 'Forgot Password?' ditekan.");
                        // Pastikan rute '/forgot-password' sudah didefinisikan di main.dart
                        Navigator.pushNamed(context, '/forgot-password');
                      },
                      child: const Text('Forgot Password?'),
                    ),
                  ),
                  const SizedBox(height: 10),

                  // Menampilkan pesan error API jika ada
                  if (_errorMessage != null)
                    Padding(
                      padding: const EdgeInsets.only(bottom: 12.0),
                      child: Text(
                        _errorMessage!,
                        style: const TextStyle(color: Colors.red, fontSize: 14.0),
                        textAlign: TextAlign.center,
                      ),
                    ),
                  
                  // Tombol Masuk
                  ElevatedButton(
                    onPressed: _isLoading ? null : _attemptLogin,
                    style: ElevatedButton.styleFrom(
                      // backgroundColor: Colors.blue, // Sesuaikan dengan tema Anda
                      padding: const EdgeInsets.symmetric(vertical: 16),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10.0)),
                    ),
                    child: _isLoading
                        ? const SizedBox(width: 24, height: 24, child: CircularProgressIndicator(strokeWidth: 3, color: Colors.white))
                        : const Text('Masuk', style: TextStyle(fontSize: 16)),
                  ),
                  const SizedBox(height: 20),

                  // Link ke Halaman Sign Up
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      const Text('Don’t have an account?'),
                      TextButton(
                        onPressed: _isLoading ? null : () {
                          // Pastikan rute '/signup' (atau '/register') sudah didefinisikan di main.dart
                          // dan mengarah ke RegisterScreen/SignUpScreen Anda
                          Navigator.pushNamed(context, '/signup');
                        },
                        child: const Text('Sign up now'),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}