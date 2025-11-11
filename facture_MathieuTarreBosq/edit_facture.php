<?php include("configDB.php"); ?>

<div style="text-align:center; margin-bottom:20px;">
    <a href="add_client.php"><button style="background-color:#4CAF50;color:white;padding:8px 12px;border-radius:8px;border:2px solid #4CAF50;margin:3px;">Ajouter un client</button></a>
    <a href="list_client.php"><button style="background-color:#2196F3;color:white;padding:8px 12px;border-radius:8px;border:2px solid #2196F3;margin:3px;">Liste des clients</button></a>
    <a href="add_facture.php"><button style="background-color:#FF9800;color:white;padding:8px 12px;border-radius:8px;border:2px solid #FF9800;margin:3px;">Ajouter une facture</button></a>
    <a href="list_facture.php"><button style="background-color:#f44336;color:white;padding:8px 12px;border-radius:8px;border:2px solid #f44336;margin:3px;">Liste des factures</button></a>
</div>

<?php
if (!isset($_GET['id'])) die("ID de la facture non spécifié");
$id = $_GET['id'];
$stmt = $bdd->prepare("SELECT * FROM factures WHERE id_facture=?");
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) die(" Facture introuvable");
?>

<h2 style="text-align:center;">Modifier la facture</h2>

<form method="post" style="max-width:450px;margin:auto;padding:15px;border:2px solid #ccc;border-radius:10px;background-color:#f9f9f9;">
    Montant : <input type="number" step="0.01" name="montant" value="<?= $row['montant'] ?>" required style="width:100%;padding:5px;margin:5px 0;"><br>
    Produits : <textarea name="produits" required style="width:100%;padding:5px;margin:5px 0;"><?= $row['produits'] ?></textarea><br>
    Quantité : <input type="number" name="quantite" value="<?= $row['quantite'] ?>" required style="width:100%;padding:5px;margin:5px 0;"><br>
    Date d'émission : <input type="date" name="date_emission" value="<?= $row['date_emission'] ?>" required style="width:100%;padding:5px;margin:5px 0;"><br>
    <input type="submit" name="modifier" value="Mettre à jour" style="background-color:#FF9800;color:white;padding:8px 12px;border:none;border-radius:8px;cursor:pointer;">
</form>

<?php
if (isset($_POST['modifier'])) {
    $sql = "UPDATE factures SET montant=?, produits=?, quantite=?, date_emission=? WHERE id_facture=?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$_POST['montant'], $_POST['produits'], $_POST['quantite'], $_POST['date_emission'], $id]);
    echo "<p style='text-align:center;color:green;'>Facture mise à jour.</p>";
}
?>
