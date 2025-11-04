<?php
// Fichier : test_country.php

use Country\Country;

require_once 'Country.php'; // Import de la classe

// --- Création d'objets ---
$france = new Country("France", "Paris", 67, "Europe");
$japan = new Country("Japon", "Tokyo", 125, "Asie");
$brazil = new Country("Brésil", "Brasilia", 214, "Amérique du Sud");

// --- Affichage initial ---
echo "<h2>Avant modification :</h2>";
echo "<p>" . $france->getInfo() . "</p>";
echo "<p>" . $japan->getInfo() . "</p>";
echo "<p>" . $brazil->getInfo() . "</p>";

// --- Modifications avec setters ---
$france->setName("République Française");
$japan->setPopulation(126);
$brazil->setName("DO Brasil");

// --- Affichage après modification ---
echo "<h2>Après modification :</h2>";
echo "<p>" . $france->getInfo() . "</p>";
echo "<p>" . $japan->getInfo() . "</p>";
echo "<p>" . $brazil->getInfo() . "</p>";





