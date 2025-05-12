<?php
class Panier{
    private int $id;
    private array $itemPanier;
    private array $descriptionItem;

    public function __construct(int $idJoueur){
        $this->id = $idJoueur;
    }
    public function getId(): int{
        return $this->id;
    }
    public function getItemPanier(): array{
        return $this->itemPanier ?? null;
    }
    public function setItemPanier(array $itemPanier): void{
        $assoc = [];
        foreach ($itemPanier as $row) {
            $assoc[$row['idItems']] = $row['quantiteItem'];
        }
        $this->itemPanier = $assoc;
    }
    public function getDescriptionItem(): array{
        return $this->descriptionItem ?? null;
    }
    public function setDescriptionItem(array $descriptionItem): void{
        $assoc = [];
        foreach ($descriptionItem as $row) {
            $assoc[$row['idItems']] = new Items($row['idItems'], $row['nomItem'], $row['quantiteItem'], $row['typeItem'], $row['prix'], $row['poids'], $row['utilite'], $row['photo']);
        }
        $this->descriptionItem = $assoc;    
    }
}