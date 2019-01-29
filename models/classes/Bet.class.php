<?php
class Bet{
  private $_id,
          $_id_match,
          $_id_user,
          $_id_battle,
          $_prono,
          $_score1,
          $_score2,
          $_win,
          $_date;

  const PARI_GAGNE = 1;
  const PARI_PERDU = 0;
  const PARI_GAGNE_SCORE_MATCH = 2;

  public function __construct(array $donnees){
    $this->hydrate($donnees);
  }

  public function WinOrLose(Match $match){
    $result = $match->determineWinner();
    if($result == Match::WIN_TEAM1 && $this->prono() == 3){
      if($match->score1() == $this->score1() && $match->score2() == $this->score2()){
        $this->setWin(self::PARI_GAGNE_SCORE_MATCH);
      }
      else{
        $this->setWin(self::PARI_GAGNE);
      }
    }
    else if($result == Match::MATCH_NUL && $this->prono() == 4){
      if($match->score1() == $this->score1() && $match->score2() == $this->score2()){
        $this->setWin(self::PARI_GAGNE_SCORE_MATCH);
      }
      else{
        $this->setWin(self::PARI_GAGNE);
      }
    }
    else if($result == Match::WIN_TEAM2 && $this->prono() == 5){
      if($match->score1() == $this->score1() && $match->score2() == $this->score2()){
        $this->setWin(self::PARI_GAGNE_SCORE_MATCH);
      }
      else{
        $this->setWin(self::PARI_GAGNE);
      }
    }
    else{
      $this->setWin(self::PARI_PERDU);
    }
  }

  /* hydratation */
  public function hydrate(array $donnees){
    foreach($donnees as $key => $value){
      $method = 'set'.ucfirst($key);
      if(method_exists($this, $method)){
        $this->$method($value);
      }
    }
  }

  /* SETTERS */
  public function setId($id){
    $id = (int) $id;
    if($id > 0){
      $this->_id = $id;
    }
  }

  public function setId_match($id_match){
    $id_match = (int) $id_match;
    if($id_match > 0){
      $this->_id_match = $id_match;
    }
  }

  public function setId_user($id_user){
    $id_user = (int) $id_user;
    if($id_user > 0){
      $this->_id_user = $id_user;
    }
  }

  public function setId_battle($id_battle){
    $id_battle = (int) $id_battle;
    if($id_battle > 0){
      $this->_id_battle = $id_battle;
    }
  }

  public function setProno($prono){
    $prono = (int) $prono;
    if($prono == 3 || $prono == 4 || $prono == 5){
      $this->_prono = $prono;
    }
  }

  public function setScore1($score1){
    $score1 = (int) $score1;
    if($score1 > 0){
      $this->_score1 = $score1;
    }
  }

  public function setScore2($score2){
    $score2 = (int) $score2;
    if($score2 > 0){
      $this->_score2 = $score2;
    }
  }

  public function setWin($value){
    if(is_int($value)){
      if($value == 0 || $value == 1 || $value == 2){
        $this->_win = $value;
      }
    }
  }

  public function setDate($date){
    if(is_string($date) && preg_match("#^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9])(?:( [0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$#", $date)){
      $this->_date = $date;
    }
  }

  /* GETTERS */
  public function id(){
    return $this->_id;
  }

  public function id_match(){
    return $this->_id_match;
  }

  public function id_user(){
    return $this->_id_user;
  }

  public function id_battle(){
    return $this->_id_battle;
  }

  public function prono(){
    return $this->_prono;
  }

  public function score1(){
    return $this->_score1;
  }

  public function score2(){
    return $this->_score2;
  }

  public function win(){
    return $this->_win;
  }

  public function date(){
    return $this->_date;
  }
}
