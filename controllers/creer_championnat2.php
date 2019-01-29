<?php
include('models/creer_championnat2.php');
if(isset($_SESSION['battle'])){
  if(isset($_POST['Ligue'])){
    $matchs = array();
    $battle = $_SESSION['battle'];
    foreach($_POST['Ligue'] as $key => $value){
      $managerMatchs = new MatchsManager($db);
      $date_debut = $battle->start_date();
      $date_fin = date('Y-m-d', strtotime('next Monday'. ' ' .$battle->start_date()));
      while(strtotime($date_fin) <= strtotime($battle->end_date())){
        $matchs[] = $managerMatchs->getListFromBbAndChamp($battle, $value, $date_debut, $date_fin);
        $date_debut = date('Y-m-d', strtotime('next Monday'. ' ' .$date_debut));
        $date_fin = date('Y-m-d', strtotime('next Monday'. ' ' .$date_fin));
      }
    }
    $manager = new BattleBettingsManager($db);
    $manager->addMatchsAlea($matchs, $battle);
    unset($_SESSION['battle']);
    header('Location: index.php');
  }
}
else{
  header('Location: index.php');
}

include('views/creer_championnat2.php');
