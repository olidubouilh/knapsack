-- Connexion
DELIMITER $$
CREATE PROCEDURE Connexion(IN S_alias VARCHAR(50))
BEGIN
    
    SELECT id, nomJoueur, prenomJoueur, alias, mPasse, montant, dexterite, pvJoueur, PoidsMaximal
    FROM Joueurs 
    WHERE alias = S_alias
    LIMIT 1;
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE verifierAlias(IN S_alias VARCHAR(40))
BEGIN
    SELECT * FROM Joueurs WHERE alias = S_alias;
END $$

DELIMITER ;

-- Ajouter un joueur
DELIMITER $$
CREATE PROCEDURE AjouterJoueur(IN S_alias VARCHAR(45), IN S_nomJoueur VARCHAR(45), IN S_prenomJoueur VARCHAR(45), IN S_mPasse varchar(50))
BEGIN
	DECLARE mPasseHache VARBINARY(128); 
    SET mPasseHache := sha2(S_mPasse, 512);
    BEGIN
		INSERT INTO Joueurs (alias, nomJoueur, prenomJoueur, mPasse) VALUES(S_alias, S_nomJoueur, S_prenomJoueur, mPasseHache);
    END;
END $$
DELIMITER ;


-- Ajouter un item au panier(À partir du magasin)
DELIMITER //
CREATE PROCEDURE AjouterItemPanier(S_idItem INT, S_idJoueurs INT)
BEGIN	
    DECLARE qtyItemMagasin INT;
    DECLARE qtyItemPanier INT DEFAULT 0;
    
    -- Check item exists
    IF NOT EXISTS(SELECT nomItem FROM Items WHERE idItems = S_idItem) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Item does not exist";
    END IF;
    
    -- Get stock quantities
    SELECT quantiteItem INTO qtyItemMagasin FROM Items WHERE idItems = S_idItem;
    SELECT COALESCE(quantiteItem, 0) INTO qtyItemPanier 
    FROM Panier WHERE idItems = S_idItem AND idJoueurs = S_idJoueurs;
    
    -- Validate conditions
    IF NOT EXISTS(SELECT alias FROM Joueurs WHERE idJoueurs = S_idJoueurs) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Player does not exist";
    ELSEIF qtyItemMagasin = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "No stock available";
    ELSEIF qtyItemPanier >= qtyItemMagasin THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Max quantity reached";
    ELSE
        -- Add or update cart
        IF qtyItemPanier = 0 THEN
            INSERT INTO Panier(idItems, idJoueurs, quantiteItem) VALUES(S_idItem, S_idJoueurs, 1);
        ELSE
            UPDATE Panier SET quantiteItem = quantiteItem + 1 
            WHERE idItems = S_idItem AND idJoueurs = S_idJoueurs;
        END IF;
    END IF;
END //
DELIMITER ;

-- Modifier le mot de passe
DELIMITER $$
CREATE PROCEDURE ModifierMotPasse(IN S_alias VARCHAR(45), IN S_ancienMpasse VARCHAR(50), IN S_nouveauMpasse VARCHAR(50))
BEGIN
		IF(SELECT ValiderIdentite(S_alias, TRIM(S_ancienMpasse)) = 0)
			THEN CALL log("Erreur: l\'ancien mot de passe est incorrect.");
		ELSEIF(TRIM(S_ancienMpasse) = TRIM(S_nouveauMpasse))
			THEN CALL log("Erreur, les mot de passes sont identiques");
		ELSE
			BEGIN
				UPDATE Joueurs SET mPasse = sha2(S_nouveauMpasse, 512) WHERE alias = S_alias;
            END;
        END IF;
END $$
DELIMITER ;
-- View Panier
CREATE OR REPLACE VIEW VPanier AS
SELECT i.idItems, i.nomItem, i.photo, i.poids, i.quantiteItem AS quantiteItemMax, i.prix, p.idJoueurs, p.quantiteItem
FROM Panier p
LEFT JOIN 
Items i ON i.idItems = p.idItems;

Select * from VPanier;
--View VInventaire
Create View VInventaire As Select
Items.nomItem, Items.photo, Items.poids, 
Items.typeItem, Items.utilite, SacADos.idJoueurs,
SacADos.quantite
from Items inner join SacADos on
Items.idItems = SacADos.idItems;
Select * from VInventaire;

----Poids du sac a dos ---------
CREATE PROCEDURE poidSac(IN S_id VARCHAR(40))
BEGIN
	SELECT SUM(i.poids * s.quantite) AS poids_total
    FROM SacADos s
    JOIN Items i ON s.idItems = i.idItems
    WHERE s.idJoueurs = S_id;
END $$

----PayerPanier **En développement----
CREATE PROCEDURE PayerPanier(IN S_idJoueur INT)
BEGIN
	DECLARE total DECIMAL(10,2);
    DECLARE poids_total DECIMAL(10,2);
    DECLARE solde_actuel DECIMAL(10,2);
    
    IF NOT EXISTS(SELECT * FROM Joueurs WHERE idJoueurs = S_idJoueur)
		THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT  = "Joueur introuvable";
	END IF;
    
    SELECT SUM(vp.prix * p.quantiteItem) INTO total FROM Panier p
    JOIN VPanier vp ON p.idItems = vp.idItems WHERE p.idJoueurs = S_idJoueur;
    
    IF total IS NULL 
		THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Le panier est vide";
    END IF;
    
    SELECT montant INTO solde_actuel FROM Joueurs WHERE idJoueurs = S_idJoueur;
    
    IF solde_actuel < total 
		THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Fonds insuffisants";
	END IF;
    
    CALL poidSac(S_idJoueur);
    SELECT SUM(i.poids * p.quantiteItem) INTO poids_total
    FROM Panier p JOIN Items i ON p.idItems = i.idItems WHERE p.idJoueurs = S_idJoueur;
    
    IF poids_total > (SELECT PoidsMaximal FROM Joueurs WHERE idJoueurs = S_idJoueur)
		THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Poids maximal dépassé";
	END IF;
    
    UPDATE Items i
    JOIN Panier p ON i.idItems = p.idItems 
    SET i.quantiteItem = i.quantiteItem - p.quantiteItem WHERE p.idJoueurs = S_idJoueur;
    
    INSERT INTO SacADos (idItems, idJoueurs, quantite)
    SELECT p.idItems, p.idJoueurs, p.quantiteItem FROM Panier p
    ON DUPLICATE KEY UPDATE quantite = quantite + VALUE(quantite);
    
    DELETE FROM Panier WHERE idJoueurs = S_idJoueur;
END $$