<?php

require_once 'src/functions.php';   
require 'src/class/Database.php';
require 'models/UserModel.php';
$style = 'profil.css';
sessionStart();



if (isset($_SESSION['user']['id'])) {
    $popUp = false;
    if (isset($_SESSION['success'])) {
        $popUp = true;
        unset($_SESSION['success']);
    }
    $pdo = Database::getInstance();
    $userModel = new UserModel($pdo);
    $user = $userModel->selectInfoJoueur($_SESSION['user']['alias']);

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alias'])) {
        
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        
    }

    view("profil.php", [
        'user' => $user ?? '',
        'errors' => $errors ?? '',
        'popUp' => $popUp ?? '',
        'style' => $style ?? '',   
        
        
    ]);
}
else{
    redirect('/connexion');
    exit;
}
