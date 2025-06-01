// lib/screens/reset_password_screen.dart
import 'package:flutter/material.dart';
import '../services/auth_service.dart'; // Sesuaikan path jika perlu

class ResetPasswordScreen extends StatefulWidget {
  final String? initialToken; // Bisa diisi dari deep link atau navigasi berparameter
  final String? initialEmail; // Bisa diisi dari deep link atau navigasi berparameter

  const ResetPasswordScreen({
    super.key,
    this.initialToken,
    this.initialEmail,
  });

  @override
  State<ResetPasswordScreen> createState() => _ResetPasswordScreenState();
}

class _ResetPasswordScreenState extends State<ResetPasswordScreen> {
  final _formKey = GlobalKey<FormState>();
  final AuthService _authService = AuthService();

  late TextEditingController _tokenController;
  late TextEditingController _emailController;
  final _passwordController = TextEditingController();
  final _confirmPasswordController = TextEditingController();

  bool _isLoading = false;
  String? _feedbackMessage;
  bool _isSuccess = false;
  bool _obscurePassword = true;
  bool _obscureConfirmPassword = true;

 @override
  void initState() {
    super.initState();
    // Isi field token dan email jika dikirim sebagai argumen
    _tokenController = TextEditingController(text: widget.initialToken ?? '');
    _emailController = TextEditingController(text: widget.initialEmail ?? '');
    print("ResetPasswordScreen initState: Token: '${widget.initialToken}', Email: '${widget.initialEmail}'");
  }

  @override
  void dispose() {
    _tokenController.dispose();
    _emailController.dispose();
    _passwordController.dispose();
    _confirmPasswordController.dispose();
    super.dispose();
  }

  Future<void> _submitResetPassword() async {
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
        final response = await _authService.submitNewPassword(
          token: _tokenController.text.trim(),
          email: _emailController.text.trim(),
          password: _passwordController.text,
          passwordConfirmation: _confirmPasswordController.text,
        );

        if (mounted) {
           final message = response['message'] ?? 'Password berhasil direset!';
           setState(() { 
             _feedbackMessage = message; 
             _isSuccess = true; 
            });
           ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text(message), backgroundColor: Colors.green, duration: const Duration(seconds: 3)),
          );
          
