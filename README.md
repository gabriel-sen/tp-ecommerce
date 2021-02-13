# tp-ecommerce

## Installez Wamp 
(ou Mamp ou xamp) 

https://www.wampserver.com/

## installez Composer 
Si PHP est installé sur le system ouvre les invit de commandes :
``` shell
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
Sinon : 
https://getcomposer.org/download/

## Installez Symfony 5 
  https://symfony.com/download

## Installez Apach-pack
    ``` shell
    composer require symfony/apache-pack
    ```
  Pour la réécriture des URL et surtout avoir accès à la barre de débuggage de Symfony 5
  https://symfony.com/doc/current/setup/web_server_configuration.html

## installez Bootstrap
  https://getbootstrap.com/docs/4.1/getting-started/download/
  - on l'install dans le dossier Public / assets
    - Dans le fichier ``` base.html.twig ``` via la ligne :
      ``` shell
      <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
      ```
    - Pareil pour le JS de Bootstrap : 
      ``` shell
      <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script> 
      ```

***


## 1 : la home page
- J'ai conçu un controler et un template pour la home nommé home via la commande :
  ```
  symfony console make:controller
  ```
  Dedans je modifie sa route ```/home ``` pour ```/ ``` ainsi, symfony l'utilisera en guise de hompage.


- Dans le repo ```shell template > home ``` le fichier ```index.html.twig``` j'ai gardé que l'extends de la base.html.twig pour qu'il prenne les assets du projet.

- Dans ``` base.html.twig ``` je créer un block nommé content
  ``` shell 
  {% block content %} xxxx  {% endblock %} 
  ```
  
- Dans ``` index.html.twig ``` je créer également un block et j'y écris le code de mon contenu de home page. 
  ``` shell 
  {% block content %} xxxx  {% endblock %} 
  ``` 
    Le contenu sera placé sur la home page dans la balise du même  nom grace à l'extends.


## 2 : Les membres

### 2.1 : Création de l'entité User()
Je veux créer une entité User pour schématiser sa table User qui sera en base de donnée qui permettras de stocker les informations de l'utilisateur.
https://symfony.com/doc/current/security.html#a-create-your-user-class
  ``` shell 
  symfony console make:user
  ``` 
Ce qui va nous créer : 
``` shell 
created: src/Entity/User.php 
created: src/Repository/UserRepository.php
updated: src/Entity/User.php
updated: config/packages/security.yaml
``` 
####En détail : 
- ``` src/Entity/User.php ``` Contient une classe User (qui implémente le schéma Userinterface) avec divers fonctions ayant pour but de get/set diverses données. On utilisera l'ORM doctrine pour intéragir avec la base de donnée.
- ``` src/Repository/UserRepository.php ``` Contient tout ce qui touche à la récupération des données de l'entité user(). 
- ``` config/packages/security.yaml ``` Contient entités ainsi que leurs règles. User, Admin, Public...

####Création de la BDD
- S'assurer que le sever MySQL est en fonctionnement dans la version 5.7 minimum
- S'assurer que ``` extension=pdo_mysql ``` dans le fichier php.ini de la version référant de nos variables d'environement system + de notre WAMP soit bien décommenté.
- Se rendre dans le fichier ``` .env ``` et modifier les deux dernières lignes. 
    ```shell 
    # DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
    DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8"
  ```
  * ``` DATABASE_URL ="mysql:// ```  l'ID du user ``` : ``` mot de passe  ``` @ip du server: ``` port (vérifier sur phpMyadmin) ``` / ``` nom du server ``` ? ``` version du server.
  * #####On commente la ligne suivante
  ```shell 
    DATABASE_URL="mysql://root:@127.0.0.1:3306/ecommerce?serverVersion=5.7"
    #DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8"
  ```
- Pour créer la BDD on utilise la commande 
    ``` shell 
    symfony console doctrine:database:create
    ``` 
- Dans PHPStorm nous avons accès à une vue BDD On s'affranchis ainsi de MySQL Workbench ou de PHPMyAdmin
    - dans l'onglet database à droite on clique sur +
    - Data source > MySQL
    - Une frois tout les champs renseigné, on Test
    - ERROR
    - On sélectionne la TimeZone on apply et OK.
  
###Création de la table User
- Nous allons utiliser doctrine pour faire une migration. Une migration c'est un fichier php qui contient les requettes SQL à éxécuter à partir des entités et les shémas qui y sont listés. Il permet d'appliquer des changements dans la BDD sans risque de tout casser. 
``` shell 
symfony console make:migration
``` 
- Il faut run la migration pour l'appliquer
``` shell 
 php bin/console doctrine:migrations:migrate
``` 
- La table User est crééer avec la structure attendu dans l'entité User.php. C'est à dire ;  id, email, role, password 

### 2.2 : Création d'un formulaire d'inscription

### 2.3 : Création d'un formulaire de connection

### 2.5 : Création d'un espace privé membre. 
