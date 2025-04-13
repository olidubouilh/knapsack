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
<!--Le texte sera peut être à modifier, me souvient pu si la prof voulait
-1000 caps total incluant les 3 questions ex: 1 facile: 50 caps + 2 difficile: 400 caps donc bonus 550 caps
-si 3 questions difficiles sont répondus d'affilé (600 caps) + bonus 400 total 1000
-1000 caps de plus que les 3 questions répondues 
-est-ce qu'il peut y avoir des questions faciles et moyennes entre les difficiles sans perdre le bonus?
-->
        <p>Si vous répondez correctement à 3 questions
        aléatoires ou difficiles vous recevrez 1000 caps</p>
    </div>
    <div>Niveau de difficulté:</div>
    <input type="radio" name="difficulte" value="facile"> Facile <br>
    <input type="radio" name="difficulte" value="moyen"> Moyen<br>
    <input type="radio" name="difficulte" value="difficile"> Difficile<br>
    <input type="radio" name="difficulte" value="aléatoire"> Aléatoire (la difficulté de la question sera facile, moyenne ou difficile)<br>



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

<!-- Ajouts très simple : 2025-04-07 par Raph -->  

<!--Web2 voir documentation Time spawn -->
