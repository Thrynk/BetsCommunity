<?php
include('models/rejoindre-championnat.php');
if(isset($usercookie)){
  $_SESSION['user'] = $managerUsers->get($usercookie);
}
if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];
  if(isset($_POST['nom']) && isset($_POST['acces']) && isset($_POST['password'])){
    if($manager->exists($_POST['nom'])){
      $battle = $manager->getFromName($_POST['nom']);
      if($manager->existsUserInBattleBetting($user, $battle)){
        $message = 'Vous participez déjà à ce championnat.';
      }
      else{
        if($_POST['acces'] == 'mdp'){
          if(password_verify($_POST['password'], $battle->code()) && strtotime(date('Y-m-d')) <= strtotime($battle->end_subscribe_date())){
            $manager->addUserInBattleBetting($user, $battle);
            header('Location: index.php');
          }
          else if(strtotime(date('Y-m-d')) > strtotime($battle->end_subscribe_date())){
            $message = 'Vous ne pouvez plus rejoindre ce championnat, les inscriptions sont finies.';
          }
          else{
            $message = 'Mot de passe incorrect.';
          }
        }
        else if($_POST['acces'] == 'ouvert'){
          if(strtotime(date('Y-m-d')) <= strtotime($battle->end_subscribe_date())){
            $manager->addUserInBattleBetting($user, $battle);
            header('Location: index.php');
          }
          else{
            $message = 'Vous ne pouvez plus rejoindre ce championnat, les inscriptions sont finies.';
          }
        }
      }
    }
    else{
      $message = 'Ce championnat n\'existe pas vérifier que vous avez saisi le bon nom.';
    }
  }
}
else{
  header('Location: index.php?page=nonco');
}

include('views/rejoindre-championnat.php');
