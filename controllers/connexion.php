<?php

require_once 'src/functions.php';   
require 'src/class/Database.php';
require 'models/UserModel.php';
$style = 'connexion.css';
sessionStart();
//A FAIRE SI ON VEUT FAIRE UNE NOTIFICATION DISANT CONNECTER OU WTV DEMANDER A OLIVIER POUR LE CODE A METTRE DANS LE HTML
$popUp = false;
if (isset($_SESSION['success'])) {
    $popUp = true;
    $message = $_SESSION['popUp'];
    unset($_SESSION['success']);
}

$pdo = Database::getInstance();
$userModel = new UserModel($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isAuthenticated()){    
        $alias = $_POST['alias'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($alias)) {
        $errors = "Alias ou mot de passse invalide";
        }
        if (empty($password)) {
            $errors = "Alias ou mot de passse invalide";
        }
        elseif(!$userModel->selectByAlias($alias, $password)) {
            $errors = "Alias ou mot de passse invalide";
        }
        if (empty($errors)) {

            $user = $userModel->selectByAlias($alias, $password);
        //FUTURE POUR SAVOIR SI EST ADMIN OU NON
        // if($user->getActive() == false){
        //     redirect('/inactif');
        //     exit;
        // }
        //else{
            //$_SESSION['user'] = $user;   FAIRE PLUS TARD
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'alias'=> $user->getAlias(),
                'montant'=> $user->getMontant(),
                'dexterite'=> $user->getDexterite(),
                'pvJoueur'=> $user->getPvJoueur(),
                'poidsMaximal'=> $user->getPoidsMaximal(),
                'poidsSac'=> $userModel->poidSac($user->getId()),
                'isAdmin' => $user->getIsAdmin()
                
                
            ];
            $_SESSION['connecter'] = 1;
            redirect('/');
            exit;
        //}
       
        }  
    }
    if(isset($_POST['deconnexion']) && isAuthenticated())
    {
        
        session_destroy();
        $_SESSION['popUp'] = "Vous avez été déconnecté avec succès.";
        $_SESSION['success'] = true;
        redirect('/connexion');
        exit;
    }
}

view("connexion.php", [
    'alias' => $alias ?? '',
    'password' => $password ?? '',
    'errors' => $errors ?? '',
    'popUp' => $popUp ?? '',
    'style' => $style ?? '', 
    'message' => $message ?? '',  
     
    
]);
