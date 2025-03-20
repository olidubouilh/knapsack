<?php
require_once '../../src/class/Database.php';


function getItemById($id)
{

    try {
        $pdo = Database::getInstance();

        $stmt = $pdo->prepare("CALL #############(". $id . ")");

        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $stmt->execute();

        $item = $stmt->fetch();

        $stmt->closeCursor();

        return $item ?: null;
    } catch (PDOException $erreur) {
        echo "Erreur dans getItemById: " . $erreur->getMessage();
        return null;
    }
}
?>