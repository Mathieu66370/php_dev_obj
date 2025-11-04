<?php

use Country\Country;

require_once 'Country.php';
$countries = [
    new Country("France", "Paris", 67, "Europe"),
    new Country("Japon", "Tokyo", 125, "Asie"),
    new Country("Brésil", "Brasilia", 214, "Amérique du Sud"),
    new Country("Canada", "Ottawa", 40, "Amérique du Nord"),
    new Country("Australie", "Canberra", 30, "Océanie")
];
foreach ($countries as $country) {
    echo "<p>" . $country->getInfo() . "</p>";
}


