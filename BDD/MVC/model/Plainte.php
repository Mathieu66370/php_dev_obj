<?php

require_once "Database.php";
class Plainte{
    private $id;
    private $nom;
    private $sujet;
    private $message;
    private $date_plainte;
    private $bdd;


function __construct(Database $bdd){
    $this->bdd = $bdd;
}
    public function getAllPlaintes() {
        $sql = "SELECT p.*, u.nom AS nom_utilisateur
                FROM plainte p
                LEFT JOIN utilisateurs u ON p.utilisateur_id = u.id
                ORDER BY p.date_plainte DESC";
        $query = $this->bdd->getBdd()->query($sql);
        return $plaintes = $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>