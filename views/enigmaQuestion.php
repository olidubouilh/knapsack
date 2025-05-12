<?php
require 'partials/head.php';
require 'views/partials/header.php';
?>
<script src="/public/javascript/buttons.js"></script>
<script src="/public/javascript/enigma.js"></script>
<main>
<h1 style="text-align: center;">Enigma</h1>
<div class="enigma-container">
    <form method="POST" class="enigma-form">
    <p><strong><?= htmlspecialchars($enonce) ?></strong></p>
        <input type="hidden" name="idQuestion" value="<?= htmlspecialchars($idQuestion) ?>">
        <input type="hidden" name="difficulte" value="<?= htmlspecialchars($difficulte) ?>">
        <?php foreach($reponses as $index => $reponse): ?>
            <input type="radio" name="reponse_id" id="reponse<?= $index + 1?>" value="<?= htmlspecialchars($reponse['laReponse'])?>">
            <label name="reponse_id"for="reponse<?= $index + 1?>"><?= htmlspecialchars(string: $reponse['laReponse']) ?></label><br>
        <?php endforeach; ?>
        <input type="hidden"  id="reponse_id">
        <button type="submit">Confirmer</button>
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