<?php
require_once 'src/class/Items.php';
require_once 'src/class/Panier.php';

class ItemsModel
{

    public function __construct(private PDO $pdo)
    {
    }

    public function getItemById($id): array|null
    {

        try {
            $stm = $this->pdo->prepare('SELECT * FROM Items WHERE idItems = :id');
            $stm->bindValue(":id", $id, PDO::PARAM_STR);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            return $data ?: null;
        } catch (PDOException $erreur) {
            echo "Erreur dans getItemById: " . $erreur->getMessage();
            return null;
        }
    }
    public function getItemsMagasin()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT  Items.*,
                                                COALESCE(Nourriture.effet, Medicaments.effet) AS effet
                                                FROM 
                                                    Items
                                                LEFT JOIN 
                                                    Nourriture ON Items.idItems = Nourriture.idItems AND Items.typeItem = 'N'
                                                LEFT JOIN 
                                                    Medicaments ON Items.idItems = Medicaments.idItems AND Items.typeItem = 'M';");
            $stmt->execute();
            $magasin = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $magasin ?? null;

        } catch (PDOException $erreur) {
            echo "erreur: " . $erreur->getMessage();
            return null;
        }
    }
    public function getItemsMagasinFiltrer($recherche, $categories): array|null
    {
        try {
            $sql = "SELECT * FROM Items";
            $conditions = [];
            $params = [];

            if (!empty($recherche)) {
                $conditions[] = "nomItem LIKE :recherche";
                $params[':recherche'] = "%" . $recherche . "%";
            }

            if (!empty($categories)) {

                $placeholders = [];
                foreach ($categories as $index => $cat) {
                    $placeholder = ":typeItem" . $index;
                    $placeholders[] = $placeholder;
                    $params[$placeholder] = $cat;
                }
                $conditions[] = "typeItem IN (" . implode(',', $placeholders) . ")";
            }

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultats ?: null;
        } catch (PDOException $e) {
            echo "Erreur dans getItemsFiltres: " . $e->getMessage();
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
class CommentaireModel
{

    public function __construct(private PDO $pdo)
    {
    }
    public function getItemByIdComm($id): array|null
    {

        try {
            $stm = $this->pdo->prepare('CALL getItemByIdComm(:id)');
            $stm->bindValue(":id", $id, PDO::PARAM_STR);
            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $data ?: null;
        } catch (PDOException $erreur) {
            echo "Erreur dans getItemById: " . $erreur->getMessage();
            return null;
        }
    }

}
