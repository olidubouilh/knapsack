<?php
require 'partials/head.php';
require 'views/partials/header.php';
?>
<main>
<h1 style="text-align: center;">Enigma</h1>
<div class="enigma-container">
    <div class="enigma-text">
        <p>Bienvenue dans le jeu de l'énigme !</p>
        <p>Pour gagner, vous devez résoudre une énigme selon une
        difficulté que vous avez choisi au paravant</p>
        <p>Si vous répondez correctement à une question facile 
        vous recevrez 50 caps, Pour une question Moyenne 100
        caps et une difficile 200 caps</p>
        <p>Si vous répondez correctement à 3 questions
        aléatoires ou difficiles vous recevrez 1000 caps</p>
    </div>
    <form action="/enigmaQuestion" method="POST">
        <div>Niveau de difficulté:</div>
        <input type="radio" name="difficulte" value="facile"><label style="color: green"> Facile</label> <br>
        <input type="radio" name="difficulte" value="moyen"><label style="color: yellow"> Moyen</label><br>
        <input type="radio" name="difficulte" value="difficile"><label style="color: red"> Difficile</label><br>
        <input type="radio" name="difficulte" value="aléatoire"><label style="color: blue"> Aléatoire (la difficulté de la question sera facile, moyenne ou difficile) </label><br>
        <input type="hidden" name="difficulte_id" onclick="setHiddenValue()" id="difficulte_id">
        <button type="submit">Confirmer</button>
    </form>
    <div class="enigma-stats">
        <p>Statistiques :</p>
        <p>Nombre de bonnes réponses : <?= htmlspecialchars(string: $nbBonnesReponses) ?></p>
        <p>Nombre de mauvaises réponses : <?= htmlspecialchars($nbMauvaisesReponses) ?></p>
    </div>
    <?php if (isset($errors)): ?>
        <div class="error-message"><?= htmlspecialchars($errors) ?></div>
    <?php endif; ?>
    <?php if (isset($popUp)): ?>
        <div class="popup-message"><?= htmlspecialchars($popUp) ?></div>
    <?php endif; ?>
</div>