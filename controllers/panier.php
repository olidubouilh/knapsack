<?php
require_once 'src/functions.php';
require 'src/class/Database.php';
require 'models/UserModel.php';
require 'models/ItemsModel.php';
require 'models/PannierModel.php';
require_once 'src/class/Panier.php';
$style = 'panier.css';
sessionStart();

$pdo = Database::getInstance();
$userModel = new UserModel($pdo);
$itemsModel = new ItemsModel($pdo);
$pannierModel = new PannierModel($pdo);


if (isset($_SESSION['user']['id'])) {
    $idJoueur = $_SESSION['user']['id']; 
    $panier = new Panier($idJoueur);
    $panier = $pannierModel->getItemsPanierById($panier);
    $panier = $pannierModel->setItemPanier($panier);
    $panierItems = $panier->getItemPanier();
    $itemsDescription = $panier->getDescriptionItem();

    if(isset($_POST['quantites'])){
        $quantiteItems = $_POST['quantites'];
       
        $payerPossible = $pannierModel->verificationPayerPanierPrix($quantiteItems, $_SESSION['user']['alias']);
        if($payerPossible){
            $poidLourd = $pannierModel->VerifierDex($quantiteItems, $_SESSION['user']['alias']);
            if($poidLourd){
                $panierModel->payerPanier($quantiteItems, $_SESSION['user']['alias']);
                $popUp = "Vous avez payé votre panier avec succès";
                
            }
        }
        else{
            $popUp = "Vous n'avez pas assez d'argent pour payer votre panier";
        }
    }

    view("panier.php", [
        'id' => $idJoueur,
        'panier' => $itemsDescription,
        'quantite' => $panierItems,
        
        'errors' => $errors ?? '',
        'popUp' => $popUp ?? '',
        'style' => $style ?? '',
    ]);
} else if (!isset($_SESSION['user']['id'])) {
    redirect('/connexion');
    exit;
}
?>