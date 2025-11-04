<?php

/* $annee_naissance = 2002; /*intval(readline ('Quel est votre année de naissance ?'));

$annee_actuelle = date("Y");

$age = $annee_actuelle - $annee_naissance;

echo "Vous avez $age ans.";

if($age < 18){
    echo "Vous êtes mineure.";}

elseif ($age >= 18){
    echo "Vous êtes majeur.";}


echo 'Vous êtes né en: '.$annee_naissance.'<br><br';

for ($i =1; $i<4; $i++) {
    $annee_naissance++;
    echo $i . "ans plus tard, nous étions en" . $annee_naissance. '<br>';
    }

$user =(readline("Quel est votre prénom ?"));
echo "Bonjour $user.";
*/

$years = [1952,1953,1954,1955,1956,1957,2000,2001,2004];

echo "avec la boucle for"."<br>";
for ($i=0; $i < count($years); $i++) {
    echo $years[$i]."<br>";
}

echo"avec la boucle foreach" . "<br>";
foreach ($years as $value) {
    echo $value."<br>";
}