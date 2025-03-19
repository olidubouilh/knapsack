<?php

require_once 'src/functions.php';
require 'src/class/Database.php';
require_once 'src/configuration.php';
$style = 'index.css';

sessionStart();
$estConnecter = isAuthenticated();
//$estAdmin = isAdministrator(); pour plus tard
//FAIRE UN IF POUR AFFICHER LES INFOS DU JOUEURS SI IL EST CONNECTER VA ETRE COMME CA DANS TOUTE LES PAGES A FAIRE DANS LE FUTURE

$db = Database::getInstance(CONFIGURATIONS['database'], DB_PARAMS);
$pdo = $db->getPDO();

$popUp = false;
if (isset($_SESSION['connecter'])) {
    $popUp = true;
    unset($_SESSION['connecter']);
}






view('index.php',[
    'style'=>$style ?? '',
    'popUp'=>$popUp
      
]);

?>