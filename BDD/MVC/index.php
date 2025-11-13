<?php

require_once "controller/PlainteController.php";
require_once "model/Plainte.php";
require_once "model/Database.php";


$bdd= new Database();

$plainteModel= new Plainte($bdd);

$plainteController= new PlainteController($plainteModel);

$plainteController->index();