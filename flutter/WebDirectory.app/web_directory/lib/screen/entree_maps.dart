import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';
import 'package:provider/provider.dart';
import 'package:web_directory/provider/entree_provider.dart';

class EntreeMaps extends StatefulWidget {
  const EntreeMaps({super.key});

  @override
  State<EntreeMaps> createState() => _EntreeMapsState();
}

class _EntreeMapsState extends State<EntreeMaps> {

  List<Marker> getMarkers() {
    List<Marker> markers = [];
    Provider.of<EntreeProvider>(context, listen: false).entrees.forEach((entree) async {
      
      if (entree.adresse != null) {
        await entree.fetchLocation();
        markers.add(
          Marker(
            width: 150,
            height: 100.0,
            point: LatLng(entree.location!.latitude, entree.location!.longitude),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Text(entree.nom, style: TextStyle(color: Theme.of(context).colorScheme.primary, fontWeight: FontWeight.bold, fontSize: 15.0)),
                Icon(
                  Icons.location_on,
                  size: 50.0,
                  color: Theme.of(context).colorScheme.primary,
                ),
              ],
            ),
          ),
        );
      }
    });
    return markers;
  }
    

  @override
  Widget build(BuildContext context) {
    return Center(
      child: FlutterMap(
        options: const MapOptions(
          initialCenter: LatLng(48.692054, 6.184417),
          initialZoom: 6.0,
        ),
        children: [
          TileLayer(
            urlTemplate: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
          ),
          MarkerLayer(markers: getMarkers())
        ],
      )
    );
  }
}