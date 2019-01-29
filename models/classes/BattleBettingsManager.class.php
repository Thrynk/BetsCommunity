<?php
class BattleBettingsManager{
  private $_db;

  public function __construct($db){
    $this->setDb($db);
  }

  public function add(BattleBetting $battle){
    $q = $this->_db->prepare('INSERT INTO battlebetting(name, code, id_creator, start_date, end_date, end_subscribe_date) VALUES(:name, :code, :id_creator, :start_date, :end_date, :end_subscribe_date)');
    $q->execute(array(
      'name' => htmlspecialchars($battle->name()),
      'code' => $battle->code(),
      'id_creator' => $battle->id_creator(),
      'start_date' => $battle->start_date(),
      'end_date' => $battle->end_date(),
      'end_subscribe_date' => $battle->end_subscribe_date()
    ));
    $battle->hydrate(array(
      'id' => $this->_db->lastInsertId()
    ));
  }

  public function getFromName($name){
    $q = $this->_db->prepare('SELECT * FROM battlebetting WHERE name = :name');
    $q->execute(array(
      'name' => $name
    ));
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    return new BattleBetting($donnees);
  }

  public function getClassement(BattleBetting $battle){
    $q = $this->_db->prepare('SELECT u.pseudo, SUM(b.win) as points FROM bets b INNER JOIN users u ON u.id = b.id_user WHERE b.id_battle = :id_battle GROUP BY u.pseudo ORDER BY points DESC');
    $q->execute(array(
      'id_battle' => $battle->id()
    ));
    return $q->fetchAll(PDO::FETCH_ASSOC);
  }

  public function addUserInBattleBetting(User $user, BattleBetting $battle){
    $q = $this->_db->prepare('INSERT INTO user_participates_battlebetting(id_user, id_battle) VALUES(:id_user, :id_battle)');
    $q->execute(array(
      'id_user' => $user->id(),
      'id_battle' => $battle->id()
    ));
  }

  public function addWithoutCode(BattleBetting $battle){
    $q = $this->_db->prepare('INSERT INTO battlebetting(name, id_creator, start_date, end_date, end_subscribe_date) VALUES(:name, :id_creator, :start_date, :end_date, :end_subscribe_date)');
    $q->execute(array(
      'name' => $battle->name(),
      'id_creator' => $battle->id_creator(),
      'start_date' => $battle->start_date(),
      'end_date' => $battle->end_date(),
      'end_subscribe_date' => $battle->end_subscribe_date()
    ));
    $battle->hydrate(array(
      'id' => $this->_db->lastInsertId()
    ));
  }

  public function addMatchsAlea(array $matchs, BattleBetting $battle){
    for($i = 0; $i < sizeof($matchs); $i++){
      shuffle($matchs[$i]);
      if(sizeof($matchs[$i]) < 10){
        for($j = 0; $j < sizeof($matchs[$i]); $j++){
          $q = $this->_db->prepare('INSERT INTO matchs_in_battlebetting(id_battle, id_match) VALUES(:id_battle, :id_match)');
          $q->execute(array(
            'id_battle' => $battle->id(),
            'id_match' => $matchs[$i][$j]->id()
          ));
        }
      }
      else{
        for($j = 0; $j < 10; $j++){
          $q = $this->_db->prepare('INSERT INTO matchs_in_battlebetting(id_battle, id_match) VALUES(:id_battle, :id_match)');
          $q->execute(array(
            'id_battle' => $battle->id(),
            'id_match' => $matchs[$i][$j]->id()
          ));
        }
      }
    }
  }

  public function exists($nom){
    $q = $this->_db->prepare('SELECT COUNT(*) FROM battlebetting WHERE name = :name');
    $q->execute(array('name' => $nom));
    return (bool) $q->fetchColumn();
  }

  public function getListFromUser(User $user){
    $q = $this->_db->prepare('SELECT b.*
      FROM users u
      INNER JOIN user_participates_battlebetting ub ON u.id = ub.id_user
      INNER JOIN battlebetting b ON b.id = ub.id_battle
      WHERE u.pseudo = :pseudo');
    $q->execute(array('pseudo' => $user->pseudo()));
    $battlebettings = array();
    while($donnees = $q->fetch(PDO::FETCH_ASSOC)){
      $battlebettings[] = new BattleBetting($donnees);
    }
    return $battlebettings;
  }

  public function existsUserInBattleBetting(User $user, Battlebetting $battle){
    $q = $this->_db->prepare('SELECT COUNT(*) FROM user_participates_battlebetting WHERE id_user = :id AND id_battle = :id_battle');
    $q->execute(array('id' => $user->id(), 'id_battle' => $battle->id()));
    return (bool) $q->fetchColumn();
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }
}
