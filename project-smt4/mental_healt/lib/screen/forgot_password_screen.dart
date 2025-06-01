// lib/screens/forgot_password_screen.dart
import 'package:flutter/material.dart';
import '../services/auth_service.dart'; // Pastikan path ini benar

class ForgotPasswordScreen extends StatefulWidget {
  const ForgotPasswordScreen({super.key});

  @override
  State<ForgotPasswordScreen> createState() => _ForgotPasswordScreenState();
}

class _ForgotPasswordScreenState extends State<ForgotPasswordScreen> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController();
  final AuthService _authService = AuthService(); // Instance AuthService

  bool _isLoading = false;
  String? _feedbackMessage; // Untuk menampilkan pesan langsung di UI (opsional)
  bool _isSuccess = false; // Untuk membedakan style pesan feedback

  @override
  void dispose() {
    _emailController.dispose();
    super.dispose();
  }

  Future<void> _sendResetLink() async {
    // Bersihkan pesan feedback sebelumnya
    if (mounted) {
      setState(() {
        _feedbackMessage = null;
        _isSuccess = false;
      });
    }

    if (_formKey.currentState!.validate()) {
      if (mounted) {
        setState(() {
          _isLoading = true;
        });
      }

      try {
        final response = await _authService.requestPasswordReset(_emailController.text.trim());
        // API Laravel Anda mengembalikan Map dengan 'success' dan 'message'
        if (mounted) {
          final message = response['message'] ?? 'Permintaan berhasil diproses.';
          setState(() {
            _feedbackMessage = message;
            _isSuccess = response['success'] ?? false;
          });
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: Text(message),
              backgroundColor: (response['success'] ?? false) ? Colors.green : Colors.red,
            ),
          );
          if (response['success'] == true) {
            // Opsional: Anda bisa biarkan pengguna di halaman ini untuk melihat pesan,
            // atau otomatis kembali setelah beberapa detik, atau tambahkan tombol "Kembali ke Login".
            // Untuk contoh ini, kita tampilkan pesan dan biarkan pengguna kembali manual atau via tombol "Kembali ke Login".
            _emailController.clear(); // Bersihkan field email setelah sukses
          }
        }
      } catch (e) {
        if (mounted) {
          final errorMessage = e.toString().replaceFirst("Exception: ", "");
          setState(() {
            _feedbackMessage = errorMessage;
            _isSuccess = false;
          });
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text(errorMessage), backgroundColor: Colors.red),
          );
        }
      } finally {
        if (mounted) {
          setState(() {
            _isLoading = false;
          });
        }
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Lupa Password'),
        elevation: 1.0,
      ),
      body: Center(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(24.0),
          child: ConstrainedBox(
            constraints: const BoxConstraints(maxWidth: 500), // Batasan lebar untuk web
            child: Form(
              key: _formKey,
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: <Widget>[
                  Icon(Icons.email_outlined, size: 70, color: Theme.of(context).primaryColor),
                  const SizedBox(height: 20),
                  const Text(
                    'Temukan Akun Anda',
                    textAlign: TextAlign.center,
                    style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 12),
                  const Text(
                    'Masukkan alamat email Anda yang terdaftar. Kami akan mengirimkan instruksi untuk mereset password Anda.',
                    textAlign: TextAlign.center,
                    style: TextStyle(fontSize: 15, color: Colors.grey),
                  ),
                  const SizedBox(height: 30),
                  TextFormField(
                    controller: _emailController,
                    decoration: InputDecoration(
                      labelText: 'Email Terdaftar',
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
                    textInputAction: TextInputAction.done,
                    onFieldSubmitted: (_) => _isLoading ? null : _sendResetLink(),
                    enabled: !_isLoading,
                  ),
                  const SizedBox(height: 24),

                  // Menampilkan pesan feedback langsung di UI (opsional)
                  if (_feedbackMessage != null && !_isLoading)
                    Padding(
                      padding: const EdgeInsets.only(bottom: 12.0),
                      child: Text(
                        _feedbackMessage!,
                        textAlign: TextAlign.center,
                        style: TextStyle(
                          color: _isSuccess ? Colors.green.shade700 : Colors.red.shade700,
                          fontSize: 14.5,
                        ),
                      ),
                    ),

                  ElevatedButton(
                    onPressed: _isLoading ? null : _sendResetLink,
                    style: ElevatedButton.styleFrom(
                      padding: const EdgeInsets.symmetric(vertical: 16),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10.0)),
                    ),
                    child: _isLoading
                        ? const SizedBox(
                            width: 20,
                            height: 20,
                            child: CircularProgressIndicator(strokeWidth: 2.5, color: Colors.white),
                          )
                        : const Text('Kirim Instruksi Reset', style: TextStyle(fontSize: 16)),
                  ),
                  const SizedBox(height: 16),
                  TextButton(
                    onPressed: _isLoading ? null : () {
                      if (Navigator.canPop(context)) {
                        Navigator.pop(context); // Kembali ke halaman login
                      }
                    },
                    child: const Text('Kembali ke Login'),
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