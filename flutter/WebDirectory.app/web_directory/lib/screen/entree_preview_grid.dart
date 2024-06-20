import 'package:flutter/material.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:web_directory/screen/entree_details.dart';

import '../models/entree.dart';

class EntreePreviewGrid extends StatelessWidget {
  final Entree entree;
  final String listeDep;
  EntreePreviewGrid({super.key, required this.entree}) : listeDep = entree.departements.map((dep) => dep.nom).join(', ');
  
  

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: () {
        Navigator.push(
            context,
            MaterialPageRoute(
              builder: (context) => EntreeDetails(entree: entree),
            ),
          );
      },
      child: Card(
        color: Theme.of(context).colorScheme.surface,
        child: Padding(
          padding: const EdgeInsets.all(10),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              CircleAvatar(
                radius: 20,
                backgroundImage: entree.imageURI == null || dotenv.env['IMG_URL'] == null
                ? const AssetImage("assets/images/default_pp.png")
                : FadeInImage.assetNetwork(
                  placeholder: "assets/images/default_pp.png",
                  image: dotenv.env['IMG_URL']! + entree.imageURI!,
                  fit: BoxFit.cover,
                ).image,
                backgroundColor: Theme.of(context).colorScheme.onPrimary,
              ),
              Text('${entree.nom} ${entree.prenom}', style: Theme.of(context).textTheme.titleMedium, overflow: TextOverflow.ellipsis,),
              Text(listeDep, style: Theme.of(context).textTheme.bodySmall, overflow: TextOverflow.ellipsis, textAlign: TextAlign.center,),
              Row(
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
            ],
          ),
        ),
      ),
    );
  }
}