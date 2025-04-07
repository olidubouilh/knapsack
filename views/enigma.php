<?php
require 'partials/head.php';
require 'views/partials/header.php';
?>

<h1 style="text-align: center;">Enigma</h1>
<div class="enigma-container">
    <div class="enigma-text">
        <p>Bienvenue dans le jeu de l'énigme !</p>
        <p>Pour gagner, vous devez résoudre l'énigme suivante :</p>
        <p><strong><?= htmlspecialchars($enonce) ?></strong></p>
    </div>

    <form method="POST" class="enigma-form">
        <input type="hidden" name="idQuestion" value="<?= htmlspecialchars($idQuestion) ?>">
        <input type="text" name="reponse" placeholder="Votre réponse" required>
        <input type="submit" value="Soumettre">
    </form>

    <div class="enigma-stats">
        <p>Statistiques :</p>
        <p>Nombre de bonnes réponses : <?= htmlspecialchars($nbBonnesReponses) ?></p>
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