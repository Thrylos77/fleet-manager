# FleetManager – Gestion numérique d’un parc automobile

## 1. Contexte du projet

Dans de nombreuses entreprises, la gestion d’un parc automobile repose encore sur des outils dispersés et peu adaptés aux besoins réels du terrain. Les véhicules sont souvent suivis dans des fichiers Excel, les chauffeurs sur des supports papier, les entretiens dans des cahiers, et les consommations de carburant sont enregistrées manuellement. Cette organisation rend le suivi lent, peu fiable et difficile à exploiter.

Avec un parc de plusieurs dizaines ou centaines de véhicules, il devient essentiel de disposer d’un outil centralisé permettant de mieux organiser les données, de suivre l’activité du parc et de prendre des décisions à partir d’informations claires et à jour.

C’est dans cette optique que l’entreprise souhaite mettre en place **FleetManager**, une application web de gestion numérique d’un parc automobile.

## 2. Sujet du projet

FleetManager est une application web destinée à centraliser et automatiser la gestion opérationnelle d’un parc automobile.

Le projet couvre principalement les besoins suivants :

* gestion des véhicules ;
* gestion des chauffeurs ;
* gestion des affectations ;
* gestion des entretiens ;
* gestion du carburant ;
* consultation de tableaux de bord et de statistiques ;
* gestion des utilisateurs et des droits d’accès.

L’application sera développée avec **Laravel** pour la logique métier et **Blade** pour l’interface utilisateur. Elle devra être simple, claire, évolutive et adaptée à un usage quotidien par différents profils d’utilisateurs.

## 3. Vision du produit

La vision de FleetManager est de devenir un **outil central de pilotage du parc automobile**, capable de remplacer progressivement les traitements manuels par un système numérique fiable, structuré et évolutif.

L’objectif n’est pas seulement de stocker des informations, mais de fournir une vraie solution de gestion permettant de :

* connaître l’état du parc en temps réel ;
* suivre les véhicules et leurs affectations ;
* organiser les chauffeurs et leurs missions ;
* planifier et conserver l’historique des entretiens ;
* enregistrer les consommations de carburant ;
* produire des indicateurs utiles à la prise de décision ;
* réduire les erreurs, les pertes d’information et les doublons.

FleetManager doit ainsi devenir un véritable support de travail pour les équipes administratives, logistiques et de supervision.

## 4. Contours du projet

Le projet se limite à la gestion interne du parc automobile. Il ne comprend pas, dans sa version initiale, la géolocalisation en temps réel, la télématique embarquée, ni l’intégration avec des systèmes externes complexes.

Le périmètre fonctionnel retenu comprend :

* l’authentification des utilisateurs ;
* la gestion des rôles et des permissions ;
* la gestion des véhicules ;
* la gestion des chauffeurs ;
* la gestion des affectations ;
* la gestion des entretiens ;
* la gestion du carburant ;
* les tableaux de bord et statistiques.

Le système doit rester évolutif afin de pouvoir intégrer plus tard des fonctionnalités comme les notifications, les alertes automatiques, les exports PDF/Excel, la gestion des assurances ou encore les demandes d’incident.

## 5. Gestion des utilisateurs et RBAC

FleetManager ne doit pas être conçu comme une application où tous les utilisateurs ont les mêmes droits. Dans un contexte professionnel réel, chaque profil a un niveau d’accès différent selon son rôle dans l’organisation.

Le projet adopte donc une logique de **RBAC (Role Based Access Control)**, c’est-à-dire une gestion des accès basée sur les rôles.

### 5.1 Les profils utilisateurs prévus

#### Administrateur

L’administrateur est le profil le plus complet de l’application.

Il peut :

* créer, modifier, activer ou désactiver des comptes ;
* attribuer des rôles ;
* accéder à toutes les fonctionnalités ;
* consulter tous les tableaux de bord ;
* gérer les paramètres généraux du système.

Ce profil peut être attribué à un responsable informatique ou à un administrateur fonctionnel de la solution.

#### Gestionnaire de parc

