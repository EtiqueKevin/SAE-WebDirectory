import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:web_directory/models/entree.dart';

import '../models/departement.dart';

class EntreeProvider extends ChangeNotifier {
  List<Entree> _entrees = [];
  List<Departement> _departements = [];
  final dio = Dio();

  List<Entree> get entrees => _entrees;
  set entrees(List<Entree> entrees) => _entrees = entrees;
  List<Departement> get departements => _departements;

  Future<List<Entree>> fetchEntrees() async {

    try{
      Response response = await dio.get('http://docketu.iutnc.univ-lorraine.fr:43000/api/entrees');
      _entrees = await Future.wait(response.data['entrees'].map<Future<Entree>>((entree) async {
        response = await dio.get('http://docketu.iutnc.univ-lorraine.fr:43000 ${entree['links']['self']['href']}');
        return Entree.fromJson(response.data);
      }).toList());
    }
    catch(e){
      _entrees = [];
    }

    await fetchDepartements();

    notifyListeners();
    return _entrees;
  }

  Future<void> fetchDepartements() async {
    try{
      Response response = await dio.get('http://docketu.iutnc.univ-lorraine.fr:43000/api/services?sort=nom-asc');
      _departements = response.data['departements'].map<Departement>((departement) => Departement.fromJson(departement['departement'])).toList(); 
    }
    catch(e){
      _departements = [];
    }
    
    notifyListeners();
  }


  Future<void> fetchEntreesFilterSort(String? departement, bool ascendant, String? nom) async {
    String sort = ascendant ? 'nom-desc' : 'nom-asc';

    try{
      
      if (departement != 'Tous' && nom == "") {
        int idDepartement = _departements.firstWhere((element) => element.nom == departement).id;  

        Response response = await dio.get('${dotenv.env['API_URL']}services/$idDepartement/entrees?sort=$sort');
          _entrees = response.data['entrees'].map<Entree>((entree) => Entree.fromJson(entree)).toList();
      } 
      else if(departement == 'Tous' && nom != ""){
        Response response = await dio.get('${dotenv.env['API_URL']}entrees/search/?q=$nom&sort=$sort');
        _entrees = response.data['entrees'].map<Entree>((entree) => Entree.fromJson(entree)).toList();
      }
      else if(departement != 'Tous' && nom != ""){
        int idDepartement = _departements.firstWhere((element) => element.nom == departement).id;  
        Response response = await dio.get('${dotenv.env['API_URL']}services/$idDepartement/entrees/search/?q=$nom&sort=$sort');
        _entrees = response.data['entrees'].map<Entree>((entree) => Entree.fromJson(entree)).toList();
      }
      else if(departement == 'Tous' && nom == ""){
        Response response = await dio.get('${dotenv.env['API_URL']}entrees?sort=$sort');
        _entrees = await Future.wait(response.data['entrees'].map<Future<Entree>>((entree) async {
          response = await dio.get('${dotenv.env['BASE_URL']}${entree['links']['self']['href']}');
          return Entree.fromJson(response.data);
        }).toList());
      }
    }
    catch(e){
      entrees = [];
    }

    notifyListeners();
  }



}