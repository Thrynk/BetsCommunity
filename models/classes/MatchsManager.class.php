<?php
class MatchsManager{
  private $_db;

  public function __construct($db){
    $this->setDb($db);
  }

  public function getListFromBbAndChamp(BattleBetting $battle, $championnat, $date_debut, $date_fin){
    $q = $this->_db->prepare('SELECT * FROM matchs WHERE championnat = :championnat AND date BETWEEN :date1 AND :date2');
    $q->execute(array(
      'championnat' => $championnat,
      'date1' => $date_debut,
      'date2' => $date_fin
    ));
    $matchs = array();
    while($donnees = $q->fetch(PDO::FETCH_ASSOC)){
      $matchs[] = new Match($donnees);
    }
    return $matchs;
  }

  public function getListOfAllFromBb(BattleBetting $battle){
    $q = $this->_db->prepare('SELECT * FROM matchs WHERE date BETWEEN :date1 AND :date2');
    $q->execute(array(
      'date1' => $battle->start_date(),
      'date2' => $battle->end_date()
    ));
    $matchs = array();
    while($donnees = $q->fetch(PDO::FETCH_ASSOC)){
      $matchs[] = new Match($donnees);
    }
    return $matchs;
  }

  public function getListFromBattleBetting(BattleBetting $battle){
    if(strtotime(date('Y-m-d')) != strtotime('Monday')){
      $date1 = date('Y-m-d', strtotime('last Monday'. ' ' . date('Y-m-d')));
    }
    else{
      $date1 = date('Y-m-d');
    }
    $date2 = date('Y-m-d', strtotime('next Monday' . ' ' . date('Y-m-d')));
    $q = $this->_db->prepare('SELECT m.*
      FROM matchs m
      INNER JOIN matchs_in_battlebetting mb ON m.id = mb.id_match
      INNER JOIN battlebetting b ON b.id = mb.id_battle
      WHERE b.id = :id_battle AND m.date BETWEEN :date1 AND :date2 ORDER BY m.date');
    $q->execute(array(
      'id_battle' => $battle->id(),
      'date1' => $date1,
      'date2' => $date2
    ));
    $matchs = array();
    while($donnees = $q->fetch(PDO::FETCH_ASSOC)){
      $matchs[] = new Match($donnees);
    }
    return $matchs;
  }

  public function existsFromTeamNamesAndDate($equipe1, $equipe2, $date){
    $q = $this->_db->prepare('SELECT COUNT(*) FROM matchs WHERE equipe1 = :equipe1 AND equipe2 = :equipe2 AND date = :date');
    $q->execute(array(
      'equipe1' => $equipe1,
      'equipe2' => $equipe2,
      'date' => $date
    ));
    return (bool) $q->fetchColumn();
  }

  public function getFromTeamNamesAndDate($equipe1, $equipe2, $date){
    $q = $this->_db->prepare('SELECT * FROM matchs WHERE equipe1 = :equipe1 AND equipe2 = :equipe2 AND date = :date');
    $q->execute(array(
      'equipe1' => $equipe1,
      'equipe2' => $equipe2,
      'date' => $date
    ));
    return New Match($q->fetch(PDO::FETCH_ASSOC));
  }

  public function update(Match $match){
    $q = $this->_db->prepare('UPDATE matchs SET score1 = :score1, score2 = :score2, statut = :statut WHERE equipe1 = :equipe1 AND equipe2 = :equipe2 AND date = :date');
    $q->execute(array(
      'score1' => $match->score1(),
      'score2' => $match->score2(),
      'statut' => $match->statut(),
      'equipe1' => $match->equipe1(),
      'equipe2' => $match->equipe2(),
      'date' => $match->date()
    ));
  }


  public function setDb(PDO $db){
    $this->_db = $db;
  }
}
