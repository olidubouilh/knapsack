<?php
require_once 'src/functions.php';
require 'src/class/Database.php';
require_once 'src/configuration.php';
require 'models/EnigmaModel.php';

sessionStart();
$pdo = Database::getInstance();
$enigmaModel = new EnigmaModel($pdo);

//Lorsque le joueur soumet une réponse
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reponse'])) {
        $reponse = $_POST['reponse'] ?? '';
        $idQuestion = $_POST['idQuestion'] ?? '';
        $difficulte = $_POST['difficulte'] ?? '';
        $nbCaps = $_POST['nbCaps'] ?? '';
        $idJoueur = $_SESSION['user']['id'] ?? '';
        $stats = new StatistiqueEnigma($idJoueur); //Dû à l'instanciation de la classe à chaque fois qu'on soumet une réponse
        //la suite de bonnes réponses, le nombre de bonnes réponses et le nombre de mauvaises réponses sont remis à 0.

        if(empty($reponse)) {
            $errors = "Veuillez entrer une réponse.";
        } else {
            // Vérifiez si la réponse est correcte
            $question = $enigmaModel->getQuestionById($idQuestion); // Récupérer la question par son ID
            if ($question) {

                // Ici c'est un test, je compte bel et bien changer getEnonce() par getReponse() dans la classe Enigma
                // et dans la base de données, mais pour l'instant je laisse ça comme ça
                if ($question->getEnonce() === $reponse) {
                    
                    // Réponse correcte
                    $popUp = "Bravo ! Vous avez trouvé la bonne réponse.";
                    $stats->incrementNbBonneReponse();
                } else {
                    
                    // Réponse incorrecte
                    $stats->incrementNbMauvaiseReponse();
                    $errors = "Mauvaise réponse. Essayez encore !";
                }
            } else {
                $errors = "Erreur lors de la récupération de la question.";
            }
        }
    }
}
// Vérifiez si l'utilisateur est connecté
if(isset($_SESSION['user']['id'])) {
    // Si l'utilisateur est connecté, on peut lui afficher une question aléatoire
    // et on affiche ses statistiques

    $idJoueur = $_SESSION['user']['id'];
    $stats = new StatistiqueEnigma($idJoueur);
    $questions = $enigmaModel->getAllQuestions(); // Récupérer toutes les questions de la base de données
    if($questions) {
        //Pour l'instant, je ne fais que récupérer une question facile, mais je vais faire en sorte de récupérer une question aléatoire
        //en fonction de la difficulté choisie par le joueur dans le futur
        $question = $enigmaModel->getRandomQuestionByDifficulty("facile");
        if($question) {
            // Récupérer les informations de la question
            $idQuestion = $question->getIdQuestion();
            $difficulte = $question->getDifficulte();
            $enonce = $question->getEnonce();
            $nbCaps = $question->getNbCaps();
        } else {
            $errors = "Erreur lors de la récupération de la question.";
        }
    } else {
        $errors = "Aucune question disponible.";
    }
    //*Choses à améliorer: ne pas nécéssairement diviser $question, mais plutot de l'envoyer à la vue qui va elle
    // le diviser selon le besoin.
    view("enigma.php", [
        'id' => $idJoueur,
        'idQuestion' => $idQuestion ?? '',
        'enonce' => $enonce ?? '',
        'nbBonnesReponses' => $stats->getNbBonneReponse(),
        'nbMauvaisesReponses' => $stats->getNbMauvaiseReponse(),
        'errors' => $errors ?? '',
        'popUp' => $popUp ?? '',
        'style' => $style ?? '',
    ]);
} else{
    redirect('/connexion');
    exit;
}
//Modifications/Commentaires : 2025-04-07 par Raph  