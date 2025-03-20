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
    SELECT alias FROM Joueurs WHERE alias = S_alias;
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


-- Ajouter un item au panier(n'est pas entièrement fini)
DELIMITER $$
CREATE PROCEDURE AjouterItemPanier(S_idItem INT, S_idJoueurs INT)
BEGIN	
	DECLARE qtyItemMagasin INT;
    DECLARE qtyItemPanier INT;
    
	IF NOT EXISTS(SELECT nomItem FROM Items WHERE idItems = S_idItem)
		THEN CALL log("Erreur, l\'id du item n\'existe pas. ");
	END IF;
    
    SELECT quantiteItem INTO qtyItemMagasin FROM Items WHERE idItems = S_idItem;
    SELECT quantiteItem INTO qtyItemPanier FROM Panier WHERE idItems = S_idItem AND idJoueurs = S_idJoueurs;
    
    IF(qtyItemMagasin < qtyItemPanier)
		THEN CALL log("Erreur, il n\'a pas assez de cet item dans le magasin pour le nombre que vous voulez.");
	END IF;
    IF NOT EXISTS(SELECT alias FROM Joueurs WHERE idJoueurs = S_idJoueurs)
		THEN CALL log("Erreur, le joueur n\'existe pas");
	END IF;
    IF(qtyItemPanier = 0)
		THEN 
			BEGIN
				INSERT INTO Panier(idItems, idJoueurs, quantiteItem) VALUES(S_idItem, S_idJoueurs, 1);
			END;
    ELSE
		BEGIN
			UPDATE Panier SET quantiteItem = quantiteItem + 1 WHERE idItems = S_idItem AND idJoueurs = S_idJoueurs;
        END;
    END IF;
END $$
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
