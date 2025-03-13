<?php

require_once 'src/functions.php';
require 'src/class/Database.php';



sessionStart();
$estConnecter = isAuthenticated();
//$estAdmin = isAdministrator(); pour plus tard

$db = Database::getInstance(CONFIGURATIONS['database'], DB_PARAMS);
$pdo = $db->getPDO();
$adModel = new AdModel($pdo);
$ads = $adModel->selectCarousel();







view('index.php',[
    'ads' => $ads,
    'estConnecter' => $estConnecter,
    'estAdmin' => $estAdmin,    
]);

?>