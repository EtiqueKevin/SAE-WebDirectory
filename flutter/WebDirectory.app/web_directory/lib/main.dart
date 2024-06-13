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
      home: Scaffold(
        appBar: AppBar(
          title: const Text('Annuaire des contacts'),
        ),
        body: Center(
          child: FutureBuilder(
            future: Provider.of<EntreeProvider>(context, listen: false).fetchEntrees(),
            builder: (BuildContext context, AsyncSnapshot snapshot) {
              if (snapshot.hasData) {
                return EntreeMaster();
              }else if(snapshot.hasError){
                return Text('Error: ${snapshot.error}');
              }
              else {
                return const CircularProgressIndicator();
              }
            },
          ),
        ),
      ),
    );
  }
}
