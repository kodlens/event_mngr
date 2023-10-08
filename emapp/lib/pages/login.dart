import 'package:flutter/material.dart';


class Login extends StatefulWidget {
  const Login({super.key});

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {

  final usernameController = TextEditingController();
  final passwordController = TextEditingController();


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(
                'Welcome to EMAPP!',
                style: TextStyle(
                  color: Colors.grey[700],
                  fontSize: 16,
                  fontWeight: FontWeight.bold
                ),
              ),



              //Texfield
              Padding(
                padding: const EdgeInsets.fromLTRB(20, 20, 20, 0),
                child: TextFormField(
                  decoration: const InputDecoration(
                      border: OutlineInputBorder(), labelText: "Username"),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please enter your username';
                    }
                    return null;
                  },
                  controller: usernameController,
                ),
              ),



              const SizedBox(height: 10),



             //password
              Padding(
                padding: const EdgeInsets.fromLTRB(20, 0, 20, 0),
                child: TextFormField(
                  obscureText: true,
                  decoration: const InputDecoration(
                      border: OutlineInputBorder(), labelText: "Password"),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please enter your password';
                    }
                    return null;
                  },
                  controller: passwordController,
                ),
              ),


              const SizedBox(height: 20),


              Padding(
                padding: const EdgeInsets.fromLTRB(20, 0, 20, 0),
                child: ElevatedButton(
                  onPressed: () {
                    print('login clicked');
                  },
                  style: ElevatedButton.styleFrom(
                    minimumSize: const Size.fromHeight(50), // NEW
                  ),
                  child: const Text('LOGIN'),
                ),
              ),


            ],
          ),
        ),
      ),
    );
  }
}
