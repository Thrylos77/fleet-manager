# FleetManager

FleetManager est une application web moderne de gestion de flotte automobile. Elle permet aux entreprises de gérer leurs véhicules, leurs chauffeurs et de suivre avec précision les affectations en temps réel.

## Technologies

Ce projet utilise les dernières technologies de l'écosystème PHP :
- **PHP** : 8.3+
- **Framework** : Laravel 13.18
- **Base de données** : PostgreSQL
- **Gestion des Rôles** : Spatie Laravel Permission

## Architecture du Projet

Le projet suit une architecture stricte inspirée du **Domain-Driven Design (DDD)** afin de garantir un code découplé, maintenable et testable :

1. **Controllers** : Point d'entrée HTTP. Gèrent les requêtes entrantes, la validation via les `FormRequests`, et instancient les `DTOs`.
2. **DTOs (Data Transfer Objects)** : Objets immuables (classes `readonly`) transportant les données validées entre le contrôleur et les services.
3. **Services** : Orchestrent la logique métier globale, gèrent la journalisation (logs) et les éventuelles notifications.
4. **Actions** : Classes mono-tâche (`execute()`) encapsulant l'interaction pure avec la base de données (ex: création avec verrous pessimistes).
5. **Observers** : Interceptent les événements des modèles (ex: empêcher la création d'une affectation non conforme en dernier recours, synchroniser les profils).
6. **Enums** : `BackedEnums` stricts pour définir les types et statuts de l'application (ex: `VehicleStatusEnum`).

### Règle d'Or Métier
L'application garantit par conception l'**exclusivité d'affectation** : 
- Un véhicule ne peut avoir qu'un seul chauffeur actif à la fois.
- Un chauffeur ne peut avoir qu'un seul véhicule actif à la fois.
Cette règle est protégée à trois niveaux : base de données (index uniques partiels PostgreSQL), action (verrous transactionnels pessimistes) et observer (filet de sécurité).

## Installation & Démarrage (Développement)

1. **Cloner le dépôt**
   ```bash
   git clone <votre-url-git>
   cd fleet-manager
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Configuration de l'environnement**
   Copiez le fichier d'exemple et configurez votre base de données PostgreSQL.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrations et Seeders**
   Cette commande crée la structure de la base de données, génère les rôles/permissions via Spatie, et crée le super-administrateur par défaut.
   ```bash
   php artisan migrate:fresh --seed
   ```
   **Comptes de test générés :**
   - **Email** : `admin@fleetmanager.com`
   - **Username** : `admin`
   - **Mot de passe** : `password`

5. **Lancer le serveur local**
   ```bash
   php artisan serve
   ```

## Documentation
- [Description du Projet](docs/project.md)
- [Modélisation des Données](docs/modelisation_v1.md)
- [Standards et Architecture](docs/architecture.md)

---
*Ce projet est en cours de développement - Sprint 1 (Fondations et Logique Backend).*
