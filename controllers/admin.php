<?php
require_once 'src/functions.php';
require_once 'src/class/Database.php';
require_once 'models/ItemsModel.php';
sessionStart();

if (!isAdministrator()) {
    redirect('/connexion');
    exit;
}

$pdo = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idJoueurs = isset($_POST['idJoueurs']) ? (int) $_POST['idJoueurs'] : null;

    try {
        $stmt = $pdo->prepare("CALL AjouterCapsJoueurs(?)");
        $stmt->bindParam(1, $idJoueurs, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $pdo->prepare("CALL verifierAlias(:alias)");
        $stmt->bindValue(":alias", $_SESSION['user']['alias'], PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user']['montant'] = $user['montant'];
    } catch (PDOException $e) {
        redirect("/admin?error=" . urlencode("Erreur: " . $e->getMessage()));
    }
}


$stmt = $pdo->prepare("SELECT * FROM Joueurs");
$stmt->execute();
$joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);


view("admin.php", [
    'joueurs' => $joueurs,
]);

