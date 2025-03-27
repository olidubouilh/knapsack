<?php
require 'partials/head.php';
require 'views/partials/header.php';

$totalPrix = 0;
?>
<script src="/public/javascript/buttons.js"></script>
 <h1 style="text-align: center;">Panier</h1>
<main class="panier-core">
    <table>
    <tr>
        <th style="width: 950px">

            <div class="panier-items">
                <?php foreach ($panier as $item) {?>
                    <div class="item-slot">

                            <div><?= htmlspecialchars($item['nomItem']) ?><br></div>

                            <div><img src="<?= htmlspecialchars($item['photo']) ?>" alt="Image" height="100"><br></div>

                            <div>Poids : <?= htmlspecialchars($item['poids']) ?> lbs<br></div>

                            <div>Prix : <?= htmlspecialchars($item['prix']) ?> Caps<br></div>
                            <div>

                            <div style="position: relative;">Quantité <br>
                                    <button href="#" class="boutonquanti" onclick="decreaseQuantity(<?= $item['idItems'] ?>)">-</button>
                                    <span class="quantite" id="<?= $item['idItems'] ?>" data-id="<?= $item['idItems'] ?>"
                                        data-prix="<?= $item['prix'] ?>">
                                        <?= htmlspecialchars($item['quantiteItem']) ?>
                                    </span>
                                    <button href="#" class="boutonquanti" onclick="increaseQuantity(<?= $item['idItems'] ?>, <?= $item['quantiteItemMax'] ?>)">+</button>
                                </div>
                                <button class="boutonSupprimer" onclick="supprimerItemPanier(<?= $item['idItems'] ?>, <?= $_SESSION['user']['id'] ?>)">Supprimer</button>
                            </div>
                            </div>
                    <?php } ?>
            
        </th>
        
        <th>
            <div class="confirmation">
                <h1 id="totalPrix"></h1>
                <div class="boutons-container">
                    <a href="#" class="bouton">Payer</a>

                </div>
            </div>
        </th>

    </tr>
    </table>
</main>
<?php require 'partials/footer.php'; ?>
