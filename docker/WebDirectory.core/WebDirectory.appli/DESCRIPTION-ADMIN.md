# Liste des fonctionnalités de l'application WebDirectory admin

-------------------

## Fonctionnalités de l'application WebDirectory admin

------------------

### Gestion des utilisateurs et permissions

- Création d'un utilisateur, par un super-administrateur
- Vérification des droits des utilisateurs
- Bar de navigation dynamique en fonction de la présence de l'utilisateur connecté ou non

### Gestion des entrees

- Création d'une entrée
- Modification d'une entrée
- Suppression d'une entrée
- Publication d'une entée
- Affichage des entrées selon leur départements
- Ajout d'une image à une entrée
- Ajout d'une adresse à une entrée
- Export des entrées en CSV
- Export des entrées en PDF
- Import des entrées en CSV

### Gestion des départements

- Création d'un département
- Modification d'un département
- Suppression d'un département

### Gestion des Sécurité

- Gestion des droits d'accès
- Protection contre l'injection SQL et XSS (SANITIZE à chaque entrée dans la base de données)
- Utilisation du CSRF token pour la protection des formulaires (dans chaques formulaires)

### Gestion des erreurs

- Affichage des erreurs en cas de problème (erreur par palier bien défini et retranscrie à l'utilisateur en HTTP erreur)
- Page d'erreur personnalisée