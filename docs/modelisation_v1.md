### Voici la modélisation **V1 de FleetManager, de A à Z**, révisée et stabilisée. J’ai intégré les retours utiles (traçabilité, robustesse des affectations) mais j’ai bien retiré le champ `vin` comme demandé.

Cette version est épurée des codes techniques (migrations, classes PHP) pour ne garder que **la structure métier, les règles de gestion et les contraintes**, prête à être implémentée.

---

## 1. Périmètre et postulats de la V1

- **Objectif** : Gérer l’authentification, le RBAC, les utilisateurs, les véhicules, les chauffeurs et les affectations.
- **Hors périmètre** : Maintenances, documents, notifications avancées, audits détaillés, historiques complets, statistiques.
- **Principe** : Toutes les tables critiques utilisent le *soft delete* (`deleted_at`) pour conserver un historique et permettre des restaurations.
- **Règle d’or** : Un véhicule ou un chauffeur ne peut avoir **qu’une seule affectation active** à la fois.

---

## 2. Table `users` (Comptes applicatifs)

**Rôle** : Représente une personne qui se connecte à l’application (avec un mot de passe).

| Champ | Type | Obligatoire | Contraintes / Particularités |
| :--- | :--- | :--- | :--- |
| `id` | Identifiant numérique | Oui | Clé primaire auto-incrémentée |
| `name` | Chaîne de caractères | Oui | - |
| `username` | Chaîne de caractères | Oui | **Unique** |
| `email` | Chaîne de caractères | Oui | **Unique** |
| `password` | Chaîne de caractères (hash) | Oui | - |
| `phone` | Chaîne de caractères | Non | **Unique** si renseigné |
| `status` | Énumération | Oui | Valeurs : `active`, `inactive`, `suspended` (défaut : `active`) |
| `email_verified_at` | Date / Heure | Non | Nullable |
| `last_login_at` | Date / Heure | Non | Nullable – permet de tracer la dernière connexion |
| `remember_token` | Chaîne de caractères | Non | Nullable – géré par Laravel |
| `created_at` | Date / Heure | Oui (auto) | - |
| `updated_at` | Date / Heure | Oui (auto) | - |
| `deleted_at` | Date / Heure | Non | Nullable – soft delete |

**Index conseillés** : `email`, `phone`, `status`, `deleted_at`.

---

## 3. Tables `roles` et `permissions` (Gestion des droits – type Spatie)

**Principe** : Les rôles et permissions sont gérés via un package comme Spatie, mais voici le périmètre métier.

**Rôles métier prédéfinis** :
- `Admin` (super administrateur)
- `Manager` (gestionnaire général)
- `Fleet Manager` (gestionnaire du parc)
- `Driver` (chauffeur – accès limité à son propre profil)

**Permissions métier minimales** (par ressource) :
- `users.view` / `users.create` / `users.update` / `users.delete`
- `vehicles.view` / `vehicles.create` / `vehicles.update` / `vehicles.delete`
- `drivers.view` / `drivers.create` / `drivers.update` / `drivers.delete`
- `assignments.view` / `assignments.manage` (créer, modifier, clore)
- `roles.manage` (réservé à l’Admin)

**Règle** : Un rôle peut avoir plusieurs permissions. Un utilisateur peut avoir un ou plusieurs rôles.

---

## 4. Table `vehicles` (Véhicules du parc)

**Rôle** : Référencer tous les véhicules.

| Champ | Type | Obligatoire | Contraintes / Particularités |
| :--- | :--- | :--- | :--- |
| `id` | Identifiant numérique | Oui | Clé primaire auto-incrémentée |
| `registration_number` | Chaîne de caractères | Oui | **Unique** (plaque d’immatriculation) |
| `brand` | Chaîne de caractères | Oui | Marque |
| `model` | Chaîne de caractères | Oui | Modèle |
| `year` | Année (small integer) | Oui | Doit être cohérent (≥ 1900 et ≤ année en cours + 1) |
| `vehicle_type` | Énumération | Oui | `car`, `van`, `truck`, `bus`, `motorcycle`, `other` |
| `fuel_type` | Énumération | Oui | `petrol`, `diesel`, `hybrid`, `electric`, `lpg`, `other` |
| `color` | Chaîne de caractères | Non | Nullable |
| `mileage_km` | Entier non signé | Oui | Kilométrage actuel (défaut : 0). Doit être ≥ 0 |
| `registration_date` | Date | Non | Nullable – date de mise en circulation |
| `status` | Énumération | Oui | `available`, `assigned`, `inactive`, `archived` (défaut : `available`) |
| `notes` | Texte long | Non | Nullable – remarques libres |
| `created_by` | Identifiant (clé étrangère) | Non | Nullable – référence `users(id)` (qui a créé) |
| `updated_by` | Identifiant (clé étrangère) | Non | Nullable – référence `users(id)` (qui a modifié) |
| `created_at` | Date / Heure | Oui (auto) | - |
| `updated_at` | Date / Heure | Oui (auto) | - |
| `deleted_at` | Date / Heure | Non | Nullable – soft delete |

