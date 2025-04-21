<?php
require_once 'src/class/Panier.php';

class PannierModel
{

    public function __construct(private PDO $pdo) {}

    public function getItemsPanierById(Panier $panier){
        try{
            $idJoueur = $panier->getId();
            $stm = $this->pdo->prepare('CALL GetItemsPanierById(:id)');
            $stm->bindValue(":id", $idJoueur, PDO::PARAM_STR);
            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($data)){
                $panier->setItemPanier($data);
                return $panier;
            }
            return null;
            
        }
        catch(PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }   
    }
    public function verificationPayerPanierPrix(array $quantiteItem, string $alias):bool{
        try{
            $prixTotal = 0;
            foreach ($quantiteItem as $idItem => $quantite){
                $itemModel = new ItemsModel($this->pdo);
                $item = $itemModel->getItemById($idItem);
                if($item){
                    $prixTotal += $item['prix'] * $quantite;
                }
            }
            $user = new UserModel($this->pdo);
            $infoJoueur = $user->selectInfoJoueur($alias);
            $caps = $infoJoueur->getMontant();
            if($caps >= $prixTotal){
                return true;
            }
            return false;
        }
        catch(PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    public function VerifierDex(array $quantiteItem, string $alias){
        try{
            $poidsTotalpanier = 0;
            foreach ($quantiteItem as $idItem => $quantite){
                $itemModel = new ItemsModel($this->pdo);
                $item = $itemModel->getItemById($idItem);
                if($item){
                    $poidsTotalpanier += $item['poids'] * $quantite;
                }
            }
            $user = new UserModel($this->pdo);
            $infoJoueur = $user->selectInfoJoueur($alias);
            $poidsMax = $infoJoueur->getPoidsMaximal();
            $poidsSacc = $user->poidSac($_SESSION['user']['id']);
            if($poidsTotalpanier + $poidsSacc <= $poidsMax){
                return true;
            }
            return false;
        }
        catch(PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }

    }
    public function payerPanier(array $quantiteItem, string $alias){
        try{
            $prixTotal = 0;
            foreach ($quantiteItem as $idItem => $quantite){
                $itemModel = new ItemsModel($this->pdo);
                $item = $itemModel->getItemById($idItem);
                if($item){
                    $prixTotal += $item['prix'] * $quantite;
                }
            }
            $user = new UserModel($this->pdo);
            $infoJoueur = $user->selectInfoJoueur($alias);
            $caps = $infoJoueur->getMontant();
            $caps -= $prixTotal;
            $stm = $this->pdo->prepare('Update Joueurs set montant = :caps where alias = :alias');
            $stm->bindValue(":caps", $caps, PDO::PARAM_STR);
            $stm->bindValue(":alias", $alias, PDO::PARAM_STR);
            $stm->execute();
        }
        catch(PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    public function setItemPanier(Panier $panier){
        try{
            $itemPanier = $panier->getItemPanier();
            $descriptionItem = [];
            $itemModell = new ItemsModel($this->pdo);
            foreach (array_keys($itemPanier) as $idItem) {
                $item = $itemModell->getItemById($idItem);
                if($item){
                    $descriptionItem[$idItem] = $item;
                }
            }
            if(!empty($descriptionItem)){
                $panier->setDescriptionItem($descriptionItem);
                return $panier;
            }
            return null;
        }
        catch(PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}