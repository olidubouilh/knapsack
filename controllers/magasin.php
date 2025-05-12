<?php

require_once 'src/functions.php';   
require 'src/class/Database.php';
require 'models/ItemsModel.php';
$style = 'magasin.css';
sessionStart();
$pdo = Database::getInstance();
$itemsModel = new ItemsModel($pdo); 

$magasin = $itemsModel->getItemsMagasin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['details'])) {
        $idDetails = $_POST['details'] ?? '';
        header("Location: /detailsItems?id=" . urlencode($idDetails));
        exit;
    }

    if (isset($_POST['search'])) {
        $recherche = isset($_POST['searchBar']) ? trim($_POST['searchBar']) : "";
        $categories = [];
        if (isset($_POST['A'])) $categories[] = "A";
        if (isset($_POST['W'])) $categories[] = "W";
        if (isset($_POST['M'])) $categories[] = "M";
        if (isset($_POST['N'])) $categories[] = "N";
        if (isset($_POST['B'])) $categories[] = "B";
        $magasin = $itemsModel->getItemsMagasinFiltrer($recherche, $categories);
    }
}






// Fetching inventory data from VInventaire view


view("magasin.php", [
    'magasin' => $magasin,
    'errors' => $errors ?? '',
    'popUp' => $popUp ?? '',
    'style' => $style ?? '',    
]);