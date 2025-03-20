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
    if(isset($_POST['penomJoueur'])){
        $errors['penomJoueur'] = "Vous devez inscrire votre prenom";
    }
    else{
        $penomJoueur = $_POST['penomJoueur'];
    }
   if($_POST['password'] !== $_POST['repassword']) {
        $errors['repassword'] = "Les mots de passe ne correspondent pas.";
   }
/////////////////////////////A FAIRE POUR VERIFFIER SI LE NOM D'UTILISATEUR EST DEJA UTILISER//////////////////////////
    if($userModel->verifyAlias($alias)) {
        $errors['email'] = "Cette adresse courriel est déjà utilisée.";
    }
    
    if (empty($password)) {
        $errors['password'] = "Le mot de passe est obligatoire.";
    }
    if(strlen($password) < 8) {
        $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères.";
    }
    if ($repassword !== $password) {
        $errors['repassword'] = "Les mots de passe ne correspondent pas.";
    }
    if (empty($errors)) {

        $user = $userModel->insertOne([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        $_SESSION['success'] = true;
        redirect('/connexion');

        
    }
}

view('inscription.php', [
    'name' => $name ?? '',
    'email' => $email ?? '',
    'errors' => $errors ?? [],
]);