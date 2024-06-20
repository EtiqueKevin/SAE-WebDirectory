import 'package:geocoding/geocoding.dart';
import 'package:web_directory/models/departement.dart';

class Entree {
  String nom; 
  String prenom;
  int numBureau; 
  String? numeroFixe;
  String? numeroPerso;
  String email;
  List<Departement> departements;
  String? imageURI;
  String? adresse;
  Location? location;

  Entree({
    required this.nom,
    required this.prenom,
    required this.numBureau,
    this.numeroFixe,
    this.numeroPerso,
    required this.email,
    required this.departements,
    this.imageURI,
    this.adresse,
  });


  Future<void> fetchLocation() async {
    if (adresse == null) return;
    try {
      List<Location> coord = await locationFromAddress(adresse!);
      location = coord.first;
    } catch (e) {
      location = null;
    }
  }

  factory Entree.fromJson(Map<String, dynamic> json) {
 
    return Entree(
      nom: json['entree']['nom'],
      prenom: json['entree']['prenom'],
      numBureau: json['entree']['num_bureau'],
      numeroFixe: json['entree']['tel_fixe'],
      numeroPerso: json['entree']['tel_mobile'],
      email: json['entree']['email'],
      departements: json['entree']['departements'].map<Departement>((dep) => Departement.fromJson(dep['departement'])).toList(),
      imageURI: json['links']['image']['href'],
      adresse: json['entree']['adresse'],
    );
  }
}