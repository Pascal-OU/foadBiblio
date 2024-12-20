# Projet de Gestion des Livres et Commentaires

## Description

Ce projet implémente un système de gestion de livres avec la possibilité d'ajouter, modifier et supprimer des commentaires. Les utilisateurs connectés peuvent commenter les livres, tandis que les administrateurs peuvent gérer les commentaires.

Les fonctionnalités principales comprennent :
- **Gestion des livres** : Affichage des livres, ajout de nouveaux livres, et recherche par titre et auteur.
- **Ajout de commentaires** : Les utilisateurs connectés peuvent ajouter des commentaires sur les livres.
- **CRUD pour les commentaires** : Les administrateurs peuvent modifier et supprimer les commentaires.

## Fonctionnalités

### 1. **Gestion des livres**
   - Ajout de livres.
   - Modification de livres.
   - suppression de livres.

### 2. **Ajout Image**
   - Ajout, possibilité d'associer une image à chaque livre (couverture).
   - utilisation d'un bundle (VichUploaderBundle).

### 3. **Recherche de livre**
   - Recherche de livres par titre ou auteur via un champ de recherche.

### 4. **Filtrage de livre**
   - Filtrage des livres par catégorie (genre)(ex: Fiction, Non-fiction, etc.).

### 5. **Ajout de commentaires**
   - Les utilisateurs connectés peuvent ajouter des commentaires sur les livres.
   - Le formulaire de commentaire permet à l'utilisateur d'entrer un texte et de soumettre le commentaire.

### 6. **Gestion des commentaires (CRUD)**
   - **Ajouter des commentaires** : Les administrateurs peuvent ajouter des commentaires via un formulaire d'ajout.
   - **Modification des commentaires** : Les administrateurs peuvent modifier les commentaires existants via un formulaire de modification.
   - **Suppression des commentaires** : Les administrateurs peuvent supprimer les commentaires avec une confirmation avant l'action.
   
## Installation

### Prérequis
Assurez-vous d'avoir installé les outils suivants :
- [PHP](https://www.php.net/) >= 8.0
- [Composer](https://getcomposer.org/) pour gérer les dépendances
- [Symfony](https://symfony.com/) pour le serveur et les outils CLI
- Une base de données (MySQL, PostgreSQL, ou SQLite)

### Étapes d'installation

1. Clonez ce projet depuis GitHub :
   ```bash
   git clone https://github.com/votre-utilisateur/gestion-livres.git
   cd gestion-livres
   
2. Installez les dépendances avec Composer :
   composer install
   
3. Configurez votre base de données dans le fichier .env :
   DATABASE_URL="mysql://username:password@127.0.0.1:3306/gestion_livres"
   
4. Créez la base de données et appliquez les migrations :
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
 
5. Lancez le serveur Symfony :
    symfony serve

6. Accédez à l'application via votre navigateur à l'adresse : http://localhost:8000.


Auteurs et Licence
Auteur : Pascal-OU
Licence : Ce projet est sous la licence MIT.
