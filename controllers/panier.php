<?php
require_once 'src/functions.php';
require 'src/class/Database.php';
require 'models/UserModel.php';
require 'models/ItemsModel.php';
require 'models/PanierModel.php';
require_once 'src/class/Panier.php';
$style = 'panier.css';

if(!isAuthenticated()){
    $message = "Vous devez être connecté pour accéder au panier.";
    $_SESSION['popUp'] = $message;
    $_SESSION['success'] = true;
    redirect('/connexion');
    exit;
}
sessionStart();

$pdo = Database::getInstance();
$userModel = new UserModel($pdo);

$itemsModel = new ItemsModel($pdo);
$panierModel = new PanierModel($pdo);
$popUp = false;
if (isset($_SESSION['success'])) {
    $popUp = true;
    unset($_SESSION['success']);
}
$message = '';
if (isset($_SESSION['popUp'])) {
    $message = $_SESSION['popUp'];
    unset($_SESSION['popUp']);
}

if (userExist()) {
    $idJoueur = $_SESSION['user']['id'] ?? null; 
    $panier = new Panier($idJoueur);
    $panier = $panierModel->getItemsPanierById($panier) ?? null;
    if(!empty($panier)){
        $panier = $panierModel->setItemPanier($panier) ?? null;
        $panierItems = $panier->getItemPanier() ?? null;
        $itemsDescription = $panier->getDescriptionItem() ?? null;

    }
   
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if (isset($_POST['supprimer'])) {
            $idItemASupprimer = $_POST['supprimer'];
            $panierModel->supprimerItemDuPanier($_SESSION['user']['id'], $idItemASupprimer);
            $message = "Objet supprimé du panier";
            $_SESSION['popUp'] = $message;
            $_SESSION['success'] = true;
            redirect('/panier');
        }
            
           
        if(isset($_POST['payer']) && isset($_POST['quantites'])) {
            $quantiteItems = $_POST['quantites'];
        
            $payerPossible = $panierModel->verificationPayerPanierPrix($quantiteItems, $_SESSION['user']['alias']);
            if($payerPossible){
                $poidLourd = $panierModel->VerifierDex($quantiteItems, $_SESSION['user']['alias']);
                if($poidLourd || isset($_POST['confirmerDex'])){
                    $erreur = $panierModel->payerFullPanier($quantiteItems, $_SESSION['user']['alias'], $poidLourd);
                    
                    if(empty($erreur)){
                        $message = "Vous avez payé votre panier avec succès";
                        $_SESSION['popUp'] = $message;
                        $_SESSION['success'] = true;
                        $alias = $_SESSION['user']['alias'];
                        $user = $userModel->selectInfoJoueur($alias);
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
                        redirect('/panier');
                        
                    }
                    else{
                        $message = $erreur;
                        $_SESSION['popUp'] = $message;
                        $_SESSION['success'] = true;
                        redirect('/panier');
                    }
                }
                else {
                    $popUp2 = "confirmationDex";
                    $quantitesEnAttente = $quantiteItems;
                }
            }
            else{
                $message = "Vous n'avez pas assez d'argent pour payer votre panier";
                $_SESSION['popUp'] = $message;
                $_SESSION['success'] = true;
                redirect('/panier');
            }
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
        'message' => $message ?? '',
    ]);
} else if (!userExist()) {
    redirect('/connexion');
    exit;
}