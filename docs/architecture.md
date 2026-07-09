## Une couche = Une responsabilité

| Couche      | Responsabilité             |
| ----------- | -------------------------- |
| FormRequest | Validation                 |
| Policy      | Autorisation               |
| Controller  | HTTP uniquement            |
| DTO         | Transport de données       |
| Service     | Orchestration métier       |
| Action      | Une opération métier       |
| Repository  | Accès aux données          |
| Observer    | Réagir aux événements      |
| Model       | Représentation des données |

Si une classe commence à assumer plusieurs responsabilités, nous la refactoriserons.

Parfait. On passe à **l’étape 0.6 — conventions du projet**.

L’objectif ici est simple : **éviter l’incohérence dès le début**.
Si on respecte les mêmes règles partout, le projet restera lisible même quand il grossira.

---

# Étape 0.6 — Conventions de FleetManager

## 1) Règle générale de nommage

On utilisera :

* **PascalCase** pour les classes : `VehicleController`, `CreateVehicleAction`
* **camelCase** pour les méthodes et variables : `storeVehicle`, `$vehicleData`
* **snake_case** pour les colonnes SQL : `registration_number`, `service_date`
* **kebab-case** pour les routes web si nécessaire : `fleet-manager`
* **UPPER_SNAKE_CASE** pour les constantes : `STATUS_ACTIVE`

---

## 2) Convention des classes

### Controllers

Nom attendu :

```text
VehicleController
DriverController
UserController
```

Rôle : gérer la couche HTTP uniquement.

---

### Requests

Nom attendu :

```text
StoreVehicleRequest
UpdateVehicleRequest
StoreDriverRequest
UpdateDriverRequest
```

Rôle : validation des données d’entrée.

---

### Services

Nom attendu :

```text
VehicleService
DriverService
UserService
```

Rôle : orchestration métier.

---

### Repositories

Nom attendu :

```text
VehicleRepository
DriverRepository
UserRepository
```

Et si on veut être plus propre avec les contrats :

```text
Contracts/VehicleRepositoryInterface
Eloquent/EloquentVehicleRepository
```

Rôle : accès aux données.

Notre philosophie concernant les Repositories : Seulement là où c'est utile.

Règle à appliquer pendant tout le projet.

**Niveau 1 : Eloquent suffit**

Si nous avons simplement :

Vehicle::find($id);
Vehicle::create(...);
Vehicle::all();

➡️ Aucun Repository.

Niveau 2 : Les requêtes deviennent complexes

Exemple :

Tous les véhicules
+
leur dernier entretien
+
leur chauffeur actuel
+
leur kilométrage
+
uniquement les véhicules actifs

Là, oui : On crée un Repository.

---

### Policies

Nom attendu :

```text
VehiclePolicy
DriverPolicy
UserPolicy
```

Rôle : autorisation.

---

### Observers

Nom attendu :

```text
VehicleObserver
DriverObserver
UserObserver
```

Rôle : réagir aux événements du modèle.

---

### Actions

Nom attendu :

```text
CreateVehicleAction
AssignDriverToVehicleAction
ArchiveVehicleAction
```

Rôle : une action métier précise.

---

### DTO

Nom attendu :

```text
CreateVehicleData / UpdateVehicleData (ou simplement VehicleData si les payloads de création et de modification sont identiques pour éviter la duplication de code)
CreateDriverData / DriverData
UserData
```

Rôle : transporter des données validées de manière immuable.

---

### Enums

Nom attendu :

```text
VehicleStatusEnum
DriverStatusEnum
FuelTypeEnum
```

Rôle : représenter des valeurs fixes.

---

## 3) Convention de préfixe / suffixe

On gardera une logique simple :

* `Store...Request` pour la création
* `Update...Request` pour la modification
* `...Controller` pour les contrôleurs
* `...Service` pour les services
* `...Repository` pour les repositories
* `...Policy` pour les policies
* `...Observer` pour les observers
* `...Action` pour les actions
* `...Data` pour les DTO

Cette cohérence est très importante.

---

# 4) Structure de dossiers proposée

Je te propose cette structure de base :

```text
app/
├── Actions/
├── DTO/
├── Enums/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Observers/
├── Policies/
├── Repositories/
│   ├── Contracts/
│   └── Eloquent/
├── Services/
├── Traits/
└── Providers/
```

---

# 5) Règles de responsabilité

## Controller

Ne fait pas de logique métier lourde.

Il :

* reçoit la requête ;
* appelle la policy ;
* envoie les données au service ou à l’action ;
* retourne la réponse HTTP.

---

## Form Request

Ne contient que la validation et les messages d’erreur.

---

## Service

Orchestre un processus métier complet.

Exemple :

* créer un véhicule ;
* enregistrer l’audit ;
* déclencher une notification.

---

## Action

Fait une seule opération métier.

Exemple :

* créer un véhicule ;
* assigner un chauffeur ;
* archiver un véhicule.

---

## Repository

Gère les requêtes vers la base de données.

Pas de logique métier ici.

---

## Policy

Décide si l’utilisateur a le droit d’agir ou non.

---

## Observer

Réagit aux événements du modèle.

Exemple :

* `created`
* `updated`
* `deleted`

---

## DTO

Transporte des données propres entre les couches.

---

# 6) Règle d’or du projet

Je veux qu’on garde cette discipline :

> **Un contrôleur ne doit jamais contenir la logique métier complète.**

Et aussi :

> **Une classe doit avoir une seule responsabilité claire.**

C’est ce qui va rendre FleetManager propre, testable et maintenable.

---

Une règle supplémentaire

Je veux également définir une règle de dépendance.

Notre code devra toujours respecter ce sens :

HTTP
↓
Controller
↓
Service
↓
Action
↓
Repository
↓
Model
↓
Database

Une couche supérieure peut appeler une couche inférieure.

En revanche :

❌ Un Repository ne doit jamais appeler un Controller.

❌ Un Model ne doit jamais appeler un Service.

❌ Un Observer ne doit jamais contenir toute la logique métier.

Cela évite les dépendances circulaires et rend le projet plus facile à maintenir.