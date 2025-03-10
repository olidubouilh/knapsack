<?php

const ROUTES = [

    '/' => 'index.php',
    '/connexion' => 'connexion.php',  
    '/inscription' => 'inscription.php',
    '/inactif' => 'inactif.php', 
    '/logout' => 'logout.php', 
    '/page-not-found' => 'page-not-found.php',
    '/ajouter-pub' => 'ajouter-pub.php',
    '/gerer-pub' => 'gerer-pub.php',    
    '/modifier-pub' => 'modifier-pub.php',  
    '/supprimer-pub' => 'supprimer-pub.php', 
    '/gerer-client' => 'gerer-client.php'   

];
const DB_PARAMS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_CASE => PDO::CASE_NATURAL,
    PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,        
];

define('CONFIGURATIONS', parse_ini_file("configurations.ini", true));


