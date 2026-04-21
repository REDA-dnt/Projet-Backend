# Mini LinkedIn — API Backend

<div align="center">

```
███╗   ███╗██╗███╗   ██╗██╗    ██╗     ██╗███╗   ██╗██╗  ██╗███████╗██████╗ ██╗███╗   ██╗
████╗ ████║██║████╗  ██║██║    ██║     ██║████╗  ██║██║ ██╔╝██╔════╝██╔══██╗██║████╗  ██║
██╔████╔██║██║██╔██╗ ██║██║    ██║     ██║██╔██╗ ██║█████╔╝ █████╗  ██║  ██║██║██╔██╗ ██║
██║╚██╔╝██║██║██║╚██╗██║██║    ██║     ██║██║╚██╗██║██╔═██╗ ██╔══╝  ██║  ██║██║██║╚██╗██║
██║ ╚═╝ ██║██║██║ ╚████║██║    ███████╗██║██║ ╚████║██║  ██╗███████╗██████╔╝██║██║ ╚████║
╚═╝     ╚═╝╚═╝╚═╝  ╚═══╝╚═╝    ╚══════╝╚═╝╚═╝  ╚═══╝╚═╝  ╚═╝╚══════╝╚═════╝ ╚═╝╚═╝  ╚═══╝
```

**Plateforme de recrutement — API RESTful Laravel**

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=for-the-badge&logo=jsonwebtokens&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)

</div>

---

##  Informations Étudiants

| | Étudiant 1 | Étudiant 2 |
|---|---|---|
| **Nom** | Bouhaya Wael | Habchi Mohamed Reda |
| **Établissement** | ENSAM Casablanca — Université Hassan II | ENSAM Casablanca — Université Hassan II |
| **Filière** | Département Génie Informatique et IA | Département Génie Informatique et IA |
| **Enseignant** | Dr. WARDI Ahmed | Dr. WARDI Ahmed |

---

##  Description du Projet

Mini LinkedIn est une API backend RESTful construite avec **Laravel 11** simulant une plateforme de recrutement. Elle met en relation :

- **Candidats** — création de profil, ajout de compétences, candidature aux offres
- **Recruteurs** — publication et gestion d'offres d'emploi, traitement des candidatures
- **Administrateurs** — supervision globale de la plateforme

Le projet couvre la modélisation Eloquent, l'authentification JWT, l'autorisation par rôles, et un système d'Events & Listeners pour le logging métier.

---

##  Prérequis

| Outil | Version minimale |
|---|---|
| PHP | 8.2+ |
| Composer | 2.x |
| SQLite | 3.x |

---

##  Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/<votre-repo>/mini-linkedin.git
cd mini-linkedin
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurer la base de données

Dans `.env`, vérifier :

```env
DB_CONNECTION=sqlite
```

Créer le fichier SQLite :

```bash
touch database/database.sqlite
```

### 5. Générer la clé JWT

```bash
php artisan jwt:secret
```

### 6. Exécuter les migrations et les seeders

```bash
php artisan migrate:fresh --seed
```

### 7. Lancer le serveur

```bash
php artisan serve
```

L'API est accessible sur `http://localhost:8000/api`.

---

##  Modèle de Données

```
users ────────────────────────────────────────────────────────┐
  │  role ∈ {candidat, recruteur, admin}                      │
  │                                                           │
  ├──[hasOne]──► profils                                      │
  │                │  disponible, titre, bio, localisation    │
  │                │                                          │
  │                ├──[belongsToMany]──► competences          │
  │                │     (pivot: competence_profil)           │
  │                │      niveau ∈ {debutant,                 │
  │                │                intermediaire, expert}    │
  │                │                                          │
  │                └──[hasMany]──► candidatures               │
  │                                  statut ∈ {en_attente,   │
  │                                            acceptee,      │
  │                                            refusee}       │
  │                                                           │
  └──[hasMany]──► offres ◄─────────────────────────────────┘
                    │  type ∈ {CDI, CDD, stage}
                    └──[hasMany]──► candidatures
```

---

##  Authentification

L'API utilise **JWT (JSON Web Token)** via le package `tymon/jwt-auth`.

Inclure le token dans toutes les requêtes protégées :

```
Authorization: Bearer <token>
```

---

##  Récapitulatif des Routes

### Auth — Public

| Méthode | Endpoint | Description |
|---|---|---|
| `POST` | `/api/register` | Inscription (candidat ou recruteur) |
| `POST` | `/api/login` | Connexion |

### Auth — Protégé

