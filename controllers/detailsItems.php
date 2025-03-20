<?php 
require_once dirname(__FILE__) . '/../models/ItemsModel.php';

function showDetailsItem(){
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    $item = getItemById($id);

    if($item == null){
        redirect(dirname(__FILE__) . '/../views/page-not-found.php');
    }

    require dirname(__FILE__) . '/../views/detailsItem.php';
}

showDetailsItem();
?>