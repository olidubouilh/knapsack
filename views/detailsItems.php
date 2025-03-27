<?php
require 'partials/head.php';
require 'partials/header.php';
?>

<html>

<body>
    <div id="popupNotification" class="popupNotification">
        Article ajouté!</div>
    <main>

        <h1><?php echo $item['nomItem']; ?></h1>
        <img src="<?php echo $item['photo']; ?>" alt="">
        <br>
        <h3>Type Item: <?php echo $item['typeItem']; ?></h3>
        <h3>Utilité: <?php echo $item['utilite']; ?></h3>
        <h3>Description: </h3>
        <h4><?php echo $item['description']; ?></h4>

        <h3>Prix : <?php echo $item['prix']; ?></h3>
        <h3>Quantite Disponible: <?php echo $item['quantiteItem']; ?></h3>
        <h3>Poid : <?php echo $item['poids']; ?></h3>
        <h3>Utilité : <?php echo $item['utilite']; ?></h3>

        <?php if ($item['typeItem'] == 'A'): ?>
            <h3>Matière: <?php echo $item['matiere']; ?></h3>
            <h3>Taille: <?php echo $item['taille']; ?></h3>
        <?php endif; ?>
        <?php if ($item['typeItem'] == 'W'): ?>
            <h3>Calibre: <?php echo $item['typeCalibre']; ?></h3>
            <h3>Efficacité: <?php echo $item['efficacite']; ?></h3>
        <?php endif; ?>
        <?php if ($item['typeItem'] == 'M'): ?>
            <h3>Effet: <?php echo $item['effet']; ?></h3>
            <h3>Effet secondaire: <?php echo $item['effetSecondaire']; ?></h3>
            <h3>Durée: <?php echo $item['duree']; ?></h3>
        <?php elseif ($item['typeItem'] == 'N'): ?>
            <h3>Nombre de calories: <?php echo $item['nbCalories']; ?></h3>
            <h3>Composant Nutritif: <?php echo $item['composantNutritif']; ?></h3>
            <h3>Composant Mineral: <?php echo $item['composantMineral']; ?></h3>
        <?php endif; ?>

        <div class="boutons-container">
            <a href="/magasin" class="bouton">Retour</a>
            <form action="/detailsItems" method="post">
                <input type="hidden" name="item_id" value="<?php echo $item['idItems']; ?>">
                <button type="submit" class="bouton">Acheter</button>
            </form>
        </div>
    </main>
    <!-- <?php if ($popUp): ?>
        <script>
            alertShow();
        </script>
    <?php endif; ?> -->
</body>


</html>