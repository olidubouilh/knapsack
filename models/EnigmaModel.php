<?php
require_once 'src/class/Enigma.php';


//le model de la classe Enigma qui va nous permettre de récupérer les données de la base de données
//et de les envoyer à la vue
class EnigmaModel
{
    public function __construct(private PDO $pdo) {}

    //Récupérer toutes les questions de la base de données
    public function getAllQuestions(): array|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Enigma");
            $stmt->execute();
            $Enigma = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $Enigma ?: null;
        } catch (PDOException $erreur) {
            echo "Erreur dans getAllQuestions: " . $erreur->getMessage();
            return null;
        }
    }
    //Récupérer toutes les questions de la base de données en fonction de la difficulté donnée par le joueur
    public function getAllQuestionsByDifficulty($difficulte): array|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Enigma WHERE niveauDifficulte = :difficulte");
            $stmt->bindValue(":difficulte", $difficulte, PDO::PARAM_STR);
            $stmt->execute();
            $Enigma = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $Enigma ?: null;
        } catch (PDOException $erreur) {
            echo "Erreur dans getAllQuestionsByLevel: " . $erreur->getMessage();
            return null;
        }
    }

    //Récupérer une question en fonction de son énoncé
    //*Cette fonction est temporaire.Actuellement, elle me permet de debugger et de voir ce que ça 
    //me retourne et de voir le résultat d'une bonne réponse vs une mauvaise réponse.

    public function getQuestionByName($enonce): Enigma|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Enigma WHERE enonce = :enonce");
            $stmt->bindValue(":enonce", $enonce, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return new Enigma(
                    $data['idQuestion'],
                    $data['niveauDifficulte'],
                    $data['question'],
                    $data['nbCaps'],
                );
            } else {
                return null;
            }
        } catch (PDOException $erreur) {
            echo "Erreur dans getQuestionByName: " . $erreur->getMessage();
            return null;
        }
    }


    //Récupérer une question en fonction de son id
    public function getQuestionById($id): Enigma|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Enigma WHERE idQuestion = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return new Enigma(
                    $data['idQuestion'],
                    $data['niveauDifficulte'],
                    $data['question'],
                    $data['nbCaps'],
                );
            } else {
                return null;
            }
        } catch (PDOException $erreur) {
            echo "Erreur dans getQuestionById: " . $erreur->getMessage();
            return null;
        }
    }

    //Permet de récupérer une seule question aléatoire en fonction de la difficulté donnée par le joueur
    public function getRandomQuestionByDifficulty($difficulte): Enigma|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Enigma WHERE niveauDifficulte = :difficulte ORDER BY RAND() LIMIT 1");
            $stmt->bindValue(":difficulte", $difficulte, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return new Enigma(
                    $data['idQuestion'],
                    $data['niveauDifficulte'],
                    $data['question'],
                    $data['nbCaps'],
                );
            } else {
                return null;
            }
        } catch (PDOException $erreur) {
            echo "Erreur dans getRandomQuestionByDifficulty: " . $erreur->getMessage();
            return null;
        }
    }
}
//Modifications/Commentaires : 2025-04-07 par Raph  