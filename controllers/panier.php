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
$user = $userModel->selectInfoJoueur($_SESSION['user']['alias']);
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
$itemsModel = new ItemsModel($pdo);
$pannierModel = new PannierModel($pdo);
$popUp = false;
if (isset($_SESSION['success'])) {
    $popUp = true;
    unset($_SESSION['success']);
}

if (isset($_SESSION['user']['id'])) {
    $idJoueur = $_SESSION['user']['id']; 
    $panier = new Panier($idJoueur);
    $panier = $pannierModel->getItemsPanierById($panier) ?? null;
    if(!empty($panier)){
        $panier = $pannierModel->setItemPanier($panier) ?? null;
        $panierItems = $panier->getItemPanier() ?? null;
        $itemsDescription = $panier->getDescriptionItem() ?? null;
    }
   
    if (isset($_POST['supprimer'])) {
        $idItemASupprimer = $_POST['supprimer'];
        $pannierModel->supprimerItemDuPanier($_SESSION['user']['id'], $idItemASupprimer);
        $_SESSION['success'] = true;
        redirect('/panier');
    }


    if(isset($_POST['quantites'])){
        $quantiteItems = $_POST['quantites'];
       
        $payerPossible = $pannierModel->verificationPayerPanierPrix($quantiteItems, $_SESSION['user']['alias']);
        if($payerPossible){
            $poidLourd = $pannierModel->VerifierDex($quantiteItems, $_SESSION['user']['alias']);
            if($poidLourd || isset($_POST['confirmerDex'])){
                $erreur = $pannierModel->payerFullPanier($quantiteItems, $_SESSION['user']['alias'], $poidLourd);
                
                if(empty($erreur)){
                    $popUp = "Vous avez payé votre panier avec succès";
                    $_SESSION['success'] = true;
                    redirect('/panier');
                }
                else{
                    $popUp = $erreur;
                    $_SESSION['success'] = true;
                }
                
                
            }
            else {
                $popUp2 = "confirmationDex";
                $quantitesEnAttente = $quantiteItems;
            }
        }
        else{
            $popUp = "Vous n'avez pas assez d'argent pour payer votre panier";
            $_SESSION['success'] = true;
        }
    }

    view("panier.php", [
        'id' => $idJoueur,
        'panier' => $itemsDescription ?? '',
        'quantite' => $panierItems ?? '',
        'quantitesEnAttente' => $quantitesEnAttente ?? null,
        'errors' => $errors ?? '',
        'popUp' => $popUp ?? '',
        'popUp2' => $popUp2 ?? '',
        'style' => $style ?? '',
    ]);
} else if (!isset($_SESSION['user']['id'])) {
    redirect('/connexion');
    exit;
}
?>