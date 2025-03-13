<?php
class Panier{
    private int $idItems;
    private int $idJoueurs; 
    private int $quantiteItem;

    public function __construct(int $id, int $idJoueur, int $quantite){
        $this->idItems = $id;
        $this->idJoueurs = $idJoueur;
        $this->quantiteItem = $quantite;
    }

    public function getId(): int {
        return $this->idItems;
    }
    public function getIdJoueur(): int {
        return $this->idJoueurs;
    }
    public function getQuantite(): int{
        return $this->quantiteItem;
    }

    public function setQuantite(int $quantite): void {
        $this->quantiteItem = $quantite;
    }
}

?>