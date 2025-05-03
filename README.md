# Espace d'Administration pour la Génération de Pages HTML

Ce projet PHP a pour but de créer un espace d'administration sécurisé, permettant de générer dynamiquement des fichiers HTML à partir d'un formulaire. L'accès à cet espace est protégé par une authentification basée sur un fichier CSV contenant les informations des utilisateurs.

## Fonctionnalités Principales

* **Authentification Sécurisée :** Connexion des administrateurs via un formulaire avec adresse e-mail et mot de passe.
* **Gestion des Comptes Administrateurs :**
    * Formulaire de création de nouveaux comptes administrateurs avec validation des champs (civilité, nom, prénom, e-mail, mot de passe, photo).
    * Upload et enregistrement des photos des utilisateurs sur le serveur.
    * Mise à jour du fichier `comptes.csv` à chaque création de compte.
    * Affichage de la liste des comptes administrateurs.
* **Génération de Pages HTML :**
    * Formulaire de création de pages HTML (nom du fichier, titre, description, titre H1, contenu principal).
    * Utilisation de l'éditeur WYSIWYG TinyMCE pour la saisie du contenu principal.
    * Génération automatique du fichier HTML correspondant.
* **Protection d'Accès :**
    * Toutes les pages de l'espace d'administration sont protégées et nécessitent une connexion préalable (gestion via les sessions PHP).
* **Fichier CSV Sécurisé :**
    * Le fichier `comptes.csv` n'est pas accessible directement via le navigateur web.
 
## Bonus

* **Mot de Passe Fort :** Validation de la complexité du mot de passe lors de la création d'un compte (8 caractères minimum, au moins un chiffre, une minuscule, une majuscule et un caractère spécial).
* **Suppression de Compte :** Possibilité de supprimer un compte administrateur uniquement si l'utilisateur connecté est `admin@eemi.com`.
* **Interface Utilisateur :** Utilisation de CSS pour améliorer l'apparence de l'interface d'administration.

## Utilisation

1.  **Connexion :** Rendez-vous sur la page de connexion et entrez vos identifiants (e-mail et mot de passe) présents dans le fichier `comptes.csv`.
2.  **Gestion des comptes :** Une fois connecté, vous aurez accès à un formulaire pour créer de nouveaux comptes administrateurs et à la liste des comptes existants.
3.  **Génération de pages :** Utilisez le formulaire dédié pour créer de nouvelles pages HTML en spécifiant le nom du fichier, le titre, la description, le titre H1 et le contenu principal via l'éditeur TinyMCE.
4.  **Les fichiers HTML générés** seront créés dans un répertoire spécifique (à définir dans votre code).

## Technologies Utilisées

* PHP
* HTML
* CSS
* JavaScript (pour TinyMCE)
