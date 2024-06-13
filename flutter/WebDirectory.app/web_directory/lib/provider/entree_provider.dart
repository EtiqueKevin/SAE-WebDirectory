import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:web_directory/models/entree.dart';

class EntreeProvider extends ChangeNotifier {
  List<Entree> _entrees = [];
  final dio = Dio();

  List<Entree> get entrees => _entrees;

  Future<List<Entree>> fetchEntrees() async {
    await Future.delayed(const Duration(milliseconds: 100), (){});
    /*
    Response response = await dio.get('');
    _entrees = response.data.map<Entree>((entree) => Entree.fromJson(entree)).toList(); 
    */

    _entrees = [
      Entree(
        nom: 'Doe',
        prenom: 'John',
        numBureau: 123,
        numeroFixe: '0123456789',
        numeroPerso: '9876543210',
        email: 'feur@feur.com',
      ),
      Entree(
        nom: 'Jean',
        prenom: 'Jane',
        numBureau: 456,
        numeroFixe: '0123456789',
        numeroPerso: '0684872984',
        email: 'zfqf@ergerg.com',
      ),
      Entree(
        nom: 'Doe',
        prenom: 'Jane',
        numBureau: 789,
        numeroFixe: '0123456789',
        numeroPerso: '9876543210',
        email: 'fvdfvsd'
      ),
    ];

    entrees.sort((a, b) => (a.nom+a.prenom).compareTo(b.nom + b.prenom));
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


}