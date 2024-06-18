import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';

import '../models/entree.dart';

class EntreeDetails extends StatefulWidget {
  final Entree entree;
  const EntreeDetails({super.key, required this.entree});

  @override
  State<EntreeDetails> createState() => _EntreeDetailsState();
}

class _EntreeDetailsState extends State<EntreeDetails> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Theme.of(context).colorScheme.primary,
        title: Text('${widget.entree.nom} ${widget.entree.prenom}', style: Theme.of(context).textTheme.titleLarge,),
      ),
      body: Container(
        padding: const EdgeInsets.all(10),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            imagePersonneSection(),
            nomPrenomSection(),
            Divider(
              color: Theme.of(context).colorScheme.primary,
              thickness: 2,
            ),
            Expanded(
              child: ListView(
                children: [
                  numPersoSection(),
                  numFixeSection(),
                  emailSection(),
                  departementsSection()
                ],
              ),
            )
          ],
        ),
      )
    );
  }

  ListTile departementsSection() {
    return ListTile(
      //
      //tileColor: Theme.of(context).colorScheme.secondary,
      title: Text('Départements:', style: Theme.of(context).textTheme.titleMedium),
      subtitle: Text(widget.entree.departements.map((e) => e.nom).join(', ')),
          
      );
  }

  ListTile emailSection() {
    return ListTile(
      tileColor: Theme.of(context).colorScheme.secondary,
      leading: const Icon(Icons.email),
      onTap: () async {
        final Uri emailLaunchUri = Uri(
          scheme: 'mailto',
          path: widget.entree.email,
          query: 'subject=sujet du mail',
        );
    
        if (await canLaunchUrl(emailLaunchUri)) {
          await launchUrl(emailLaunchUri);
        } else {
          throw 'impossible de lancer ${emailLaunchUri.toString()}';
        }
      },
      title: Text(widget.entree.email),
  );
  }

  ListTile numPersoSection() {
    return ListTile(
      tileColor: Theme.of(context).colorScheme.secondary,
      leading: const Icon(Icons.phone_android),
      onTap: () async {
        final Uri url = Uri.parse("tel:${widget.entree.numeroPerso}");
        if (await canLaunchUrl(url)) {
          await launchUrl(url);
        } else {
          throw 'Could not launch $url';
        }
      },
      title: Text('${widget.entree.numeroPerso}')
      );
  }

  Text nomPrenomSection() {
    return Text('${widget.entree.nom} ${widget.entree.prenom}',
    style: Theme.of(context).textTheme.titleMedium,);

  }

  CircleAvatar imagePersonneSection() {
    return widget.entree.imageURI == null
    ? CircleAvatar(
      radius: 60,
      backgroundImage: const AssetImage("assets/images/default_pp.png"),
      backgroundColor: Theme.of(context).colorScheme.onPrimary,
    )
    : CircleAvatar(
      radius: 60,
      backgroundImage: NetworkImage("http://docketu.iutnc.univ-lorraine.fr:43000/img/${widget.entree.imageURI!}"),
    );
  }

  ListTile numFixeSection() {
    return ListTile(
      tileColor: Theme.of(context).colorScheme.secondary,
      leading: const Icon(Icons.phone),          
      onTap: () async {
        final Uri url = Uri.parse("tel:${widget.entree.numeroPerso}");
        if (await canLaunchUrl(url)) {
          await launchUrl(url);
        } else {
          throw 'Impossible de lancer $url';
        }
      },
      title: Text('${widget.entree.numeroFixe}'),
    );
  }
}