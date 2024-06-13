class Entree {
  String nom; 
  String prenom;
  int numBureau; 
  String? numeroFixe;
  String? numeroPerso;
  String email;

  Entree({
    required this.nom,
    required this.prenom,
    required this.numBureau,
    this.numeroFixe,
    this.numeroPerso,
    required this.email
  });

  factory Entree.fromJson(Map<String, dynamic> json) {
    return Entree(
      nom: json['nom'],
      prenom: json['prenom'],
      numBureau: json['numBureau'],
      numeroFixe: json['numeroFixe'],
      numeroPerso: json['numeroPerso'],
      email: json['email']
    );
  }
}