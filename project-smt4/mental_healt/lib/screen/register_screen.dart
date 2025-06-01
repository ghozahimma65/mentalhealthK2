// lib/screens/register_screen.dart (atau signup_screen.dart)

import 'package:flutter/material.dart';
import 'dart:convert'; // Mungkin tidak langsung digunakan di sini, tapi baik ada jika suatu saat parse error manual
import '../services/auth_service.dart'; // Sesuaikan path jika service Anda ada di folder lain

class RegisterScreen extends StatefulWidget {
  // Jika Anda menggunakan nama kelas SignUpScreen di main.dart, ganti nama kelas ini
  const RegisterScreen({super.key});

  @override
  State<RegisterScreen> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  final _formKey = GlobalKey<FormState>();
  final AuthService _authService = AuthService();

  // Controllers untuk setiap TextField
  final _nameController = TextEditingController();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  final _confirmPasswordController = TextEditingController();

  bool _isLoading = false; // State untuk menunjukkan proses loading
  String? _errorMessage; // Untuk menampilkan pesan error dari API atau validasi di UI

  bool _obscurePassword = true; // State untuk toggle visibilitas password
  bool _obscureConfirmPassword = true; // State untuk toggle visibilitas konfirmasi password

  @override
  void initState() {
    super.initState();
    print("RegisterScreen: initState() dipanggil");
  }

  @override
  void dispose() {
    print("RegisterScreen: dispose() dipanggil");
    _nameController.dispose();
    _emailController.dispose();
    _passwordController.dispose();
    _confirmPasswordController.dispose();
    super.dispose();
  }

