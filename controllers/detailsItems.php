<?php 
require_once 'src/functions.php';   
require 'src/class/Database.php';
require 'models/ItemsModel.php';
require 'models/CommentaireModel.php';
$style = 'stylesdetails.css';
sessionStart();

$popUp = false;
if (isset($_SESSION['success'])) {
    $popUp = true;
    unset($_SESSION['success']);
}

$pdo = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    if (!isset($_SESSION['user']['id'])) {
        redirect('/connexion');
        exit;
    }

    $itemId = (int)$_POST['item_id'];
    $playerId = $_SESSION['user']['id'];

    try {
        $stmt = $pdo->prepare("CALL AjouterItemPanier(?, ?)");
        $stmt->bindParam(1, $itemId, PDO::PARAM_INT);
        $stmt->bindParam(2, $playerId, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['success'] = true;

        redirect("/magasin");
        
        exit;
    } catch (PDOException $e) {
        $errors = "Erreur lors de l'ajout au panier: " . $e->getMessage();
        redirect("/detailsItems?id=$itemId&error=" . urlencode($errors));
        exit;
    }
}

$id = isset($_GET['id']) ? (string)$_GET['id'] : null;

$itemsModel = new ItemsModel($pdo); 

$item = $itemsModel->getItemById($id);

$CommModel = new CommentaireModel($pdo); 

$itemComm = $CommModel->getItemByIdComm($id);

view('detailsItems.php', [
    'item' => $item,
    'itemComm' => $itemComm
]);
