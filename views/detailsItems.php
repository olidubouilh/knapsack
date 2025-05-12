<?php
require 'partials/head.php';
require 'partials/header.php';
require 'partials/footer.php';
?>
    <div id="popupNotification" class="popupNotification">Article ajouté!</div>
    <main>
    <table>
        <h1><?php echo $item['nomItem']; ?></h1>
    <tr>
    <td style="width: 50%">
        <img style="padding-left: 15px; max-width: 600px; max-height: 400px;" src="<?php echo $item['photo']; ?>" alt="">
    </td>
    <td>
    <div><?php echo $item['description']; ?></div>
    <br>
        <div>Utilité: <?php echo $item['utilite']; ?></div>
        <div>Prix : <?php echo $item['prix']; ?> Caps</div>
        <div>Quantite Disponible: <?php echo $item['quantiteItem']; ?></div>
        <div>Poid : <?php echo $item['poids']; ?></div>
        
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
    </tr>
    </td>
    <td>
    <?php
        $totalStars = 0;
        $count = count($itemComm);
        foreach ($itemComm as $eval) {
            $totalStars += $eval['nbEtoiles'];
        }
        $average = $count > 0 ? $totalStars / $count : 0;
        $percentage = ($average / 5) * 100;
    ?>
    <div style="margin-bottom: 10px;">
        <strong>Moyenne des étoiles : <?= round($average, 1) ?>/5</strong>
        <div style="background-color: #eee; border-radius: 5px; width: 100%; height: 10px; margin: 5px 0;">
            <div style="background-color: gold; height: 100%; border-radius: 5px; width: <?= $percentage ?>%;"></div>
        </div>
    </div>
    <?php if (empty($itemComm) || !is_array($itemComm)): ?>
        <div>Aucune évaluation pour cet article.</div>
    <?php else: ?>
        <?php
            $starCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
            $total = count($itemComm);
            foreach ($itemComm as $eval) {
                $nb = (int)$eval['nbEtoiles'];
                if ($nb >= 1 && $nb <= 5) {
                    $starCounts[$nb]++;
                }
            }
        ?>
        <div style="margin-bottom: 15px;">
            <strong>Répartition des évaluations :</strong>
            <?php foreach ($starCounts as $stars => $count): 
                $percent = $total > 0 ? round(($count / $total) * 100) : 0;
            ?>
                <div style="display: flex; align-items: center; margin: 4px 0;">
                    <div style="width: 40px;"><?= $stars ?>★</div>
                    <div style="flex: 1; background: #eee; height: 10px; margin: 0 8px; border-radius: 5px;">
                        <div style="width: <?= $percent ?>%; background: gold; height: 100%; border-radius: 5px;"></div>
                    </div>
                    <div style="width: 40px;"><?= $percent ?>%</div>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="max-height: 150px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; border-radius: 5px;">
            <?php foreach ($itemComm as $eval): ?>
                <div style="margin-bottom: 1em;">
                    <strong><?= $eval['nbEtoiles'] ?>★</strong> – <?= htmlspecialchars($eval['commentaire']) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</td>
    </table>
    </main>
    <!-- <?php if ($popUp): ?>
        <script>
            alertShow();
        </script>
    <?php endif; ?> -->
