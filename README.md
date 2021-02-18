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



_____________
_____________

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

___________________
___________________

## 2 : Les membres (BDD, tables)

### 2.1 : Création de l'entité User()
_______________________
Je veux créer une entité User pour schématiser sa table User dans la BDD.
https://symfony.com/doc/current/security.html#a-create-your-user-class

Cette entité me permet d'être la base sur laquel ```Registretype``` va s'appuiller pour vérifier si les éléments existent en base. 

Le fichier ```RegistreController.php``` aussi en a besoin pour créer le formulaire et l'injécter dans la vue.
_________________________
Donc, je créer l'entité User : 
``` shell 
  symfony console make:user
  ``` 
Ce qui va nous créer 3 fichiers : 
``` shell 
created: src/Entity/User.php 
created: src/Repository/UserRepository.php
updated: src/Entity/User.php
updated: config/packages/security.yaml
``` 
#### En détail : 
1. ``` src/Entity/User.php ``` Contient une classe User (qui implémente le schéma Userinterface) avec divers fonctions ayant pour but de get/set diverses données. On utilisera l'ORM doctrine pour intéragir avec la base de donnée.
2. ``` src/Repository/UserRepository.php ``` Contient tout ce qui touche à la récupération des données de l'entité user(). 
3. ``` config/packages/security.yaml ``` Contient entités ainsi que leurs règles. User, Admin, Public...


### 2.2 Configuration de la futur BDD

Pour que ça marche, j'ai besoin de créer la BDD de ce projet contenant mes tables. 

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

### 2.3 Création de la BDD
- Pour créer la BDD on utilise la commande 
    ``` shell 
    symfony console doctrine:database:create
    ```
  
___________________
- Dans PHPStorm nous avons accès à une vue BDD On s'affranchis ainsi de MySQL Workbench ou de PHPMyAdmin
    - dans l'onglet database à droite on clique sur +
    - Data source > MySQL
    - Une frois tout les champs renseigné, on Test
    - ERROR
    - On sélectionne la TimeZone on apply et OK.
  
___________________
### 2.4 Création de la table User à partire de l'entité User avec doctrine.
Nous allons utiliser doctrine pour faire une migration. Le but est de demander une requete SQL ```CREAT TABLE user ...``` 
    
Simplement, une migration c'est un fichier php qui contient les requettes SQL à éxécuter à partir des entités et les shémas qui y sont listés. Il permet d'appliquer des changements dans la BDD sans risque de tout casser. a noter que la deuxieme partie du fichier d'une migration contient la requette SQL pour annuler cette migration. 
  ``` shell 
  symfony console make:migration
  ``` 
  - Il faut run la migration pour l'appliquer
  ``` shell 
   php bin/console doctrine:migrations:migrate
  ``` 
  - La table User est crééer avec la structure attendu dans l'entité User.php. C'est à dire ;  id, email, role, password 

## 3 : Création d'un formulaire d'inscription
#### Création de la vue du formulaire d'inscription
  - je commence par créer le contoller nommé ```RegisterController```
    ``` shell 
     symfony console make:controller
    ```
_____________________________
  Ce fichier va m'indiquer la route de la page inscription. Mais aussi me stocker dans une variable :
  
- $user l'objet de l'entité User()
- $form la création du formulaire à partir de ``RegisterType`` qui comportera les rélléments attendu du formulaire.
- Ce fichier nous retourne donc le contenu de la page ``register/index.html.twig``
- Je renome sa route pour ``` @Route("/inscription", name="register") ```
_____________________________
#### Zute, le formulaire est mal placé dans la vue. Il est collé au Carousel. Mettons un espace superieur sur le conteneur dessous SI le carousel est présents ur la page.
  - Dans le fichier ``` template > register > index.html.twig  ``` je créer mon block content. Avec mon contenu HTML dedans. 
  - Dans le fichier ``` base.html.twig```  je place le carousel sous une confition ``` if``` ainsi le carousel sera affiché uniquement si un ``` {% block carousel %}```  est définie dans la vue.
    ``` shell 
    {% if block('carousel') is defined %}
    ...contenu HTML du carousel...
    {% endif %}
    ```
  - Dans le fichier ```base.html.twig``` , On va ajouter une marge superieur à la section content UNIQUEMENT si le carousel n'est pas définie. On va passer une condition ```{% if block('carousel') is not defined %}``` dans la classe de son parent pour appliquer la class bootstraop ```mt-5``` Magrin top 5.
    ``` shell 
      <div class="container marketing {% if block('carousel') is not defined %}mt-5{% endif %}">
    ``` 
