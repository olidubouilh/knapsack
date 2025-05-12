<?php

require_once 'src/functions.php';   
require 'src/class/Database.php';
require 'models/UserModel.php';
$style = 'profil.css';
sessionStart();



if (userExist()) {
    $popUp = false;
    if (isset($_SESSION['success'])) {
        $popUp = true;
        unset($_SESSION['success']);
    }
    $pdo = Database::getInstance();
    $userModel = new UserModel($pdo);
    $user = $userModel->selectInfoJoueur($_SESSION['user']['alias']);
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alias'])) {
        if($_SESSION['user']['alias'] !== $_POST['alias']) {
            $aliasModfifier = $userModel->updateAlias($_SESSION['user']['id'], $_POST['alias']);
            if($aliasModfifier) {
                $_SESSION['user']['alias'] = $_POST['alias'];
                $_SESSION['success'] = 'BIEN';
            }
            else{
                $errors = "L'alias est déjà utilisé";
            } 
        }
        else{
            $errors = "L'alias doit être diffférent de l'ancien";
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newPassword']) || isset($_POST['oldPassword'])) {
        if($_POST['newPassword'] === $_POST['oldPassword']) {
            $errors = "Les deux mots de passe doivent être différents";
        }
        else{
            $ancienMdp = $userModel->updatePassword($_SESSION['user']['id'], $_POST['newPassword'], $_POST['oldPassword']);
            if($ancienMdp) {
                $_SESSION['success'] = 'bien';
            }
            else{
                $errors = "L'ancien mot de passe est incorrect";
            }
        }   
        
    }
    $alias = $_SESSION['user']['alias'];

    view("profil.php", [
        'user' => $user ?? '',
        'errors' => $errors ?? '',
        'popUp' => $popUp ?? '',
        'style' => $style ?? '',   
        'alias' => $alias ?? '',    
        
        
    ]);
}
else{
    redirect('/connexion');
    exit;
}