| Méthode | Endpoint | Description |
|---|---|---|
| `POST` | `/api/logout` | Déconnexion |
| `GET` | `/api/me` | Profil de l'utilisateur connecté |

### Profil — `candidat` uniquement

| Méthode | Endpoint | Description |
|---|---|---|
| `POST` | `/api/profil` | Créer son profil (une seule fois) |
| `GET` | `/api/profil` | Consulter son profil |
| `PUT` | `/api/profil` | Modifier son profil |
| `POST` | `/api/profil/competences` | Ajouter une compétence |
| `DELETE` | `/api/profil/competences/{id}` | Retirer une compétence |

### Offres — Tous les rôles authentifiés

| Méthode | Endpoint | Description |
|---|---|---|
| `GET` | `/api/offres` | Liste des offres actives (pagination, filtres) |
| `GET` | `/api/offres/{offre}` | Détail d'une offre |

### Offres — `recruteur` uniquement

| Méthode | Endpoint | Description |
|---|---|---|
| `POST` | `/api/offres` | Créer une offre |
| `PUT` | `/api/offres/{offre}` | Modifier son offre |
| `DELETE` | `/api/offres/{offre}` | Supprimer son offre |
| `GET` | `/api/offres/{offre}/candidatures` | Voir les candidatures reçues |
| `PATCH` | `/api/candidatures/{candidature}/statut` | Changer le statut d'une candidature |

### Candidatures — `candidat` uniquement

| Méthode | Endpoint | Description |
|---|---|---|
| `POST` | `/api/offres/{offre}/candidater` | Postuler à une offre |
| `GET` | `/api/mes-candidatures` | Lister ses candidatures |

### Administration — `admin` uniquement

| Méthode | Endpoint | Description |
|---|---|---|
| `GET` | `/api/admin/users` | Liste de tous les utilisateurs |
| `DELETE` | `/api/admin/users/{user}` | Supprimer un compte |
| `PATCH` | `/api/admin/offres/{offre}` | Activer / désactiver une offre |

---

##  Codes de réponse HTTP

| Situation | Code |
|---|---|
| Token absent | `401 Unauthenticated` |
| Token invalide / expiré | `401 Token Signature could not be verified` |
| Rôle insuffisant | `403 Accès refusé` |
| Accès à la ressource d'un autre | `403 Action non autorisée` |
| Login incorrect | `401 Email ou mot de passe incorrect` |
| Validation échouée | `422 Unprocessable Entity` |
| Doublon (ex: déjà candidaté) | `409 Conflict` |

---

##  Données de test (Seeders)

Les seeders génèrent automatiquement :

| Rôle | Quantité | Détails |
|---|---|---|
| Admin | 2 | — |
| Recruteur | 5 | 2 à 3 offres chacun |
| Candidat | 10 | Profil complet + 3 compétences + 2 candidatures |

Mot de passe par défaut pour tous les comptes : **`password`**

---

##  Structure du Projet

```
mini-linkedin/
├── app/
│   ├── Events/
│   │   ├── CandidatureDeposee.php
│   │   └── StatutCandidatureMis.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AuthController.php
│   │   │   ├── CandidatureController.php
│   │   │   ├── OffreController.php
│   │   │   └── ProfilController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   ├── Listeners/
│   │   ├── LogCandidatureDeposee.php
│   │   └── LogStatutCandidatureMis.php
│   ├── Models/
│   │   ├── Candidature.php
│   │   ├── Competence.php
│   │   ├── Offre.php
│   │   ├── Profil.php
│   │   └── User.php
│   └── Providers/
│       └── EventServiceProvider.php
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── postman/
│   └── mini-linkedin.postman_collection.json
├── routes/
│   └── api.php
├── storage/
│   └── logs/
│       └── candidatures.log      ← logs métier Events & Listeners
├── .env.example
└── README.md
```

---

##  Events & Listeners

Le projet implémente deux événements métier loggés dans `storage/logs/candidatures.log` :

| Événement | Déclencheur | Log |
|---|---|---|
| `CandidatureDeposee` | Candidat postule à une offre | Date, nom du candidat, titre de l'offre |
| `StatutCandidatureMis` | Recruteur change le statut | Ancien statut, nouveau statut, date |

---

##  Collection Postman

La collection Postman est disponible dans `postman/mini-linkedin.postman_collection.json`.

Elle couvre :
- Inscription / Connexion / Déconnexion
- CRUD Profil & Compétences
- CRUD Offres
- Candidature & changement de statut
- Administration
- Cas d'erreur : `401`, `403`, `409`, `422`
