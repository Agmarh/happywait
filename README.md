# happywait

API permettant d'envoyer par email un lien de connexion valable 10 minutes.

Les bundles utilisés sont :
- SwiftMailer : Librairie permettant d'envoyer des emails, ici paramétrée avec une adresse Gmail
- UrlSignerBundle : Librairie permettant la création d'URL signés

Attention : UrlSignerBundle avait des problèmes de dépendances sur mon projet, j'ai dû corriger le bundle avant de pouvoir m'en servir.

Outils utilisés pour exécuté les tests :
- cmder : émulateur de console
- Postman : permet d'exécuter des appels HTTP via une interface graphique

Pour tester l'API :- 
- A l'aide d'une console cmd, déplacez vous dans le répertoir du projet
- Après avoir clôné le projet, pensez à exécuter la commande : composer install
- Démarrez le serveur avec cette commande : symfony server:start
- Via Postman (ou un autre outil), insérez l'adresse : http://127.0.0.1:8000/api/send/{email}
- La variable {email} est à remplacer par votre adresse email
- Vous devriez recevoir un mail contenant un lien valable 10 minutes vous permettant d'accéder à une page protégée de l'API.
