CandidatureTracker

    Application Laravel de suivi de candidatures — Simplon x Jobintech x CDG

📋 Contexte
La recherche d'emploi pour un jeune diplômé est un défi organisationnel majeur. Entre les startups, les agences et les grandes entreprises, la multiplication des candidatures mène rapidement à une saturation d'informations.
Actuellement gérée de manière informelle via de simples notes, cette méthode montre ses limites : oublis de relances cruciales, chevauchements d'entretiens et perte de visibilité sur l'entonnoir de recrutement.
CandidatureTracker centralise ces flux pour transformer une gestion mentale stressante en un processus structuré et efficace.
🎯 Objectif
Développer une solution Laravel dédiée au suivi personnalisé des candidatures. L'outil permet d'enregistrer chaque opportunité, de planifier les étapes d'entretien et de maintenir un historique complet des interactions, assurant ainsi une réactivité optimale face aux recruteurs.
✨ Fonctionnalités
| US    | Fonctionnalité                                                                | Statut |
| ----- | ----------------------------------------------------------------------------- |     
------  |
| US1   | Inscription / Connexion / Déconnexion (Laravel Breeze)                        | ✅      |
| US2   | Liste de mes candidatures actives                                             | ✅      |
| US3   | Créer une candidature (entreprise, poste, URL, statut, priorité, notes, date) | ✅      |
| US4   | Voir le détail d'une candidature + entretiens associés                        | ✅      |
| US5   | Modifier une candidature                                                      | ✅      |
| US6   | Archiver une candidature (Soft Delete)                                        | ✅      |
| US7   | Page Archives dédiée                                                          | ✅      |
| US8   | Restaurer une candidature archivée                                            | ✅      |
| US9   | Filtres par statut et/ou priorité                                             | ✅      |
| US10  | Ajouter un entretien (type, date/heure, notes, résultat)                      | ✅      |
| US11  | Modifier / Supprimer un entretien                                             | ✅      |
| Bonus | Attacher un fichier (CV, lettre) via Storage::disk                            | ✅      |
| Bonus | Tests Pest (Policy, validation, CRUD, archivage)                              | ✅      |

🛠 Stack Technique
| Couche               | Technologie                    |
| -------------------- | ------------------------------ |
| **Backend**          | PHP 8.3, Laravel 11            |
| **Frontend**         | Blade, Tailwind CSS, Alpine.js |
| **Base de données**  | MySQL 8.0                      |
| **Authentification** | Laravel Breeze                 |
| **Tests**            | Pest PHP                       |
| **Debug / Perf**     | Laravel Debugbar (zéro N+1)    |
| **Stockage**         | Laravel Storage (disque local) |

📐 Architecture & Contraintes Techniques
Le projet respecte l'ensemble des contraintes imposées :

    ✅ Authentification via Laravel Breeze
    ✅ Toutes les routes nommées (Route::resource() + noms explicites)
    ✅ Toutes les routes protégées par le middleware auth
    ✅ Validation via Form Request classes (StoreCandidatureRequest, UpdateCandidatureRequest, StoreEntretienRequest)
    ✅ $fillable défini sur chaque modèle (Candidature, Entretien, User)
    ✅ Autorisation via Policy (CandidaturePolicy) — un utilisateur ne peut modifier/supprimer que ses propres ressources
    ✅ Archivage via Soft Deletes sur les candidatures (deleted_at)
    ✅ Statuts et priorités affichés en français dans les vues
    ✅ Zéro N+1 vérifiable en live avec Debugbar (with('entretiens') systématique)
    ✅ @csrf sur tous les formulaires
    ✅ @forelse pour toutes les listes avec cas vide géré (@empty)

    Modèle de données
    users
├── id (PK)
├── name
├── email (unique)
├── password
└── timestamps

candidatures
├── id (PK)
├── entreprise
├── poste
├── url_offre (nullable)
├── statut (en_attente, entretien, en_cours, refusee)
├── priorite (basse, moyenne, haute)
├── notes (nullable)
├── date_candidature
├── user_id (FK → users.id)
├── deleted_at (Soft Delete)
└── timestamps

entretiens
├── id (PK)
├── type
├── date_heure
├── notes_preparation (nullable)
├── resultat (nullable)
├── candidature_id (FK → candidatures.id)
└── timestamps

