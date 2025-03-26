<?php

require_once 'src/functions.php';   
require 'src/class/Database.php';
require 'models/UserModel.php';
$style = 'magasin.css';
sessionStart();

//A FAIRE SI ON VEUT FAIRE UNE NOTIFICATION DISANT CONNECTER OU WTV DEMANDER A OLIVIER POUR LE CODE A METTRE DANS LE HTML
// $popUp = false;
// if (isset($_SESSION['success'])) {
//     $popUp = true;
//     unset($_SESSION['success']);
// }
$pdo = Database::getInstance();
$itemsModel = new ItemsModel($pdo); 
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['form1_submit'])) {
        // Formulaire 1 soumis
    } elseif (isset($_POST['form2_submit'])) {
        // Formulaire 2 soumis
    }

}

$magasin = $itemsModel->getItemsMagasin();




// Fetching inventory data from VInventaire view


view("magasin.php", [
    'magasin' => $magasin,
    'errors' => $errors ?? '',
    'popUp' => $popUp ?? '',
    'style' => $style ?? '',    
]);

