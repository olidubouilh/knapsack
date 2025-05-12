<?php

require_once 'src/functions.php';
require 'src/class/Database.php';
require_once 'src/configuration.php';
$style = 'index.css';

sessionStart();
$pdo = Database::getInstance();

$popUp = false;
if (isset($_SESSION['connecter'])) {
    $popUp = true;
    unset($_SESSION['connecter']);
}

view('index.php',[
    'style'=>$style ?? '',
    'popUp'=>$popUp
      
]);