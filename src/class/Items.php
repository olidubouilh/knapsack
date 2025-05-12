<?php
class Items{
    private int $idItems;
    private string $nomItem;
    private int $quantiteItem;
    private string $typeItem;
    private int $prix;
    private int $poids;
    private int $utilite;
    private string $photo;

    public function __construct(int $id, string $nom, int $quantite, string $type, int $prix, int $poids, int $utilite, string $photo){
        $this->idItems = $id;
        $this->nomItem = $nom;
        $this->quantiteItem = $quantite;
        $this->typeItem = $type;
        $this->prix = $prix;
        $this->poids = $poids;
        $this->utilite = $utilite;
        $this->photo = $photo;
    }
    public function getNomItem(){
        return $this->nomItem;
    }
    public function getQuantiteItem(){
        return $this->quantiteItem;
    }
    public function getTypeItem(){
        return $this->typeItem;
    }
    public function getPrix(){
        return $this->prix;
    }
    public function getPoids(){
        return $this->poids;
    }
    public function getUtilite(){
        return $this->utilite;
    }
    public function getPhoto(){
        return $this->photo;
    }
    public function setQuantiteItem(int $quantite){
        $this->quantiteItem = $quantite;
    }
    public function setPrix(int $prix){
        $this->prix = $prix;
    }
}

class Commentaire{
    private int $idCommentaire;
    private int $idJoueurs;
    private int $idItems;
    private string $commentaire;
    private int $nbEtoiles;

    public function __construct(int $idJoueur, int $idItem, string $commentaire, int $nbEtoiles){
        $this->idJoueurs = $idJoueur;
        $this->idItems = $idItem;
        $this->commentaire = $commentaire;
        $this->nbEtoiles = $nbEtoiles;
    }   
    public function getIdJoueur(){
        return $this->idJoueurs;
    }
    public function getIdItem(){
        return $this->idItems;
    }
    public function getCommentaire(){
        return $this->commentaire;
    }
    public function setCommentaire(string $commentaire){
        $this->commentaire = $commentaire;
    }
}
