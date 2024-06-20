class Departement { 
  int id;
  String nom;

  Departement({
    required this.id,
    required this.nom,
  });

  factory Departement.fromJson(Map<String, dynamic> json) {
    return Departement(
      id: json['id'],
      nom: json['nom'],
    );
  }
}