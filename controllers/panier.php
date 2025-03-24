<?php

require_once 'src/functions.php';
require 'src/class/Database.php';
require 'models/UserModel.php';
$style = 'panier.css';
sessionStart();

$pdo = Database::getInstance();
$userModel = new UserModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $alias = $_POST['alias'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($alias)) {
        $errors = "Alias ou mot de passse invalide";
    }
    if (empty($password)) {
        $errors = "Alias ou mot de passse invalide";
    } elseif (!$userModel->selectByAlias($alias, $password)) {
        $errors = "Alias ou mot de passse invalide";
    }

    if (empty($errors)) {

        $user = $userModel->selectByAlias($alias, $password);

        $_SESSION['user'] = [
            'id' => $user->getId(),
            'alias' => $user->getAlias(),
            'montant' => $user->getMontant(),
            'dexterite' => $user->getDexterite(),
            'pvJoueur' => $user->getPvJoueur(),
            'poidsMaximal' => $user->getPoidsMaximal(),
        ];

        redirect('/');  // This ends the script, nothing below this line will be executed
        exit;
    }
}

// 👇 Make sure this part is outside of the POST request block
if (isset($_SESSION['user']['id'])) {
    $idJoueur = $_SESSION['user']['id']; 

    $stmt = $pdo->prepare("SELECT * FROM VPanier WHERE idJoueurs = :idJoueur");
    $stmt->execute(['idJoueur' => $idJoueur]);
    $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);

    view("panier.php", [
        'id' => $idJoueur,
        'panier' => $panier,
        'errors' => $errors ?? '',
        'popUp' => $popUp ?? '',
        'style' => $style ?? '',
    ]);
}
else {
    redirect('/connexion');
}
