<?php
require_once '../src/class/Database.php';


function getItemById($id) {
    $pdo = new Database();
    $pdo = getPDO();

    try {

        $stmt = $pdo->prepare("CALL #############(#)");
        
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        $item = $stmt->fetch();
        
        $stmt->closeCursor();
        
        return $item ?: null;
    } catch (PDOException $erreur) {
        echo "Erreur: " . $erreur->getMessage();
        return null;
    } finally {
        closeConnection();
    }
}
?>