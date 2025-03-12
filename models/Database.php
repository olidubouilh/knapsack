<?php 
#Fonction pour se connecter à la BD MySQL
function connect(){
    $connection = mysqli_connect(CONFIGURATIONS['servername'], CONFIGURATIONS['username'], CONFIGURATIONS['password'], CONFIGURATIONS['dbname']);

    if (!$connection) {
        exit("Connection échoué: " . mysqli_connect_error());
    }

    echo "Connection reussi!";
}
?>