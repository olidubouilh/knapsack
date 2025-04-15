<?php
require 'partials/head.php';
require 'partials/header.php';
require 'partials/footer.php';
?>

    <div id="popupNotification" class="popupNotification">Article ajouté!</div>
    <main>

        <h1><?php echo $item['nomItem']; ?></h1>
        <img src="<?php echo $item['photo']; ?>" alt="">
        <br>
        <div>Type Item: <?php echo $item['typeItem']; ?></div>
        <div>Utilité: <?php echo $item['utilite']; ?></div>
        <div>Description: </div>
        <h4><?php echo $item['description']; ?></h4>

        <div>Prix : <?php echo $item['prix']; ?></div>
        <div>Quantite Disponible: <?php echo $item['quantiteItem']; ?></div>
        <div>Poid : <?php echo $item['poids']; ?></div>
        <div>Utilité : <?php echo $item['utilite']; ?></div>

        <?php if ($item['typeItem'] == 'A'): ?>
            <div>Matière: <?php echo $item['matiere']; ?></div>
            <div>Taille: <?php echo $item['taille']; ?></div>
        <?php endif; ?>
        <?php if ($item['typeItem'] == 'W'): ?>
            <div>Calibre: <?php echo $item['typeCalibre']; ?></div>
            <div>Efficacité: <?php echo $item['efficacite']; ?></div>
        <?php endif; ?>
        <?php if ($item['typeItem'] == 'M'): ?>
            <div>Effet: <?php echo $item['effet']; ?></div>
            <div>Effet secondaire: <?php echo $item['effetSecondaire']; ?></div>
            <div>Durée: <?php echo $item['duree']; ?></div>
        <?php elseif ($item['typeItem'] == 'N'): ?>
            <div>Effet: <?php echo $item['effetNourriture']; ?></div>
            <div>Nombre de calories: <?php echo $item['nbCalories']; ?></div>
            <div>Composant Nutritif: <?php echo $item['composantNutritif']; ?></div>
            <div>Composant Mineral: <?php echo $item['composantMineral']; ?></div>
        <?php endif; ?>
        
        <div class="boutons-container">
            <form action="/detailsItems" method="post">
                <input type="hidden" name="item_id" value="<?php echo $item['idItems']; ?>">
                <button type="submit" class="boutonAcheter" style="margin-bottom: 10px;">Acheter</button>
            </form>
            <a href="/magasin" class="bouton">Retour</a>
        </div>
    </main>
    <!-- <?php if ($popUp): ?>
        <script>
            alertShow();
        </script>
    <?php endif; ?> -->
