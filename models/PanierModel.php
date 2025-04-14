<?php
require_once 'src/class/Panier.php';

class PanierModel
{
    public function __construct(private PDO $pdo) {}


    public function getPanier(int $idJoueur){

        try{
        $stmt = $this->pdo->prepare("SELECT * FROM VPanier WHERE idJoueurs = :idJoueur");
        $stmt->bindParam(":idJoueur", $idJoueur, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {

            return new Panier(
                $data['idItems'],
                $data['idJoueurs'],
                $data['quantiteItem']
            );
        }
        else 
        {
            return null;
        }
        }catch(PDOException $e){
            //à changer
            echo"erreur: ". $e->getMessage();
            return null;
        }
    }   
}

