DELIMITER $$

CREATE PROCEDURE Connexion(IN S_alias VARCHAR(50))
BEGIN
    
    SELECT id, nomJoueur, prenomJoueur, alias, mPasse, montant, dexterite, pvJoueur, PoidsMaximal
    FROM Joueurs 
    WHERE alias = S_alias
    LIMIT 1;
END $$

DELIMITER ;
///////////////////////////////////////////////////Vue de l''inventaire//////////////////////////////////////////////////
Create View VInventaire As Select
Items.nomItem, Items.photo, Items.poids, 
Items.typeItem, Items.utilite, SacADos.idJoueurs,
SacADos.quantite
from Items inner join SacADos on
Items.idItems = SacADos.idItems;

Select * from VInventaire;
////////////////////////////////////////////////////Vue du Panier////////////////////////////////////////////////////////
Create View VPanier As Select
Items.nomItem, Items.photo, Items.poids, 
Items.prix, Panier.idJoueurs, Panier.quantiteItem
from Items inner join Panier on
Items.idItems = Panier.idItems;

Select * from VPanier;

