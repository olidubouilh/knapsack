<?php 
    require 'partials/head.php';
?>
<body>
    <?php require 'views/partials/header.php' ?>
    
    <div style="color:  rgb(255, 255, 25);">
        <h3>Caps: 450</h3>
    </div>
    <div class="filtre">
        
        <form action="recherche.php" method="post" >
            <span>Filtrer par :</span>
            <input type="checkbox" name="categorie" value="categorie1"> Armes</input>
            <input type="checkbox" name="categorie" value="categorie2"> Armures</input>
            <input type="checkbox" name="categorie" value="categorie3"> Medicaments</input>
            <input type="checkbox" name="categorie" value="categorie4"> Nourritures</input>
            <input type="checkbox" name="categorie" value="categorie5"> Ressources</input>
            <input type="checkbox" name="categorie" value="categorie6"> Munitions</input>
        </form>
    </div>
    <main>
        
        <section>
            <h1>Stimpack</h1>
            <img src="stimpack.png" alt="lol">
            <h5>Prix : 20 Caps</h5>
            <h5>Quantite disponible: 20</h5>
            <h5>Poid : 1 lbs</h5>
            <div class="boutons-container">
                <a href="#" class="bouton">Acheter</a>
                <a href="#" class="bouton">Détails</a>
            </div>
        </section>
        <section>
            <h1>Pistol</h1>
            <img src="pistol.png" alt="lol">
            <h5>Prix : 100 Caps</h5>
            <h5>Quantite disponible: 3</h5>
            <h5>Poid : 7 lbs</h5>
            <div class="boutons-container">
                <a href="#" class="bouton">Acheter</a>
                <a href="#" class="bouton">Détails</a>
            </div>
        </section>
        <section>
            <h1>Triple-barrel shotgun</h1>
            <img src="shotgun.png" alt="lol">
            <h5>Prix : 250 Caps</h5>
            <h5>Quantite: 1</h5>
            <h5>Poid : 15 lbs</h5>
            <div class="boutons-container">
                <a href="#" class="bouton">Acheter</a>
                <a href="#" class="bouton">Détails</a>
            </div>
        </section>
        <section>
            <h1>T-51 Armor</h1>
            <img src="armure.png" alt="lol">
            <h5>Prix : 600 Caps</h5>
            <h5>Quantite: 1</h5>
            <h5>Poid : 1</h5>
            <div class="boutons-container">
                <a href="#" class="bouton">Acheter</a>
                <a href="#" class="bouton">Détails</a>
            </div>
        </section>
        <section>
            <h1>Plasma Pistol</h1>
            <img src="plasmapistol.png" alt="lol">
            <h5>Prix : 1200 Caps</h5>
            <h5>Quantite Disponible: 1</h5>
            <h5>Poid : 10 lbs</h5>
            <div class="boutons-container">
                <a href="#" class="bouton">Acheter</a>
                <a href="#" class="bouton">Détails</a>
            </div>
        </section>
        <section>
            <h1>Carrot</h1>
            <img src="Carrot.png" alt="lol">
            <h5>Prix : 5 Caps</h5>
            <h5>Quantite Disponible: 53</h5>
            <h5>Poid : 1</h5>
            <div class="boutons-container">
                <a href="#" class="bouton">Acheter</a>
                <a href="#" class="bouton">Détails</a>
            </div>
        </section>
        
      
    </main>
    
</body>
</html>