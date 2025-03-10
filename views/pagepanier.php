<?php 
    require 'partials/head.php';
?>
<body>
    
    <main>
        <?php require 'views/partials/header.php' ?>
        <!-- Section contenant tous les items du panier -->
        <section class="panier">
            <section class="item">
                <h1>Nom item</h1>
                <img src="item.png" alt="Image Item">
                <h5>Prix : $$$</h5>
                <h5>Poids : 111</h5>
                <h5>Type: null</h5>
                <div>
                    <h5 style="display: inline-block;">Quantité: 1</h5>
                    <a href="#" class="boutonquanti">+</a>
                    <a href="#" class="boutonquanti">-</a>
                </div>
                <div class="boutons-container">
                    <a href="#" class="bouton">Supprimer</a>
                </div>
            </section>
            <section class="item">
                <h1>Nom item</h1>
                <img src="item.png" alt="Image Item">
                <h5>Prix : $$$</h5>
                <h5>Poids : 111</h5>
                <h5>Type: null</h5>
                <div>
                    <h5 style="display: inline-block;">Quantité: 1</h5>
                    <a href="#" class="boutonquanti">+</a>
                    <a href="#" class="boutonquanti">-</a>
                </div>
                <div class="boutons-container">
                    <a href="#" class="bouton">Supprimer</a>
                </div>
            </section>
            <section class="item">
                <h1>Nom item</h1>
                <img src="item.png" alt="Image Item">
                <h5>Prix : $$$</h5>
                <h5>Poids : 111</h5>
                <h5>Type: null</h5>
                <div>
                    <h5 style="display: inline-block;">Quantité: 1</h5>
                    <a href="#" class="boutonquanti">+</a>
                    <a href="#" class="boutonquanti">-</a>
                </div>
                <div class="boutons-container">
                    <a href="#" class="bouton">Supprimer</a>
                </div>
            </section>
            
            
        </section>
    
        
        <section class="confirmation">
            <h1>Prix total: $$$</h1>
            <div class="boutons-container">
                <a href="#" class="bouton">Acheter</a>
                <a href="#" class="bouton">Annuler</a>
            </div>  
        </section>
    </main>
    
    
    
    
</body>
</html>