#### Voilà le Carousel dispose bien d'un espace en dessous.
_____________________________
#### Création des champs du formulaire à partir de l'entité user et l'injection dans la vue : 

  - Dans le fichier  ``` template > register > index.html.twig  ``` je créer un formulaire avec la cmd symfony Qui utilisera les données de l'entité User :
    ``` shell 
    symfony console make:form
    
    The name of the form class (e.g. TinyGnomeType):
    > Register
    
    The name of Entity or fully qualified model class name that the new form will be bound to (empty for none):
    > User
    
     Success! 
    ```
  - Grace à l'entité User, Symfony me créer ``` src > Form RegisterType.php``` comportant une fonction Build : 

    ``` shell
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email') // input
            // ->add('roles')
            ->add('password') // input
        ;
    }
     ```
  - Dans le fichier ```RegisterController.php``` 
  - Je crééer mon objet ```User()``` dans une variable ```$user```. Ne pas oublier d'importer  ```use App\Entity\User;```
      ``` shell
      $user = new User();
      ```
  - J'intencie (je créer) mon formulaire dans une variable ```$form``` en y plaçant en paramètre la classe ```RegisterType``` du fichier ```RegisterType.php``` Ainsi que l'objet ```User()``` que nous avons placé dans la variable ```$user```.
    ``` shell
    $form = $this->createForm(RegisterType::class, $user);
    ```
  - La classe doit retourner dans la vue, le formulaire placé en variable pour le template via un tableau associatif dans le return en 2em parametre :
      en clé je le nome ```'formulaire'``` => ```$form``` car le form est créé sur la ligne précédant maintenant je veux créer la vue de ce formulaire. J'utilise la methode ```createView()```.
    ``` shell
    'formulaire' => $form->createView()
    ```
    Ce qui donne en tout :
    ``` shell
    public function index(): Response
    {
      $user = new User();
      $form = $this->createForm(RegisterType::class, $user);
  
          return $this->render('register/index.html.twig', [
              'formulaire' => $form->createView()
          ]);
    }
    ```
    - Pour finir, dans la vue, ``` register > index.html.twig ``` je demande à symfony de créer le fomulaire à partire du rendu du controller ```RegisterController.php```:
    ``` shell
      {{ form(formulaire) }}
    ```
    Ce formulaire est créé par ```RegisterType.php``` au besoin de modifications des champs on le gère dans ce fichier.

