# happywait

API permettant d'envoyer par email un lien de connexion valable 10 minutes.

## Bundles utilisés
- SwiftMailer : Librairie permettant d'envoyer des emails, ici paramétrée avec une adresse Gmail
- UrlSignerBundle : Librairie permettant la création d'URL signés
- LexikJWTAuthenticationBundle : Librairie permettant de générer des Token
- Doctrine : Librairie de gestion de BDD native
- DoctrineFixturesBundle : Librairie permettant de générer un jeu de données

Attention : UrlSignerBundle avait des problèmes de dépendances sur mon projet, j'ai dû corriger le bundle avant de pouvoir m'en servir.

## Outils utilisés pour exécuté les tests
- cmder : émulateur de console
- Postman : permet d'exécuter des appels HTTP via une interface graphique

## Installation
- A l'aide d'une console cmd, déplacez vous dans le répertoir du projet
```bash
# Après avoir clôné le projet, pensez à exécuter la commande
composer install

# Créez la base de données
php bin/console make:migration

# Générez les tables
php bin/console make:migration
php bin/console doctrine:migrations:migrate

# Chargez les données
php bin/console doctrine:fixtures:load

# Lancez le serveur
symfony server:start
```

## Utilisation
- Via Postman (ou un autre outil), insérez l'adresse : http://127.0.0.1:8000/api/send/{email}
- La variable {email} est à remplacer par votre adresse email
- Vous devriez recevoir un mail contenant un lien valable 10 minutes vous permettant d'obtenir un Token d'authentification.

- Le Token récupéré est valable 2h et permet d'accéder à la page : http://127.0.0.1:8000/api
- Ajoutez le Token récupérer dans le headers de votre requête (Bearer Token).

## Ajouter des adresses mails à la base 
Pour ajouter des adresses mails à la base de données, modifiez le fichier se situant dans src/DataFixtures/AppFixtures.php.
Ajoutez autant d'utilisateur que vous le souhaitez, puis dans une nouvelle console cmd, utilisez la commande 

```bash
php bin/console doctrine:fixtures:load
```
Répondez "yes" à la question posé pour mettre à jour la base.

