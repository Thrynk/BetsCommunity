<?php
function chargerClasse($classname){
  require 'models/classes/'.$classname.'.class.php';
}

spl_autoload_register('chargerClasse');
