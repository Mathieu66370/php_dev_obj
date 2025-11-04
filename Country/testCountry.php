<?php
require_once 'Country.php';
require_once 'DevelopedCountry.php';

// Exercice 2 & 4 : Création d’un tableau de pays
$countries = [
    new Country("France", "Paris", 67, "Europe"),
    new Country("Japon", "Tokyo", 125, "Asie"),
    new Country("Brésil", "Brasilia", 214, "Amérique du Sud"),
    new DevelopedCountry("États-Unis", "Washington D.C.", 331, "Amérique du Nord", 25000),
    new DevelopedCountry("Allemagne", "Berlin", 83, "Europe", 4500)
];

// Affichage initial
echo "<h2>Informations sur les pays :</h2>";
foreach ($countries as $country) {
    echo "<p>" . $country->getInfo() . "</p>";
}

// Exercice 3 : Test des setters
$countries[0]->setName("République Française");
$countries[1]->setPopulation(126);
$countries[3]->setGdp(26000);

// Affichage après modification
echo "<h2>Après modification :</h2>";
foreach ($countries as $country) {
    echo "<p>" . $country->getInfo() . "</p>";
}






