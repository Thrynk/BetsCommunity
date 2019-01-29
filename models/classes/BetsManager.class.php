<?php
class BetsManager{
  private $_db;

  public function __construct($db){
    $this->setDb($db);
  }

  public function add(Bet $bet){
    $q = $this->_db->prepare('INSERT INTO bets(id_match, id_user, id_battle, prono, date) VALUES(:id_match, :id_user, :id_battle, :prono, :date)');
    $q->execute(array(
      'id_match' => $bet->id_match(),
      'id_user' => $bet->id_user(),
      'id_battle' => $bet->id_battle(),
      'prono' => $bet->prono(),
      'date' => $bet->date()
    ));
    $bet->hydrate(array(
      'id' => $this->_db->lastInsertId()
    ));
  }

  public function update(Bet $bet){
    $q = $this->_db->prepare('UPDATE bets SET win = :win WHERE id = :id');
    $q->execute(array(
      'win' => $bet->win(),
      'id' => $bet->id()
    ));
  }

  public function addExactScores(Bet $bet){
    $q = $this->_db->prepare('UPDATE bets SET score1 = :score1, score2 = :score2 WHERE id = :id');
    $q->execute(array(
      'score1' => $bet->score1(),
      'score2' => $bet->score2(),
      'id' => $bet->id()
    ));
  }

  public function getListFromUserAndBattleBetting(User $user, Battlebetting $battle){
    $q = $this->_db->prepare('SELECT * FROM bets WHERE id_user = :id_user AND id_battle = :id_battle');
    $q->execute(array('id_user' => $user->id(), 'id_battle' => $battle->id()));
    $bets = array();
    while($donnees = $q->fetch(PDO::FETCH_ASSOC)){
      $bets[] = new Bet($donnees);
    }
    return $bets;
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }
}
