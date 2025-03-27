<?php

require 'partials/head.php';
require 'views/partials/header.php';
?>   
<div class="search">
   <form method="POST">
      <label for="searchBar">Recherche :</label>
      <input type="text" name="searchBar" id="searchBar" value="<?= isset($_POST['searchBar']) ? htmlspecialchars($_POST['searchBar']) : '' ?>">
      <label for="A">Armure</label>
      <input type="checkbox" name="A" id="A" <?= isset($_POST['A']) ? 'checked' : '' ?>>
      <label for="W">Arme</label>
      <input type="checkbox" name="W" id="W" <?= isset($_POST['W']) ? 'checked' : '' ?>>
      <label for="M">Médicament</label>
      <input type="checkbox" name="M" id="M" <?= isset($_POST['M']) ? 'checked' : '' ?>>
      <label for="R">Nourriture</label>
      <input type="checkbox" name="N" id="N" <?= isset($_POST['N']) ? 'checked' : '' ?>>
      <label for="B">Munition</label>
      <input type="checkbox" name="B" id="B" <?= isset($_POST['B']) ? 'checked' : '' ?>>
      <input type="submit" name="search" id="search" class="button">
   </form>
</div>

<main class="inventaire">    

    
<h1>Magasin</h1>
<div class="inventaire-container">
   <?php if (!empty($magasin)) { ?>
      <?php foreach ($magasin as $item) { ?>
         <div class="item-container">
            <div><?= htmlspecialchars($item['nomItem']) ?><br></div>
            <div><img src="<?= htmlspecialchars($item['photo']) ?>" alt="Image" height="140"><br></div>
            <div>Poids : <?= htmlspecialchars($item['poids']) ?> lbs<br></div>
            <?php if($item['typeItem'] == 'A')
               echo "<div>Type d'item : Armure<br></div>";
            if($item['typeItem'] == 'W')
               echo "<div>Type d'item : Arme<br></div>";
            if($item['typeItem'] == 'M')
               echo "<div>Type d'item : Médicament<br></div>";
            if($item['typeItem'] == 'N')
               echo "<div>Type d'item : Nourriture<br></div>";
            if($item['typeItem'] == 'B')
               echo "<div>Type d'item : Munitions<br></div>";?>
            <div>Utilite : <?= htmlspecialchars($item['utilite']) ?><br></div>
            <div>Quantite disponible : <?= htmlspecialchars($item['quantiteItem']) ?></div>
            <form method="POST">
               <input type="submit" class="button" value="Details" ></input>
               <input type="hidden" name="details" value="<?= htmlspecialchars($item['idItems']) ?>">
            </form>
            
         </div>
      <?php } ?>
      <?php } else { ?>
         </div>
         <div class="aucun-item">
            <div>Aucun item trouvé</div>
         </div>
      
   <?php } ?>
   
</div>


</main>
<?php require 'partials/footer.php'; ?>