C’est l’utilisateur métier principal de l’application.

Il peut :

* gérer les véhicules ;
* gérer les chauffeurs ;
* affecter un chauffeur à un véhicule ;
* enregistrer les entretiens ;
* enregistrer les consommations de carburant ;
* consulter les tableaux de bord opérationnels.

Il n’a pas accès à la gestion complète des comptes utilisateurs.

#### Responsable / Manager

Ce profil est orienté consultation et pilotage.

Il peut :

* consulter les véhicules et les chauffeurs ;
* visualiser les affectations ;
* consulter les statistiques ;
* suivre les entretiens ;
* analyser les coûts de carburant.

Il intervient principalement pour le contrôle et la prise de décision, sans modifier les données sensibles.

#### Chauffeur

Le chauffeur dispose d’un accès limité et personnel.

Il peut :

* consulter son profil ;
* voir le véhicule qui lui est affecté ;
* consulter son historique d’affectations ;
* suivre certaines informations utiles liées à son activité.

Dans une version plus avancée, ce profil pourra aussi permettre de signaler un incident, une panne ou une anomalie.

### 5.2 Structure simplifiée des rôles

* **Administrateur** : gestion totale ;
* **Gestionnaire** : gestion opérationnelle du parc ;
* **Manager** : consultation et pilotage ;
* **Chauffeur** : accès personnel limité.

### 5.3 Évolution prévue du RBAC

La gestion des utilisateurs sera pensée de manière progressive :

* au départ, les rôles essentiels seront mis en place ;
* ensuite, les permissions pourront être affinées ;
* enfin, l’application pourra intégrer une gestion plus détaillée des droits par module ou par action.

Cette approche permet de garder un système simple au départ, tout en préparant une évolution plus professionnelle à long terme.

## 6. Approche Agile Scrum

Le développement de FleetManager suivra une approche **Agile Scrum** afin de livrer le produit par incréments successifs.

Cette méthode permet :

* de découper le projet en petites étapes appelées sprints ;
* de livrer rapidement des fonctionnalités utiles ;
* de recueillir des retours à chaque itération ;
* d’ajuster les priorités selon les besoins métier ;
* de garder une bonne visibilité sur l’avancement.

Le projet pourra être suivi dans un fonctionnement inspiré de **Jira**, avec :

* un **Product Backlog** regroupant toutes les fonctionnalités ;
* un **Sprint Backlog** pour chaque itération ;
* des statuts de type : *À faire*, *En cours*, *En test*, *Terminé* ;
* une validation de fin de sprint sous forme d’incrément fonctionnel.

## 7. Organisation du projet par versions

Pour donner une vision claire de l’évolution du produit, FleetManager peut être pensé en plusieurs versions.

### Version 1 – MVP

Cette première version contient les fonctionnalités indispensables au fonctionnement de base.

Elle inclut :

* authentification ;
* gestion des utilisateurs et rôles principaux ;
* gestion des véhicules ;
* gestion des chauffeurs.

Cette version permet d’obtenir un socle fonctionnel et exploitable.

### Version 2 – Exploitation opérationnelle

Cette étape renforce l’usage quotidien du système.

Elle inclut :

* gestion des affectations ;
* historique des affectations ;
* suivi des disponibilités ;
* premiers contrôles métiers.

### Version 3 – Suivi technique et financier

Cette version apporte davantage de suivi et de pilotage.

Elle inclut :

* gestion des entretiens ;
* suivi du carburant ;
* historique des opérations ;
* indicateurs de base.

### Version 4 – Pilotage avancé

Cette dernière étape met l’accent sur la décision et la supervision.

Elle inclut :

* tableaux de bord avancés ;
* statistiques détaillées ;
* indicateurs de performance ;
* alertes et améliorations futures.

## 8. Organisation des sprints

### Sprint 1 – Mise en place des fondations

Le premier sprint constitue la base de l’application.

#### Épics du Sprint 1 :

* **Authentification**

  * inscription ;
  * connexion ;
  * déconnexion ;
  * modification du mot de passe ;
  * consultation du profil.

