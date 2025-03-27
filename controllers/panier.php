<?php
require_once 'src/functions.php';
require 'src/class/Database.php';
require 'models/UserModel.php';
$style = 'panier.css';
sessionStart();

$pdo = Database::getInstance();
$userModel = new UserModel($pdo);

if (isset($_SESSION['user']['id']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
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
} else if (!isset($_SESSION['user']['id'])) {
    redirect('/connexion');
    exit;
}
?>