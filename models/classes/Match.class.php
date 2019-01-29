<?php
class Match{
  private $_id,
          $_logo1,
          $_equipe1,
          $_score1,
          $_score2,
          $_equipe2,
          $_logo2,
          $_date,
          $_statut,
          $_championnat;


  const WIN_TEAM1 = 3;
  const MATCH_NUL = 4;
  const WIN_TEAM2 = 5;


  public function __construct(array $donnees){
    $this->hydrate($donnees);
  }

  public function setScores($score1, $score2){
    $this->setScore1($score1);
    $this->setScore2($score2);
  }

  public function determineWinner(){
    if($this->statut() == "FINISHED"){
      if($this->score1() > $this->score2()){
        return self::WIN_TEAM1;
      }
      else if($this->score1() == $this->score2()){
        return self::MATCH_NUL;
      }
      else if($this->score1() < $this->score2()){
        return self::WIN_TEAM2;
      }
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

  public function setEquipe1($equipe1){
    if(is_string($equipe1)){
      $this->_equipe1 = $equipe1;
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

  public function setEquipe2($equipe2){
    if(is_string($equipe2)){
      $this->_equipe2 = $equipe2;
    }
  }

  public function setDate($date){
    if(is_string($date) && preg_match("#^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9])(?:( [0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$#", $date)){
      $this->_date = $date;
    }
  }

  public function setStatut($statut){
    if(is_string($statut)){
      $this->_statut = $statut;
    }
  }

  public function setChampionnat($championnat){
    $championnat = (int) $championnat;
    if($championnat > 0){
      $this->_championnat = $championnat;
    }
  }

  public function setLogo1($link){
    if(is_string($link)){
      $this->_logo1 = $link;
    }
  }

  public function setLogo2($link){
    if(is_string($link)){
      $this->_logo2 = $link;
    }
  }

  /* GETTERS */
  public function id(){
    return $this->_id;
  }

  public function equipe1(){
    return $this->_equipe1;
  }

  public function score1(){
    return $this->_score1;
  }

  public function score2(){
    return $this->_score2;
  }

  public function equipe2(){
    return $this->_equipe2;
  }

  public function date(){
    return $this->_date;
  }

  public function statut(){
    return $this->_statut;
  }

  public function championnat(){
    return $this->_championnat;
  }

  public function logo1(){
    return $this->_logo1;
  }

  public function logo2(){
    return $this->_logo2;
  }
}
