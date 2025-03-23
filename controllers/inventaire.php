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

    $alias = $_POST['alias'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($alias)) {
    $errors = "Alias ou mot de passse invalide";
    }
    if (empty($password)) {
        $errors = "Alias ou mot de passse invalide";
    }
    elseif(!$userModel->selectByAlias($alias, $password)) {
        $errors = "Alias ou mot de passse invalide";
    }
    if (empty($errors)) {

        $user = $userModel->selectByAlias($alias, $password);
        //FUTURE POUR SAVOIR SI EST ADMIN OU NON
        // if($user->getActive() == false){
        //     redirect('/inactif');
        //     exit;
        // }
        //else{
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'alias'=> $user->getAlias(),
                'montant'=> $user->getMontant(),
                'dexterite'=> $user->getDexterite(),
                'pvJoueur'=> $user->getPvJoueur(),
                'poidsMaximal'=> $user->getPoidsMaximal(),
            ];
            redirect('/');
            exit;
        //}
       
    }  
}
#############################Câlicement temporaire################

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