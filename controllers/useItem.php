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
        $stmt = $pdo->prepare("CALL poidSac(:idJoueurs)");
        $stmt->bindValue(":idJoueurs", (string) $user_id, PDO::PARAM_STR);
        $stmt->execute();
        $poids = $stmt->fetch(PDO::FETCH_ASSOC);
        $old_poids = $poids['poids_total'];

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

        $stmt = $pdo->prepare("SELECT COUNT(*) as is_nourriture FROM Nourriture WHERE idItems = :idItem");
        $stmt->bindValue(":idItem", $item_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $is_food = $result['is_nourriture'] > 0;

        $poidsMaximal = $user['PoidsMaximal'];
        $currentDexterite = $user['dexterite'];

        $weight_reduction = $old_poids - $new_poids;
        $overload = max($new_poids - $poidsMaximal, 0);
        
        if ($new_poids <= 50 && $currentDexterite < 100) {
            $new_dexterite = 100;
        } elseif ($weight_reduction > 0 && $currentDexterite < 100) {

            $dexterity_to_restore = min($weight_reduction, 100 - $currentDexterite);
            $new_dexterite = min($currentDexterite + $dexterity_to_restore, 100 - $overload);
        } else {

            $new_dexterite = max(100 - $overload, 0);
        }

        $food_bonus_applied = false;
        if ($is_food && $new_dexterite < 100) {
            $new_dexterite = min($new_dexterite + 2, 100);
            $food_bonus_applied = true;
        }

        if ($new_dexterite != $currentDexterite) {

            $new_dexterite = max(0, min($new_dexterite, 100));

            $stmt = $pdo->prepare("CALL ModifierDexteriteJoueurs(:dex, :idJoueur)");
            $stmt->bindValue(":dex", $new_dexterite, PDO::PARAM_INT);
            $stmt->bindValue(":idJoueur", $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['user']['dexterite'] = $new_dexterite;
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