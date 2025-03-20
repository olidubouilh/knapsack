<?php

require 'partials/head.php';
require 'partials/header.php'

?>
<html>

<body>
    <main>
        <div style="color:  rgb(255, 255, 25);">
            <h3>Caps: <? $_SESSION['user']['montant'] ?></h3>
        </div>
        <h1><? $item['nomItem'] ?></h1>
        <img src=<? $item['photo']?> alt="">
        <br>
        <h3>Type Item: <? $item['typeItem'] ?></h3>
        <h3>Utilité: <? $item['utilite'] ?></h3>
        <h3>Efficacité: <? #Efficacité ?></h3>
        <h3>Genre: <? #Genre ?></h3>
        <h3>Description: </h3>
        <h4><? #Description ?></h4>
        <h3>Prix : <? $item['prix'] ?></h3>
        <h3>Quantite Disponible: <? $item['quantiteItem'] ?></h3>
        <h3>Poid : <? $item['poids'] ?></h3>
        <h3>Type de munition: Non Applicable</h3>
        <div class="boutons-container">
            <a href="#" class="bouton">Retour</a>
            <a href="#" class="bouton">Acheter</a>
        </div>
    </main>

</body>

</html>