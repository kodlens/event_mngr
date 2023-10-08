import 'package:flutter/material.dart';
import 'package:emapp/pages/login.dart';


void main() {
  runApp(MaterialApp(
    initialRoute: '/',
    routes: {
      '/': (context) => Login()
    },
  ));
}

