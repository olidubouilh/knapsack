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

    <div class="popupNotification" id="popupNotification"><?= $message ?></div>

    <h1>Panier</h1>
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
                                    <span class="quantite" id="<?= $idItem ?>"
                                          data-id="<?= $idItem ?>"
                                          data-prix="<?= $item->getPrix() ?>"
                                          data-poids="<?= $item->getPoids() ?>"
                                          value="<?= $quantite[$idItem] ?>">
                                        <?= htmlspecialchars($quantite[$idItem]) ?> 
                                    </span>
                                    <button type="button" class="boutonquanti" onclick="increaseQuantity(<?= $idItem ?>, <?= $item->getQuantiteItem() ?>)">+</button>
                                </div>

                                <!-- FORMULAIRE SUPPRIMER -->
                                <form method="post" action="/panier" style="display:inline;">
                                    <input type="hidden" name="supprimer" value="<?= $idItem ?>">
                                    <button type="submit" class="boutonSupprimer">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- FORMULAIRE PAYER (en dehors de la boucle) -->
        <form method="post" action="/panier">
            <?php if ($panier != null) : ?>
                <?php foreach ($panier as $idItem => $item): ?>
                    <input type="hidden" name="quantites[<?= $idItem ?>]" id="input-<?= $idItem ?>" value="<?= $quantite[$idItem] ?>">
                <?php endforeach; ?>
            <?php endif; ?>
            <div>
                <h1 id="totalPrix"></h1>
                <h2 id="poidsTotal"></h2>
                <button class="button" type="submit" name="payer" value="1">Payer</button>
            </div>
        </form>
    </div>
</main>

<script src="/public/javascript/buttons.js"></script>
<script src="/public/javascript/alert.js"></script>
<script src="/public/javascript/confirmationPanier.js"></script>
<?php if ($popUp): ?>
    <script>
        alertShow();
    </script>
<?php endif; ?>
<?php require 'partials/footer.php'; ?>
