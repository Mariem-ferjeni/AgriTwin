# AgriTwin – Plateforme de gestion agricole

## 1. Présentation du projet

**AgriTwin** est une application web destinée à faciliter la gestion et le suivi des exploitations agricoles.

Elle permet aux utilisateurs de gérer leurs exploitations, leurs parcelles et leurs cultures, ainsi que de consulter des conseils agricoles.

## 2. Technologies utilisées

- **PHP** : programmation côté serveur.
- **MySQL** : gestion de la base de données.
- **HTML** : structure des pages.
- **CSS** : mise en forme et design.
- **JavaScript** : interactions côté client.
- **Apache** : serveur web local avec XAMPP.

## 3. Fonctionnalités principales

### Espace public

- Consultation de la plateforme.
- Consultation des cultures et des conseils agricoles.
- Inscription et connexion.
- Formulaire de contact.

### Espace utilisateur

- Gestion du profil.
- Gestion des exploitations agricoles.
- Gestion des parcelles.
- Suivi des activités agricoles.

### Back Office – Administrateur

- Tableau de bord.
- Gestion des utilisateurs.
- Gestion des exploitations.
- Gestion des cultures et des catégories.
- Gestion des conseils agricoles.
- Consultation des messages.
- Statistiques et paramètres.

## 4. Architecture du projet

Le projet utilise une architecture de type MVC (Model – View – Controller).

- `admin/` : interfaces et fonctionnalités d'administration.
- `app/controllers/` : contrôleurs qui gèrent les requêtes.
- `app/models/` : modèles qui communiquent avec la base de données.
- `app/views/` : interfaces affichées aux utilisateurs.
- `app/core/` : classes et mécanismes principaux de l'application.
- `assets/css/` : feuilles de style.
- `assets/js/` : scripts JavaScript.
- `config/` : configuration de l'application et de la base de données.
- `database/` : scripts SQL et migrations.
- `includes/` : éléments PHP réutilisables.

## 5. Installation et configuration

### Prérequis

- XAMPP installé.
- Apache et MySQL activés.
- Navigateur web.
- PHP et MySQL compatibles avec la configuration du projet.

### Étapes d'installation

1. Copier le dossier `AgriTwin_Final` dans le répertoire `htdocs` de XAMPP.
2. Démarrer Apache et MySQL depuis XAMPP.
3. Ouvrir phpMyAdmin à l'adresse `http://localhost/phpmyadmin`.
4. Créer une base de données nommée `agritwin`.
5. Importer le fichier `database/migrations/001_migration.sql`.
6. Configurer les paramètres de connexion à la base de données dans les fichiers locaux du dossier `config/`.
7. Ouvrir l'application dans le navigateur :

`http://localhost/AgriTwin_Final/`

## 6. Sécurité

Le projet comprend notamment :

- Une gestion des sessions.
- Une authentification des utilisateurs.
- Une gestion des rôles et des autorisations.
- Une validation des données.
- Une protection CSRF.

## 7. Équipe du projet

Projet universitaire réalisé dans le cadre de la formation d'ingénierie à ESPRIT.

**Projet : AgriTwin**
