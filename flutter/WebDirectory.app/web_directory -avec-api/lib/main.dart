import 'package:flutter/material.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:provider/provider.dart';
import 'package:web_directory/provider/entree_provider.dart';
import 'package:web_directory/screen/entree_maps.dart';

import 'screen/entree_master.dart';

void main() async {
  await dotenv.load(fileName: "assets/.env");
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
        seedColor: const Color.fromARGB(255, 62, 143, 64),
        surface: const Color.fromARGB(255, 227, 250, 228),
        primary: const Color.fromARGB(255, 62, 143, 64),
        onPrimary: Colors.white,
        secondary: const Color.fromARGB(255, 235, 255, 226),
        tertiary: Colors.black,
      ),
      textTheme: const TextTheme(
        titleLarge: TextStyle(
          color: Colors.white,
          fontWeight: FontWeight.bold,
        ),  
        titleMedium: TextStyle(
          color:Color.fromARGB(255, 62, 143, 64),
        ),
      ),
      appBarTheme: const AppBarTheme(
        iconTheme: IconThemeData(
          color: Colors.white,
        ),
      ),
    );
  }



  ThemeData themeSombre() {
    return ThemeData(
      scaffoldBackgroundColor: const Color.fromARGB(255, 36, 36, 34),
      colorScheme: ColorScheme.fromSeed(
        brightness: Brightness.dark,
        seedColor:const Color.fromARGB(255, 255, 255, 255),
        surface: const Color.fromARGB(255, 105, 122, 105),
        primary: const Color.fromARGB(255, 62, 143, 64),
        onPrimary: Colors.white,
        secondary: const Color.fromARGB(255, 44, 44, 42),
        tertiary: Colors.white,
      ),
      textTheme: const TextTheme(
        titleLarge: TextStyle(
          color: Colors.white,
          fontWeight: FontWeight.bold,
        ),  
        titleMedium: TextStyle(
          color:Color.fromARGB(255, 255, 255, 255),
        ),
      ),
      appBarTheme: const AppBarTheme(
        iconTheme: IconThemeData(
          color: Colors.white,
        ),
      ),
    );
  }
}

class Home extends StatefulWidget {
  const Home({
    super.key,
  });

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  int _currentIndex = 0;
  final List<Widget> _pages = [
    const EntreeMaster(),
    const EntreeMaps(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Theme.of(context).colorScheme.primary,
        title: Text('Annuaire des contacts', style : Theme.of(context).textTheme.titleLarge),
      ),
      body: Center(
        child: FutureBuilder(
          future: Provider.of<EntreeProvider>(context, listen: false).fetchEntrees(),
          builder: (BuildContext context, AsyncSnapshot snapshot) {
            if (snapshot.hasData){
              return _pages[_currentIndex];
            }else if(snapshot.hasError){
              return const Text('impossible de charger les données');
            }
            else {
              return const CircularProgressIndicator();
            }
          },
        ),
      ),
      bottomNavigationBar: BottomNavigationBar(
        backgroundColor: Theme.of(context).colorScheme.primary,
        selectedItemColor: Colors.white,
        unselectedItemColor: const Color.fromARGB(255, 153, 153, 153),
        currentIndex: _currentIndex,
        onTap: (int index) {
          setState(() {
            _currentIndex = index;
          });
        },
        items : const <BottomNavigationBarItem>[
          BottomNavigationBarItem(
            icon: Icon(Icons.home),
            label: "Home",
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.map),
            label: "Maps",
          ),
        ],
      ),
    );
  }
}
