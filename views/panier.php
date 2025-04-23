<?php
require 'partials/head.php';
require 'views/partials/header.php';

$totalPrix = 0;
?>
<script>
    document.querySelectorAll("form").forEach((form, index) => {
        console.log(`Formulaire #${index + 1}`, form);
    });
</script>
<script src="/public/javascript/buttons.js"></script>
<script src="/public/javascript/alert.js"></script>

<?php if ($popUp2 === "confirmationDex") : ?>
<script>
    window.quantitesEnAttente = <?= json_encode($quantitesEnAttente) ?>;
    window.afficherConfirmationDex = true;
</script>
<?php else: ?>
<script>
    window.afficherConfirmationDex = false;
</script>
<?php endif; ?>

<main>
<?php if (!empty($popUp)): ?>
    <div class="popupNotification" id="popupNotification"><?= htmlspecialchars($popUp) ?></div>
    <script>
        alertShow();
    </script>
<?php endif; ?>
    <h1>Panier</h1>
    <form method="post">
    <div class="panier-core">
        <?php if($panier != null) : ?>
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
                                <form method="post">
                                    <button type="submit" class="boutonSupprimer" name="supprimer" value="<?= $idItem ?>">Supprimer</button>
                                </form>
                                
                            </div>
                            <input type="hidden" name="prixTotal" id="prixTotalInput" value="0">
                        </div>
                    <?php } ?>

                </div>
            <?php endif; ?>
        </div>

        <div>
            <h1 id="totalPrix"></h1>
            <button class="button" type="submit">Payer</button>
        </div>
    </div>
    </form>
</main>
<script src="/public/javascript/confirmationPanier.js"></script>
<?php require 'partials/footer.php'; ?>