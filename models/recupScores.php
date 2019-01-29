<?php
require_once('classes/MatchsManager.class.php');
require_once('classes/Match.class.php');
try {
    $db = new PDO('mysql:host=mysql-betscommunity.alwaysdata.net;dbname=betscommunity_bets', '156253', 'PHILIPPE');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$arrayCompets = array(
  'Bundesliga' => 452,
  'Ligue 1' => 450,
  'Premier league' => 445,
  'Liga' => 455,
  'Serie A' => 456,
  'Champion s League' => 464,
  'World Cup' => 467
);
foreach($arrayCompets as $key => $value){
$uri = 'http://api.football-data.org/v1/competitions/'.$value.'/fixtures/?timeFrameStart='. date('Y-m-d') . '&timeFrameEnd=' . date('Y-m-d', strtotime('+1 day ' . date('Y-m-d')));
$reqPrefs['http']['method'] = 'GET';
$reqPrefs['http']['header'] = 'X-Auth-Token: 96b49ffb45794b9390e6ade650f1985d';
$stream_context = stream_context_create($reqPrefs);
$response = file_get_contents($uri, false, $stream_context);
$fixtures = json_decode($response, true);
echo '<pre>';
print_r($fixtures);
echo '</pre>';

$managerMatchs = new MatchsManager($db);

for($i = 0; $i < $fixtures['count']; $i++){
  if($fixtures['fixtures'][$i]['status'] == 'FINISHED'){
    $date = str_replace('T', ' ', $fixtures['fixtures'][$i]['date']);
    $date = str_replace('Z', '', $date);
    if($managerMatchs->existsFromTeamNamesAndDate($fixtures['fixtures'][$i]['homeTeamName'], $fixtures['fixtures'][$i]['awayTeamName'], $date)){ /* SELECT * FROM `matchs` WHERE equipe1 = 'Stade Rennais FC' AND equipe2 = 'AS Monaco FC' AND date = '2018-04-04 16:45:00' */
      $match = $managerMatchs->getFromTeamNamesAndDate($fixtures['fixtures'][$i]['homeTeamName'], $fixtures['fixtures'][$i]['awayTeamName'], $date);
      $match->setScores($fixtures['fixtures'][$i]['result']['goalsHomeTeam'], $fixtures['fixtures'][$i]['result']['goalsAwayTeam']);
      $match->setStatut($fixtures['fixtures'][$i]['status']);
      $managerMatchs->update($match);
      echo 'reussi<br>';
    }
    else{
      echo 'echec<br>';
    }
  }
  else{
    echo 'non fini <br>';
  }
}
}
