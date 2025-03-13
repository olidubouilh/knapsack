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


?>