import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:web_directory/provider/entree_provider.dart';

import 'screen/entree_master.dart';

void main() {
  runApp(ChangeNotifierProvider(
      create: (BuildContext context) => EntreeProvider(),
      child: const MainApp()
    ));
}

class MainApp extends StatelessWidget {
  const MainApp({super.key});

  @override
  Widget build(BuildContext context) {
    return  MaterialApp(
      theme: themeClair(),
      darkTheme: themeSombre(),

      home: const Home(),
    );
  }

  ThemeData themeClair() {
    return ThemeData(
      colorScheme: ColorScheme.fromSeed(
        brightness: Brightness.light,
        seedColor: Colors.green,
        surface: Colors.green,
        primary: Colors.green,
        onPrimary: Colors.white,
      ),
      textTheme: const TextTheme(
        titleLarge: TextStyle(
          color: Colors.white,
          fontWeight: FontWeight.bold,
        ),  
        titleMedium: TextStyle(
          color: Colors.green,
        )
      ),
    );
  }



  ThemeData themeSombre() {
    return ThemeData(
      colorScheme: ColorScheme.fromSeed(
        surface: Colors.green,
        brightness: Brightness.dark,
        seedColor: Colors.green,
      ),
      textTheme: const TextTheme(
        titleLarge: TextStyle(
          color: Colors.white,
          fontWeight: FontWeight.bold,
        ),  
      ),
    );
  }
}

class Home extends StatelessWidget {
  const Home({
    super.key,
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Theme.of(context).colorScheme.surface,
        title: Text('Annuaire des contacts', style : Theme.of(context).textTheme.titleLarge),
      ),
      body: Center(
        child: FutureBuilder(
          future: Provider.of<EntreeProvider>(context, listen: false).fetchEntrees(),
          builder: (BuildContext context, AsyncSnapshot snapshot) {
            if (snapshot.hasData) {
              return const EntreeMaster();
            }else if(snapshot.hasError){
              return Text('Error: ${snapshot.error}');
            }
            else {
              return const CircularProgressIndicator();
            }
          },
        ),
      ),
    );
  }
}