________
Pour styliser le formulaire, se rendre sur la doc de symfony : https://symfony.com/doc/current/form/bootstrap4.html
- Twig propose de prendre en charge dans on fichier yml le style booststrap.
- Dans ``` config/packages/twig.yaml``` Ajouter la ligne : ```form_themes: ['bootstrap_4_layout.html.twig']``` pour affecter le style bootstrap au form. conformément à la doc.
________
#### Ajouter des champs à notre formulaire. Nous devons modifier L'entité User :
``` shell
    symfony console make:entity
```
  - Le terminal demande alors le nom de l'edntité, on renseigne : ```User```
  - Il dit que cette entité existe déjà alors Ajoutons de nouveaux champs.
  - On donne le nom du champs.
  - On donne le type du champs qui nous retourne su c'est un Varchar ```(String) 255 caracteres```
  - On choisit si ce champs peut etre ```null``` en BDD. Non
  - Veut on créer un nouveau ```user``` ? oui
    - on recommence la procédure pour ```Lastname```
    ##### Ce qui donne sur le terminal : 
    ```shell
      C:\wamp64\www\site-ecommerce (master -> origin) 
      λ symfony console make:entity
      
      Class name of the entity to create or update (e.g. BraveElephant):
      > User
      User
      Your entity already exists! So let's add some new fields!
      New property name (press <return> to stop adding fields):
      > firstname
      Field type (enter ? to see all types) [string]:
      >
      Field length [255]:
      >
      Can this field be null in the database (nullable) (yes/no) [no]:
      > no
      updated: src/Entity/User.php
      Add another property? Enter the property name (or press <return> to stop adding fields):
      > lastname
      Field type (enter ? to see all types) [string]:
      >
      Field length [255]:
      >
      Can this field be null in the database (nullable) (yes/no) [no]:
      > no
      updated: src/Entity/User.php
      Add another property? Enter the property name (or press <return> to stop adding fields):
      >
      Success!
      Next: When you're ready, create a migration with php bin/console make:migration
      >
      C:\wamp64\www\site-ecommerce (master -> origin)
      λ

    ```
  - On va donc pouvoir créer une migration pour ALTER TABLE la table USER déjà existante et y appliquer nos nouveaux champs de données : 
    ``` shell
    Next: When you're ready, create a migration with php bin/console make:migration
    
    C:\wamp64\www\site-ecommerce (master -> origin)
    λ symfony console make:migration
    
    Success!
    
    Next: Review the new migration "migrations/Version20210214142612.php"
    Then: Run the migration with php bin/console doctrine:migrations:migrate
    See https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html
    
    C:\wamp64\www\site-ecommerce (master -> origin)
    λ
    ```
  - Et pour finir on execute la migration avec doctrine. ```λ symfony console doctrine:migrations:migrate ``` ça nous éxécuter une SQL querrie.
##### C'est bon. On a ajouté dans notre BDD dans le tableau USER les champs : Firestname et Lastname.
  
#### Ajouter cette modification dans la vue : 
  - on retourne dans ```RegisterType.php``` Le fichier qui génère mon formulaire et on créer notre formulaire avec ses attributs ça donne ça : 
``` shell
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
  $builder
  
      ->add('firstname', TextType::class, [
          'label' => 'Votre nom',
          'attr' => [
          'placeholder' => 'Veuillez saisir votre nom'
        ]
      ])// fin input
  
      ->add('lastname', TextType::class, [
          'label' => 'Votre prénom',
          'attr' => [
              'placeholder' => 'Veuillez saisir votre prénom'
          ]
      ])// fin input
  
      ->add('email', EmailType::class, [
          'label' => 'Votre email',
          'attr' => [
              'placeholder' => 'exemple@mail.com'
          ]
      ]) // fin input
  
    ->add('password', RepeatedType::class, [
        'type' => PasswordType::class,
        'required' => true,
        'label' => 'Votre mort de passe',
        'first_options' => ['label' => 'Mot de passe'],
        'second_options' => ['label' => 'Confirmez votre mot de passe.'],
        'invalid_message' => 'Le mot de passe et le mot de passe de confirmation doivent être identiques.'
    ]) // fin input
  
      ->add('password_confirm', PasswordType::class, [
          'label' => 'Confirmez votre mot de passe',
          'mapped' => false, // on dit à symfony de ne pas lier à l'entité ce champs "password_confirm" dans l'entité User.
          'attr' => [
              'placeholder' => 'Confirmez votre mot de passe'
          ]
      ]) // fin input
  
      ->add('submit', SubmitType::class,[
          'label' =>"S'inscrire"
      ])
    ;
   }
 ```


### 3.1 : Sauvegarde des entrés du formulaire en BDD
J'ai donc un formulaire de création de compte en vue et une table user en BDD.
Pour l'instant à la validation du formulaire, rien ne s'écrit dans le tableau User.
Voici comment je vais procéder : 
1. Dès que le formulaire est soumis
2. Je veux que tu traites l'information saisie
3. Regarde si le formulaire est valide 
4. Enregistre dans mon tableau user() les donnés entré par l'utilisateur.

