<?php

require_once 'src/functions.php';   
require 'src/class/Database.php';
require 'models/UserModel.php';

sessionStart();
$popUp = false;
if (isset($_SESSION['success'])) {
    $popUp = true;
    unset($_SESSION['success']);
}
$db = Database::getInstance(CONFIGURATIONS['database'], DB_PARAMS);
$pdo = $db->getPDO();
$userModel = new UserModel($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {    

    $alias = $_POST['alias'] ?? '';
    $password = $_POST['password'] ?? '';

    if (! $alias) {
    $errors = "Courriel ou mot de passse invalide";
    }
    elseif(!$userModel->verifyEmail($email)) {
        $errors = "Courriel ou mot de passse invalide";
    }
    if (empty($password)) {
        $errors = "Courriel ou mot de passse invalide";
    }
    elseif(!$userModel->verifyPassword($password, $email) ) {
        $errors = "Courriel ou mot de passse invalide";
    }

    if (empty($errors)) {

        $user = $userModel->selectByEmail($email);
        if($user->getActive() == false){
            redirect('/inactif');
            exit;
        }
        else{
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'role' => $user->getRole(),
                'active' =>$user->getActive()
            ];
            redirect('/');
            exit;
        }
       
    }  
}

view("connexion.php", [
    'email' => $email ?? '',
    'password' => $password ?? '',
    'errors' => $errors ?? '',
    'popUp' => $popUp ?? '' 
    
]);
