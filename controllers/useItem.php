<?php
ob_start();
require_once 'src/functions.php';
require 'src/class/Database.php';
require 'models/UserModel.php';
sessionStart();

$pdo = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
    $item_id = (int) $_POST['item_id'];

    try {
        $stmt = $pdo->prepare("CALL UseItem(:idJoueurs, :idItems)");
        $stmt->bindParam(':idJoueurs', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':idItems', $item_id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $pdo->prepare("CALL poidSac(:idJoueurs)");
        $stmt->bindValue(":idJoueurs", (string) $user_id, PDO::PARAM_STR);
        $stmt->execute();
        $poids = $stmt->fetch(PDO::FETCH_ASSOC);
        $new_poids = $poids['poids_total'];
        $_SESSION['user']['poidsSac'] = $new_poids;
        
        $stmt = $pdo->prepare("CALL verifierAlias(:alias)");
        $stmt->bindValue(":alias", $_SESSION['user']['alias'], PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user']['pvJoueur'] = $user['pvJoueur'];

        $_SESSION['popUp'] = "Item bien utilisé!";
        redirect('/inventaire');
    } catch (PDOException $e) {
        $_SESSION['errors'] = "Erreur lors d'utilisation d'items: " . $e->getMessage();
        redirect('/inventaire');
    }
} else {
    redirect('/connexion');
}
?>