Dans le fichier  ``` RegisterController.php  ``` nous allons écrire celà dans la fonction index.
1. On dois faire une injection de dépendance pour dire à symfony de rentrer dans la fonction en écoutant la requette HTTP qu'on place dan sune variable ```$request```
Ce qui donne ``public function index(Request $request): Response`` On utilisera .
   
2. On demand à la fonction d'écouter la requette (à la recherche d'un post) ```$form->handleRequest($request);``` on utiliseras```use Symfony\Component\HttpFoundation\Request;```.
A ce niveau mon formulaire est écouté.
   
3. On dois vérifié si le formulaire est soumis ET sile formulaire est valide par rapport a l'objet dans le fichier entité user, user()
   ```if($form->isSubmitted() && $form->isValid()){ } ```
   
   3.1 dans une variable $user,  on va demander à symfony d'injécter dans mon objet User(), toute les donnés reçu de la requette :
   ```$user = $form->getdata();```
   
   3.2 Puis on va les tester : 
   ```dd($user);```
    #### Ca donne ça : 
``` shell
    public function index(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
    
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getdata();
    
            //pour tester
            dd($user);
        }
    
        return $this->render('register/index.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }
```
    
    Bon, c'est cool. Sauf qu'on veux envoyer nos donnés dans notre table User() en base de donnée. 
    Et bien je vais utiliser mon ORM Doctrine : 
    A suivre. 
   

4. Enregistre dans mon tableau user() les donnés entré par l'utilisateur.
   
4.1. Il n'est pas impossible que mon controller ai à terme plusieurs fonctions. Je risque d'avoir besoin de Doctrine un peux partout. Je vais donc l'écrire dans mon contructeur et pas dans ma function.
    Je dois initialiser une variable qui seras doctrine. La convention de Symfony m'oblige à l'appeler```private $entityManager; ``` Car c'est le manager de Doctrine qu'on utilise pour faire nos manipulations.

4.2. Je créer ma fonction de sonctruction. J'y injecte le manager d'interface et qui prendras comme nom une variable.``` public function __construct(EntityManagerInterface $entityManager){```    
     
4.3. Dans ce manager d'entité (```private $entitymanager```), tu lui met dedans, l'entité manager que tu viens d'instancier et mis dans une variable lors de ton injection dans la fonction ```__construct```. ```$this->entityManager = $entityManager;```.

Ce qui donne : 
 ```shell
    private $entityManager;
        public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
``` 

4.4. J'appelle doctrine : ```$doctrine = $this->getDoctrine()->getManager();```
    Je demande à Doctrine de me figer la data pour l'enregistrer. 
``` shell
    $this->entityManager->persist($user);
```

4.3. Tu execute l'objet que tu as figé et tu l'enregistre en base de donnée
``` shell
    $this->entityManager->flush()
```
Ce qui donne : 
``` shell
     &class RegisterController extends AbstractController
    {
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
    $this->entityManager = $entityManager;
    }
    /**
    * @Route("/inscription", name="register")
    */
    public function index(Request $request): Response
    {
    $user = new User();
    $form = $this->createForm(RegisterType::class, $user);
    
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
                $user = $form->getdata();
    
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
    
            return $this->render('register/index.html.twig', [
                'formulaire' => $form->createView()
            ]);
        }
    }
```

### 4 : Encodage des mot de passes. 

Dans le fichier ```security.yaml``` nous avons en tête des lignes qui nous interessent :

```shell
    security:
        encoders:
            App\Entity\User:
                algorithm: auto
```
Ca dit que dans l'entité User, oui, tu encode les mot de passes. 
La ligne ```algorithm: auto```signifie que symfony doit utiliser la meilleur methode d'encodage possible. 

Dans RegisterController.php on dois injécter la dépendance ``` UserPasswordEncoderInterface $encoder ``` pour qu'il utilise bien ce parametre. 
On l'injecte dans la fonction qui permet d''écrire en base de donnée.'

```  shell
 public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
  ```

Je vais tester si l'encodage fonctionne bien à la soumission de mon formulaire : 
``` shell 
    $password = $encoder->encodePassword($user, $user->getPassword());
    dd($password);
```