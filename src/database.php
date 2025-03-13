<?php
# Lien pour les refs des functions MySQLi : https://www.w3schools.com/php/php_ref_mysqli.asp

#Fonction pour se connecter à la BD MySQL
function getPdo(){
    try{
        return new PDO("mysql:host=".CONFIGURATIONS["servername"].";dbname=".CONFIGURATIONS["dbname"], CONFIGURATIONS["username"], CONFIGURATIONS["password"], DB_PARAMS);
    }
    catch(PDOException $erreur){
        throw new PDOException($erreur->getMessage());
    }
}
#Function pour se déconnecter de la BD
function disconnect($connection){
    if ($connection) {
        $connection = null;;
        echo "Déconnection reussi!";
    }
}
#Fonction pour exécuter une query SQL
function insert($query){
    $connection = getPdo();
    if ($result = mysqli_query($connection, $query)) {
        return $result;
    }
    disconnect($connection);
}

?>