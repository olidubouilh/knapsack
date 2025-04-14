<?php
//Classe Enigma
class Enigma{
    private int $idQuestion; //Id question
    private string $difficulte; //Difficulté de la question(facile, moyen, difficile)
    private string $enonce; //Enoncé de la question
    private int $nbCaps; //Nombre de caps qui est donné si on répond correctement à la question

    private string $reponse; //Réponse de la question

    //Constructeur de la classe Enigma
    //Il prend en paramètre l'id de la question, la difficulté, l'énoncé et le nombre de caps
    public function __construct(int $idQuestion, string $niveau, string $question, int $nbCaps, string $reponse){
        $this->idQuestion = $idQuestion;
        $this->difficulte = $niveau;
        $this->enonce = $question;
        $this->nbCaps = $nbCaps;
        $this->reponse = $reponse;
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
    public function getNbCaps(): int{
        return $this->nbCaps;
    }
    public function getReponse(): string{
        return $this->reponse;
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
        
        //*À revoir parce qu'à chaque fois que la page est lancée,        
        //la suite de bonnes réponses, le nombre de bonnes réponses et le nombre de mauvaises réponses sont remis à 0.
        $this->suiteBonneReponse = 0;

        $this->nbBonneReponse = 0;//Nombre de bonnes réponses total
        $this->nbMauvaiseReponse = 0;//Nombre de mauvaises réponses total
    }

    //Permet de charger les statistiques du joueur depuis la base de données grâce à son id stocké dans la variable idJoueur
    private function loadStatsFromDatabase(): void
    {

        $stmt = Database::getInstance()->prepare("SELECT * FROM StatistiqueEnigma WHERE idJoueurs = :idJoueur");
        $stmt->bindValue(":idJoueur", $this->idJoueur, PDO::PARAM_INT);
        $stmt->execute();
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
        //On récupère les statistiques du joueur dans la base de données
        if($stats){
            $this->suiteBonneReponse = $this->getSuiteBonneReponse();
            $this->nbBonneReponse = $this->getNbBonneReponse();
            $this->nbMauvaiseReponse = $this->getNbMauvaiseReponse();
        }
    }

    //Permet d'incrémenter le nombre de bonnes réponses
    public function incrementNbBonneReponse(): void
    {
        $this->nbBonneReponse++;
        $this->suiteBonneReponse++;
        
    }

    //Permet d'incrémenter le nombre de mauvaises réponses
    //On remet la suite de bonnes réponses à 0
    public function incrementNbMauvaiseReponse() : void
    {
        $this->nbMauvaiseReponse++;
        $this->suiteBonneReponse = 0;
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
        $this->updateStatsInDatabase();
        return $this->nbBonneReponse;
    }
    public function getNbMauvaiseReponse(): int
    {
        $this->updateStatsInDatabase();
        return $this->nbMauvaiseReponse;
    }
}
//Modifications/Commentaires : 2025-04-07 par Raph  