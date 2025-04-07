<?php

require_once 'src/functions.php';
require 'src/class/Database.php';
require 'models/UserModel.php';
$style = 'inventaire.css';
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
                $stmt = $pdo->prepare("CALL ModifierCapsJoueurs(:caps, :idJoueurs)");
                $stmt->bindValue(":caps", $caps_to_add, PDO::PARAM_INT);
                $stmt->bindValue(":idJoueurs", $user_id, PDO::PARAM_INT);
                $stmt->execute();

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

} else {
    redirect('/connexion');
}

