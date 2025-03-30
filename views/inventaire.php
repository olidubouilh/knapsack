<?php
require 'partials/head.php';
require 'views/partials/header.php';
?>

<!-- Lien vers le CSS -->
<link rel="stylesheet" href="/public/css/inventaire.css">

<main class="inventaire">    
    <h1>Inventaire</h1>

    <div class="scroll-zone">
        <div class="inventaire-container">
            <?php foreach ($inventaire as $item) { ?>
                <div class="item-container">
                    <div><?= htmlspecialchars($item['nomItem']) ?><br></div>
                    <div><img src="<?= htmlspecialchars($item['photo']) ?>" alt="Image" height="140"><br></div>
                    <div>Poids : <?= htmlspecialchars($item['poids']) ?> lbs<br></div>
                    <?php
                    if ($item['typeItem'] == 'A') echo "<div>Type d'item : Armure<br></div>";
                    if ($item['typeItem'] == 'W') echo "<div>Type d'item : Arme<br></div>";
                    if ($item['typeItem'] == 'M') echo "<div>Type d'item : Médicament<br></div>";
                    if ($item['typeItem'] == 'N') echo "<div>Type d'item : Nourriture<br></div>";
                    if ($item['typeItem'] == 'B') echo "<div>Type d'item : Munitions<br></div>";
                    ?>
                    <div>Utilité : <?= htmlspecialchars($item['utilite']) ?><br></div>
                    <div>Quantité dans le sac : <?= htmlspecialchars($item['quantite']) ?></div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<?php require 'partials/footer.php'; ?>
