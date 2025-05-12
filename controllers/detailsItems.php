<?php

// Chargement des fonctions et des classes nécessaires
require_once 'src/functions.php';
require 'src/class/Database.php';
require 'models/ItemsModel.php';
require 'models/CommentaireModel.php';

$style = 'stylesdetails.css';
sessionStart();

// Récupération d'une instance PDO unique
$pdo = Database::getInstance();

// Gestion de la requête POST pour ajouter un item au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    // Vérification de l'authentification de l'utilisateur
    if (!isAuthenticated()) {
        redirect('/connexion'); // Redirection vers la page de connexion si l'utilisateur n'est pas authentifié 
        exit;
    }

    // Récupération des ID de l'item et du joueur
    $itemId = (int)$_POST['item_id'];
    $playerId = userExist() ? $_SESSION['user']['id'] : null;

    try {
        // Préparation et exécution de l'appel de la procédure stockée pour ajouter l'item au panier
        $stmt = $pdo->prepare('CALL AjouterItemPanier(?, ?)');
        $stmt->bindParam(1, $itemId, PDO::PARAM_INT);
        $stmt->bindParam(2, $playerId, PDO::PARAM_INT);
        $stmt->execute();

        redirect("/magasin"); // Redirection vers la page de la boutique en cas de succès
        exit;
    } catch (PDOException $e) {
        // Redirection vers la page des détails de l'item avec un message d'erreur en cas d'échec
        $errors = "Erreur lors de l'ajout au panier: " . $e->getMessage();
        redirect("/detailsItems?id=$itemId&error=" . urlencode($errors));
        exit;
    }
}

// Récupération de l'ID de l'item depuis les paramètres GET
$itemId = isset($_GET['id']) ? (string)$_GET['id'] : null;

// Redirection vers la page de la boutique si l'ID de l'item n'est pas fourni
if ($itemId === null) {
    redirect('/magasin');
    exit;
}

// Récupération des détails de l'item et des commentaires de la base de données
$itemsModel = new ItemsModel($pdo);
$item = $itemsModel->getItemById($itemId);
$commModel = new CommentaireModel($pdo);
$itemComments = $commModel->getItemByIdComm($itemId);

// Génération de la vue des détails de l'item
view('detailsItems.php', [
    'item' => $item,
    'itemComments' => $itemComments
]);

