# Mini LinkedIn API

Une API REST construite avec Laravel pour simuler les fonctionnalités
principales de LinkedIn : profils, offres d'emploi et candidatures.

---

## Prerequis

- PHP 8.3+
- Composer
- MySQL 8.0+

---

## Installation

1. Cloner le projet :
   git clone https://github.com/REDA-dnt/Projet-Backend.git
   cd Projet-Backend

2. Installer les dependances :
   composer install

3. Configurer l'environnement :
   cp .env.example .env
   php artisan key:generate
   php artisan jwt:secret

4. Configurer la base de donnees dans .env :
   DB_DATABASE=mini_linkedin
   DB_USERNAME=root
   DB_PASSWORD=

5. Lancer les migrations et seeders :
   php artisan migrate --seed

6. Demarrer le serveur :
   php artisan serve

---

## Authentification

L'API utilise JWT (JSON Web Token).
Inclure le token dans le header de chaque requete protegee :

   Authorization: Bearer {token}

---

## Endpoints

### Authentification

| Methode | Route         | Auth | Description          |
|---------|---------------|------|----------------------|
| POST    | /api/register | Non  | Inscription          |
| POST    | /api/login    | Non  | Connexion            |
| POST    | /api/logout   | Oui  | Deconnexion          |
| GET     | /api/me       | Oui  | Utilisateur connecte |

---

### Profil

| Methode | Route                        | Auth | Description              |
|---------|------------------------------|------|--------------------------|
| GET     | /api/profil                  | Oui  | Voir son profil          |
| PUT     | /api/profil                  | Oui  | Modifier son profil      |
| POST    | /api/profil/competences      | Oui  | Ajouter une competence   |
| DELETE  | /api/profil/competences/{id} | Oui  | Supprimer une competence |

---

### Offres

| Methode | Route            | Auth      | Description          |
|---------|------------------|-----------|----------------------|
| GET     | /api/offres      | Non       | Lister les offres    |
| GET     | /api/offres/{id} | Non       | Voir une offre       |
| POST    | /api/offres      | Recruteur | Creer une offre      |
| PUT     | /api/offres/{id} | Recruteur | Modifier une offre   |
| DELETE  | /api/offres/{id} | Recruteur | Supprimer une offre  |

---

### Candidatures

| Methode | Route                         | Auth      | Description           |
|---------|-------------------------------|-----------|-----------------------|
| POST    | /api/offres/{id}/candidater   | Oui       | Postuler a une offre  |
| GET     | /api/candidatures/mes         | Oui       | Voir mes candidatures |
| PUT     | /api/candidatures/{id}/statut | Recruteur | Changer le statut     |

---

### Administration

| Methode | Route                  | Auth  | Description         |
|---------|------------------------|-------|---------------------|
| GET     | /api/admin/users       | Admin | Lister les users    |
| DELETE  | /api/admin/users/{id}  | Admin | Supprimer un user   |
| GET     | /api/admin/offres      | Admin | Lister les offres   |
| DELETE  | /api/admin/offres/{id} | Admin | Supprimer une offre |

---

## Roles

| Role      | Permissions                                     |
|-----------|-------------------------------------------------|
| candidat  | Gerer son profil, postuler aux offres           |
| recruteur | Creer et gerer ses offres, modifier les statuts |
| admin     | Acces complet a toutes les ressources           |

---

## Collection Postman

Importer le fichier `postman/mini-linkedin.json` dans Postman
pour tester tous les endpoints directement.