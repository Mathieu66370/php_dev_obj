<?php
require_once "bdd.php"; // Inclusion du fichier de connexion à la base de données (via PDO)


// Suppression d'une plainte
if (isset($_GET['delete'])) { // Si un paramètre "delete" est présent dans l'URL
    $idToDelete = (int)$_GET['delete']; // Sécurisation de l'ID
    $stmt = $bdd->prepare("DELETE FROM plainte WHERE id=:id");
    $stmt->execute([':id' => $idToDelete]);
    header("Location: plainte.php");
    exit();
}


//  Action de changement de visibilité
if (isset($_GET['toggle'])) { // Si un paramètre "toggle" est présent dans l'URL
    $idToToggle = (int)$_GET['toggle']; // ID de la plainte à modifier

    // On récupère l'état actuel de la plainte
    $stmt = $bdd->prepare("SELECT visible FROM plainte WHERE id = :id");
    $stmt->execute([':id' => $idToToggle]);
    $plainte = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($plainte) {
        // Inversion de l'état : si visible = 1, on le passe à 0, sinon 1
        $nouvelEtat = $plainte['visible'] == 1 ? 0 : 1;

        // Mise à jour de la visibilité
        $update = $bdd->prepare("UPDATE plainte SET visible = :visible WHERE id = :id");
        $update->execute([
                ':visible' => $nouvelEtat,
                ':id' => $idToToggle
        ]);
    }

    // Redirection après modification (pour éviter les doubles actions si on recharge)
    header("Location: plainte.php");
    exit();
}


// Récupération de toutes les plaintes
$sql = "SELECT * FROM plainte ORDER BY date_plainte DESC"; // Récupération des plaintes triées par date
$query = $bdd->query($sql);
$plaintes = $query->fetchAll(PDO::FETCH_ASSOC);

require_once "bdd.php"; // Connexion à la base de données via PDO


// 🗑️ Suppression multiple
if (isset($_POST['delete_selected']) && !empty($_POST['ids'])) {
    $ids = $_POST['ids']; // Tableau des IDs sélectionnés

    // Création de la liste de placeholders pour la requête préparée (?, ?, ...)
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    // Suppression des plaintes sélectionnées
    $stmt = $bdd->prepare("DELETE FROM plainte WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    // Redirection pour éviter double soumission
    header("Location: plainte.php");
    exit();
}


// 🗑️ Suppression individuelle
if (isset($_GET['delete'])) {
    $idToDelete = (int)$_GET['delete']; // Sécurisation de l'ID
    $stmt = $bdd->prepare("DELETE FROM plainte WHERE id=:id");
    $stmt->execute([':id' => $idToDelete]);
    header("Location: plainte.php");
    exit();
}


// 👁️ Changement de visibilité (Visible <-> Masquée)
if (isset($_GET['toggle'])) {
    $idToToggle = (int)$_GET['toggle'];

    // Récupération de l'état actuel
    $stmt = $bdd->prepare("SELECT visible FROM plainte WHERE id = :id");
    $stmt->execute([':id' => $idToToggle]);
    $plainte = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($plainte) {
        // Inversion de la visibilité
        $nouvelEtat = $plainte['visible'] == 1 ? 0 : 1;
        $update = $bdd->prepare("UPDATE plainte SET visible = :visible WHERE id = :id");
        $update->execute([
            ':visible' => $nouvelEtat,
            ':id' => $idToToggle
        ]);
    }

    header("Location: plainte.php");
    exit();
}


// 📋 Récupération de toutes les plaintes
$sql = "SELECT * FROM plainte ORDER BY date_plainte DESC";
$query = $bdd->query($sql);
$plaintes = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des plaintes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <!-- En-tête de la page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des plaintes</h1>
        <a href="formulaire.php" class="btn btn-primary">Ajouter une plainte</a>
    </div>

    <!-- Formulaire global pour la suppression multiple -->
    <form method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer les plaintes sélectionnées ?');">

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
            <tr>
                <!-- Nouvelle colonne pour checkbox individuelle -->
                <th>Supprimer</th>
                <th>ID</th>
                <th>Nom</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Date plainte</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($plaintes as $plainte): ?>
                <tr>
                    <!-- ✅ Checkbox individuelle pour sélectionner la plainte -->
                    <td>
                        <input type="checkbox" name="ids[]" value="<?= $plainte['id'] ?>">
                    </td>

                    <!-- Affichage des données de la plainte -->
                    <td><?= htmlspecialchars($plainte['id']) ?></td>
                    <td><?= htmlspecialchars($plainte['nom']) ?></td>
                    <td><?= htmlspecialchars($plainte['sujet']) ?></td>
                    <td><?= htmlspecialchars($plainte['message']) ?></td>
                    <td><?= htmlspecialchars($plainte['date_plainte']) ?></td>

                    <!-- Statut (visible ou masquée) -->
                    <td>
                        <?= $plainte['visible'] == 1
                            ? '<span class="badge bg-success">Visible</span>'
                            : '<span class="badge bg-secondary">Masquée</span>' ?>
                    </td>

                    <!-- Actions pour chaque plainte -->
                    <td>
                        <!-- Modifier la plainte -->
                        <a href="formulaire.php?id=<?= $plainte['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>

                        <!-- Supprimer individuellement -->
                        <a href="plainte.php?delete=<?= $plainte['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Voulez-vous vraiment supprimer cette plainte ?');">
                            Supprimer
                        </a>

                        <!-- Rendre visible/invisible -->
                        <?php if ($plainte['visible'] == 1): ?>
                            <a href="plainte.php?toggle=<?= $plainte['id'] ?>"
                               class="btn btn-outline-secondary btn-sm"
                               onclick="return confirm('Voulez-vous rendre cette plainte invisible ?');">
                                Rendre invisible
                            </a>
                        <?php else: ?>
                            <a href="plainte.php?toggle=<?= $plainte['id'] ?>"
                               class="btn btn-outline-success btn-sm"
                               onclick="return confirm('Voulez-vous rendre cette plainte visible ?');">
                                Rendre visible
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Bouton pour supprimer toutes les plaintes cochées -->
        <button type="submit" name="delete_selected" class="btn btn-danger mt-2">
            Supprimer la sélection
        </button>
    </form>
</div>
</body>
</html>






