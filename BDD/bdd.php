<?php
// Connexion à la base de données avec PDO

try {
    // Création d'une nouvelle instance PDO pour se connecter à MySQL
    // Paramètres :
    // - host=localhost : serveur de base de données local
    // - dbname=poo_plainte : nom de la base de données
    // - "root", "" : nom d'utilisateur et mot de passe pour se connecter à MySQL
    // - PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION : pour que PDO lance une exception en cas d'erreur
    $bdd = new PDO("mysql:host=localhost;dbname=poo_plainte;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $e) {
    // Si la connexion échoue, on interrompt le script et on affiche le message d'erreur
    die("Erreur : " . $e->getMessage());
}
?>

