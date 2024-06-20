# Description de l'application JavaScript WebDirectory

## Fonctionnalités principales

- Affichage d'une liste d'entrées dans l'ordre alphabétique. Pour chaque entrée, on affiche les noms, prénoms, service / département.
- Filtrage de la liste d'entrée par service / département.
- Recherche d'entrée par nom.
- Affichage en détail d'une personne, avec toutes ses informations. Cliquer sur l'adresse email ouvre l'application de mail par défaut.
- Filtrage de la liste d'entrée par service / département et recherche par nom en même temps.
- Tri de la liste par ordre alphabétique ascendant et descendant.
- Affichage d'une image associée à une entrée.

## Fonctionnalités ajoutées
- Mode clair et Mode sombre.
- Export des données affichées en CSV.
- Pouvoir afficher un département en détail.

### Affichage de la liste des entrées
Lorsque l'on charge la page, un appel à l'API va être effectué pour récupérer les entrées non filtrées et les afficher dans l'interface principale via un template.

### Filtrage de la liste d'entrée par service / département
Lorsque l'on effectue un changement dans le formulaire, une fonction 'search' va être appelée avec les différents paramètres dans le formulaire. En fonction des différents paramètres, la fonction va faire le bon appel à l'API et renvoyer le résultat de l'appel pour être affiché. 

### Recherche par nom
Dans le formulaire, il y a une entrée pour la recherche, à chaque lettre écrite, un timer de 300ms est lancé et à la fin de ce timer, la fonction 'search' est appelée. Si l'utilisateur écrit une autre lettre, le timer est annulé et un nouveau de 300ms prend sa place et on répète cela tant que l'utilisateur continue d'écrire. 
Cela nous permet de faire qu'un seul appel à l'API à la place d'un appel pour chaque lettre ou suppression de lettre. Si l'utilisateur sait quoi chercher, il peut écrire un nom complet et avoir le résultat et si l'utilisateur ne sait pas ce qu'il cherche, il peut toujours faire des essais et avoir le résultat.

### Affichage en détail d'une personne, avec toutes ses informations.
Lorsque l'on clique sur une entrée, on va effectuer un appel à l'API pour récupérer les informations de la personne et les afficher dans une fenêtre modale. Si l'utilisateur clique sur l'adresse email, on va ouvrir l'application de mail par défaut avec l'adresse email de la personne grâce à un 'mailto:'. On peut sortir de la fenêtre modale en cliquant sur la croix ou en cliquant en dehors de la fenêtre.

### Filtrage de la liste d'entrée par service / département et recherche par nom en même temps
Grâce à la fonction 'search' qui prend en paramètre les différents paramètres du formulaire, on peut faire un appel à l'API avec les différents paramètres et afficher le résultat dans l'interface principale.

### Tri de la liste par ordre alphabétique ascendant et descendant
Dans le formulaire, il y a un bouton pour changer l'ordre de la liste. Lorsque l'on clique sur le bouton, on va utiliser la fonction 'search' avec les paramètres du formulaire et un paramètre 'sort' qui va changer l'ordre de la liste.

### Affichage d'une image associée à une entrée
Dans la fenêtre modale, on récupère le nom de l'image associée à la personne et on l'affiche dans la fenêtre modale si l'image existe. Si l'image n'existe pas, on affiche une image par défaut. Pour récupérer l'image, on utilise l'URL [http://docketu.iutnc.univ-lorraine.fr:43000/img/](http://docketu.iutnc.univ-lorraine.fr:43000/img/) avec le nom de l'image après le '/'.

### Mode clair et Mode sombre
Dans le formulaire, il y a un bouton pour changer le thème de l'application. Lorsque l'on clique sur le bouton, on va changer le thème de l'application en changeant les couleurs des éléments de l'interface. Il y a deux thèmes, un thème clair et un thème sombre. Le thème affiché par défaut change en fonction du thème du navigateur.

### Export des données affichées en CSV
Dans le formulaire, il y a un bouton pour exporter les données affichées en CSV. Lorsque l'on clique sur le bouton, on va faire les différents appels à l'API pour récupérer les données et les exporter en CSV. On va créer un fichier CSV avec les données et le télécharger. Il existe maintenant une meilleure façon de récupérer les données sur WebDirectory Admin.