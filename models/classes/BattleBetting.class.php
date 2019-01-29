<?php
class BattleBetting{
  private $_id,
          $_name,
          $_code,
          $_id_creator,
          $_start_date,
          $_end_date,
          $_end_subscribe_date;

  public function __construct(array $donnees){
    $this->hydrate($donnees);
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

  public function setName($name){
    if(is_string($name)){
      $this->_name = $name;
    }
  }

  public function setCode($code){
    $this->_code = $code;
  }

  public function setId_creator($id_creator){
    $id_creator = (int) $id_creator;
    if($id_creator > 0){
      $this->_id_creator = $id_creator;
    }
  }

  public function setStart_date($date){
    if(is_string($date) && preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}$#', $date)){
      $this->_start_date = $date;
    }
  }

  public function setEnd_date($date){
    if(is_string($date) && preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}$#', $date)){
      $this->_end_date = $date;
    }
  }

  public function setEnd_subscribe_date($date){
    if(is_string($date) && preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}$#', $date)){
      $this->_end_subscribe_date = $date;
    }
  }

  /* GETTERS */
  public function id(){
    return $this->_id;
  }

  public function name(){
    return $this->_name;
  }

  public function code(){
    return $this->_code;
  }

  public function id_creator(){
    return $this->_id_creator;
  }

  public function start_date(){
    return $this->_start_date;
  }

  public function end_date(){
    return $this->_end_date;
  }

  public function end_subscribe_date(){
    return $this->_end_subscribe_date;
  }
}
