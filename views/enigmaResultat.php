<?php
require 'partials/head.php';
require 'views/partials/header.php';
?>
<script src="/public/javascript/buttons.js"></script>
<main>
<h1 style="text-align: center;">Enigma Res</h1>
<div class="enigma-container">
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
</main>
<!-- Ajouts très simple : 2025-04-07 par Raph -->  