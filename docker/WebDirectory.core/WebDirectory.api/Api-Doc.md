# Documentation du Projet WebDirectory

## Langages et Frameworks utilisés

- SQL
- PHP
- Composer

## Structure du Projet

Le projet est structuré en plusieurs répertoires principaux :

- `src/core/domain` : Contient les modèles de données.
- `src/core/service` : Contient les services qui interagissent avec les modèles de données.
- `src/app/actions` : Contient les actions qui sont les points d'entrée de l'API.
- `src/conf` : Contient les fichiers de configuration.

## Modèles de Données

- `Entrees` : Représente une entrée dans le répertoire. Chaque entrée a un nom, un prénom, un numéro de bureau, un numéro de téléphone mobile, un numéro de téléphone fixe, une adresse e-mail, une date de création et une date de mise à jour.
- `Departement` : Représente un département. Chaque département a un nom.

## Services

- `EntreeService` : Fournit des méthodes pour interagir avec les données d'entrée.
- `DepartementService` : Fournit des méthodes pour interagir avec les données de département.

## Actions

- `GetEntreesAction` : Récupère toutes les entrées.
- `GetEntreeByIdAction` : Récupère une entrée par son ID.
- `GetEntreesBySearchAction` : Récupère les entrées en fonction d'une recherche.
- `GetEntreesSorted` : Récupère les entrées triées par un champ spécifique.
- `getEntreesByDepartementAndSearchSortedAction` : Récupère les entrées d'un département spécifique en fonction d'une recherche et les trie.

## Routes

- `/api/services` : Récupère tous les départements.
- `/api/entrees` : Récupère toutes les entrées.
- `/api/entrees/search` : Récupère les entrées en fonction d'une recherche.
- `/api/entrees/{id}` : Récupère une entrée par son ID.
- `/api/services/{id}/entrees` : Récupère les entrées d'un département spécifique.
- `/api/articles` : Récupère les entrées triées.
- `/api/services/{id}/entrees/search` : Récupère les entrées d'un département spécifique en fonction d'une recherche et les trie.

## Exceptions

- `OrmException` : Exception personnalisée pour gérer les erreurs liées à l'ORM.

## Utilisation

- ### `/api/services`

  - **GET** : Récupère tous les départements.
  - **Paramètres** :
    - `sort` : Tri sur le nom, prend pour valeur :
      - `nom-asc` : Tri ascendant sur le nom.
      - `nom-desc` : Tri descendant sur le nom.

- ### `/api/entrees`

  - **GET** : Récupère toutes les entrées.
  - **Paramètres** :
    - `sort` : Tri sur le nom, prend pour valeur :
      - `nom-asc` : Tri ascendant sur le nom.
      - `nom-desc` : Tri descendant sur le nom.

- ### `/api/entrees/search`

  - **GET** : Récupère les entrées en fonction d'une recherche.
  - **Paramètres** :
    - `q` : Recherche sur le nom.
    - `sort` : Tri sur le nom, prend pour valeur :
      - `nom-asc` : Tri ascendant sur le nom.
      - `nom-desc` : Tri descendant sur le nom.

- ### `/api/entrees/{id}`

  - **GET** : Récupère une entrée par son ID.

- ### `/api/services/{id}/entrees`

    - **GET** : Récupère les entrées d'un département spécifique.
    - **Paramètres** :
        - `sort` : Tri sur le nom, prend pour valeur :
          - `nom-asc` : Tri ascendant sur le nom.
          - `nom-desc` : Tri descendant sur le nom.

- ### `/api/articles`

  - **GET** : Récupère les entrées triées.
  - **Paramètres** :
    - `sort` : Tri sur le nom, prend pour valeur :
      - `nom-asc` : Tri ascendant sur le nom.
      - `nom-desc` : Tri descendant sur le nom.

- ### `/api/services/{id}/entrees/search`

    - **GET** : Récupère les entrées d'un département spécifique en fonction d'une recherche et les trie.
    - **Paramètres** :
        - `q` : Recherche sur le nom.
        - `sort` : Tri sur le nom, prend pour valeur :
          - `nom-asc` : Tri ascendant sur le nom.
          - `nom-desc` : Tri descendant sur le nom.