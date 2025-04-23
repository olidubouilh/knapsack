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
            $stmt = $this->pdo->prepare("SELECT * FROM VEnigma");
            $stmt->execute();
            $Enigma = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $Enigma ?: null;
        } catch (PDOException $erreur) {
            echo "Erreur dans getAllQuestions: " . $erreur->getMessage();
            return null;
        }
    }

    public function getAnswersById($idQuestion): array|null
    {
        try
        {
            $stmt = $this->pdo->prepare("SELECT laReponse, estBonne FROM VEnigma WHERE idQuestion = :idQuestion ORDER BY RAND()");
            $stmt->bindValue(":idQuestion", $idQuestion, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($data) {

                return $data;
            }else {
                return null;
            }
        }catch (PDOException $erreur) {
            echo "Erreur dans getAswerById: " . $erreur->getMessage();
            return null;
        }
    }
    //Récupérer une question en fonction de son id(POur avoir une question random(faire un random et récuperer un int ayant comme valeur entre min et max de idQuestion))
    public function getQuestionById($id): Enigma|null
    {
        try {
            $stmt = $this->pdo->prepare("SELECT idQuestion, niveauDifficulte, question, laReponse, estBonne FROM VEnigma WHERE idQuestion = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return new Enigma(
                    $data['idQuestion'],
                    $data['niveauDifficulte'],
                    $data['question'],
                    $data['laReponse'],
                    $data['estBonne']
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
            $stmt = $this->pdo->prepare("SELECT idQuestion, niveauDifficulte, question, laReponse, estBonne FROM VEnigma WHERE niveauDifficulte = :difficulte ORDER BY RAND() LIMIT 1");
            $stmt->bindValue(":difficulte", $difficulte, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return new Enigma(
                    $data['idQuestion'],
                    $data['niveauDifficulte'],
                    $data['question'],
                    $data['laReponse'],
                    $data['estBonne']
                   
                );
            } else {
                return null;
            }
        } catch (PDOException $erreur) {
            echo "Erreur dans getRandomQuestionByDifficulty: " . $erreur->getMessage();
            return null;
        }
    }
    public function giveCapsAmountEnigma($idJoueur, $difficulte)
    {
        try {
            $stmt = $this->pdo->prepare("CALL QuestionGainCaps(:idJoueur, :difficulte)");
            $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);
            $stmt->bindValue(':difficulte', $difficulte, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de l'appel de la procédure QuestionGainCaps : " . $e->getMessage();
        }
    }
    public function getMontantById($idJoueur)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT montant FROM Joueurs WHERE idJoueurs = :idJoueur");
            $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);
            $stmt->execute();
            $newMontant = $stmt->fetchColumn();
        
            if ($newMontant !== false) {
                $_SESSION['user']['montant'] = $newMontant;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du montant des caps : " . $e->getMessage();
        }
    }
}
//Modifications/Commentaires : 2025-04-07 par Raph  