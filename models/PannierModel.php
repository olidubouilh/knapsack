<?php
require_once 'src/class/Panier.php';
require_once 'src/class/User.php';

class PannierModel
{

    public function __construct(private PDO $pdo) {}

    public function getItemsPanierById(Panier $panier){
        try{
            $idJoueur = $panier->getId();
            $stm = $this->pdo->prepare('SELECT * FROM Panier WHERE idJoueurs = :id');
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
    public function payerFullPanier(array $quantiteItem, string $alias, bool $modifierDex){
        try{
            $itemModel = new ItemsModel($this->pdo);    
            $userModel = new UserModel($this->pdo);

            $totalPrix = 0;
            $poidsAjoute = 0;

            foreach ($quantiteItem as $idItem => $quantite){
                
                $item = $itemModel->getItemById($idItem);
                if($item){
                    $totalPrix += $item['prix'] * $quantite;
                    $poidsAjoute += $item['poids'] * $quantite;
                }
            }

        }
        catch(PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode());
        }
        $erreur = '';
        $poidsActuel = $userModel->poidSac($_SESSION['user']['id']);
        $poidsTotal = $poidsActuel + $poidsAjoute;
        
        $excedent = $poidsTotal - 50;
        $infoJoueur = $userModel->selectInfoJoueur($alias);
        $dexActuelle = $infoJoueur->getDexterite();
        if($poidsTotal > 50) {
            $poidSac = 50;
        }
        else{
            $poidSac = $poidsTotal;
        }

        if ($dexActuelle <= 1) {
            $erreur = "Vous n’avez pas assez de dextérité pour compenser la surcharge.";
        }
        if ($dexActuelle < $excedent) {
            $erreur = "Vous n’avez pas assez de dextérité pour compenser la surcharge.";
            
        }
        if($erreur == ''){
            try{
                $stm = $this->pdo->prepare("UPDATE Joueurs SET montant = montant - :totalPrix WHERE alias = :alias");
                $stm->execute([
                    'totalPrix' => $totalPrix,
                    'alias' => $alias
                ]);
                $stm = $this->pdo->prepare("UPDATE Joueurs SET poids = :poidsAjoute WHERE alias = :alias");
                $stm->execute([
                    'poidsAjoute' => $poidSac,
                    'alias' => $alias
                ]);
                if($excedent > 0){
                   
                    
                    $stm = $this->pdo->prepare("UPDATE Joueurs SET dexterite = dexterite - :excedent WHERE alias = :alias");
                    $stm->execute([
                    'excedent' => $excedent,
                    'alias' => $alias
                    ]);
                    
                    
                }
               
                foreach ($quantiteItem as $idItem =>$quantite) {
                    $stm = $this->pdo->prepare("INSERT INTO SacADos (idItems, idJoueurs, quantite) VALUES (:idItem, :idJoueur, :quantite) ON DUPLICATE KEY UPDATE quantite = quantite + :quantite");
                    $stm->execute([
                        'idItem' => $idItem,
                        'idJoueur' => $_SESSION['user']['id'],
                        'quantite' => $quantite
                    ]);
                    $stm = $this->pdo->prepare("UPDATE Items SET quantiteItem = quantiteItem - :quantite WHERE idItems = :idItem");
                    $stm->execute([
                        'quantite' => $quantite,
                        'idItem' => $idItem
                    ]);
                }
                $stm = $this->pdo->prepare("DELETE from Panier WHERE idJoueurs = :idJoueur");
                $stm->execute([
                    'idJoueur' => $_SESSION['user']['id']
                ]);
                return $erreur;
            }
            catch(PDOException $e){
                throw $e;
            }
            
        }
        else{
            return $erreur;
        }
            
       

        
    }
    public function supprimerItemDuPanier($idJoueur, $idItem): void {
        try {
            $stm = $this->pdo->prepare("DELETE FROM Panier WHERE idJoueurs = :idJoueur AND idItems = :idItem");
            $stm->execute([
                'idJoueur' => $idJoueur,
                'idItem' => $idItem
            ]);
        } catch (PDOException $e) {
            throw $e;
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