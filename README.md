# Blog Professionnel en PHP

[![SymfonyInsight](https://insight.symfony.com/projects/26168549-ecdd-4f08-937b-d1c6878e1c7f/big.svg)](https://insight.symfony.com/projects/26168549-ecdd-4f08-937b-d1c6878e1c7f) [![OCP](https://img.shields.io/badge/OpenClassRooms%20Project-8A2BE2)](https://img.shields.io/badge/OpenClassRooms%20Project-8A2BE2)

Bienvenue sur le dépôt de mon blog professionnel développé en PHP. Ce blog est une plateforme où je partage mes connaissances, mes expériences et mes projets en tant que développeur PHP.

## 🌟 Caractéristiques

- Page d'accueil avec une présentation personnelle.
- Liste de tous les articles du blog.
- Détail de chaque article avec la possibilité d'ajouter des commentaires.
- Espace d'administration pour gérer les articles et les commentaires.
- Sécurité renforcée pour l'espace d'administration.
- Formulaire de contact pour me joindre directement.

## 🚀 Installation

1. Clonez ce dépôt dans le dossier www de Wampserver64 :
   ```bash
   git clone https://github.com/Teyk0o/Projet_OC_5.git
   ```

2. Installez les dépendances :
   ```bash
   composer install
   ```

3. Configurez votre base de données et votre serveur SMTP dans le fichier .env :
   ```env
   DB_HOST=
   DB_NAME=
   DB_USER=
   DB_PASS=

   SMTP_USERNAME=
   SMTP_PASSWORD=
   SMTP_HOST=
   SMTP_PORT=
   ```
4. Installez la base de donnée en cliquant sur l'icon Wamp64 puis sur PhpMyAdmin.

5. Une fois sur PhpMyAdmin, connectez-vous avec root et sans indiquer de mot de passe puis cliquez sur "Import" en spécifiant le fichier SQL disponible dans le dossier SQL du projet.
(La base de donnée est configurée !)

4. Maintenant cliquez sur l'icon Wamp64 dans votre barre des tâches puis sur VirtualHosts -> Gestion de vos VirtualHosts.

5. Remplissez les champs obligatoire et mettez le dossier contenant le projet en chemin d'accès.

6. Redémarrez Wamp64.

7. Cliquez sur l'icon Wamp64 dans votre barre des tâches puis sur VirtualHosts -> <Le nom du VirtualHosts que vous venez de créer>

4. Visitez le site internet, tout est prêt !

## 📝 Contribution

- Forkez ce dépôt.
- Créez une nouvelle branche avec le nom de la fonctionnalité ou de la correction que vous souhaitez ajouter.
- Faites vos modifications et poussez-les sur votre fork.
- Créez une pull request.
