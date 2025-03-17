<?php

require_once 'src/functions.php';   
require 'src/class/Database.php';
require 'models/UserModel.php';
$style = 'connexion.css';
sessionStart();

//A FAIRE SI ON VEUT FAIRE UNE NOTIFICATION DISANT CONNECTER OU WTV DEMANDER A OLIVIER POUR LE CODE A METTRE DANS LE HTML
// $popUp = false;
// if (isset($_SESSION['success'])) {
//     $popUp = true;
//     unset($_SESSION['success']);
// }
$db = Database::getInstance(CONFIGURATIONS['database'], DB_PARAMS);
$pdo = $db->getPDO();
$userModel = new UserModel($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {    

    $alias = $_POST['alias'] ?? '';
    $password = $_POST['password'] ?? '';

    if (! $alias) {
    $errors = "Alias ou mot de passse invalide";
    }
    elseif(!$userModel->verifyAlias($alias)) {
        $errors = "Alias ou mot de passse invalide";
    }
    if (empty($password)) {
        $errors = "Alias ou mot de passse invalide";
    }
    elseif(!$userModel->verifyPassword($password, $Alias) ) {
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
    'popUp' => $popUp ?? '',
    'style' => $style ?? '',    
    
]);
