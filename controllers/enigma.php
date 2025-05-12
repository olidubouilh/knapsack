<?php

// Charge les fonctions et les classes nécessaires
require_once 'src/functions.php';
require 'src/class/Database.php';
require_once 'src/configuration.php';
require 'models/EnigmaModel.php';

$style = 'enigma.css';
sessionStart();

// Récupère l'ID du joueur depuis la session
$idJoueur = userExist() ? $_SESSION['user']['id'] : null;

// Vérifie si le joueur est authentifié
if (!isAuthenticated()) {
    // Définit un message et redirige vers la page de connexion si le joueur n'est pas authentifié
    $message = "Vous devez être connecté pour accéder à la page Énigma.";
    $_SESSION['popUp'] = $message;
    $_SESSION['success'] = true;
    redirect('/connexion');
    exit;
}

// Récupère une instance de connexion à la base de données
$pdo = Database::getInstance();

// Initialise le modèle pour Énigma
$enigmaModel = new EnigmaModel($pdo);

// Initialise les statistiques pour le joueur
$stats = new StatistiqueEnigma($idJoueur);

// Affiche la page de d'Énigma avec les statistiques du joueur et d'autres données nécessaires
view("enigma.php", [
    'id' => $idJoueur,
    'nbBonnesReponses' => $stats->getNbBonneReponse(),
    'nbMauvaisesReponses' => $stats->getNbMauvaiseReponse(),
    'errors' => $errors ?? '',
    'popUp' => $popUp ?? '',
    'style' => $style ?? '',
]);