<?php
class User{
  private $_id,
          $_pseudo,
          $_password,
          $_mail,
          $_subscribe_date,
          $_pointsgen;

  const PSEUDO_INVALIDE = 1;
  const PSEUDO_VALIDE = 2;
  const PASSWORD_VALIDE = 3;
  const PASSWORD_INVALIDE = 4;

  public function __construct(array $donnees){
    $this->hydrate($donnees);
  }

  public function getMorePoints($pointsSup){
    /* recevoir des points qui + pointsgen est un int supérieur aux points d'avant */
    $pointsSup = (int) $pointsSup;
    if(pointsgen() + $pointsSup > pointsgen() && $pointsSup > 0){
      setPointsgen(pointsgen() + $pointsSup);
    }
  }

  public function changePseudo($pseudo){
    /* change le pseudo du perso (doit être différent des pseudos déjà pris verif dans le manager) est un string de longueur inférieur à 20 */
    if(preg_match('`^([a-zA-Z0-9-_]{2,20})$`', $pseudo)){
      setPseudo($pseudo);
      return self::PSEUDO_VALIDE;
    }
    return self::PSEUDO_INVALIDE;
  }

  public function changePassword($password, $password2){
    /* change le mot de passe les mots de passe doivent être pareils */
    if($password == $password2){
      setPassword($password);
      return self::PASSWORD_VALIDE;
    }
    return self::PASSWORD_INVALIDE;
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

  public function setPseudo($pseudo){
    if(is_string($pseudo)){
      $this->_pseudo = $pseudo;
    }
  }

  public function setPassword($password){
    if(is_string($password)){
      $this->_password = $password;
    }
  }

  public function setSubscribe_date($date){
    if(is_string($date)){
      $this->_subscribe_date = $date;
    }
  }

  public function setPointsgen($points){
    $points = (int) $points;
    if($points > 0){
      $this->_pointsgen = $points;
    }
  }

  public function setMail($mail){
    if(preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)){
      $this->_mail = $mail;
    }
  }

  /* GETTERS */
  public function id(){
    return $this->_id;
  }

  public function pseudo(){
    return $this->_pseudo;
  }

  public function password(){
    return $this->_password;
  }

  public function subscribe_date(){
    return $this->_subscribe_date;
  }

  public function pointsgen(){
    return $this->_pointsgen;
  }

  public function mail(){
    return $this->_mail;
  }
}
