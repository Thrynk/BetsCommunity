<?php
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
$uri = 'http://api.football-data.org/v1/competitions/'. $value. '/fixtures';
$reqPrefs['http']['method'] = 'GET';
$reqPrefs['http']['header'] = 'X-Auth-Token: 96b49ffb45794b9390e6ade650f1985d';
$stream_context = stream_context_create($reqPrefs);
$response = file_get_contents($uri, false, $stream_context);
$fixtures = json_decode($response, true);
/*echo '<pre>';
print_r($fixtures);
echo '</pre>';*/
$uri2 = 'http://api.football-data.org/v1/competitions/'. $value. '/teams';
$response2 = file_get_contents($uri2, false, $stream_context);
$fixtures2 = json_decode($response2, true);
/*echo '<pre>';
print_r($fixtures2);
echo '</pre>';*/
echo $fixtures['count'] . '<br>';
try {
    $db = new PDO('mysql:host=mysql-betscommunity.alwaysdata.net;dbname=betscommunity_bets', '156253', 'PHILIPPE');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
for($i = 0; $i < $fixtures['count']; $i++){
  echo $fixtures['fixtures'][$i]['homeTeamName'].' ';
  $key = array_search($fixtures['fixtures'][$i]['homeTeamName'], array_column($fixtures2['teams'], 'name'));
  echo $fixtures2['teams'][$key]['crestUrl'] . ' ';
  if(isset($fixtures['fixtures'][$i]['result']['goalsHomeTeam']) && isset($fixtures['fixtures'][$i]['result']['goalsAwayTeam'])){
    echo $fixtures['fixtures'][$i]['result']['goalsHomeTeam']. ' ';
    echo $fixtures['fixtures'][$i]['result']['goalsAwayTeam']. ' ';
  }
  echo $fixtures['fixtures'][$i]['awayTeamName']. ' ';
  $key2 = array_search($fixtures['fixtures'][$i]['awayTeamName'], array_column($fixtures2['teams'], 'name'));
  echo $fixtures2['teams'][$key2]['crestUrl'] . ' ';
  $date = str_replace('T', ' ', $fixtures['fixtures'][$i]['date']);
  $date = str_replace('Z', '', $date);
  echo $date. ' ';
  echo $fixtures['fixtures'][$i]['status'] .' ';
  echo $value.'<br>' .'<br>';
  if(isset($fixtures['fixtures'][$i]['result']['goalsHomeTeam']) && isset($fixtures['fixtures'][$i]['result']['goalsAwayTeam'])){
    $req = $db->prepare('REPLACE INTO matchs(logo1, equipe1, score1, score2, equipe2, logo2, date, statut, championnat) VALUES(:logo1, :equipe1, :score1, :score2, :equipe2, :logo2, :date, :statut, :championnat)');
    $req->execute(array(
      'logo1' => $fixtures2['teams'][$key]['crestUrl'],
      'equipe1' => $fixtures['fixtures'][$i]['homeTeamName'],
      'score1' => $fixtures['fixtures'][$i]['result']['goalsHomeTeam'],
      'score2' => $fixtures['fixtures'][$i]['result']['goalsAwayTeam'],
      'equipe2' => $fixtures['fixtures'][$i]['awayTeamName'],
      'logo2' => $fixtures2['teams'][$key2]['crestUrl'],
      'date' => $date,
      'statut' => $fixtures['fixtures'][$i]['status'],
      'championnat' => $value
    ));
    $req->closeCursor();
  }else{
    $req = $db->prepare('REPLACE INTO matchs(logo1, equipe1, equipe2, logo2, date, statut, championnat) VALUES(:logo1, :equipe1, :equipe2, :logo2, :date, :statut, :championnat)');
    $req->execute(array(
      'logo1' => $fixtures2['teams'][$key]['crestUrl'],
      'equipe1' => $fixtures['fixtures'][$i]['homeTeamName'],
      'equipe2' => $fixtures['fixtures'][$i]['awayTeamName'],
      'logo2' => $fixtures2['teams'][$key2]['crestUrl'],
      'date' => $date,
      'statut' => $fixtures['fixtures'][$i]['status'],
      'championnat' => $value
    ));
    $req->closeCursor();
  }
  /* INSERT INTO matchs(logo1, equipe1, equipe2, logo2, date, statut, championnat)
			SELECT :logo1, :equipe1, :equipe2, :logo2, :date, :statut, :championnat
			WHERE NOT EXISTS (SELECT equipe1, equipe2, date FROM matchs WHERE equipe1 = :equipe1 AND equipe2 = :equipe2 AND date = :date); */
}
}
