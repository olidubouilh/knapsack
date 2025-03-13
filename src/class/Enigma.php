<?php
class Enigma{
    private int $idEnigme;
    private int $difficulte;
    private string $enonce;
    private int $nbCaps;
    private string $estPigee;

    public function __construct(int $id, int $niveau, string $question, string $pige, int $nbCaps){
        $this->idEnigme = $id;
        $this->difficulte = $niveau;
        $this->enonce = $question;
        $this->estPigee = $pige;
        $this->nbCaps = $nbCaps;
    }
    public function getIdEnigme(){
        return $this->idEnigme;
    }
    public function getDifficulte(){
        return $this->difficulte;
    }
    public function getEnonce(){
        return $this->enonce;
    }
    public function getEstPige(){
        return $this->estPigee;
    }
    public function getNbCaps(){
        return $this->nbCaps;
    }
}
   


?>