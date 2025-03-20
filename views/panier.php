<?php
require 'partials/head.php';
require 'views/partials/header.php'
?>
 <h1 style="text-align: center;">Panier</h1>
<main class="panier-core">
   

    <table>
        <th style="width: 950px">

            <div class="panier-items">
                <?php foreach ($panier as $item) { ?>
                    <div class="item-slot">

                        <div><?= htmlspecialchars($item['nomItem']) ?><br></div>

                        <div><img src="<?= htmlspecialchars($item['photo']) ?>" alt="Image" height="100"><br></div>

                        <div>Poids : <?= htmlspecialchars($item['poids']) ?> lbs<br></div>

                        <div>Prix : <?= htmlspecialchars($item['prix']) ?> Caps<br></div>
                        <div>

                            <div style="display: inline-block;">Quantité <br>
                                <a href="#" class="boutonquanti">-</a>
                                <?= htmlspecialchars($item['quantiteItem']) ?>
                                <a href="#" class="boutonquanti">+</a>
                            </div>
                        </div>

                    </div>
                <?php } ?>
            </div>
        </th>
        <th>
            <div class="confirmation">
                <h1>Prix total: Caps</h1>
                <div class="boutons-container">
                    <a href="#" class="bouton">Acheter</a>
                    <a href="#" class="bouton">Annuler</a>
                </div>
            </div>
        </th>
    </table>
</main>

<?php require 'partials/footer.php'; ?>