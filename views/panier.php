<?php
require 'partials/head.php';
require 'views/partials/header.php';

$totalPrix = 0;
?>
<script src="/public/javascript/buttons.js"></script>

<main>
    <h1>Panier</h1>
    <div class="panier-core">

        <div class="panier-colonne-gauche">
            <div class="panier-items">
                <?php foreach ($panier as $idItem => $item) { ?>
                    <div class="item-slot">
                        <div><?= htmlspecialchars($item->getNomItem()) ?><br></div>
                        <div><img src="<?= htmlspecialchars($item->getPhoto()) ?>" alt="Image" height="100"><br></div>
                        <div>Poids : <?= htmlspecialchars($item->getPoids()) ?> lbs<br></div>
                        <div>Prix : <?= htmlspecialchars($item->getPrix()) ?> Caps<br></div>
                        <div>
                            <div style="position: relative;">Quantité <br>
                                <button class="boutonquanti" onclick="decreaseQuantity(<?= $idItem ?>)">-</button>
                                <span class="quantite" id="<?= $idItem ?>" data-id="<?= $idItem ?>" data-prix="<?= $item->getPrix() ?>">
                                    <?= htmlspecialchars($quantite[$idItem]) ?>
                                </span>
                                <button class="boutonquanti" onclick="increaseQuantity(<?= $idItem, $item->getQuantiteItem() ?>)">+</button>
                            </div>
                            <button class="boutonSupprimer" onclick="supprimerItemPanier(<?= $idItem ?>, <?= $_SESSION['user']['id'] ?>)">Supprimer</button>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>

        <div class="confirmation">
            <h1 id="totalPrix"></h1>
            <div class="boutons-container">
                <a href="#" class="bouton">Payer</a>
            </div>
        </div>
    </div>
</main>

<?php require 'partials/footer.php'; ?>