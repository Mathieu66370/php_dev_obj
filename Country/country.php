<?php
// Exercice 1 et 3 : Classe Country
class Country
{
    private $name;
    private $capital;
    private $population;
    private $continent;

    // Constructeur
    public function __construct($name, $capital, $population, $continent)
    {
        $this->name = $name;
        $this->capital = $capital;
        $this->population = $population;
        $this->continent = $continent;
    }

    public function getInfo()
    {
        return "Le pays {$this->name} se situe en {$this->continent}. Sa capitale est {$this->capital} et sa population est d’environ {$this->population} millions d’habitants.";
    }

    // Getters
    public function getName() { return $this->name; }
    public function getCapital() { return $this->capital; }
    public function getPopulation() { return $this->population; }
    public function getContinent() { return $this->continent; }

    // Setters (nom et population)
    public function setName($name) { $this->name = $name; }
    public function setPopulation($population) { $this->population = $population; }
}

