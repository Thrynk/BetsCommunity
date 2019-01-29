<?php
try {
    $db = new PDO('mysql:host=mysql-betscommunity.alwaysdata.net;dbname=betscommunity_bets', '156253', 'PHILIPPE');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$manager = new BetsManager($db);
$managerUsers = new UsersManager($db);
