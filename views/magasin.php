<?php

require 'partials/head.php';
require 'views/partials/header.php';
?>   
<main class="inventaire">    
<body><form method="POST"></form>
    
<h1>Magasin</h1>
<div class="inventaire-container">

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
           <div>Quantite dans le sac : <?= htmlspecialchars($item['quantiteItem']) ?></div>

           <div><a type="submit" class="btn btn-primary" href="/detailsItems?id=<?php echo $item['idItems']; ?>" value="$item['idItem']"name="details" id="details">Details</a></div>
           <form action="/detailsItems" method="post">
                <input type="hidden" name="item_id" value="<?php echo $item['idItems']; ?>">
                <button type="submit" class="bouton">Acheter</button>
            </form>
           
       </div>
   <?php } ?>
   </form>
</div>

</body>
</main>
<?php require 'partials/footer.php'; ?>

