<?php

$annee_naissance = [2012,2014,1923,1945,1975,1998]; /* si le tableau est vide : error donc rajouter une condition*/

$annee_max = max($annee_naissance);
$annee_min = min($annee_naissance);



echo "L'année de naissance de la personne la plus agée est $annee_min."."<br>";
echo  "L'année de naissance de la personne la plus jeune est $annee_max."."<br>";

$annee_pair = 0;

foreach ($annee_naissance as $val) {
    if ($val % 2 == 0) {
        $annee_pair++;
    }
}

echo "Il y a $annee_pair années paires.<br>";

