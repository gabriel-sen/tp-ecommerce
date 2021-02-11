# tp-ecommerce
## Installez Symfony 5 
  https://symfony.com/download
  
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
    Le contenu sera placé sur la home page dans la balise du même nom graçe à l'extends.
      