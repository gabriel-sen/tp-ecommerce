# tp-ecommerce
### Installez Symfony 5 
  https://symfony.com/download
  
### installez Bootstrap
  https://getbootstrap.com/docs/4.1/getting-started/download/
  - on l'install dans le dossier Public / assets
    - Dans le fichier ```shell base.html.twig``` via la ligne :
      ```shell
      <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
      ```
    - Pareil pour le JS de Bootstrap : 
      ```shell 
      <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script> 
      ```