**Index conseillés** : `registration_number`, `status`, `vehicle_type`, `fuel_type`, `created_by`, `updated_by`.

---

## 5. Table `drivers` (Chauffeurs)

**Rôle** : Référencer les personnes physiques qui conduisent les véhicules (qu’elles aient ou non un compte utilisateur).

| Champ | Type | Obligatoire | Contraintes / Particularités |
| :--- | :--- | :--- | :--- |
| `id` | Identifiant numérique | Oui | Clé primaire auto-incrémentée |
| `user_id` | Identifiant (clé étrangère) | Non | **Unique** si renseigné – référence `users(id)`. Un chauffeur peut être rattaché à un seul compte applicatif. |
| `first_name` | Chaîne de caractères | Oui | Prénom |
| `last_name` | Chaîne de caractères | Oui | Nom |
| `phone` | Chaîne de caractères | Oui | **Unique** |
| `email` | Chaîne de caractères | Non | **Unique** si renseigné |
| `license_number` | Chaîne de caractères | Oui | **Unique** (numéro de permis) |
| `license_category` | Chaîne de caractères | Oui | Catégorie du permis (ex: B, C, D, CE) |
| `license_expiry_date` | Date | Non | Nullable – date d’expiration du permis (utile pour la conformité) |
| `status` | Énumération | Oui | `available`, `assigned`, `unavailable`, `inactive`, `archived` (défaut : `available`) |
| `address` | Texte long | Non | Nullable – adresse postale |
| `hire_date` | Date | Non | Nullable – date d’embauche |
| `notes` | Texte long | Non | Nullable – remarques libres |
| `created_by` | Identifiant (clé étrangère) | Non | Nullable – référence `users(id)` |
| `updated_by` | Identifiant (clé étrangère) | Non | Nullable – référence `users(id)` |
| `created_at` | Date / Heure | Oui (auto) | - |
| `updated_at` | Date / Heure | Oui (auto) | - |
| `deleted_at` | Date / Heure | Non | Nullable – soft delete |

**Index conseillés** : `user_id`, `phone`, `email`, `license_number`, `status`, `created_by`, `updated_by`.

---

## 6. Table `vehicle_assignments` (Affectations)

**Rôle** : Tracer l’historique des affectations entre un véhicule et un chauffeur. C’est le pivot central de la V1.

| Champ | Type | Obligatoire | Contraintes / Particularités |
| :--- | :--- | :--- | :--- |
| `id` | Identifiant numérique | Oui | Clé primaire auto-incrémentée |
| `vehicle_id` | Identifiant (clé étrangère) | Oui | Référence `vehicles(id)` |
| `driver_id` | Identifiant (clé étrangère) | Oui | Référence `drivers(id)` |
| `assigned_by` | Identifiant (clé étrangère) | Non | Nullable – référence `users(id)` (utilisateur qui a fait l’affectation) |
| `start_date` | Date | Oui | Date de début d’affectation |
| `end_date` | Date | Non | Nullable – date de fin. Si `end_date` est renseigné, doit être ≥ `start_date` |
| `status` | Énumération | Oui | `pending`, `active`, `ended`, `cancelled` (défaut : `pending`) |
| `assignment_type` | Énumération | Oui (défaut) | `primary` (principale), `temporary` (temporaire), `replacement` (remplacement). Défaut : `primary` |
| `notes` | Texte long | Non | Nullable – remarques libres |
| `created_by` | Identifiant (clé étrangère) | Non | Nullable – référence `users(id)` |
| `updated_by` | Identifiant (clé étrangère) | Non | Nullable – référence `users(id)` |
| `created_at` | Date / Heure | Oui (auto) | - |
| `updated_at` | Date / Heure | Oui (auto) | - |
| `deleted_at` | Date / Heure | Non | Nullable – soft delete (permet de masquer une saisie erronée) |

**Index conseillés** : `vehicle_id`, `driver_id`, `assigned_by`, `status`, `start_date`, `end_date`, `created_by`, `updated_by`.

---

## 7. Règles de gestion critiques (intégrité des données)

Pour garantir la cohérence du parc, ces règles doivent être appliquées (au niveau base de données ou, à défaut, au niveau applicatif) :

