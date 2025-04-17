<?php
require 'partials/head.php';
require 'partials/header.php';
require 'partials/footer.php';
?>

    <div id="popupNotification" class="popupNotification">Article ajouté!</div>
    <main>
    <table>
        <h1><?php echo $item['nomItem']; ?></h1>
    <td>
        <img style="padding-left: 15px; width: 600px" src="<?php echo $item['photo']; ?>" alt="">
    </td>
    <td>
    <div><?php echo $item['description']; ?></div>
    <br>
        <div>Utilité: <?php echo $item['utilite']; ?></div>
        <div>Prix : <?php echo $item['prix']; ?> Caps</div>
        <div>Quantite Disponible: <?php echo $item['quantiteItem']; ?></div>
        <div>Poid : <?php echo $item['poids']; ?></div>
        <div>Utilité : <?php echo $item['utilite']; ?></div>
        
        <?php if ($item['typeItem'] == 'A'): ?>
            <div>Type Item: Armure</div>
            <div>Matière: <?php echo $item['matiere']; ?></div>
            <div>Taille: <?php echo $item['taille']; ?></div>
        <?php endif; ?>
        <?php if ($item['typeItem'] == 'W'): ?>
            <div>Type Item: Arme</div>
            <div>Calibre: <?php echo $item['typeCalibre']; ?></div>
            <div>Efficacité: <?php echo $item['efficacite']; ?></div>
        <?php endif; ?>
        <?php if ($item['typeItem'] == 'M'): ?>
            <div>Type Item: Médicament</div>
            <div>Effet: <?php echo $item['effet']; ?></div>
            <div>Effet secondaire: <?php echo $item['effetSecondaire']; ?></div>
            <div>Durée: <?php echo $item['duree']; ?></div>
        <?php elseif ($item['typeItem'] == 'N'): ?>
            <div>Type Item: Nourriture</div>
            <div>Effet: <?php echo $item['effetNourriture']; ?></div>
            <div>Nombre de calories: <?php echo $item['nbCalories']; ?></div>
            <div>Composant Nutritif: <?php echo $item['composantNutritif']; ?></div>
            <div>Composant Mineral: <?php echo $item['composantMineral']; ?></div>
        <?php endif; ?>
        
        <div class="boutons-cote">
            <form action="/detailsItems" method="post">
                <input type="hidden" name="item_id" value="<?php echo $item['idItems']; ?>">
                <button type="submit" class="bouton" style="margin-bottom: 10px;">Ajouter au panier</button>
            <a href="/magasin" class="bouton">Retour</a></form>
        </div>
        </td>
    </table>
    </main>
    <!-- <?php if ($popUp): ?>
        <script>
            alertShow();
        </script>
    <?php endif; ?> -->
