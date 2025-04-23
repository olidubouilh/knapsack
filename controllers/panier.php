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

if (isset($_SESSION['user']['id'])) {
    $idJoueur = $_SESSION['user']['id']; 
    $panier = new Panier($idJoueur);
    $panier = $pannierModel->getItemsPanierById($panier) ?? null;
    if(!empty($panier)){
        $panier = $pannierModel->setItemPanier($panier) ?? null;
        $panierItems = $panier->getItemPanier() ?? null;
        $itemsDescription = $panier->getDescriptionItem() ?? null;

    }
   
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if (isset($_POST['supprimer'])) {
            $idItemASupprimer = $_POST['supprimer'];
            $pannierModel->supprimerItemDuPanier($_SESSION['user']['id'], $idItemASupprimer);
            $message = "Objet supprimé du panier";
            $_SESSION['popUp'] = $message;
            $_SESSION['success'] = true;
            redirect('/panier');
        }
            
           
        if(isset($_POST['payer']) && isset($_POST['quantites'])) {
            $quantiteItems = $_POST['quantites'];
        
            $payerPossible = $pannierModel->verificationPayerPanierPrix($quantiteItems, $_SESSION['user']['alias']);
            if($payerPossible){
                $poidLourd = $pannierModel->VerifierDex($quantiteItems, $_SESSION['user']['alias']);
                if($poidLourd || isset($_POST['confirmerDex'])){
                    $erreur = $pannierModel->payerFullPanier($quantiteItems, $_SESSION['user']['alias'], $poidLourd);
                    
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
} else if (!isset($_SESSION['user']['id'])) {
    redirect('/connexion');
    exit;
}
?>