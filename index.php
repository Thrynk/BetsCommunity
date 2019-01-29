<?php
include('models/autoload.php');
session_start();
if(isset($_COOKIE['user'])){
  $usercookie = $_COOKIE['user'];
}
if(isset($_GET['page'])){
  if($_GET['page'] == 'accueil'){
    include('controllers/accueil.php');
  }
  else if($_GET['page'] == 'inscription'){
    include('controllers/inscription.php');
  }
  else if($_GET['page'] == 'connexion'){
    include('controllers/connexion.php');
  }
  else if($_GET['page'] == 'deconnexion'){
    session_destroy();
    setcookie('user', '', -1);
    header('Location: index.php');
  }
  else if($_GET['page'] == 'creer-championnat'){
    include('controllers/creer_championnat.php');
  }
  else if($_GET['page'] == 'nonco'){
    $message = 'Vous devez être connecté pour effectuer cette action.';
    include('controllers/accueil.php');
  }
  else if($_GET['page'] == 'creer-championnat2'){
    include('controllers/creer_championnat2.php');
  }
  else if($_GET['page'] == 'afficher-championnat'){
    include('controllers/afficher-championnat.php');
  }
  else if($_GET['page'] == 'rejoindre-championnat'){
    include('controllers/rejoindre-championnat.php');
  }
  else if($_GET['page'] == 'parier'){
    include('controllers/parier.php');
  }
}
else{
  include('controllers/accueil.php');
}
