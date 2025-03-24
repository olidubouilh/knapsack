<?php 
require_once 'src/functions.php';   
require 'src/class/Database.php';
require 'models/ItemsModel.php';
sessionStart();
$pdo = Database::getInstance();
$id = isset($_GET['id']) ? (string)$_GET['id'] : null;

$itemsModel = new ItemsModel($pdo); 

$item = $itemsModel->getItemById($id);

view('detailsItems.php', [
    'item' => $item
]);
