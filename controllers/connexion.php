<?php
include('models/connexion.php');
if(isset($_POST['login']) && isset($_POST['password'])){
  if($manager->exists($_POST['login'])){
    $user = $manager->get($_POST['login']);
    if(password_verify($_POST['password'], $user->password())){
      $_SESSION['user'] = $user;
      if($_POST['remember'] == 'oui'){
        setcookie('user', $user->pseudo(), time() + 3600*24*365);
      }
      header('Location: index.php');
    }
    else{
      $message = 'Mot de passe incorrect';
      $alert = 'alert-danger';
      include('views/accueil.php');
      ?>
      <?php
    }
  }
  else{
    $message = 'Mauvais identifiant';
    $alert = 'alert-danger';
    include('views/accueil.php');
  }
}
