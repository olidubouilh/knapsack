<?php

require_once 'src/functions.php';
require 'src/class/Database.php';
require 'models/UserModel.php';
$style = 'inventaire.css';

if(!isAuthenticated()){
    $message = "Vous devez être connecté pour accéder à l'inventaire.";
    $_SESSION['popUp'] = $message;
    $_SESSION['success'] = true;
    redirect('/connexion');
    exit;
}
sessionStart();

//A FAIRE SI ON VEUT FAIRE UNE NOTIFICATION DISANT CONNECTER OU WTV DEMANDER A OLIVIER POUR LE CODE A METTRE DANS LE HTML
// $popUp = false;
// if (isset($_SESSION['success'])) {
//     $popUp = true;
//     unset($_SESSION['success']);
// }
$pdo = Database::getInstance();

$userModel = new UserModel($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $item_id = isset($_POST['item_id']) ? (int) $_POST['item_id'] : 0;
    $item_value = isset($_POST['item_value']) ? (int) $_POST['item_value'] : 0;

    if ($item_id > 0 && $item_value >= 0) {

        $caps_to_add = (int) ($item_value * 0.6);

        $user_id = isset($_SESSION['user']['id']) ? (int) ($_SESSION['user']['id']) : 0;

        if ($user_id > 0) {
            try {
                $stmt = $pdo->prepare("CALL poidSac(:idJoueurs)");
                $stmt->bindValue(":idJoueurs", (string) $user_id, PDO::PARAM_STR);
                $stmt->execute();
                $poids = $stmt->fetch(PDO::FETCH_ASSOC);
                $old_poids = $poids['poids_total'];

                if (isset($_POST['action']) && $_POST['action'] == 'vendre') {
                    $stmt = $pdo->prepare("CALL ModifierCapsJoueurs(:caps, :idJoueurs)");
                    $stmt->bindValue(":caps", $caps_to_add, PDO::PARAM_INT);
                    $stmt->bindValue(":idJoueurs", $user_id, PDO::PARAM_INT);
                    $stmt->execute();
                }

                $stmt = $pdo->prepare("CALL ReduireItemInventaire(:idItem, :idJoueurs)");
                $stmt->bindValue(":idItem", $item_id, PDO::PARAM_INT);
                $stmt->bindValue(":idJoueurs", $user_id, PDO::PARAM_INT);
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
                $_SESSION['user']['montant'] = $user['montant'];

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

                if ($new_dexterite != $currentDexterite) {
                    $stmt = $pdo->prepare("CALL ModifierDexteriteJoueurs(:dex, :idJoueur)");
                    $stmt->bindValue(":dex", $new_dexterite, PDO::PARAM_INT);
                    $stmt->bindValue(":idJoueur", $user_id, PDO::PARAM_INT);
                    $stmt->execute();

                    $_SESSION['user']['dexterite'] = $new_dexterite;
                }

                $stmt = $pdo->prepare("UPDATE Items SET quantiteItem = quantiteItem + 1 WHERE idItems = :idItem");
                $stmt->bindValue(":idItem", $item_id, PDO::PARAM_INT);
                $stmt->execute();

            } catch (PDOException $e) {
                die("Erreur lors de la vente: " . $e->getMessage());
            }
        }
    }
}

if (isset($_SESSION['user']['id'])) {
    $idJoueur = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("SELECT * FROM VInventaire WHERE idJoueurs = :idJoueur");
    $stmt->execute(['idJoueur' => $idJoueur]);
    $inventaire = $stmt->fetchAll(PDO::FETCH_ASSOC);

    view("inventaire.php", [
        'id' => $idJoueur,
        'inventaire' => $inventaire,
        'errors' => $errors ?? '',
        'popUp' => $popUp ?? '',
        'style' => $style ?? '',
    ]);

}

