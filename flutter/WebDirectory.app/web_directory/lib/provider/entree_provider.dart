import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:web_directory/models/entree.dart';

import '../models/Departement.dart';

class EntreeProvider extends ChangeNotifier {
  List<Entree> _entreesGlobal = [];
  List<Entree> _entrees = [];
  List<Departement> _departements = [];
  final dio = Dio();

  List<Entree> get entreesGlobal => _entreesGlobal;
  List<Entree> get entrees => _entrees;
  void set entrees(List<Entree> entrees) => _entrees = entrees;
  List<Departement> get departements => _departements;

  Future<List<Entree>> fetchEntrees() async {
    Response response = await dio.get('http://docketu.iutnc.univ-lorraine.fr:43000/api/entrees');
          _entreesGlobal = await Future.wait(response.data['entrees'].map<Future<Entree>>((entree) async {
      response = await dio.get('http://docketu.iutnc.univ-lorraine.fr:43000' + entree['links']['self']['href']);
      print(response.data['entree']);
      return Entree.fromJson(response.data['entree']);
    }).toList());

    await fetchDepartements();

    _entrees = _entreesGlobal;

    notifyListeners();
    return _entrees;
  }

  Future<List<Entree>> fetchEntreeParNom(String nom) async {
    await Future.delayed(const Duration(milliseconds: 100), (){});

    /*
    Response response = await dio.get('');
    _entrees = response.data.map<Entree>((entree) => Entree.fromJson(entree)).toList(); 
    */

    _entrees = _entrees.where((entree) => entree.nom == nom).toList();
    notifyListeners();
    return _entrees;
  }

  Future<List<Entree>> fetchEntreeAscendant() async {
    await Future.delayed(const Duration(milliseconds: 100), (){});


    /*
    Response response = await dio.get('');
    _entrees = response.data.map<Entree>((entree) => Entree.fromJson(entree)).toList(); 
    */

    entrees.sort((a, b) => (a.nom+a.prenom).compareTo(b.nom + b.prenom));

    notifyListeners();
    return _entrees;
  }

  Future<List<Entree>> fetchEntreeDescendant() async {
    await Future.delayed(const Duration(milliseconds: 100), (){});

    /*
    Response response = await dio.get('');
    _entrees = response.data.map<Entree>((entree) => Entree.fromJson(entree)).toList(); 
    */

    entrees.sort((b, a) => (a.nom+a.prenom).compareTo(b.nom + b.prenom));

    notifyListeners();
    return _entrees;
  }


  Future<List<Departement>> fetchDepartements() async {
    Response response = await dio.get('http://docketu.iutnc.univ-lorraine.fr:43000/api/services');
    _departements = response.data['departements'].map<Departement>((departement) => Departement.fromJson(departement['departement'])).toList(); 

    
    notifyListeners();
    return _departements;
  }






  Future<List<Entree>> fetchEntreeParDepartement(String? departement) async {
    await Future.delayed(const Duration(milliseconds: 100), (){});

    /*
    Response response = await dio.get('');
    _entrees = response.data.map<Entree>((entree) => Entree.fromJson(entree)).toList(); 
    */
    _entrees = _entreesGlobal;
    _entrees = _entrees.where((entree) => entree.departements.any((dep) => dep.nom == departement)).toList();
    notifyListeners();
    return _entrees;
  }




  

  void annulerFiltre() async {
    _entrees = _entreesGlobal;
  }

}