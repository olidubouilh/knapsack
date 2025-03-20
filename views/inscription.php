<?php

require 'partials/head.php';
require 'views/partials/header.php';
?>   

<main class="funnel-sans-body">

    <h1>Inscription</h1>
    
    <form method="POST">
                
        <div class="mb-3">
            <label for="alias" class="form-label">Alias</label>
            <input maxlength="45" type="alias" class="form-control" id="alias" name="alias" value="<?= htmlspecialchars($alias ?? '') ?>">
            <span class="help-inline" style="color: red;"><?= $errors['alias'] ?? '' ?></span>
            
        </div>
        <div class="mb-3">
            <label for="nomJoueur" class="form-label">Nom</label>
            <input maxlength="20" type="nomJoueur" class="form-control" id="nomJoueur" name="nomJoueur" value="<?= htmlspecialchars($nomJoueur ?? '') ?>">
            <span class="help-inline" style="color: red;"><?= $errors['nomJoueur'] ?? '' ?></span>
            
        </div>
        <div class="mb-3">
            <label for="prenomJoueur" class="form-label">Prenom</label>
            <input maxlength="20"  type="prenomJoueur" class="form-control" id="prenomJoueur" name="prenomJoueur" value="<?= htmlspecialchars($prenomJoueur ?? '') ?>">
            <span class="help-inline" style="color: red;"><?= $errors['prenomJoueur'] ?? '' ?></span> 
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
            <span class="help-inline" style="color: red;"><?= $errors['password'] ?? '' ?></span>
        </div>
        <div class="mb-3">
                    <label for="repassword" class="form-label">Répétez le mot de passe</label>
                    <input type="password" class="form-control" id="repassword" name="repassword">
                    <span class="help-inline"style="color: red;"><?= $errors['repassword'] ?? '' ?></span>
        </div>
          
        <button type="submit" class="btn btn-primary">Inscription</button>
        <a class="btn btn-secondary" href="/">Annuler</a>
    </form>
</main>
>
<?php require 'partials/footer.php'; ?> 

