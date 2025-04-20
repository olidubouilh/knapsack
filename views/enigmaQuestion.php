<?php
require 'partials/head.php';
require 'views/partials/header.php';
?>
<script src="/public/javascript/buttons.js"></script>
<main>
<h1 style="text-align: center;">Enigma</h1>
<div class="enigma-container">
    <form method="POST" class="enigma-form">
    <p><strong><?= htmlspecialchars($enonce) ?></strong></p>
        <input type="hidden" name="idQuestion" value="<?= htmlspecialchars($idQuestion) ?>">
        <input type="hidden" name="difficulte" value="<?= htmlspecialchars($difficulte) ?>">
        <?php foreach($reponses as $index => $reponse): ?>
            <input type="radio" name="reponse" id="reponse<?= $index + 1?>" value="<?= htmlspecialchars($reponse['laReponse'])?>">
            <label for="reponse<?= $index + 1?>"><?= htmlspecialchars(string: $reponse['laReponse']) ?></label><br>
        <?php endforeach; ?>
        <input type="hidden" name="reponse_id" id="reponse_id">
        <button type="submit" value="Soumettre">Confirmer</button>
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
</main>
<!-- Ajouts très simple : 2025-04-07 par Raph -->  