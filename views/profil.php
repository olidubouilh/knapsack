<?php

require 'partials/head.php';
require 'views/partials/header.php';
?>   
<script src="/public/javascript/alert.js"></script>
<main class="funnel-sans-body">
<div id="popupNotification" class="popupNotification">
            Compte modifié</div>
    <h1>Information sur <?= htmlspecialchars($alias ?? '') ?> </h1>
    
    
        <div class="mb-3">
            <form action="post" class="alias">
                <label for="alias" class="form-label">Alias: <?=htmlspecialchars($alias ?? '') ?></label>
                <input type="text" class="form-control" id="alias" name="alias" value="<?= htmlspecialchars($alias ?? '') ?>">  
                <button type="submit" class="button" name="alias">Modifier</button>
            </form>
        </div>        
        
        <div class="mb-3">
            <form action="post">
                <div class="password">
                    <label for="oldPassword" class="form-label">Ancien mot de passe</label>
                    <input type="text" class="form-control" id="oldPassword" name="oldPassword">
                </div>
                <div class="password">
                    <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                    <input type="text" class="form-control" id="newPassword" name="newPassword">
                    <button type="submit" class="button" name="alias">Modifier</button>    
                </div>
                
            </form>
        </div>   
        <div class="mb-3">
            <span class="help-inline" style="color: red;"><?= $errors ?? '' ?></span>
        </div>
    
    
</main>
<?php if ($popUp): ?>
    <script>
        alertShow();
    </script>
<?php endif; ?>
<?php require 'partials/footer.php'; ?> 

