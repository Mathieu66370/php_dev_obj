<?php
// Exercice 5 : Classe DevelopedCountry
require_once 'Country.php';

class DevelopedCountry extends Country
{
    private $gdp; // PIB en milliards de dollars

    // Constructeur
    public function __construct($name, $capital, $population, $continent, $gdp)
    {
        parent::__construct($name, $capital, $population, $continent);
        $this->gdp = $gdp;
    }

    // Getter et setter pour le PIB
    public function getGdp() { return $this->gdp; }
    public function setGdp($gdp) { $this->gdp = $gdp; }

    // Redéfinition de getInfo() pour inclure le PIB
    public function getInfo()
    {
        return parent::getInfo() . " Son PIB est d’environ {$this->gdp} milliards de dollars.";
    }
}




