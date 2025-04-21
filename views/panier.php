<?php
require 'partials/head.php';
require 'views/partials/header.php';

$totalPrix = 0;
?>
<script src="/public/javascript/buttons.js"></script>
<script src="/public/javascript/alert.js"></script>
<main>
    <div id="popupNotification" class="popupNotification">
        <?=$popUp?>
    </div>
    <h1>Panier</h1>
    <form method="post" action="/panier">
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
                                <button type="button" class="boutonquanti" onclick="decreaseQuantity(<?= $idItem ?>)">-</button>
                                <span class="quantite" id="<?= $idItem ?>" data-id="<?= $idItem ?>" data-prix="<?= $item->getPrix() ?>" value="<?= $quantite[$idItem] ?>">
                                    <?= htmlspecialchars($quantite[$idItem]) ?> 
                                </span>
                                <input type="hidden" name="quantites[<?= $idItem ?>]" id="input-<?= $idItem ?>" value="<?= $quantite[$idItem] ?>">
                                <button type="button" class="boutonquanti" onclick="increaseQuantity(<?= $idItem?>, <?= $item->getQuantiteItem() ?>)">+</button>
                            </div>
                            <button class="boutonSupprimer" onclick="supprimerItemPanier(<?= $idItem ?>, <?= $_SESSION['user']['id'] ?>)">Supprimer</button>
                        </div>
                        <input type="hidden" name="prixTotal" id="prixTotalInput" value="0">
                    </div>
                <?php } ?>

            </div>
        </div>

        <div>
            <h1 id="totalPrix"></h1>
            <button class="button" type="submit">Payer</button>
        </div>
    </div>
    </form>
</main>

<?php require 'partials/footer.php'; ?>