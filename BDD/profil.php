<?php
require_once "bdd.php";
if (session_status() === PHP_SESSION_NONE) session_start();
include "header.php";

if (!isset($_SESSION['user'])) {
    header("Location: connexion.php");
    exit();
}

$user = $_SESSION['user'];

// Récupérer les plaintes liées à cet utilisateur via utilisateur_id
$stmt = $bdd->prepare("SELECT * FROM plainte WHERE utilisateur_id = :id ORDER BY date_plainte DESC");
$stmt->execute([':id' => $user['id']]);
$plaintes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">Mon profil</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Informations personnelles</h5>
            <p><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>

            <div class="d-flex gap-2 mt-3">
                <a href="formulaire.php" class="btn btn-primary">Déposer une nouvelle plainte</a>
                <!-- 🔹 Nouveau bouton -->
                <a href="plainte.php" class="btn btn-secondary">Voir la liste des plaintes</a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Mes plaintes</h5>

            <?php if (!empty($plaintes)): ?>
                <table class="table table-striped mt-3">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Sujet</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($plaintes as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['id']) ?></td>
                            <td><?= htmlspecialchars($p['sujet']) ?></td>
                            <td><?= htmlspecialchars($p['message']) ?></td>
                            <td><?= htmlspecialchars($p['date_plainte']) ?></td>
                            <td>
                                <?= $p['visible'] == 1
                                    ? '<span class="badge bg-success">Visible</span>'
                                    : '<span class="badge bg-secondary">Masquée</span>' ?>
                            </td>
                            <td>
                                <a href="formulaire.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="plainte.php?delete=<?= $p['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Voulez-vous vraiment supprimer cette plainte ?');">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted mt-3">Vous n’avez déposé aucune plainte pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>

