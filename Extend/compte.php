<?php
class compteBancaire{
    public $proprietaire;
    public $solde;
    public $annee;

    public function __construct($proprietaire,$solde,$annee){
        $this->proprietaire=$proprietaire;
        $this->solde=$solde;
        $this->annee=$annee;
    }
    public function getProprietaire(){
        echo"Le proprio est".$this->proprietaire."<br>";
    }
    public function infoBancaire(){
        echo "Solde :".$this->solde."<br>";
    }
}
class compteEpargne extends compteBancaire{
    public $soldeBloque;
    public function __construct($proprietaire,$solde,$annee,$soldeBloque){
        Parent::__construct($proprietaire,$solde,$annee);
        $this->soldeBloque=$soldeBloque;
    }
    public function showBloqueMontant(){
        echo"Le montant bloqué est".$this->soldeBloque."<br>";
    }
}
$c1 = new compteBancaire("Mathieu",2600,2019);
$c1->getProprietaire();
$c1->infoBancaire();

$c2 = new compteEpargne("Estelle",2022,2019,500);
$c2->getProprietaire();
$c2->infoBancaire();
$c2->showBloqueMontant();