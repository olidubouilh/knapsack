<body>
    <header>
        <nav class="navbar">
            <div class="nav-left">
                <a href="/magasin"><img src="public/img/magasin.png" alt="Magasin"></a>
                <a href="/enigma"><img src="public/img/enigma.png" alt="Enigma"></a>
            </div>
            <div class="nav-center">
                <a href="/"><img src="public/img/logo.png" alt="Logo de Knapsack" class="logo"></a>
            </div>
            <div class="nav-right">
                <?php  if(isAdministrator()) {?>
                    <a href="/admin"><img src="public/img/adminHeader.jpg" alt="Admin"></a>
                <?php } ?>
                <a href="/panier"><img src="public/img/panier.png" alt="Panier"></a>
                <a href="/inventaire"><img src="public/img/school-bag.png" alt="Inventaire"></a>
                <a href="/connexion"><img src="public/img/connection.png" alt="Connexion"></a>
            </div>
        </nav>
        <?php if (isset($_SESSION['user'])): ?>
            <div class="stats">
                <div><?= $_SESSION['user']['alias'] ?? ''; ?></div>
                <div>Caps: <?= $_SESSION['user']['montant'] ?? '0'; ?></div>
                <div>Dex: <?= $_SESSION['user']['dexterite'] ?? '0'; ?></div>
                <div>Pv: <?= $_SESSION['user']['pvJoueur'] ?? '0'; ?></div>
                <div>Poids Maximal: <?= $_SESSION['user']['poidsMaximal'] ?? ''; ?> lbs</div>
                <div>Poids du sac: <?= $_SESSION['user']['poidsSac'] ?? '0'; ?> lbs</div>
            </div>
        <?php endif; ?>
    </header>