<?php
require 'partials/head.php';
require 'views/partials/header.php';
?>
<script src="/public/javascript/buttons.js"></script>
<div class="search">
   <h1>Magasin</h1>
   <form method="POST">
      <label for="searchBar">Recherche :</label>
      <input type="text" name="searchBar" id="searchBar"
         value="<?= isset($_POST['searchBar']) ? htmlspecialchars($_POST['searchBar']) : '' ?>">
      <label for="A">Armure</label>
      <input type="checkbox" name="A" id="A" <?= isset($_POST['A']) ? 'checked' : '' ?>>
      <label for="W">Arme</label>
      <input type="checkbox" name="W" id="W" <?= isset($_POST['W']) ? 'checked' : '' ?>>
      <label for="M">Médicament</label>
      <input type="checkbox" name="M" id="M" <?= isset($_POST['M']) ? 'checked' : '' ?>>
      <label for="N">Nourriture</label>
      <input type="checkbox" name="N" id="N" <?= isset($_POST['N']) ? 'checked' : '' ?>>
      <label for="B">Munition</label>
      <input type="checkbox" name="B" id="B" <?= isset($_POST['B']) ? 'checked' : '' ?>>
      <input type="submit" name="search" id="search" class="button">
   </form>
</div>
<main class="inventaire">
   <div class="scroll-zone">
      <div class="inventaire-container">
         <?php if (!empty($magasin)) { ?>
            <?php foreach ($magasin as $item) { ?>
               <div class="item-container">
               <form method="POST">
                     <input type="hidden" name="details" value="<?= htmlspecialchars($item['idItems']) ?>">
                     <button type="submit" class="bouton-detail-photo" value="Details">
                  <div><?= htmlspecialchars($item['nomItem']) ?><br></div>
                  <div><img src="<?= htmlspecialchars($item['photo']) ?>" alt="Image" height="140"><br></div>
                  <div>Poids : <?= htmlspecialchars($item['poids']) ?> lbs<br></div>
                  <?php
                  if ($item['typeItem'] == 'A')
                     echo "<div>Type d'item : Armure<br></div>";
                  if ($item['typeItem'] == 'W')
                     echo "<div>Type d'item : Arme<br></div>";
                  if ($item['typeItem'] == 'M'){
                     echo "<div>Type d'item : Médicament<br></div>";
                     echo "<div>Effet: " . $item['effet'] . "</div>";
                  }
                  if ($item['typeItem'] == 'N'){
                     echo "<div>Type d'item : Nourriture<br></div>";
                     echo "<div>Effet: " . $item['effet'] . "</div>";
                  }
                  if ($item['typeItem'] == 'B')
                     echo "<div>Type d'item : Munitions<br></div>";
                  ?>
                  <div>Utilité : <?= htmlspecialchars($item['utilite']) ?><br></div>
                  <div>Quantité disponible : <?= htmlspecialchars($item['quantiteItem']) ?></div>
                  <div>Prix : <?php echo $item['prix']; ?></div>
                  </button>
               </form>              
               <div class="bouton-cote">
                  <form action="/detailsItems" method="post">
                     <input type="hidden" name="item_id" value="<?php echo $item['idItems']; ?>">
                     <?php if($item['quantiteItem'] > 0) { ?>
                        <button type="submit" class="bouton">Ajouter au panier</button>
                        <?php } else { ?>
                        <div> Non disponible</div>
                        <?php } ?>
                  </form>
               </div>
               </div>
            <?php } ?>
         <?php } else { ?>
         </div>
         <div class="aucun-item">
            <div>Aucun item trouvé</div>
         </div>
      <?php } ?>
   </div>
   </div>
</main>
<?php require 'partials/footer.php'; ?>