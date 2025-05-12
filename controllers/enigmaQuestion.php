<?php
use Random\Randomizer;

require_once 'src/functions.php';
require 'src/class/Database.php';
require_once 'src/configuration.php';
require 'models/EnigmaModel.php';
$style = 'enigma.css';

$message = '';
if(!isAuthenticated()){
    $message = "Vous devez être connecté pour accéder à la page d'Énigma.";
    $_SESSION['popUp'] = $message;
    $_SESSION['success'] = true;
    redirect('/connexion');
    exit;
}
sessionStart();
$pdo = Database::getInstance();
$enigmaModel = new EnigmaModel($pdo);
$idJoueur = userExist() ? $_SESSION['user']['id'] : null;

$match = false;
if($idJoueur){
    $stats = new StatistiqueEnigma($idJoueur);
}

//Lorsque le joueur soumet une réponse
$random = new Randomizer();
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['idQuestion'])) {
        // Première question après le choix de la difficulté
        $difficulte = $_POST['difficulte'] ?? '';
        
        if ($difficulte === 'aléatoire') {
            $random = new Randomizer();
            $randomDiff = $random->getInt(1, 3);
            $difficulte = match($randomDiff) {
                1 => 'facile',
                2 => 'moyenne',
                3 => 'difficile',
                default => 'facile'
            };
        }
    
        $question = $enigmaModel->getRandomQuestionByDifficulty($difficulte);
        $idQuestion = $question->getIdQuestion();
        $enonce = $question->getEnonce();
        $reponses = $enigmaModel->getAnswersById($idQuestion);
        $reponseAttendue = $question->getBonneReponse();
    
        view("enigmaQuestion.php", [
            'id' => $idJoueur,
            'idQuestion' => $idQuestion,
            'enonce' => $enonce,
            'difficulte' => $difficulte,
            'reponses' => $reponses,
            'nbBonnesReponses' => $stats->getNbBonneReponse(),
            'nbMauvaisesReponses' => $stats->getNbMauvaiseReponse(),
            'errors' => '',
            'popUp' => '',
            'style' => $style,
        ]);
        exit;
    }
        if(!empty($_POST['difficulte']) && $_POST['difficulte'] == 'aléatoire') //si la difficulté choisie est aléatoire, on en choisit une aléatoirement
        {
            $aléatoire = 'aléatoire';
            
            $differentesDifficulté = [
                1 => 'facile',
                2 => 'moyenne',
                3 => 'difficile',
            ];
            $difficulte = $differentesDifficulté[$random->getInt(1,3) ?? 'facile'];
            
            $questionAvant = $enigmaModel->getQuestionById($_POST['idQuestion'] ?? 1);
            $VraieReponse = $questionAvant->getBonneReponse();
            $difficulte = $aléatoire; //difficulte choisie par le joueur
            $reponse = $_POST['reponse_id'] ?? null; //reponse choisie par le joueur lorsque le joueur soumet une réponse ou null lors de sa première question
            $idQuestion = $_POST['idQuestion'];
            if (isset($reponse)) 
            {
                 //si le joueur a soumis une réponse
                if ($reponse == $VraieReponse) {  
                        $match = true;
                        $popUp = $match ? "Bravo ! Vous avez trouvé la bonne réponse." : true; //message de popup si la réponse est correcte
                        $stats->incrementNbBonneReponse($match); //incrémente le nombre de bonnes réponses du joueur
                        $enigmaModel->giveCapsAmountEnigma($idJoueur, $difficulte);
                        $enigmaModel->getMontantById($idJoueur);
                }
                else
                {        
                    $match = false;        
                    $errors = $match ? false : "Mauvaise réponse. Essayez encore !"; //message d'erreur si la réponse est incorrecte                
                    $stats->incrementNbMauvaiseReponse($match); //incrémente le nombre de mauvaises réponses du joueur
                    $enigmaModel->badAnswer($difficulte, $idJoueur); 
        
                }        
            }
            //si le joueur n'a pas soumis de réponse
            else {
                $errors = "Veuillez entrer une réponse.";
            }
            $question = $enigmaModel->getRandomQuestionByDifficulty($difficulte); //question choisie aléatoirement selon la difficulté choisie par le joueur
            $idQuestion = $question->getIdQuestion(); //id de la question choisie aléatoirement
            $enonce = $question->getEnonce() ?? ''; //énoncé de la question choisie aléatoirement
            $reponses = $enigmaModel->getAnswersById($idQuestion); //réponses de la question choisie aléatoirement(4 choix)
            $reponseAttendue = $question->getBonneReponse() ?? null;//réponse attendue de la question choisie aléatoirement(prend la question selon son id et retourne la reponse où estBonne = 1)
        }
        else
        {
            $difficulte = $_POST['difficulte'] ?? null; //difficulte choisie par le joueur
            $questionAvant = $enigmaModel->getQuestionById($_POST['idQuestion'] ?? 1);
            $VraieReponse = $questionAvant->getBonneReponse();
            $reponse = $_POST['reponse_id'] ?? null; //reponse choisie par le joueur lorsque le joueur soumet une réponse ou null lors de sa première question
            $idQuestion = $_POST['idQuestion'];
            if (isset($reponse)) 
            {
                 //si le joueur a soumis une réponse
                if ($reponse == $VraieReponse) {
                        $match = true;
                        if($difficulte == 'difficile' && $stats->getSuiteBonneReponse() % 3 === 0)
                        {
                            $popUp = $match ? "Bravo ! Vous avez trouvé la bonne réponse." : true; //message de popup si la réponse est correcte
                            $stats->incrementNbBonneReponse($match); //incrémente le nombre de bonnes réponses du joueur
                            for ($i= 0; $i < 5; $i++) { 
                                $enigmaModel->giveCapsAmountEnigma($idJoueur, $difficulte);
                            }
                            $enigmaModel->getMontantById($idJoueur);
                        }
                        else
                        {
                            $popUp = $match ? "Bravo ! Vous avez trouvé la bonne réponse." : true; //message de popup si la réponse est correcte
                            $stats->incrementNbBonneReponse($match); //incrémente le nombre de bonnes réponses du joueur
                            $enigmaModel->giveCapsAmountEnigma($idJoueur, $difficulte);
                            $enigmaModel->getMontantById($idJoueur);
                        }  
                    }
                else
                {        
                    $match = false;        
                    $errors = $match ? false : "Mauvaise réponse. Essayez encore !"; //message d'erreur si la réponse est incorrecte                
                    $stats->incrementNbMauvaiseReponse($match); //incrémente le nombre de mauvaises réponses du joueur 
                    $enigmaModel->badAnswer($difficulte, $idJoueur); 
        
                }
            }
            //si le joueur n'a pas soumis de réponse
            else {
                $errors = "Veuillez entrer une réponse.";
            }
            $question = $enigmaModel->getRandomQuestionByDifficulty($difficulte); //question choisie aléatoirement selon la difficulté choisie par le joueur
            $idQuestion = $question->getIdQuestion(); //id de la question choisie aléatoirement
            $enonce = $question->getEnonce() ?? ''; //énoncé de la question choisie aléatoirement
            $reponses = $enigmaModel->getAnswersById($idQuestion); //réponses de la question choisie aléatoirement(4 choix)
            $reponseAttendue = $question->getBonneReponse() ?? null;//réponse attendue de la question choisie aléatoirement(prend la question selon son id et retourne la reponse où estBonne = 1)
        
        }
    view("enigmaQuestion.php", [
        'id' => $idJoueur,
        'idQuestion' => $idQuestion,
        'enonce' => $enonce ?? '',
        'difficulte' => $difficulte,
        'reponses' => $reponses ?? null,
        'nbBonnesReponses' => $stats->getNbBonneReponse(),
        'nbMauvaisesReponses' => $stats->getNbMauvaiseReponse(),
        'errors' => $errors ?? '',
        'popUp' => $popUp ?? '',
        'style' => $style ?? '',
    ]);    
}