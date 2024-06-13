import 'package:flutter/material.dart';
import 'package:web_directory/screen/entree_details.dart';

class EntreePreview extends StatelessWidget {
  final entree;
  const EntreePreview({super.key, required this.entree});

  @override
  Widget build(BuildContext context) {
    return ListTile(
      title: Text('${entree.nom} ${entree.prenom}'),
      subtitle: Text('Bureau: ${entree.numBureau}'),
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