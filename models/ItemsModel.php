<?php
require_once '../src/database.php';

function getItemById($id) {
    $pdo = connect();

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
        disconnect($pdo);
    }
}
?>