<?php
class Database {
    private $bdd;

    public function __construct() {
        try {
            $this->bdd = new PDO("mysql:host=localhost;dbname=poo_plainte;charset=utf8", "root", "", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            return $this->bdd;
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
    public function getBdd(){
        return $this->bdd;
    }
}
