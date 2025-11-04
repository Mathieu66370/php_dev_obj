<?php
/*
 class NomCLass{
}
 */
class Voiture{
    //Attributs / variables
    public $marque;
    public $anneeDeFabrication;
    public $couleur;
    //Construteur
    public function __construct ($marque,$anneeDeFabrication,$couleur){
        $this->marque = $marque;
        $this->anneeDeFabrication = $anneeDeFabrication;
        $this->couleur = $couleur;
    }

    // Les méthodes ou functions
   public function maVoiture(){
        echo$this->marque."<br>";
        echo$this->anneeDeFabrication."<br>";
        echo$this->couleur."<br>";
    }
}
$voiture1= new Voiture("Ferrari",2010,"Rouge");
$voiture1-> maVoiture();

//Des objets
/*
$voiture1 = new Voiture();
$voiture1->marque = "Citroën C3";
$voiture1->anneeDeFabrication = 2010;
$voiture1->couleur = "blanche";
 */

