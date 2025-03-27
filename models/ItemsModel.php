<?php
require_once 'src/class/Items.php';
class ItemsModel
{

    public function __construct(private PDO $pdo) {}

    public function getItemById($id)
    {

        try {
            $stm = $this->pdo->prepare('CALL getItemById(:id)');
            $stm->bindValue(":id", $id, PDO::PARAM_STR);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            return $data ?: null;
        } catch (PDOException $erreur) {
            echo "Erreur dans getItemById: " . $erreur->getMessage();
            return null;
        }
    }
    public function getItemsMagasin(){
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM Items");
            $stmt->execute();
            $magasin = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $magasin ?? null;

        }
        catch(PDOException $erreur){
            echo"erreur: ". $erreur->getMessage();
            return null;
        }
    }
    

    public function SupprimerItemPanier($idItem, $idJoueur): void
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("CALL SupprimerItemPanier(:idItems, :idJoueurs)");
        $stmt->execute([
            'idItems' => $idItem,
            'idJoueurs' => $idJoueur
        ]);
    }
}
