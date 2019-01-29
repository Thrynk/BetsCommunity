<?php
try {
    $db = new PDO('mysql:host=mysql-betscommunity.alwaysdata.net;dbname=betscommunity_bets', '156253', 'PHILIPPE');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$manager = new MatchsManager($db);
$managerBets = new BetsManager($db);
$managerBattleBettings = new BattleBettingsManager($db);
$managerUsers = new UsersManager($db);

$arrayCompets = array(
  'Bundesliga' => 452,
  'Ligue 1' => 450,
  'Premier league' => 445,
  'Liga' => 455,
  'Serie A' => 456,
  'Champion s League' => 464,
  'World Cup' => 467
);
$ligue1 = array();
$bundesliga = array();
$premierleague = array();
$liga = array();
$serieA = array();
$champions = array();
$worldcup = array();

if(isset($_SESSION['championnatsUser']) && isset($_GET['championnat'])){
  $championnats = $_SESSION['championnatsUser'];
  $_SESSION['championnatCourant'] = $_GET['championnat'];
  $keyBattle = $_GET['championnat'];
  if(isset($championnats[$keyBattle])){
    $_SESSION['battle'] = $championnats[$keyBattle];
    $matchs = $manager->getListFromBattleBetting($championnats[$keyBattle]);
    $matchsAll = $manager->getListOfAllFromBb($championnats[$keyBattle]);
    if(isset($_SESSION['user'])){
      $user = $_SESSION['user'];
      $bets = $managerBets->getListFromUserAndBattleBetting($user, $_SESSION['battle']);
    }
    else{
      header('Location: index.php');
    }
    if($matchs != false){
      for($i = 0; $i<sizeof($matchs); $i++){
        if($matchs[$i]->championnat() == $arrayCompets['Ligue 1']){
          $ligue1[] = $matchs[$i];
        }
        else if($matchs[$i]->championnat() == $arrayCompets['Bundesliga']){
          $bundesliga[] = $matchs[$i];
        }
        else if($matchs[$i]->championnat() == $arrayCompets['Premier league']){
          $premierleague[] = $matchs[$i];
        }
        else if($matchs[$i]->championnat() == $arrayCompets['Liga']){
          $liga[] = $matchs[$i];
        }
        else if($matchs[$i]->championnat() == $arrayCompets['Serie A']){
          $serieA[] = $matchs[$i];
        }
        else if($matchs[$i]->championnat() == $arrayCompets['Champion s League']){
          $champions[] = $matchs[$i];
        }
        else if($matchs[$i]->championnat() == $arrayCompets['World Cup']){
          $worldcup[] = $matchs[$i];
        }
      }
    }
    else{
      $message = 'Pas de grille de paris disponible pour le moment.';
    }
    if($matchsAll != false){
      for($i = 0; $i<sizeof($matchsAll); $i++){
        $betOfMatchAll = NULL;
        foreach($bets as $key => $bet){
          if($bet->id_match() == $matchsAll[$i]->id()){
            $betOfMatchAll = $bet;
            break;
          }
        }
        if($betOfMatchAll){
          if($betOfMatchAll->win() == NULL){
            $betOfMatchAll->WinOrLose($matchsAll[$i]);
            $managerBets->update($betOfMatchAll);
          }
        }
      }
    }
    $nombreCompets = 0;
    if(!empty($ligue1)){
      $nombreCompets++;
      $_SESSION['ligue1'] = $ligue1;
    }
    if(!empty($bundesliga)){
      $nombreCompets++;
      $_SESSION['bundesliga'] = $bundesliga;
    }
    if(!empty($premierleague)){
      $nombreCompets++;
      $_SESSION['premierleague'] = $premierleague;
    }
    if(!empty($serieA)){
      $nombreCompets++;
      $_SESSION['ligue1'] = $ligue1;
    }
    if(!empty($champions)){
      $nombreCompets++;
      $_SESSION['champions'] = $champions;
    }
    if(!empty($worldcup)){
      $nombreCompets++;
      $_SESSION['worldcup'] = $worldcup;
    }
    if(!empty($liga)){
      $nombreCompets++;
      $_SESSION['liga'] = $liga;
    }
    $_SESSION['nombreCompets'] = $nombreCompets;
  }
}
else{
  header('Location: index.php');
}
