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