1. **Exclusivité d’affectation active**  
   - Un véhicule dont le statut est `assigned` ne peut avoir qu’une seule affectation `active` dans la table `vehicle_assignments`.  
   - Un chauffeur dont le statut est `assigned` ne peut avoir qu’une seule affectation `active`.  
   - *Solution technique recommandée* : création d’un index unique partiel sur `(vehicle_id, status)` pour `status = 'active'`, et idem sur `(driver_id, status)`. Si le SGBD ne le permet pas (MySQL), une validation explicite dans le code (Observer ou règle métier) avant l’écriture est indispensable.

2. **Cohérence des dates**  
   - `start_date` ne peut pas être dans le futur (sauf si c’est une affectation prévue `pending`).  
   - Si `end_date` est renseigné, il ne peut pas être antérieur à `start_date`.  

3. **Cohérence des statuts**  
   - Lorsqu’une affectation passe en `active`, le statut du véhicule et du chauffeur concernés doit automatiquement passer à `assigned` (ou bloquer si ce n’est pas le cas).  
   - Lorsqu’une affectation `active` est terminée (`ended` ou `cancelled`), le statut du véhicule et du chauffeur doit repasser à `available` (sauf s’ils ont une autre affectation active, ce qui est interdit par la règle n°1).

4. **Contraintes d’unicité**  
   - `email` utilisateur unique, `phone` utilisateur unique si présent.  
   - `registration_number` véhicule unique.  
   - `phone`, `email`, `license_number` chauffeur uniques.  
   *(Note technique : Pour être compatible avec le SoftDelete, ces contraintes sont implémentées en base de données via des index uniques partiels PostgreSQL qui excluent les lignes où `deleted_at IS NOT NULL`)*.

5. **Contrainte d’année** : L’année du véhicule ne peut pas être inférieure à 1900 ni supérieure à l’année en cours + 1.

---

## 8. Synthèse des énumérations (valeurs autorisées)

| Table | Champ énuméré | Valeurs possibles | Défaut |
| :--- | :--- | :--- | :--- |
| `users` | `status` | `active`, `inactive`, `suspended` | `active` |
| `vehicles` | `vehicle_type` | `car`, `van`, `truck`, `bus`, `motorcycle`, `other` | - |
| `vehicles` | `fuel_type` | `petrol`, `diesel`, `hybrid`, `electric`, `lpg`, `other` | - |
| `vehicles` | `status` | `available`, `assigned`, `inactive`, `archived` | `available` |
| `drivers` | `status` | `available`, `assigned`, `unavailable`, `inactive`, `archived` | `available` |
| `vehicle_assignments` | `status` | `pending`, `active`, `ended`, `cancelled` | `pending` |
| `vehicle_assignments` | `assignment_type` | `primary`, `temporary`, `replacement` | `primary` |

---

## 9. Relations entre les tables (résumé)

- **Users** ↔ **Roles** / **Permissions** : relation many-to-many (via Spatie).
- **Users** ↔ **Drivers** : un utilisateur peut avoir zéro ou un chauffeur (one-to-one, avec `user_id` sur `drivers`).
- **Vehicles** ↔ **VehicleAssignments** : one-to-many. Un véhicule peut avoir plusieurs affectations historiques.
- **Drivers** ↔ **VehicleAssignments** : one-to-many. Un chauffeur peut avoir plusieurs affectations historiques.
- **Users** ↔ **VehicleAssignments** : un utilisateur peut créer/modifier plusieurs affectations (via `assigned_by`, `created_by`, `updated_by`).
- **Users** ↔ **Vehicles** : un utilisateur peut créer/modifier plusieurs véhicules (via `created_by`, `updated_by`).
- **Users** ↔ **Drivers** : un utilisateur peut créer/modifier plusieurs chauffeurs (via `created_by`, `updated_by`).

---

## 10. Ce qui est volontairement laissé de côté (post-V1)

Afin de ne pas alourdir le socle, les modules suivants sont exclus de cette modélisation :

- Gestion des maintenances et réparations.
- Gestion des documents (assurances, cartes grises, PV).
- Gestion des notifications métier (alertes, rappels).
- Audit complet des actions (logs historiques) – seuls `created_by` / `updated_by` assurent une traçabilité minimale.
- Module de rapports et statistiques avancés. (Sera ajouté très bientôt)
- Suivi kilométrique évolutif (via des relevés journaliers).

---

**Conclusion** : Cette modélisation V1 constitue un socle robuste, opérationnel dès les premiers sprints, et parfaitement extensible. Elle garantit la traçabilité des actions essentielles et l’intégrité des affectations, pierre angulaire de la gestion de parc. Elle est maintenant prête à être soumise aux équipes de développement pour l’implémentation.