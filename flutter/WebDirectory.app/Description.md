# desscription de l'application flutter

## fonctionnalités principales réalisés

- Affichage de la liste des entrées dans l’ordre alphabétique. Pour chaque entrée on affiche les noms, prénoms, service / département.
- Filtrage de la liste d’entrée par service / département.
- Recherche d’une entrée par le nom.
- Affichage complet d’une entrée, en cliquant sur l’adresse e-mail de la personne, l’application demessagerie par défaut est lancée.
- Liste d’entrées filtrée par nom et département ou service.
- Tri des listes d’entrées selon l’ordre alphabétique ascendant ou descendant.
- Affichage de l’image associée à une entrée si elle est présente.

#### Affichage de la liste des entrées dans l’ordre alphabétique. Pour chaque entrée on affiche les noms, prénoms, service / département

L'affichage des entrées se fait par ordre alphabétique au lancement de l'application après un appel à l'api qui va stocker les entrées dans une liste qui s'affichera par la suite ou au moment du rechargement de la page `EntréeMaster` avec un `pull to refresh`.

#### Filtrage de la liste d’entrée par service / département

Pour le filtrage des entrées par service/département, il s'effectue au moment du choix du service/département dans une `combobox` en haut de la page `EntreeMaster`. Un appel va être effectué sur l'api et va modifier la liste d'entrée local qui est affiché et qui utilise un `consumer` du `provider` où se trouve la liste.

#### Recherche d’une entrée par le nom

Pour rechercher une entrée, on effectue un appel à l'api à chaque fois que l'utilisateur tape sur la barre d'entrée et que il laisse au moins 0,3 secondes sans taper (pour éviter d'avoir trop d'appel d'api). L'appel va modifier la liste d'entrée de la même façon que précédemment.

#### Affichage complet d’une entrée, en cliquant sur l’adresse e-mail de la personne, l’application demessagerie par défaut est lancée

Pour afficher une entrée en détails, il suffit de cliquer sur l'une des entrées qui est affiché dans la page `EntréeMaster`. Pour envoyer un mail à une personne, il y a plusieurs moyen, la première est de cliquer sur l'email de la personne dans sa page de détail, le deuxième moyen est de cliquer sur l'icône d'email sur l'entrée afficher dans `EntreeMaster`, dans les deux cas, l'application va ouvrir l'application de mail par défaut et prérempli.

#### Liste d’entrées filtrée par nom et département ou service

Les filtres sont cummulables c'est à dire qu'à chaque changement de filtre, l'appel sera fait en fonction du nom si il y en a un, du nom de département/service et de si la liste est triée de façon alphabétique `ascendant` ou `descandant`.

#### Tri des listes d’entrées selon l’ordre alphabétique ascendant ou descendant

Le tri se réalise quand on appuie sur l'icône de tri alphabétique en haut à gauche, si la liste est en `ascendant` et que l'on appuie elle passera en `descendant` et inversement.

#### Affichage de l’image associée à une entrée si elle est présente

L'image s'affiche sur chaque entrée dans `EntreeMaster` et dans le détail d'une entrée.

## fonctionnalités supplémentaires

#### Changer d'un affichage en liste à un affichage en grille

Pour pouvoir changer la méthode d'affichage des entrées, il faut appuyer sur l'icône correspondante en haut à gauche, si l'affichage est en grille, l'icône sera l'icône de l'affichage en liste et si on appuie l'affichage passera en liste et l'icône passera à celle de l'affichage en grille, le fonctionnement est le même dans l'autre cas.

#### Pull to refresh

Le `pull to refresh` est l'exécution souhaité grâce à la méthode `onRefresh` quand on scroll vers le haut et que l'on est déjà tout en haut. 
Dans la méthode `onRefresh` j'ai mis un appel à l'api qui me permet de récupérer toutes les entrées et de les mettres dans ma liste local, ce qui va recharger la liste des entrées sur `EntreeMaster`.

#### Telephoner en cliquant sur le numero de telephone 

De la même façon que pour les emails, il est possible d'aller sur l'application de téléphonie par défaut du téléphone et de préremplir le numéro de téléphone à appellé. Pour ce faire il y a encore 2 moyens, le premier est d'appuyer sur le numéro de téléphone que l'on veut appelé dans le détail d'une entrée et le deuxième est d'appuyer sur l'icône de téléphone sur l'une des entrées de la page `EntreeMaster`.

#### Afficher les adresses des entrée sur une carte

Pour accéder à la map, il faut aller sur l'onglet `Maps` pour que la carte s'affiche. Les positions des entrées sont affichés par un `marker` vert avec le nom écrit au dessus. 