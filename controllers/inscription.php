<?php
include('models/inscription.php');

if(isset($_POST['login']) && isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['mail'])){
  $user = new User(array(
    'pseudo' => $_POST['login'],
    'mail' => $_POST['mail'],
    'subscribe_date' => date('Y-m-d H:i:s')
  ));
  if($manager->exists($user->pseudo())){
    $message = 'Cet identifiant est déjà pris.';
    $alert = 'alert-danger';
    unset($user);
    include('views/accueil.php');
  }
  else if($manager->existsWithMail($user->mail())){
    $message = 'Votre e-mail est déjà renseigné, vous devez déjà être inscrit.';
    $alert = 'alert-danger';
    unset($user);
    include('views/accueil.php');
  }
  else if($_POST['password1'] != $_POST['password2']){
    $message = 'Les mots de passe ne correspondent pas.';
    $alert = 'alert-danger';
    unset($user);
    include('views/accueil.php');
  }
  else{
    $user->hydrate(array(
      'password' => password_hash($_POST['password1'], PASSWORD_DEFAULT)
    ));
    $manager->add($user);
    $message = 'Merci de votre inscription';
    $alert = 'alert-success';
    include('views/accueil.php');
  }
}
