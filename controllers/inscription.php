<?php
require_once 'src/functions.php';
require 'src/class/Database.php';
require 'models/UserModel.php';


sessionStart();

$pdo = Database::getInstance();
$userModel = new UserModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if(!isset($_POST['alias'])){
        $errors['alias'] = "Vous devez inscrire un alias";
    }
    else{
        $alias = $_POST['alias'];
    }
    if(!isset($_POST['password'])){
        $errors['password'] = "Vous devez inscrire un mot de passe";
    }
    else{
        $password = $_POST['password'];
    }
    if(!isset($_POST['repassword'])){
        $errors['repassword'] = "Vous devez inscrire un mot de passe";
    }
    else{
        $repassword = $_POST['repassword'];
    }
    if(!isset($_POST['nomJoueur'])){
        $errors['nomJoueur'] = "Vous devez inscrire votre nom";
    }
    else{
        $nomJoueur = $_POST['nomJoueur'];
    }
    if(!isset($_POST['prenomJoueur'])){
        $errors['prenomJoueur'] = "Vous devez inscrire votre prenom";
    }
    else{
        $prenomJoueur = $_POST['prenomJoueur'];
    }
   if($_POST['password'] !== $_POST['repassword']) {
        $errors['repassword'] = "Les mots de passe ne correspondent pas.";
   }
/////////////////////////////A FAIRE POUR VERIFFIER SI LE NOM D'UTILISATEUR EST DEJA UTILISER//////////////////////////
    if($userModel->verifierAlias($alias)) {
        $errors['alias'] = "Cette alias est déjà utilisée.";
    }
    
  
    if (empty($errors)) {

        $userModel->insertOne([
            'alias' => $alias,
            'nomJoueur' => $nomJoueur,
            'prenomJoueur' => $prenomJoueur,
            'password' => $password,
        ]);
        $_SESSION['success'] = true;
        $message = 'Compte créé! Veuillez vous connecter';
        redirect('/connexion');

        
    }
}

view('inscription.php', [
    'name' => $name ?? '',
    'email' => $email ?? '',
    'errors' => $errors ?? [],
]);