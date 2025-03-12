<?php
# Lien pour les refs des functions MySQLi : https://www.w3schools.com/php/php_ref_mysqli.asp

#Fonction pour se connecter à la BD MySQL
function connect(){
    $connection = mysqli_connect(CONFIGURATIONS['servername'], CONFIGURATIONS['username'], CONFIGURATIONS['password'], CONFIGURATIONS['dbname']);

    if (!$connection) {
        exit("Connection échoué: " . mysqli_connect_error());
    }

    echo "Connection reussi!";

    return $connection;
}
#Function pour se déconnecter de la BD
function disconnect($connection){
    if ($connection) {
        mysqli_close($connection);
        echo "Déconnection reussi!";
    }
}
#Fonction pour exécuter une query SQL
function query($query){
    $connection = connect();
    if ($result = mysqli_query($connection, $query)) {
        return $result;
    }
    disconnect($connection);
}

?>