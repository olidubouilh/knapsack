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

$match = false;
if($idJoueur){
    $stats = new StatistiqueEnigma($idJoueur);
}

//Erreurs: actuellement, ce qui est pris en compte(réponse du user) n'est pas nécéssairement ce qui est pris en compte.
//J'ai essayé de modifier ça avec du Javascript, mais ça ne fonctionne pas.
//Je n'en peut plus aider moi!  

//Lorsque le joueur soumet une réponse
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $questionAvant = $enigmaModel->getQuestionById($_POST['idQuestion'] ?? 1) ;
    $VraieReponse = $questionAvant->getBonneReponse();
    var_dump($_POST); //debug qui montre les données envoyées par le formulaire(idQuestion, difficulte, reponse, reponse_id)
    $difficulte = $_POST['difficulte'] ?? null; //difficulte choisie par le joueur
    $reponse = $_POST['reponse_id'] ?? null; //reponse choisie par le joueur lorsque le joueur soumet une réponse ou null lors de sa première question
    $idQuestion = $_POST['idQuestion'];
    if (isset($reponse)) 
    {
         //si le joueur a soumis une réponse
        /*var_dump($reponseAttendue); //debug
        var_dump($reponse); //debug*/
        if ($reponse == $VraieReponse) { //si la réponse soumise est égale à la réponse attendue 
            //*il y a aussi une fonction checkReponse dans la classe Enigma qui pourrait être utilisée ici, mais je ne l'ai pas utilisé pour le moment
                $match = true;
               
                $popUp = $match ? "Bravo ! Vous avez trouvé la bonne réponse." : true; //message de popup si la réponse est correcte
                $stats->incrementNbBonneReponse($match); //incrémente le nombre de bonnes réponses du joueur
                $enigmaModel->giveCapsAmountEnigma($idJoueur, $difficulte);
                
        }
        else
        {        
            $match = false;        
            $errors = $match ? false : "Mauvaise réponse. Essayez encore !"; //message d'erreur si la réponse est incorrecte                
            $stats->incrementNbMauvaiseReponse($match); //incrémente le nombre de mauvaises réponses du joueur 

        }
        var_dump($match); //debug

    }
    else {
        $errors = "Veuillez entrer une réponse.";
    }
    $question = $enigmaModel->getRandomQuestionByDifficulty($difficulte); //question choisie aléatoirement selon la difficulté choisie par le joueur
    $idQuestion = $question->getIdQuestion(); //id de la question choisie aléatoirement
    $enonce = $question->getEnonce() ?? ''; //énoncé de la question choisie aléatoirement
    $reponses = $enigmaModel->getAnswersById($idQuestion); //réponses de la question choisie aléatoirement(4 choix)
    $reponseAttendue = $question->getBonneReponse() ?? null;//réponse attendue de la question choisie aléatoirement(prend la question selon son id et retourne la reponse où estBonne = 1)

// Vérifiez si l'utilisateur est connecté
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
else {
    redirect('/enigma');
    exit;
}

//Modifications/Commentaires : 2025-04-07 par Raph  
//Modifications/Commentaires : 2025-04-20 par Raph