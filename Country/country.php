<?php

namespace Country;
class Country
{
    public $name;
    public $capitale;
    public $population;
    public $continent;

    public function __construct($name, $capitale, $population, $continent)
    {
        $this->name = $name;
        $this->capitale = $capitale;
        $this->population = $population;
        $this->continent = $continent;
    }

    public function getInfo()
    {
        echo "Le pays {$this->name} se situe en {$this->continent}. Sa capitale est {$this->capitale} et sa population est d’environ {$this->population} millions d’habitants.";
    }


// --- Getters ---
    public function getName()
    {
        return $this->name;
    }

    public function getCapital()
    {
        return $this->capital;
    }

    public function getPopulation()
    {
        return $this->population;
    }

    public function getContinent()
    {
        return $this->continent;
    }

// --- Setters ---
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPopulation($population)
    {
        $this->population = $population;
    }
}
