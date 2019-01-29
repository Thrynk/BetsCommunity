<?php
include('models/afficher-mes-championnats.php');
if(isset($usercookie)){
  $_SESSION['user'] = $managerUsers->get($usercookie);
}
if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];
  $championnats = $manager->getListFromUser($user);
  $_SESSION['championnatsUser'] = $championnats;
}
else{
  header('Location: index.php?page=nonco');
}
include('views/afficher-mes-championnats.php');
