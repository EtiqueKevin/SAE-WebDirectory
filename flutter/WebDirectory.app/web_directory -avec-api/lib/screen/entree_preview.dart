import 'package:flutter/material.dart';
import 'package:web_directory/screen/entree_details.dart';

import '../models/entree.dart';

class EntreePreview extends StatelessWidget {
  final Entree entree;
  final String listeDep;
  EntreePreview({super.key, required this.entree}) : listeDep = entree.departements.map((dep) => dep.nom).join(', ');
  
  

  @override
  Widget build(BuildContext context) {
    return ListTile(
      title: Text('${entree.nom} ${entree.prenom}'),
      subtitle: Text('Départements: $listeDep'),
      onTap: () {
        Navigator.push(
            context,
            MaterialPageRoute(
              builder: (context) => EntreeDetails(entree: entree),
            ),
          ); 
      },
    );
  }
}