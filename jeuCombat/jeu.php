<?php
require_once 'classe.php';
require_once 'arena.php';

// Création des combattants
$warrior = new Warrior("Eivor");
$mage = new Mage("Gandalf");
$archer = new Archer("Arrow");

// Affichage initial
$warrior->displayStatus();
$mage->displayStatus();
$archer->displayStatus();
echo "<br>";

// Lancer un combat entre deux créatures
$arena = new Arena($mage, $archer);
$arena->launchFight();
