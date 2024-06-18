import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:web_directory/models/departement.dart';
import 'package:web_directory/provider/entree_provider.dart';

import 'entree_preview_grid.dart';
import 'entree_preview_list.dart';

class EntreeMaster extends StatefulWidget {
  const EntreeMaster({super.key});

  @override
  State<EntreeMaster> createState() => _EntreeMasterState();
}

class _EntreeMasterState extends State<EntreeMaster> {
  final GlobalKey<RefreshIndicatorState> _refreshIndicatorKey = GlobalKey<RefreshIndicatorState>();
  final TextEditingController _controller = TextEditingController();
  bool _ascendant = false;
  String? _selectedValue = 'Tous';
  bool _grid = false;

  @override
  Widget build(BuildContext context) {
    return RefreshIndicator(
      onRefresh: () async {
        setState(() {
          _ascendant = false;
          _selectedValue = 'Tous';
          _controller.clear();
        });
        
        await Provider.of<EntreeProvider>(context, listen: false).fetchEntrees();
      },
      key: _refreshIndicatorKey,
      child: Column(
        children: [
          SingleChildScrollView(
            child: Column(
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Container(
                      margin: const EdgeInsets.only(left: 10, top: 10, right: 10),
                      child: Row(
                        children: [
                          IconButton(
                            style: ButtonStyle(
                              backgroundColor: WidgetStateProperty.all(Theme.of(context).colorScheme.primary),
                              iconColor: WidgetStateProperty.all(Theme.of(context).colorScheme.onPrimary),
                            ),
                            icon: const Icon(Icons.sort_by_alpha),
                            onPressed: () {
                              _ascendant = !_ascendant;
                              Provider.of<EntreeProvider>(context, listen: false).fetchEntreesFilterSort(_selectedValue, _ascendant, _controller.text);
                            },
                          ),
                          const SizedBox(width: 10),
                          IconButton(
                            style: ButtonStyle(
                              backgroundColor: WidgetStateProperty.all(Theme.of(context).colorScheme.primary),
                              iconColor: WidgetStateProperty.all(Theme.of(context).colorScheme.onPrimary),
                            ),
                            icon: Icon( _grid ? Icons.view_list : Icons.view_module),
                            onPressed: () {
                              setState(() {
                                _grid = !_grid;
                              });
                            },
                          ),
                        ],
                      ),
                    ),
                    
                    DropdownButton<String>(
                      value: _selectedValue,
                      hint: const Text('Sélectionnez une option'),
                      items: [
                      const DropdownMenuItem<String>(
                        value: 'Tous',
                        child: Text('Tous'),
                      ),
                      ...Provider.of<EntreeProvider>(context, listen: false).departements.map((Departement dep) {
                        return DropdownMenuItem<String>(
                          value: dep.nom,
                          child: Text(dep.nom),
                        );
                      }),
                    ],
                      onChanged: (newValue) {
                        setState(() {
                          _selectedValue = newValue;
                        });
                        Provider.of<EntreeProvider>(context, listen: false).fetchEntreesFilterSort(_selectedValue, _ascendant, _controller.text);
                      },
                    ),
                  ],
                ),
                TextField(
                  style: Theme.of(context).textTheme.titleMedium,
                  controller: _controller,
                  decoration: InputDecoration(
                    enabledBorder: UnderlineInputBorder(
                      borderSide: BorderSide(color: Theme.of(context).colorScheme.primary),
                    ),
                    labelStyle: Theme.of(context).textTheme.titleMedium,
                    labelText: 'Rechercher',
                    suffixIcon: IconButton(
                      style: ButtonStyle(
                        iconColor: WidgetStateProperty.all(Theme.of(context).colorScheme.tertiary),
                      ),
                      icon: const Icon(Icons.clear),
                      onPressed: () {
                        _controller.clear();
                        Provider.of<EntreeProvider>(context, listen: false).fetchEntreesFilterSort(_selectedValue, _ascendant, _controller.text);
                      },
                    ),
                  ),
                  onChanged: (text) => {
                    Provider.of<EntreeProvider>(context, listen: false).fetchEntreesFilterSort(_selectedValue, _ascendant, text),
                  },
                ),
              ],
            ),
          ),
          Consumer<EntreeProvider>(
            builder: (context, entreeProvider, child) {
              return Expanded(
                child: Container(
                  margin : const EdgeInsets.all(10),
                  child: _grid 
                    ? GridView.builder(
                      gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                        crossAxisCount: (MediaQuery.of(context).size.width / (150)).floor(),
                        crossAxisSpacing: 10,
                        mainAxisSpacing: 10,
                      ),
                      itemCount: entreeProvider.entrees.length,
                      itemBuilder: (context, index) {
                        return EntreePreviewGrid(entree: entreeProvider.entrees[index]);
                      }
                    )
                    : ListView.builder(
                        itemCount: entreeProvider.entrees.length,
                        itemBuilder: (context, index) {
                        return EntreePreviewList(entree: entreeProvider.entrees[index]);
                      }
                  ),
                ),
              );
            },
          ),
        ],
      ),
    );
  }
}