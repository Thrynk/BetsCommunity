<?php
include('models/creer_championnat.php');
if(isset($usercookie)){
  $_SESSION['user'] = $managerUsers->get($usercookie);
}
if(!isset($_SESSION['user'])){
  header('Location: index.php?page=nonco');
}
else{
  if(isset($_POST['nom']) && isset($_POST['acces']) && isset($_POST['password']) && isset($_POST['numberOfWeeks'])){
    $user = $_SESSION['user'];
    $message = 'Merci votre championnat a été enregistré. Veuillez continuer en choisissant les ligues sur lesquels les participants pariront.';
    if(strtotime(date('Y-m-d')) > strtotime('Wednesday')){
      $date_debut = date('Y-m-d', strtotime('next Monday'. ' ' . date('Y-m-d')));
    }
    else if(strtotime(date('Y-m-d')) == strtotime('Monday')){
      $date_debut = date('Y-m-d');
    }
    else{
      $date_debut = date('Y-m-d', strtotime('last Monday'. ' ' . date('Y-m-d')));
    }
    $jour = date('d', strtotime('next Monday'. ' ' . date('Y-m-d')));
    $date_fin = date('Y-m-d', strtotime('+'.$_POST['numberOfWeeks'].' weeks', strtotime($date_debut)));
    $date_fin_inscription = date('Y-m-d', strtotime('next Wednesday'. ' ' . date('Y-m-d')));
    if($_POST['acces'] == 'mdp'){
      $battle = new BattleBetting(array(
        'name' => htmlspecialchars($_POST['nom']),
        'code' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'id_creator' => $user->id(),
        'start_date' => $date_debut,
        'end_date' => $date_fin,
        'end_subscribe_date' => $date_fin_inscription
      ));
    }
    else if($_POST['acces'] == 'ouvert'){
      $battle = new BattleBetting(array(
        'name' => htmlspecialchars($_POST['nom']),
        'id_creator' => $user->id(),
        'start_date' => $date_debut,
        'end_date' => $date_fin,
        'end_subscribe_date' => $date_fin_inscription
      ));
    }
    if($manager->exists($battle->name())){
      $message = 'Ce nom de championnat est déjà pris.';
      unset($battle);
      unset($_POST);
    }
    if(isset($_POST['acces'])){
      if($_POST['acces'] == 'mdp'){
        $manager->add($battle);
        $manager->addUserInBattleBetting($user, $battle);
        $_SESSION['battle'] = $battle;
      }
      if($_POST['acces'] == 'ouvert'){
        $manager->addWithoutCode($battle);
        $manager->addUserInBattleBetting($user, $battle);
        $_SESSION['battle'] = $battle;
      }
    }

  }
}
include('views/creer_championnat.php');
