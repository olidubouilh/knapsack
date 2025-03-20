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
