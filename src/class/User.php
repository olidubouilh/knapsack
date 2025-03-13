<?php

class User 
{

    private int $idJoueurs;
    private string $nomJoueur;
    private string $prenomJoueur;
    private string $alias;
    private string $password;
    private int $montant;
    private int $dexterite;
    private int $pvJoueur;
    private int $poidsMaximal;
    

    
    public function __construct(int $id, string $nom, string $prenom, string $alias, string $password,
                                int $argent, int $dex, int $pv, int $poids ) 
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
    public function getId(): int {
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
    public function getMontant(): int {
        return $this->montant;
    }
    public function getDexterite(): int {
        return $this->dexterite;
    }
    public function getPvJoueur(): int {
        return $this->pvJoueur;
    }
    public function getPoidsMaximal(): int {
        return $this->poidsMaximal;
    }
    

    

    // Setters
    public function setAlias(string $alias): void {
        $this->alias = $alias;
    }   
    public function setPassword(string $password): void {
        $this->password = $password;
    }
    public function setMontant(int $argent): void {
        $this->montant = $argent;
    }
    public function setDexterite(int $dex): void    {
        $this->dexterite = $dex;
    }
    public function setPvJoueur(int $pv): void {
        $this->pvJoueur = $pv;
    }
    public function setPoidsMaximal(int $poids): void {
        $this->poidsMaximal = $poids;
    }
} 