<?php
class Commentaire{
    private int $idCommentaire;
    private int $idJoueurs;
    private int $idItems;
    private string $commentaire;

    public function __construct(int $idJoueur, int $idItem, string $commentaire){
        $this->idJoueurs = $idJoueur;
        $this->idItems = $idItem;
        $this->commentaire = $commentaire;
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
?>