* **Gestion des utilisateurs**

  * création d’un utilisateur ;
  * modification d’un utilisateur ;
  * consultation de la liste des utilisateurs ;
  * activation ou désactivation d’un compte ;
  * attribution d’un rôle.

* **Gestion des véhicules**

  * ajouter un véhicule ;
  * modifier un véhicule ;
  * consulter la liste des véhicules ;
  * afficher les détails d’un véhicule ;
  * supprimer un véhicule.

* **Gestion des chauffeurs**

  * ajouter un chauffeur ;
  * modifier un chauffeur ;
  * consulter la liste des chauffeurs ;
  * afficher les détails d’un chauffeur ;
  * supprimer un chauffeur.

Ce sprint pose le socle technique et fonctionnel de l’application.

### Sprint 2 – Affectations et usage métier

Ce sprint ajoute les premières fonctionnalités opérationnelles.

Fonctionnalités prévues :

* affecter un chauffeur à un véhicule ;
* modifier une affectation ;
* retirer une affectation ;
* consulter l’historique des affectations ;
* visualiser les véhicules disponibles.

### Sprint 3 – Entretiens et maintenance

Ce sprint permet de suivre l’état de maintenance du parc.

Fonctionnalités prévues :

* enregistrer un entretien ;
* planifier un entretien ;
* consulter l’historique des entretiens ;
* associer un entretien à un véhicule ;
* suivre les entretiens à venir.

### Sprint 4 – Carburant et coûts

Ce sprint introduit le suivi de la consommation et des dépenses.

Fonctionnalités prévues :

* enregistrer un ravitaillement ;
* renseigner la quantité et le coût ;
* consulter l’historique des consommations ;
* suivre les dépenses par véhicule ;
* analyser les tendances de consommation.

### Sprint 5 – Tableaux de bord et statistiques

Ce sprint complète le produit avec les fonctions de pilotage.

Fonctionnalités prévues :

* tableau de bord général ;
* statistiques sur les véhicules ;
* statistiques sur les chauffeurs ;
* suivi des entretiens ;
* suivi du carburant ;
* indicateurs de gestion.

## 9. Évolution progressive du produit

Le développement de FleetManager suit une logique incrémentale. Chaque sprint apporte une valeur concrète et exploitable.

* le **Sprint 1** construit le socle du système ;
* le **Sprint 2** permet l’usage opérationnel ;
* le **Sprint 3** améliore le suivi technique ;
* le **Sprint 4** introduit le suivi financier ;
* le **Sprint 5** transforme les données en outil d’aide à la décision.

Cette organisation permet de livrer rapidement une version utile, puis d’enrichir progressivement l’application selon les priorités métier.

## 10. Résultat attendu

À la fin du projet, l’entreprise disposera d’une application web moderne, centralisée et évolutive pour gérer efficacement son parc automobile.

FleetManager permettra de :

* réduire la gestion manuelle ;
* fiabiliser les informations ;
* structurer les rôles des utilisateurs ;
* améliorer le suivi des véhicules et des chauffeurs ;
* mieux contrôler les entretiens et le carburant ;
* disposer d’indicateurs utiles pour la prise de décision.

## 11. Technologies envisagées

* **Laravel** pour le développement back-end ;
* **Blade** pour les vues et l’interface utilisateur ;
* **MySQL ou PostgreSQL** pour la base de données ;
* **Tailwind** pour l’interface ;
* une gestion structurée du projet selon **Scrum** et le suivi des tâches façon **Jira**.

## 12. Conclusion

FleetManager est un projet de digitalisation d’un processus métier essentiel : la gestion d’un parc automobile. En s’appuyant sur Laravel et Blade, et en adoptant une approche Agile Scrum avec une gestion des utilisateurs en RBAC, le projet devient plus réaliste, plus structuré et plus proche d’un contexte professionnel réel.

La progression par versions et par sprints permet de construire une solution évolutive, capable d’accompagner l’entreprise depuis une première version fonctionnelle jusqu’à un véritable outil de pilotage du parc automobile.
