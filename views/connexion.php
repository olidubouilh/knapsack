<?php

require 'partials/head.php';

?>

<body>
    <?php require 'views/partials/header.php' ?>
    <main>
        <h1>Connexion</h1>
       
        <form method="POST">
                    
            <div class="mb-3">
                <label for="alias" class="form-label">Alias</label>
                <input type="alias" class="form-control" id="alias" name="alias" value="<?= htmlspecialchars($alias ?? '') ?>">
                
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3">
                <span class="help-inline" style="color: red;"><?= $errors ?? '' ?></span>
            </div>
            
                
            <button type="submit" class="btn btn-primary">Connexion</button>
            <a class="btn btn-secondary" href="/inscription">Inscription</a>
        </form>
    </main>
    
</body>
</html>