  Future<void> _attemptRegister() async {
    print("RegisterScreen: _attemptRegister() dipanggil");
    // Bersihkan error message lama
    if (mounted) {
      setState(() {
        _errorMessage = null;
      });
    }

    // Validasi form
    if (_formKey.currentState?.validate() ?? false) {
      print("RegisterScreen: Form valid.");
      if (mounted) {
        setState(() {
          _isLoading = true; // Mulai loading
        });
      }
      print("RegisterScreen: _isLoading = true. Memanggil AuthService.register...");

      try {
        // Panggil service untuk registrasi
        final response = await _authService.register(
          name: _nameController.text.trim(),
          email: _emailController.text.trim(),
          password: _passwordController.text,
          passwordConfirmation: _confirmPasswordController.text,
        );

        print("RegisterScreen: Panggilan AuthService.register berhasil. Respons: ${response['message']}");

        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: Text(response['message'] ?? 'Registrasi berhasil! Silakan login.'),
              backgroundColor: Colors.green,
              duration: const Duration(seconds: 3),
            ),
          );
          // Kembali ke halaman sebelumnya (diasumsikan LoginScreen)
          if (Navigator.canPop(context)) {
            Navigator.pop(context);
          } else {
            // Fallback jika tidak bisa di-pop
            Navigator.pushReplacementNamed(context, '/login'); // Pastikan rute '/login' ada
            print("RegisterScreen: Sukses register, tidak bisa pop, navigasi ke /login");
          }
        }
      } catch (e) {
        print("RegisterScreen: Exception ditangkap di _attemptRegister: $e");
        if (mounted) {
          setState(() {
            _errorMessage = e.toString().replaceFirst("Exception: ", "");
          });
        }
      } finally {
        print("RegisterScreen: Blok finally di _attemptRegister. Mengatur _isLoading = false.");
        if (mounted) {
          setState(() {
            _isLoading = false; // Hentikan loading
          });
        }
      }
    } else {
      print("RegisterScreen: Form tidak valid.");
      if (mounted) {
        setState(() {
          _errorMessage = "Harap lengkapi semua field dengan benar.";
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    print("RegisterScreen: build() dipanggil. _isLoading: $_isLoading, _errorMessage: $_errorMessage");
    return Scaffold(
      appBar: AppBar(
        title: const Text('Buat Akun Baru'),
        leading: Navigator.canPop(context) ? IconButton(
          icon: const Icon(Icons.arrow_back),
          onPressed: () {
            if (!_isLoading) { // Hanya izinkan pop jika tidak sedang loading
              Navigator.of(context).pop();
            }
          },
        ) : null,
      ),
      body: Center(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 24.0, vertical: 16.0),
          child: ConstrainedBox(
            constraints: const BoxConstraints(maxWidth: 500), // Batasan lebar untuk tampilan web
            child: Form(
              key: _formKey,
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: <Widget>[
                  // Header (Icon and Title)
                  Padding(
                    padding: const EdgeInsets.only(bottom: 24.0),
                    child: Column(
                      children: [
                        Icon(Icons.person_add_alt_1_rounded, size: 60, color: Theme.of(context).primaryColor),
                        const SizedBox(height: 12),
                        Text(
                          'Selamat Datang!',
                          textAlign: TextAlign.center,
                          style: Theme.of(context).textTheme.headlineSmall?.copyWith(fontWeight: FontWeight.bold),
                        ),
                         const SizedBox(height: 4),
                        const Text(
                          'Silakan isi detail di bawah untuk membuat akun baru.',
                          textAlign: TextAlign.center,
                          style: TextStyle(fontSize: 15, color: Colors.grey),
                        ),
                      ],
                    ),
                  ),

                  // Input Nama
                  TextFormField(
                    controller: _nameController,
                    decoration: InputDecoration(
                      labelText: 'Nama Lengkap',
                      hintText: 'Masukkan nama lengkap Anda',
                      prefixIcon: const Icon(Icons.person_outline_rounded),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(10.0)),
                    ),
                    validator: (value) {
                      if (value == null || value.trim().isEmpty) {
                        return 'Nama tidak boleh kosong';
                      }
                      return null;
                    },
                    textInputAction: TextInputAction.next,
                    enabled: !_isLoading, // Disable saat loading
                  ),
                  const SizedBox(height: 16),

                  // Input Email
                  TextFormField(
                    controller: _emailController,
                    decoration: InputDecoration(
                      labelText: 'Email',
                      hintText: 'contoh@email.com',
                      prefixIcon: const Icon(Icons.email_outlined),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(10.0)),
                    ),
                    keyboardType: TextInputType.emailAddress,
                    validator: (value) {
                      if (value == null || value.trim().isEmpty) {
                        return 'Email tidak boleh kosong';
                      }
                      if (!RegExp(r"^[a-zA-Z0-9.a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9]+\.[a-zA-Z]+").hasMatch(value)) {
                        return 'Masukkan format email yang valid';
                      }
                      return null;
                    },
                    textInputAction: TextInputAction.next,
                    enabled: !_isLoading,
                  ),
                  const SizedBox(height: 16),

                  // Input Password
                  TextFormField(
                    controller: _passwordController,
                    decoration: InputDecoration(
                      labelText: 'Password',
                      hintText: 'Minimal 6 karakter',
                      prefixIcon: const Icon(Icons.lock_outline_rounded),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(10.0)),
                      suffixIcon: IconButton(
                        icon: Icon(_obscurePassword ? Icons.visibility_off_outlined : Icons.visibility_outlined),
                        onPressed: () => setState(() => _obscurePassword = !_obscurePassword),
                      ),
                    ),
                    obscureText: _obscurePassword,
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'Password tidak boleh kosong';
                      }
                      if (value.length < 6) { // Sesuaikan dengan aturan min:6 backend
                        return 'Password minimal 6 karakter';
                      }
                      return null;
                    },
                    textInputAction: TextInputAction.next,
                    enabled: !_isLoading,
                  ),
                  const SizedBox(height: 16),

                  // Input Konfirmasi Password
                  TextFormField(
                    controller: _confirmPasswordController,
                    decoration: InputDecoration(
                      labelText: 'Konfirmasi Password',
                      hintText: 'Ketik ulang password Anda',
                      prefixIcon: const Icon(Icons.lock_person_outlined),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(10.0)),
                       suffixIcon: IconButton(
                        icon: Icon(_obscureConfirmPassword ? Icons.visibility_off_outlined : Icons.visibility_outlined),
                        onPressed: () => setState(() => _obscureConfirmPassword = !_obscureConfirmPassword),
                      ),
                    ),
                    obscureText: _obscureConfirmPassword,
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'Konfirmasi password tidak boleh kosong';
                      }
                      if (value != _passwordController.text) {
                        return 'Konfirmasi password tidak cocok';
                      }
                      return null;
                    },
                    textInputAction: TextInputAction.done,
                    onFieldSubmitted: (_) => _isLoading ? null : _attemptRegister(),
                    enabled: !_isLoading,
                  ),
                  const SizedBox(height: 20),

                  // Tampilkan pesan error dari API
                  if (_errorMessage != null)
                    Padding(
                      padding: const EdgeInsets.only(bottom: 10.0),
                      child: Text(
                        _errorMessage!,
                        style: const TextStyle(color: Colors.red, fontSize: 14.0),
                        textAlign: TextAlign.center,
                      ),
                    ),
                  const SizedBox(height: 10),

                  // Tombol Daftar
                  ElevatedButton(
                    style: ElevatedButton.styleFrom(
                      padding: const EdgeInsets.symmetric(vertical: 16),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10.0)),
                      // backgroundColor: Theme.of(context).primaryColor, // Bisa diatur via tema
                      // foregroundColor: Colors.white,
                    ),
                    onPressed: _isLoading ? null : _attemptRegister,
                    child: _isLoading
                        ? const SizedBox(
                            width: 24, // Ukuran disesuaikan agar pas di tombol
                            height: 24,
                            child: CircularProgressIndicator(strokeWidth: 3, color: Colors.white),
                          )
                        : const Text('Daftar Sekarang', style: TextStyle(fontSize: 16)),
                  ),
                  const SizedBox(height: 12),

                  // Link ke Halaman Login
                  TextButton(
                    onPressed: _isLoading ? null : () { // Nonaktifkan juga saat loading
                       if (Navigator.canPop(context)) {
                          Navigator.pop(context);
                        } else {
                          // Fallback jika tidak bisa di-pop, navigasi ke login
                          Navigator.pushReplacementNamed(context, '/login');
                        }
                    },
                    child: const Text('Sudah punya akun? Masuk'),
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