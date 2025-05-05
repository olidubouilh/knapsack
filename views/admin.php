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
    <br>
    <div>Tests Unitaires</div>
    <div>1: Les pv ne peuvent pas être négatifs après une mauvaise réponse</div>
    <div>2: Les pv descendent en fonction de la difficulté en cas de mauvaise réponse</div>
    <div>3: Affichage d'enigma adaptatif jusqu'à la largeur cellulaire</div>
    <div>4: La quantité d'un item dans le panier ne peut pas être plus petit qu'1</div>
    <div>5: La quantité disponible dans le magasin se met à jour après un achat confirmé</div>
    <div>6: Le montant de caps d'un joueur est +petit que le coût de son panier</div>
    <div>7: La déconnexion retire l'accès au données reliées au joueur</div>
    <div>8: Accéder à enigma sans être connecté</div>
    <div>9: Accéder à panier sans être connecté</div>
    <div>10: Accéder à inventaire sans être connecté</div>
    <div>11: La dextérité remonte graduellement en vendant, mangeant ou jettant des items</div>
    <div>12: Accéder à la page admin sans en être un</div>
    <div>13: Ajouter des items au panier modifie la valeur poids total</div>
    <div>14: Payer le panier quand panier+inventaire plus lourd que 100 lbs</div>
    <div>15: Ajouter des items au panier modifie la valeur de coût total</div>
    <div>16: Le pourcentage de chaque niveau d'étoiles évalué est affiché</div>
    <div>17: La moyenne d'évaluation pour toutes les évals de l'item est correcte</div>
    <div>18: Si l'item n'a pas d'évaluation 'Aucune évaluation pour cet article' est affiché </div>
    <div>19: Les évaluations et commentaires s'affichent selon l'item sélectionné</div>
    <div>20: Ne peut pas acheter un item dont la quantité est = 0</div>

</main>

<?php
require 'views/partials/footer.php';
?>