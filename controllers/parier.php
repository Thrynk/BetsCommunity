<?php
include('models/parier.php');
if(isset($usercookie)){
  $_SESSION['user'] = $managerUsers->get($usercookie);
}
if(isset($_SESSION['user']) && isset($_SESSION['battle']) && isset($_SESSION['championnatCourant'])){
  $user = $_SESSION['user'];
  $battle = $_SESSION['battle'];
  $championnatCourant = $_SESSION['championnatCourant'];
  if(isset($_SESSION['nombreCompets'])){
    $nombreCompets = $_SESSION['nombreCompets'];
  }
  if(isset($_SESSION['ligue1'])){
    $ligue1 = $_SESSION['ligue1'];
  }
  if(isset($_SESSION['bundesliga'])){
    $bundesliga = $_SESSION['bundesliga'];
  }
  if(isset($_SESSION['premierleague'])){
    $premierleague = $_SESSION['premierleague'];
  }
  if(isset($_SESSION['liga'])){
    $liga = $_SESSION['liga'];
  }
  if(isset($_SESSION['serieA'])){
    $serieA = $_SESSION['serieA'];
  }
  if(isset($_SESSION['champions'])){
    $champions = $_SESSION['champions'];
  }
  if(isset($_SESSION['worldcup'])){
    $worldcup = $_SESSION['worldcup'];
  }

  $j = 0;
  $boolligue1 = 0;
  $boolbundes = 0;
  $boolpl = 0;
  $boolliga = 0;
  $boolserieA = 0;
  $boolchampions = 0;
  $boolworldcup = 0;

  for($i = 0; $i < $nombreCompets; $i++){
    if(!empty($ligue1) && $boolligue1 == 0){
      $champ = $ligue1;
      $boolligue1 = 1;
    }
    else if(!empty($bundesliga) && $boolbundes == 0){
      $champ = $bundesliga;
      $boolbundes = 1;
    }
    else if(!empty($premierleague) && $boolpl == 0){
      $champ = $premierleague;
      $boolpl = 1;
    }
    else if(!empty($liga) && $boolliga == 0){
      $champ = $liga;
      $boolliga = 1;
    }
    else if(!empty($serieA) && $boolserieA == 0){
      $champ = $serieA;
      $boolserieA = 1;
    }
    else if(!empty($champions) && $boolchampions == 0){
      $champ = $champions;
      $boolchampions = 1;
    }
    else if(!empty($worldcup) && $boolworldcup == 0){
      $champ = $worldcup;
      $boolworldcup = 1;
    }

    foreach ($champ as $key => $match) {
      if(isset($_POST['bouton' . $j])){
        $bet = new Bet(array(
          'id_match' => $match->id(),
          'id_user' => $user->id(),
          'id_battle' => $_SESSION['battle']->id(),
          'prono' => $_POST['bouton' . $j],
          'date' => date('Y-m-d H:i:s')
        ));
        $manager->add($bet);
        if(isset($_POST['scoreEquipe1:'.$j]) && isset($_POST['scoreEquipe2:'.$j])){
          $bet->hydrate(array(
            'score1' => $_POST['scoreEquipe1:'.$j],
            'score2' => $_POST['scoreEquipe2:'.$j]
          ));
          $manager->addExactScores($bet);
        }
      }

      $j++;
    }
  }
  header('Location: index.php?page=afficher-championnat&championnat=' . $championnatCourant);
}
else{
  header('Location: index.php');
}
