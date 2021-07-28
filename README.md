# happywait

API permettant d'envoyer par email un lien de connexion valable 10 minutes.

Les bundles utilisés sont :
- SwiftMailer : Librairie permettant d'envoyer des emails, ici paramétrée avec une adresse Gmail
- UrlSignerBundle : Librairie permettant la création d'URL signés

Attention : UrlSignerBundle avait des problèmes de dépendances sur mon projet, j'ai dû corriger le bundle avant de pouvoir m'en servir.

Pour tester l'API :
- La route /api/send/{email} enverra un mail à l'adresse renseignée comportant un lien de connexion valable 10 minutes.
