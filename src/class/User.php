<?php

class User 
{

    private string $idJoueurs;
    private string $nomJoueur;
    private string $prenomJoueur;
    private string $alias;
    private string $password;
    private string $montant;
    private string $dexterite;
    private string $pvJoueur;
    private string $poidsMaximal;
    

    
    public function __construct(string $id, string $nom, string $prenom, string $alias, string $password,
                                string $argent, string $dex, string $pv, string $poids ) 
    {
        $this->idJoueurs = $id;
        $this->nomJoueur = $nom;
        $this->prenomJoueur = $prenom;
        $this->alias = $alias;
        $this->password = $password;
        $this->montant = $argent;
        $this->dexterite = $dex;
        $this->pvJoueur = $pv;
        $this->poidsMaximal = $poids;

    }


    // Getters
    public function getId(): string {
        return $this->idJoueurs;
    }
    public function getNomJoueur(): string {
        return $this->nomJoueur;
    }
    public function getPrenomJoueur(): string {
        return $this->prenomJoueur;
    }
    public function getAlias(): string {
        return $this->alias;
    }
    public function getPassword(): string {
        return $this->password;
    }
    public function getMontant(): string {
        return $this->montant;
    }
    public function getDexterite(): string {
        return $this->dexterite;
    }
    public function getPvJoueur(): string {
        return $this->pvJoueur;
    }
    public function getPoidsMaximal(): string {
        return $this->poidsMaximal;
    }
    

    

    // Setters
    public function setAlias(string $alias): void {
        $this->alias = $alias;
    }   
    public function setPassword(string $password): void {
        $this->password = $password;
    }
    public function setMontant(string $argent): void {
        $this->montant = $argent;
    }
    public function setDexterite(string $dex): void    {
        $this->dexterite = $dex;
    }
    public function setPvJoueur(string $pv): void {
        $this->pvJoueur = $pv;
    }
    public function setPoidsMaximal(string $poids): void {
        $this->poidsMaximal = $poids;
    }
} 