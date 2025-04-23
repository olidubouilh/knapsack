<?php


require_once 'src/functions.php';
require 'src/class/Database.php';
require_once 'src/configuration.php';
require 'models/EnigmaModel.php';
$style = 'enigma.css';
sessionStart();
$pdo = Database::getInstance();
$enigmaModel = new EnigmaModel($pdo);
$idJoueur = $_SESSION['user']['id'] ?? '';

if($idJoueur){
    $stats = new StatistiqueEnigma($idJoueur);
}

//Lorsque le joueur soumet une réponse
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $difficulte = $_POST['difficulte'] ?? null;
    $reponseUser = $_POST['reponse_id'] ?? null;

    // CASE 1: First time choosing difficulty (no answer yet)
    if (!$reponseUser && $difficulte) {
        $question = $enigmaModel->getRandomQuestionByDifficulty($difficulte);

        if ($question) {
            $_SESSION['enigma_question_id'] = $question->getIdQuestion(); // Save for validation
            $reponses = $enigmaModel->getAnswersById($question->getIdQuestion());

            view("enigmaQuestion.php", [
                'question' => $question,
                'reponses' => $reponses,
                'style' => $style
            ]);
            exit;
        } else {
            $errors = "Aucune question disponible pour cette difficulté.";
        }
    }

    // CASE 2: User answered a question
    elseif ($reponseUser && isset($_SESSION['enigma_question_id'])) {
        $idQuestion = $_SESSION['enigma_question_id'];
        $reponses = $enigmaModel->getAnswersById($idQuestion);
        $isCorrect = false;

        foreach ($reponses as $rep) {
            if ($rep['estBonne'] == 1 && $rep['laReponse'] == $reponseUser) {
                $isCorrect = true;
                break;
            }
        }

        // Update stats
        if ($idJoueur) {
            if ($isCorrect) {
                $stats->incrementNbBonneReponse(true);
                $popUp = "Bravo ! Vous avez trouvé la bonne réponse.";
            } else {
                $stats->incrementNbMauvaiseReponse(false);
                $errors = "Mauvaise réponse. Essayez encore !";
            }
        }

        unset($_SESSION['enigma_question_id']); // Clear stored question

        view("enigmaResultat.php", [
            'id' => $idJoueur,
            'nbBonnesReponses' => $stats->getNbBonneReponse(),
            'nbMauvaisesReponses' => $stats->getNbMauvaiseReponse(),
            'errors' => $errors ?? '',
            'popUp' => $popUp ?? '',
            'style' => $style,
        ]);
        exit;
    } else {
        $errors = "Veuillez sélectionner une réponse.";
    }
}


//Modifications/Commentaires : 2025-04-07 par Raph  
//Modifications/Commentaires : 2025-04-20 par Raph