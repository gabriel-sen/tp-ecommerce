# tp-ecommerce
## Installez Symfony 5 
  https://symfony.com/download
  
## installez Bootstrap
  https://getbootstrap.com/docs/4.1/getting-started/download/
  - on l'install dans le dossier Public / assets
    - Dans le fichier ```shell base.html.twig``` via la ligne :
      ```
      <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
      ```
    - Pareil pour le JS de Bootstrap : 
      ```
      <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script> 
      ```

***


## 1 : la home page
- J'ai conçu un controler et un template pour la home nommé home via la commande :
      ```
      symfony console make:controller
      ```
  Dedans je modifie sa route /home pour / ainsi, symfony l'utilisera en guise de hompage.
 - Dans le repo template > home, le fichier index.html.twig j'ai gardé que l'extends de la base.html.twig pour qu'il prenne les assets du projet.
