import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:web_directory/provider/entree_provider.dart';

import 'entree_preview.dart';

class EntreeMaster extends StatefulWidget {
  const EntreeMaster({super.key});

  @override
  State<EntreeMaster> createState() => _EntreeMasterState();
}

class _EntreeMasterState extends State<EntreeMaster> {
  final TextEditingController _controller = TextEditingController();
  bool _ascendant = true;

  @override
  Widget build(BuildContext context) {
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