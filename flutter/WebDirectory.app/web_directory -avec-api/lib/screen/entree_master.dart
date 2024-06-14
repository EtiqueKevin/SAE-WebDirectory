import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:web_directory/models/departement.dart';
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
  String? _selectedValue = 'Tous';

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        SingleChildScrollView(
          child: Column(
            children: [
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  IconButton(
                    style: ButtonStyle(
                      backgroundColor: WidgetStateProperty.all(Theme.of(context).colorScheme.primary),
                      iconColor: WidgetStateProperty.all(Theme.of(context).colorScheme.onPrimary),
                    ),
                    icon: const Icon(Icons.sort_by_alpha),
                    onPressed: () {
                      _ascendant = !_ascendant;
                      Provider.of<EntreeProvider>(context, listen: false).fetchEntreesFilterSort(_selectedValue, _ascendant, _controller.text);
                    },
                  ),
                  DropdownButton<String>(
                    value: _selectedValue,
                    hint: const Text('Sélectionnez une option'),
                    items: [
                    const DropdownMenuItem<String>(
                      value: 'Tous',
                      child: Text('Tous'),
                    ),
                    ...Provider.of<EntreeProvider>(context, listen: false).departements.map((Departement dep) {
                      return DropdownMenuItem<String>(
                        value: dep.nom,
                        child: Text(dep.nom),
                      );
                    }),
                  ],
                    onChanged: (newValue) {
                      setState(() {
                        _selectedValue = newValue;
                      });
                      Provider.of<EntreeProvider>(context, listen: false).fetchEntreesFilterSort(_selectedValue, _ascendant, _controller.text);
                    },
                  ),
                ],
              ),
              TextField(
                style: Theme.of(context).textTheme.titleMedium,
                controller: _controller,
                decoration: InputDecoration(
                  enabledBorder: UnderlineInputBorder(
                    borderSide: BorderSide(color: Theme.of(context).colorScheme.primary),
                  ),
                  labelStyle: Theme.of(context).textTheme.titleMedium,
                  labelText: 'Rechercher',
                  suffixIcon: IconButton(
                    style: ButtonStyle(
                      iconColor: WidgetStateProperty.all(Theme.of(context).colorScheme.primary),
                    ),
                    icon: const Icon(Icons.clear),
                    onPressed: () {
                      _controller.clear();
                      Provider.of<EntreeProvider>(context, listen: false).fetchEntreesFilterSort(_selectedValue, _ascendant, _controller.text);
                    },
                  ),
                ),
                onChanged: (text) => {
                  Provider.of<EntreeProvider>(context, listen: false).fetchEntreesFilterSort(_selectedValue, _ascendant, text),
                },
              ),
            ],
          ),
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