          // Navigasi ke halaman login setelah berhasil reset
          // Membersihkan stack navigasi sampai halaman login (jika login bukan root)
          // atau kembali ke root lalu push login.
          if (Navigator.canPop(context)) { // Jika bisa kembali beberapa kali
             Navigator.of(context).popUntil((route) => route.settings.name == '/login' || route.isFirst);
             // Jika halaman login bukan halaman pertama, dan ingin memastikan kembali ke sana:
             if (ModalRoute.of(context)?.settings.name != '/login') {
                Navigator.pushReplacementNamed(context, '/login');
             }
          } else { // Jika tidak bisa pop (misal dibuka dari deep link langsung)
            Navigator.pushReplacementNamed(context, '/login');
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
        title: const Text('Atur Password Baru'),
        elevation: 1.0,
         leading: Navigator.canPop(context) ? IconButton(
          icon: const Icon(Icons.arrow_back),
          onPressed: () => Navigator.of(context).pop(),
        ) : null,
      ),
      body: Center(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(24.0),
           child: ConstrainedBox(
            constraints: const BoxConstraints(maxWidth: 500),
            child: Form(
              key: _formKey,
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: <Widget>[
                  Icon(Icons.lock_open_rounded, size: 60, color: Theme.of(context).primaryColor),
                  const SizedBox(height: 20),
                  const Text(
                    'Buat Password Baru Anda',
                    textAlign: TextAlign.center,
                    style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 12),
                  Text(
                    'Masukkan token dari email, email terdaftar Anda, dan password baru.',
                    textAlign: TextAlign.center, style: TextStyle(fontSize: 15, color: Colors.grey.shade700),
                  ),
                  const SizedBox(height: 30),
                  
                  TextFormField(
                    controller: _tokenController,
                    decoration: InputDecoration(
                      labelText: 'Token Reset', 
                      hintText: 'Salin & tempel token dari email',
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(10.0)), 
                      prefixIcon: const Icon(Icons.vpn_key_outlined)
                    ),
                    validator: (value) => value == null || value.trim().isEmpty ? 'Token tidak boleh kosong' : null,
                    textInputAction: TextInputAction.next,
                    enabled: !_isLoading,
                  ),
                  const SizedBox(height: 16),
                  
                  TextFormField(
                    controller: _emailController,
                    decoration: InputDecoration(
                      labelText: 'Email Terdaftar', 
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(10.0)), 
                      prefixIcon: const Icon(Icons.email_outlined)
                    ),
                    keyboardType: TextInputType.emailAddress,
                    // Jika initialEmail ada (misalnya dari deep link), bisa dibuat readOnly
                    readOnly: widget.initialEmail != null && widget.initialEmail!.isNotEmpty, 
                    validator: (value) { 
                       if (value == null || value.trim().isEmpty) return 'Email tidak boleh kosong';
                       if (!RegExp(r"^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[a-zA-Z]+").hasMatch(value)) return 'Format email tidak valid';
                       return null;
                    },
                    textInputAction: TextInputAction.next,
                    enabled: !_isLoading,
                  ),
                  const SizedBox(height: 16),

                  TextFormField(
                    controller: _passwordController,
                    decoration: InputDecoration(
                      labelText: 'Password Baru', 
                      hintText: 'Minimal 6 karakter',
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(10.0)), 
                      prefixIcon: const Icon(Icons.lock_outline_rounded),
                      suffixIcon: IconButton(
                        icon: Icon(_obscurePassword ? Icons.visibility_off_outlined : Icons.visibility_outlined),
                        onPressed: () => setState(()=> _obscurePassword = !_obscurePassword),
                      )
                    ),
                    obscureText: _obscurePassword,
                    validator: (value) {
                      if (value == null || value.isEmpty) return 'Password baru tidak boleh kosong';
                      if (value.length < 6) return 'Password minimal 6 karakter';
                      return null;
                    },
                    textInputAction: TextInputAction.next,
                    enabled: !_isLoading,
                  ),
                  const SizedBox(height: 16),

                  TextFormField(
                    controller: _confirmPasswordController,
                    decoration: InputDecoration(
                      labelText: 'Konfirmasi Password Baru', 
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(10.0)), 
                      prefixIcon: const Icon(Icons.lock_person_outlined),
                       suffixIcon: IconButton(
                        icon: Icon(_obscureConfirmPassword ? Icons.visibility_off_outlined : Icons.visibility_outlined),
                        onPressed: () => setState(()=> _obscureConfirmPassword = !_obscureConfirmPassword),
                      )
                    ),
                    obscureText: _obscureConfirmPassword,
                    validator: (value) {
                      if (value == null || value.isEmpty) return 'Konfirmasi password tidak boleh kosong';
                      if (value != _passwordController.text) return 'Konfirmasi password tidak cocok';
                      return null;
                    },
                    textInputAction: TextInputAction.done,
                    onFieldSubmitted: (_) => _isLoading ? null : _submitResetPassword(),
                    enabled: !_isLoading,
                  ),
                  const SizedBox(height: 24),

                  if (_feedbackMessage != null && !_isLoading)
                    Padding(
                      padding: const EdgeInsets.only(bottom: 12.0),
                      child: Text(
                        _feedbackMessage!,
                        textAlign: TextAlign.center,
                        style: TextStyle(color: _isSuccess ? Colors.green.shade700 : Colors.red.shade700, fontSize: 14.5),
                      ),
                    ),

                  ElevatedButton(
                    onPressed: _isLoading ? null : _submitResetPassword,
                    style: ElevatedButton.styleFrom(padding: const EdgeInsets.symmetric(vertical: 16), shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10.0))),
                    child: _isLoading
                        ? const SizedBox(width: 20, height: 20, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2.5))
                        : const Text('Reset Password Saya', style: TextStyle(fontSize: 16)),
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