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

        $poidsMaximal = $user['PoidsMaximal'];
        $currentDexterite = $user['dexterite'];

        if ($new_poids <= $poidsMaximal && $currentDexterite < 100) {

            $stmt = $pdo->prepare("CALL ModifierDexteriteJoueurs(:dex, :idJoueur)");
            $stmt->bindValue(":dex", 100, PDO::PARAM_INT);
            $stmt->bindValue(":idJoueur", $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['user']['dexterite'] = 100;
        }
        redirect('/inventaire');
    } catch (PDOException $e) {
        $_SESSION['errors'] = "Erreur lors d'utilisation d'items: " . $e->getMessage();
        redirect('/inventaire');
    }
} else {
    redirect('/connexion');
}
?>