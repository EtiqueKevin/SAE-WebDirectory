import 'package:flutter/material.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:url_launcher/url_launcher.dart';

import '../models/entree.dart';
import 'entree_details.dart';

class EntreePreviewList extends StatelessWidget {
  final Entree entree;
  final String listeDep;
  EntreePreviewList({super.key, required this.entree}) : listeDep = entree.departements.map((dep) => dep.nom).join(', ');

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(3),
      child: Material(
        child: ListTile(
          tileColor: Theme.of(context).colorScheme.surface,
          onTap: () {
            Navigator.push(
              context,
              MaterialPageRoute(
                builder: (context) => EntreeDetails(entree: entree),
              ),
            );
          },
          leading: CircleAvatar(
            radius: 20,
            backgroundImage: entree.imageURI == null 
            ? const AssetImage("assets/images/default_pp.png")
            : FadeInImage.assetNetwork(
              placeholder: "assets/images/default_pp.png",
              image: dotenv.env['IMG_URL']! + entree.imageURI!,
              fit: BoxFit.cover,
            ).image,
            backgroundColor: Theme.of(context).colorScheme.onPrimary,
          ),
          trailing: Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              IconButton(
                icon: const Icon(Icons.phone),
                onPressed: () async {
                  final Uri url = Uri.parse("tel:${entree.numeroPerso}");
                  if (await canLaunchUrl(url)) {
                    await launchUrl(url);
                  } else {
                    throw 'Could not launch $url';
                  }
                },
              ),
              IconButton(
                icon: const Icon(Icons.email),
                onPressed: () async {
                  final Uri emailLaunchUri = Uri(
                    scheme: 'mailto',
                    path: entree.email,
                    query: 'subject=sujet du mail',
                  );
                  if (await canLaunchUrl(emailLaunchUri)) {
                    await launchUrl(emailLaunchUri);
                  } else {
                    throw 'impossible de lancer ${emailLaunchUri.toString()}';
                  }
                },
              ),
            ],
          ),
          title: Text('${entree.nom} ${entree.prenom}', style: Theme.of(context).textTheme.titleMedium, overflow: TextOverflow.ellipsis,),
          subtitle: Text(listeDep, style: Theme.of(context).textTheme.bodySmall, overflow: TextOverflow.ellipsis,),
        ),
      )
    );
  }
}