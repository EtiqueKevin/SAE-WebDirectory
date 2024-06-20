import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:web_directory/models/Departement.dart';
import 'package:web_directory/provider/entree_provider.dart';

import 'entree_preview.dart';

class EntreeMaster extends StatefulWidget {
  const EntreeMaster({super.key});

  @override
  State<EntreeMaster> createState() => _EntreeMasterState();
}

class _EntreeMasterState extends State<EntreeMaster> {
  final TextEditingController _controller = TextEditingController();
  bool _ascendant = false;
  String? _selectedValue;

  void initState() {
    super.initState();
    setState(() {
      WidgetsBinding.instance.addPostFrameCallback((_) {
      _selectedValue = Provider.of<EntreeProvider>(context, listen: false).departements[0].nom; 
    });
  });
  }

  @override
  Widget build(BuildContext context) {
    print(Provider.of<EntreeProvider>(context, listen: false).departements);
    return Column(
      children: [
        Row(
          mainAxisAlignment: MainAxisAlignment.start,
          children: [
            IconButton(
              icon: const Icon(Icons.sort_by_alpha),
              onPressed: () {
                _ascendant = !_ascendant;
                if(_ascendant){
                  Provider.of<EntreeProvider>(context, listen: false).fetchEntreeDescendant();
                }
                else{
                  Provider.of<EntreeProvider>(context, listen: false).fetchEntreeAscendant();
                }
              },
            ),
            DropdownButton<String>(
              value: _selectedValue,
              hint: const Text('Sélectionnez une option'),
              items: Provider.of<EntreeProvider>(context, listen: false).departements.map((Departement dep) {
                return DropdownMenuItem<String>(
                  value: dep.nom,
                  child: Text(dep.nom),
                );
              }).toList(),
              onChanged: (newValue) {
                _controller.clear();
                Provider.of<EntreeProvider>(context, listen: false).fetchEntreeParDepartement(newValue);
                setState(() {
                  _selectedValue = newValue;
                });
              },
            ),
            Expanded(
              child: TextField(
                controller: _controller,
                decoration: InputDecoration(
                  labelText: 'Rechercher',
                  suffixIcon: IconButton(
                    icon: const Icon(Icons.clear),
                    onPressed: () {
                      Provider.of<EntreeProvider>(context, listen: false).fetchEntrees();
                      _controller.clear();
                    },
                  ),
                ),
                onSubmitted: (text) => {
                  Provider.of<EntreeProvider>(context, listen: false).fetchEntreeParNom(text),
                },
              ),
            ),
          ],
        ),
        Consumer<EntreeProvider>(
          builder: (context, entreeProvider, child) {
            return Expanded(
              child: ListView(
                children: entreeProvider.entrees.map((entree) => EntreePreview(entree: entree)).toList(),
              ),
            );
          },
        ),
      ],
    );
  }
}