🚀 Installation
Prérequis

    PHP >= 8.3
    Composer
    Node.js & NPM
    MySQL
    Extension PHP : pdo_mysql, mbstring, openssl, json, fileinfo

Étapes
# 1. Cloner le repository
git clone https://github.com/votre-username/candidature-tracker.git
cd candidature-tracker

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install

# 4. Compiler les assets
npm run build

# 5. Copier le fichier d'environnement
cp .env.example .env

# 6. Générer la clé d'application
php artisan key:generate

# 7. Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=candidature_tracker
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe

# 8. Créer la base de données
mysql -u root -p -e "CREATE DATABASE candidature_tracker;"

# 9. Exécuter les migrations
php artisan migrate

# 10. Créer le lien symbolique pour le stockage
php artisan storage:link

# 11. (Optionnel) Lancer les seeders
php artisan db:seed

# 12. Démarrer le serveur de développement
php artisan serve

🧪 Tests
Le projet inclut des tests Pest PHP couvrant les scénarios critiques :
# Lancer tous les tests
php artisan test

# Ou avec Pest directement
./vendor/bin/pest

Scénarios testés
    Accès non autorisé bloqué par la Policy
    Création d'une candidature avec données valides et invalides
    Archivage et restauration (Soft Deletes)
    Authentification requise sur les routes protégées


📁 Structure du Projet
candidature-tracker/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CandidatureController.php
│   │   │   └── EntretienController.php
│   │   ├── Requests/
│   │   │   ├── StoreCandidatureRequest.php
│   │   │   ├── UpdateCandidatureRequest.php
│   │   │   └── StoreEntretienRequest.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── Candidature.php      # SoftDeletes, $fillable, relations
│   │   ├── Entretien.php        # $fillable, belongsTo
│   │   └── User.php             # HasMany candidatures
│   └── Policies/
│       └── CandidaturePolicy.php # Propriétaire uniquement
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── 2026_05_18_100000_create_candidatures_table.php
│       └── 2026_05_18_100001_create_entretiens_table.php
├── resources/
│   └── views/
│       ├── candidatures/
│       │   ├── index.blade.php    # @forelse + filtres
│       │   ├── create.blade.php   # @csrf
│       │   ├── edit.blade.php     # @csrf + @method('PUT')
│       │   ├── show.blade.php     # Détail + entretiens
│       │   └── archives.blade.php # Candidatures soft deleted
│       ├── entretiens/
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       └── layouts/
│           └── app.blade.php
├── routes/
│   └── web.php                  # Routes nommées + middleware auth
├── storage/
│   └── app/
│       └── candidatures/        # Fichiers attachés (CV, LM)
├── tests/
│   └── Feature/
│       ├── CandidatureTest.php
│       ├── EntretienTest.php
│       └── AuthTest.php
└── README.md

🔐 Sécurité & Bonnes Pratiques

    Autorisation : authorize() dans les Form Requests + Policies sur les controllers
    Validation : règles centralisées dans les classes Request (pas de $request->validate() dans les controllers)
    CSRF : protection active sur tous les formulaires Blade
    Mass Assignment : protection via $fillable sur tous les modèles
    Fichiers : stockage via Storage::disk('local') avec suppression automatique à la suppression de la candidature
    N+1 : eager loading systématique (with(['entretiens'])) pour optimiser les requêtes


🗓 Planification
| Jour         | Objectif                                                   |
| ------------ | ---------------------------------------------------------- |
| **Lundi**    | MCD / MLD, Setup Laravel Breeze, Migrations, US1 (Auth)    |
| **Mardi**    | US2-US5 (CRUD Candidatures), Form Requests, Policies       |
| **Mercredi** | US6-US9 (Archives, Soft Deletes, Filtres), Relations       |
| **Jeudi**    | US10-US11 (Entretiens), File Storage (Bonus), Debugbar N+1 |
| **Vendredi** | Tests Pest, Polish UI, Préparation soutenance              |



👤 Auteur
Khalid Elkhattab — Full Stack Developer
Formation Simplon x Jobintech x CDG — Casablanca, Maroc

📄 Licence
Ce projet est réalisé dans le cadre d'une formation professionnelle. Tous droits réservés.

    "Gérez, suivez et organisez vos candidatures en toute simplicité."
