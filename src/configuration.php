<?php

const ROUTES = [

    '/' => 'index.php',
    '/connexion' => 'connexion.php',  
    '/inscription' => 'inscription.php',
      

];
const DB_PARAMS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_CASE => PDO::CASE_NATURAL,
    PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,        
];

define('CONFIGURATIONS', parse_ini_file("configurations.ini", true));


