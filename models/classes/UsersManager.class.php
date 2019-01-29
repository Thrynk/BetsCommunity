<?php
class UsersManager{
  private $_db;

  public function __construct($db){
    $this->setDb($db);
  }

  public function add(User $user){
    $q = $this->_db->prepare('INSERT INTO users(pseudo, password, mail, subscribe_date) VALUES(:pseudo, :password, :mail, :subscribe_date)');
    $q->execute(array(
      'pseudo' => htmlspecialchars($user->pseudo()),
      'password' => $user->password(),
      'mail' => htmlspecialchars($user->mail()),
      'subscribe_date' => $user->subscribe_date()
    ));
    $user->hydrate(array(
      'id' => $this->_db->lastInsertId()
    ));
  }

  public function delete(User $user){
    $this->_db->exec('DELETE FROM users WHERE id = '.$user->id());
  }

  public function exists($pseudo){
    $q = $this->_db->prepare('SELECT COUNT(*) FROM users WHERE pseudo = :pseudo');
    $q->execute(array('pseudo' => $pseudo));
    return (bool) $q->fetchColumn();
  }

  public function existsWithMail($mail){
    $q = $this->_db->prepare('SELECT COUNT(*) FROM users WHERE mail= :mail');
    $q->execute(array('mail' => $mail));
    return (bool) $q->fetchColumn();
  }

  public function update(User $user){
    $q = $this->_db->prepare('UPDATE users SET pseudo = :pseudo, password = :password, pointsgen = :pointsgen WHERE id = :id');
    $q->bindValue(':pointsgen', $user->pointsgen(), PDO::PARAM_INT);
    $q->bindValue(':id', $user->id(), PDO::PARAM_INT);
    $q->execute(array(
      'pseudo' => $user->pseudo(),
      'password' => $user->password()
    ));
  }

  public function get($pseudo){
    $q = $this->_db->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
    $q->execute(array(
      'pseudo' => $pseudo
    ));
    return new User($q->fetch(PDO::FETCH_ASSOC));
  }

  public function getInfoFromId($id){
    if(is_int($id)){
      $q = $this->_db->query('SELECT * FROM users WHERE id ='.$id);
      return new User($q->fetch(PDO::FETCH_ASSOC));
    }
  }

  public function getInfoFromMail($mail){
    $q = $this->_db->prepare('SELECT * FROM users WHERE mail = :mail');
    $q->execute(array(
      'mail' => $mail
    ));
    return new User($q->fetch(PDO::FETCH_ASSOC));
  }

  public function setDb(PDO $db){
    $this->_db = $db;
  }
}
