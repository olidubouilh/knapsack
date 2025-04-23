<?php
//Classe Enigma
class Enigma{
    private int $idQuestion; //Id question
    private string $difficulte; //Difficulté de la question(facile, moyen, difficile)
    private string $enonce; //Enoncé de la question
    private string $reponse; //Réponses de la question

    private int $estBonne; //Réponse correcte de la question
    //Constructeur de la classe Enigma
    //Il prend en paramètre l'id de la question, la difficulté, l'énoncé et le nombre de caps
    public function __construct(int $idQuestion, string $niveau, string $question, string $reponse, int $estBonne){
        $this->idQuestion = $idQuestion;
        $this->difficulte = $niveau;
        $this->enonce = $question;
        $this->reponse = $reponse;
        $this->estBonne = $estBonne;
    }
    public function getIdQuestion(): int{
        return $this->idQuestion;
    }
    public function getDifficulte(): string{
        return $this->difficulte;
    }
    public function getEnonce(): string{
        return $this->enonce;
    }
    public function getReponse(): string{
        return $this->reponse;
    }
    public function getEstBonne(): int{
        return $this->estBonne;
    }
    //À changer
    public function getBonneReponse() : string{
        
        $stmt = Database::getInstance()->prepare("SELECT laReponse FROM VEnigma WHERE idQuestion = :idQuestion AND estBonne = 1");
        $stmt->bindValue(":idQuestion", $this->idQuestion, PDO::PARAM_INT);
        $stmt->execute();
        $reponse = $stmt->fetch(PDO::FETCH_ASSOC);
        if($reponse){
            return $reponse['laReponse'];
        }
        else {
            return "Aucune réponse trouvée";
        }
    }
    public function checkReponse(string $reponse): bool{
        var_dump("reponse venant d'enigma: " . $this->reponse);
        var_dump("reponse venant du formulaire: " . $reponse);


        return $this->reponse == $reponse && $this->estBonne == 1;
    }
}

//Classe StatistiqueEnigma
//Cette classe est utilisée pour gérer les statistiques du joueur
class StatistiqueEnigma{
    private int $idJoueur;//Id du joueur
    private int $suiteBonneReponse;//Suite de bonnes réponses(Si le joueur à bon a 3 réponses de questions difficiles
    //de suite, il gagne 1000 caps)
    private int $nbBonneReponse;//Nombre de bonnes réponses total
    private int $nbMauvaiseReponse;//Nombre de mauvaises réponses total

    //Constructeur de la classe StatistiqueEnigma
    //Il prend en paramètre l'id du joueur
    public function __construct(int $idJoueur){
        $this->idJoueur = $idJoueur;//Id du joueur
        $this->loadStatsFromDatabase();//On charge les statistiques du joueur depuis la base de données



       /* 
        //*À revoir parce qu'à chaque fois que la page est lancée,        
        //la suite de bonnes réponses, le nombre de bonnes réponses et le nombre de mauvaises réponses sont remis à 0.
        $this->suiteBonneReponse = 0;

        $this->nbBonneReponse = 0;//Nombre de bonnes réponses total
        $this->nbMauvaiseReponse = 0;//Nombre de mauvaises réponses total*/

        //PREMIER PROBLÈME RÉGLÉ, LES STATISTIQUES S'INSÈRENT DASN LA TABLE STATISTIQUES ENIGMA QUAND ELLES N'EXISTENT PAS
    }

    //Permet de charger les statistiques du joueur depuis la base de données grâce à son id stocké dans la variable idJoueur
    private function loadStatsFromDatabase(): void
    {

        $stmt = Database::getInstance()->prepare("SELECT * FROM StatistiqueEnigma WHERE idJoueurs = :idJoueur");
        $stmt->bindValue(":idJoueur", $this->idJoueur, PDO::PARAM_INT);
        $stmt->execute();
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($stats) {
            $this->suiteBonneReponse = (int)$stats['suiteBonneReponse'];
            $this->nbBonneReponse = (int)$stats['nbBonneReponse'];
            $this->nbMauvaiseReponse = (int)$stats['nbMauvaiseReponse'];
        } else {
            // If not found, initialize all values to 0 and insert into DB
            $this->suiteBonneReponse = 0;
            $this->nbBonneReponse = 0;
            $this->nbMauvaiseReponse = 0;
    
            $insert = Database::getInstance()->prepare("
                INSERT INTO StatistiqueEnigma (idJoueurs, suiteBonneReponse, nbBonneReponse, nbMauvaiseReponse)
                VALUES (:idJoueur, 0, 0, 0)
            ");
            $insert->bindValue(":idJoueur", $this->idJoueur, PDO::PARAM_INT);
            $insert->execute();
        }
    }

    //Permet d'incrémenter le nombre de bonnes réponses
    public function incrementNbBonneReponse(bool $match): void
    {
        if($match){
            $this->nbBonneReponse++;
            $this->suiteBonneReponse++;
        }
        $this->updateStatsInDatabase();
    }

    //Permet d'incrémenter le nombre de mauvaises réponses
    //On remet la suite de bonnes réponses à 0
    public function incrementNbMauvaiseReponse(bool $match) : void
    {
        if(!$match){
            $this->nbMauvaiseReponse++;
            $this->suiteBonneReponse = 0;
        }
        $this->updateStatsInDatabase();
    }

    //Permet de mettre à jour les statistiques du joueur dans la base de données
    //On met à jour la suite de bonnes réponses, le nombre de bonnes réponses et le nombre de mauvaises réponses
    private function updateStatsInDatabase(): void
    {
        $stmt = Database::getInstance()->prepare("UPDATE StatistiqueEnigma SET suiteBonneReponse = :suite, nbBonneReponse = :nbBonne, nbMauvaiseReponse = :nbMauvaise WHERE idJoueurs = :idJoueur");
        $stmt->bindValue(":suite", $this->suiteBonneReponse, PDO::PARAM_INT);
        $stmt->bindValue(":nbBonne", $this->nbBonneReponse, PDO::PARAM_INT);
        $stmt->bindValue(":nbMauvaise", $this->nbMauvaiseReponse, PDO::PARAM_INT);
        $stmt->bindValue(":idJoueur", $this->idJoueur, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getSuiteBonneReponse(): int
    {
        return $this->suiteBonneReponse;
    }
    public function getNbBonneReponse(): int
    {
        return $this->nbBonneReponse;
    }
    public function getNbMauvaiseReponse(): int
    {
        return $this->nbMauvaiseReponse;
    }
}
//Modifications/Commentaires : 2025-04-07 par Raph  