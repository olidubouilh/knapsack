<?php

require 'partials/head.php';
require 'views/partials/header.php';
?>   
<script src="/public/javascript/alert.js"></script>
<main class="funnel-sans-body">
<div id="popupNotification" class="popupNotification">
            Compte créé! Veuillez vous connecter</div>
    <h1>Connexion</h1>
    
    <form method="POST">
                
        <div class="mb-3">
            <label for="alias" class="form-label">Alias</label>
            <input type="text" class="form-control" id="alias" name="alias" value="<?= htmlspecialchars($alias ?? '') ?>">
            
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <span class="help-inline" style="color: red;"><?= $errors ?? '' ?></span>
        </div>
        
        <div class="bouton-group">
            <button class="button" type="submit">Connexion</button>
            <a class="button" href="/inscription">Inscription</a>
        </div>   
        
    </form>
</main>
<?php if ($popUp): ?>
    <script>
        alertShow();
    </script>
<?php endif; ?>
<?php require 'partials/footer.php'; ?> 

