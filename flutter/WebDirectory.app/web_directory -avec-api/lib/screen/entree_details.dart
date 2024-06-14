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
        title: Text('${widget.entree.nom} ${widget.entree.prenom}', style: Theme.of(context).textTheme.titleLarge,),
      ),
      body: Column(
        children: [
          Container(
            padding: const EdgeInsets.all(10),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Container(
                  margin: const EdgeInsets.symmetric(vertical: 10),
                  child: Row(
                    children: [
                      const Icon(Icons.person),
                      Text('${widget.entree.nom} ${widget.entree.prenom}'),
                    ],
                  ),
                ),
                Container(
                  margin: const EdgeInsets.symmetric(vertical: 10),

                  child: Row(
                    children: [
                      const Icon(Icons.phone),
                      InkWell(
                        onTap: () async {
                          final Uri url = Uri.parse("tel:${widget.entree.numeroPerso}");
                          if (await canLaunchUrl(url)) {
                            await launchUrl(url);
                          } else {
                            throw 'Could not launch $url';
                          }
                        },
                        child: Container(
                          decoration: const BoxDecoration(
                            border: Border(bottom: BorderSide(color: Color.fromARGB(255, 0, 0, 0))),
                          ),
                          child: Text('${widget.entree.numeroFixe}')
                        )
                      ),
                    ],
                  ),
                ),
                Container(
                  margin: const EdgeInsets.symmetric(vertical: 10),

                  child: Row(
                    children: [
                      const Icon(Icons.phone_android),
                      InkWell(
                        onTap: () async {
                          final Uri url = Uri.parse("tel:${widget.entree.numeroPerso}");
                          if (await canLaunchUrl(url)) {
                            await launchUrl(url);
                          } else {
                            throw 'Could not launch $url';
                          }
                        },
                        child: Container(
                          decoration: const BoxDecoration(
                            border: Border(bottom: BorderSide(color: Color.fromARGB(255, 0, 0, 0))),
                          ),
                          child: Text('${widget.entree.numeroPerso}')
                        )
                      ),
                    ],
                  ),
                ),
                Container(
                  margin: const EdgeInsets.symmetric(vertical: 10),
                  child: Row(
                    children: [
                      const Icon(Icons.email),
                      InkWell(
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
                        child: Container(
                          decoration: const BoxDecoration(
                            border: Border(bottom: BorderSide(color: Color.fromARGB(255, 0, 0, 0))),
                          ),
                          child:  Text(widget.entree.email),
                        ),
                      ),
                    ],
                  ),
                ),
                Container(
                  margin: const EdgeInsets.symmetric(vertical: 10),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Text('Départements:'),
                      for (var dep in widget.entree.departements) 
                      Padding(
                        padding: const EdgeInsets.only(left: 15),
                        child: Text("- ${dep.nom}"),
                      ),
                    ],
                  ),
                  )
              ],
            ),
          )
        ]
      )
    );
  }
}