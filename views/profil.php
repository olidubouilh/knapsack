<?php

require 'partials/head.php';
require 'views/partials/header.php';
?>   
<script src="/public/javascript/alert.js"></script>
<main class="funnel-sans-body">
<div id="popupNotification" class="popupNotification">
            Compte modifié
</div>
    <h1>Information sur <?= htmlspecialchars($alias ?? '') ?></h1>
        <div class="mb-3">
            <form method="POST" class="alias">
                <label for="alias" class="form-label">Alias:</label>
                <input type="text" class="form-control" id="alias" name="alias" value="<?= htmlspecialchars($alias ?? '') ?>">  
                <button type="submit" class="button" >Modifier</button>
            </form>
        </div>        
        <button id="togglePasswordDiv" class="button" style="margin-left: 45%;">Modifier le mot de passe</button>
        <div class="mb-3">
            <div id="passwordDiv" style="display: none;">
                <form method="POST">
                    <div class="password">
                        <label for="oldPassword" class="form-label">Ancien mot de passe</label>
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword">
                    </div>
                    <div class="password">
                        <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                    </div>
                    <button type="submit" class="button" name="password" style="margin-left: 48%;">Modifier</button>    
                </form>
            </div>
        </div>   
        <div class="mb-3">
            <span class="help-inline" style="color: red;margin-left: 45%;"><?= $errors ?? '' ?></span>
        </div>
</main>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const toggleButton = document.getElementById('togglePasswordDiv');
    const passwordDiv = document.getElementById('passwordDiv');
    toggleButton.addEventListener('click', function() {
        if (passwordDiv.style.display === "none" || passwordDiv.style.display === "") {
            passwordDiv.style.display = "block";
            toggleButton.textContent = "Annuler";
            toggleButton.style.marginLeft = "48%";
        } else {
            passwordDiv.style.display = "none";
            toggleButton.textContent = "Modifier le mot de passe";
            toggleButton.style.marginLeft = "45%";
            document.getElementById('oldPassword').value = '';
            document.getElementById('newPassword').value = '';
        }
    });
});
</script>
<?php if ($popUp): ?>
    <script>
        alertShow();
    </script>
<?php endif; ?>
<?php require 'partials/footer.php'; ?> 