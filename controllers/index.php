<?php

require_once 'src/functions.php';
require 'src/class/Database.php';
require_once 'src/configuration.php';
$style = 'index.css';


sessionStart();
$estConnecter = isAuthenticated();
//$estAdmin = isAdministrator(); pour plus tard

$db = Database::getInstance(CONFIGURATIONS['database'], DB_PARAMS);
$pdo = $db->getPDO();








view('index.php',[
    'style'=>$style ?? '',
      
]);

?>