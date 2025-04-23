<?php
require 'partials/head.php';
require 'views/partials/header.php';
?>

<main style="background-color: brown;">
    <div>
        <h1 style="text-align: center;">Gestion administrateur</h1>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px;">
        <table style="width: 100%; border-collapse: collapse; margin: 0 auto;">
            <thead>
                <tr style="font-size: larger;">
                    <th style="border: 1px; padding: 8px;">ID</th>
                    <th style="border: 1px; padding: 8px;">Alias</th>
                    <th style="border: 1px; padding: 8px;">Prénom</th>
                    <th style="border: 1px; padding: 8px;">Nom</th>
                    <th style="border: 1px; padding: 8px;">Caps</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($joueurs as $player): ?>
                    <tr
                        style="text-align: center; font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; font-size: smaller;">
                        <td style="border: 1px; padding: 8px;"><?php echo ($player['idJoueurs']); ?></td>
                        <td style="border: 1px; padding: 8px;"><?php echo ($player['alias']); ?></td>
                        <td style="border: 1px; padding: 8px;"><?php echo ($player['prenomJoueur']); ?></td>
                        <td style="border: 1px; padding: 8px;"><?php echo ($player['nomJoueur']); ?></td>
                        <td style="border: 1px; padding: 8px;"><?php echo ($player['montant'] . " caps"); ?></td>
                        <td>
                            <?php if ($player['capsDonner'] < 3): ?>
                                <form action="/admin" method="post">
                                    <input type="hidden" name="idJoueurs" value="<?php echo ($player['idJoueurs']); ?>">
                                    <button type="submit" class="button" style="margin-bottom: 10px;">Donner caps</button>
                                </form>
                            <?php else: ?>
                                <button disabled class="button" style="background-color: #cccccc; color: #666666; padding: 5px 10px; border: none; border-radius: 5px; cursor: not-allowed; margin-bottom: 10px;" >Maximum atteint</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
require 'views/partials/footer.php';
?>