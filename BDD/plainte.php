<?php
require_once "bdd.php";
session_start();
include "header.php";

// 🔹 Suppression d'une plainte (uniquement si connecté et propriétaire)
if (isset($_GET['delete']) && isset($_SESSION['user'])) {
    $idToDelete = (int)$_GET['delete'];

    // Vérifier si la plainte appartient à l'utilisateur connecté
    $stmt = $bdd->prepare("SELECT utilisateur_id FROM plainte WHERE id = :id");
    $stmt->execute([':id' => $idToDelete]);
    $plainte = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($plainte && $plainte['utilisateur_id'] == $_SESSION['user']['id']) {
        $stmt = $bdd->prepare("DELETE FROM plainte WHERE id=:id");
        $stmt->execute([':id' => $idToDelete]);
    }

    header("Location: plainte.php");
    exit();
}

// 🔹 Changement de visibilité (uniquement si connecté et propriétaire)
if (isset($_GET['toggle']) && isset($_SESSION['user'])) {
    $idToToggle = (int)$_GET['toggle'];

    $stmt = $bdd->prepare("SELECT utilisateur_id, visible FROM plainte WHERE id = :id");
    $stmt->execute([':id' => $idToToggle]);
    $plainte = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($plainte && $plainte['utilisateur_id'] == $_SESSION['user']['id']) {
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

// 🔹 Récupération de toutes les plaintes (tout le monde les voit)
$sql = "SELECT p.*, u.nom AS nom_utilisateur 
        FROM plainte p
        LEFT JOIN utilisateurs u ON p.utilisateur_id = u.id
        ORDER BY p.date_plainte DESC";
$query = $bdd->query($sql);
$plaintes = $query->fetchAll(PDO::FETCH_ASSOC);

// 🔹 Suppression multiple (uniquement si connecté et propriétaire)
if (isset($_POST['delete_selected']) && !empty($_POST['ids']) && isset($_SESSION['user'])) {
    $ids = $_POST['ids'];

    // Supprimer uniquement les plaintes appartenant à l'utilisateur connecté
    $in = str_repeat('?,', count($ids) - 1) . '?';
    $sql = "DELETE FROM plainte WHERE id IN ($in) AND utilisateur_id = ?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([...$ids, $_SESSION['user']['id']]);

    header("Location: plainte.php");
    exit();
}
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
    <h2>Liste de toutes les plaintes</h2>

    <div class="d-flex justify-content-end mb-3">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="formulaire.php" class="btn btn-primary">Ajouter une plainte</a>
        <?php endif; ?>
    </div>

    <form method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer les plaintes sélectionnées ?');">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
            <tr>
                <th>Sélectionner</th>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($plaintes as $plainte): ?>
                <tr>
                    <td>
                        <?php if (isset($_SESSION['user']) && $plainte['utilisateur_id'] == $_SESSION['user']['id']): ?>
                            <input type="checkbox" name="ids[]" value="<?= $plainte['id'] ?>">
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($plainte['id']) ?></td>
                    <td><?= htmlspecialchars($plainte['nom_utilisateur'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($plainte['sujet']) ?></td>
                    <td><?= htmlspecialchars($plainte['message']) ?></td>
                    <td><?= htmlspecialchars($plainte['date_plainte']) ?></td>
                    <td>
                        <?= $plainte['visible'] == 1
                                ? '<span class="badge bg-success">Visible</span>'
                                : '<span class="badge bg-secondary">Masquée</span>' ?>
                    </td>
                    <td>
                        <?php if (isset($_SESSION['user']) && $plainte['utilisateur_id'] == $_SESSION['user']['id']): ?>
                            <a href="formulaire.php?id=<?= $plainte['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="plainte.php?delete=<?= $plainte['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Voulez-vous vraiment supprimer cette plainte ?');">
                                Supprimer
                            </a>
                            <?php if ($plainte['visible'] == 1): ?>
                                <a href="plainte.php?toggle=<?= $plainte['id'] ?>"
                                   class="btn btn-outline-secondary btn-sm">
                                    Rendre invisible
                                </a>
                            <?php else: ?>
                                <a href="plainte.php?toggle=<?= $plainte['id'] ?>"
                                   class="btn btn-outline-success btn-sm">
                                    Rendre visible
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted">Non autorisé</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (isset($_SESSION['user'])): ?>
            <button type="submit" name="delete_selected" class="btn btn-danger mt-2">
                Supprimer la sélection
            </button>
        <?php endif; ?>
    </form>
</div>
</body>
</html>

