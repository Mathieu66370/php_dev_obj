<?php

include("configDB.php");
$id = $_GET['id'];

$stmt = $bdd->prepare("DELETE FROM factures WHERE id_facture = ?");
$stmt->execute([$id]);

header("Location: list_facture.php");
