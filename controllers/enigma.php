<?php
require_once 'src/functions.php';
require 'src/class/Database.php';
require_once 'src/configuration.php';
require 'models/EnigmaModel.php';
$style = 'enigma.css';
if(!isAuthenticated()){
    $message = "Vous devez être connecté pour accéder à la page Énigma.";
    $_SESSION['popUp'] = $message;
    $_SESSION['success'] = true;
    redirect('/connexion');
    exit;
}
sessionStart();
$pdo = Database::getInstance();
$enigmaModel = new EnigmaModel($pdo);
$idJoueur = $_SESSION['user']['id'] ?? '';
if($idJoueur){
    $stats = new StatistiqueEnigma($idJoueur);
}
view("enigma.php", [
        'id' => $idJoueur,
        'nbBonnesReponses' => $stats->getNbBonneReponse(),
        'nbMauvaisesReponses' => $stats->getNbMauvaiseReponse(),
        'errors' => $errors ?? '',
        'popUp' => $popUp ?? '',
        'style' => $style ?? '',
    ]);
//Modifications/Commentaires : 2025-04-07 par Raph  