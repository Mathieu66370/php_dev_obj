<?php

require_once "./model/Plainte.php";
class PlainteController{
    private Plainte $plainte;
    public function __construct(Plainte $plainte){
        $this->plainte = $plainte;
    }
    public function index(){
        $plaintes=$this->plainte->getAllPlaintes();
        include ("./view/liste_plainte.php");
    }
}