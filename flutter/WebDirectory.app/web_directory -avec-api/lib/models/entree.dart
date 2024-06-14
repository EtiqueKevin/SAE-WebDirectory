import 'package:web_directory/models/departement.dart';

class Entree {
  String nom; 
  String prenom;
  int numBureau; 
  String? numeroFixe;
  String? numeroPerso;
  String email;
  List<Departement> departements;

  Entree({
    required this.nom,
    required this.prenom,
    required this.numBureau,
    this.numeroFixe,
    this.numeroPerso,
    required this.email,
    required this.departements
  });

  factory Entree.fromJson(Map<String, dynamic> json) {
 
    return Entree(
      nom: json['nom'],
      prenom: json['prenom'],
      numBureau: json['num_bureau'],
      numeroFixe: json['tel_fixe'],
      numeroPerso: json['tel_mobile'],
      email: json['email'],
      departements: json['departements'].map<Departement>((dep) => Departement.fromJson(dep['departement'])).toList()
    );
  }
}