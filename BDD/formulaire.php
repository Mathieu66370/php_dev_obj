<?php
require_once "bdd.php";
if (session_status() === PHP_SESSION_NONE) session_start();
include "header.php";

// L'utilisateur doit être connecté pour ajouter/éditer une plainte
if (!isset($_SESSION['user'])) {
    header("Location: connexion.php");
    exit();
}

$user = $_SESSION['user'];
$edit = false;
$plainte = [
        'nom' => '',
        'sujet' => '',
        'message' => '',
        'visible' => 1
];
$error = "";

// Si édition : vérifier que la plainte existe et appartient à l'utilisateur
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $bdd->prepare("SELECT * FROM plainte WHERE id = :id AND utilisateur_id = :uid LIMIT 1");
    $stmt->execute([':id' => $id, ':uid' => $user['id']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $edit = true;
        $plainte = $row;
    } else {
        // plainte non trouvée ou n'appartient pas à l'utilisateur
        $error = "Plainte introuvable ou accès refusé.";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $visible = isset($_POST['visible']) ? 1 : 0;

    if ($nom === '' || $sujet === '' || $message === '') {
        $error = "Veuillez remplir tous les champs.";
    } else {
        if ($edit) {
            // UPDATE — uniquement si la plainte appartient bien à l'utilisateur (sécurité)
            $sql = "UPDATE plainte
                    SET nom = :nom, sujet = :sujet, message = :message, visible = :visible
                    WHERE id = :id AND utilisateur_id = :uid";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([
                    ':nom' => $nom,
                    ':sujet' => $sujet,
                    ':message' => $message,
                    ':visible' => $visible,
                    ':id' => $id,
                    ':uid' => $user['id']
            ]);
        } else {
            // INSERT avec utilisateur_id
            $sql = "INSERT INTO plainte (nom, sujet, message, date_plainte, visible, utilisateur_id)
                    VALUES (:nom, :sujet, :message, NOW(), :visible, :uid)";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([
                    ':nom' => $nom,
                    ':sujet' => $sujet,
                    ':message' => $message,
                    ':visible' => $visible,
                    ':uid' => $user['id']
            ]);
        }

        header("Location: plainte.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $edit ? "Modifier la plainte" : "Ajouter une plainte" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1><?= $edit ? "Modifier la plainte" : "Ajouter une plainte" ?></h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="mt-3">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom complet :</label>
            <input type="text" id="nom" name="nom" required class="form-control"
                   value="<?= htmlspecialchars($plainte['nom'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="sujet" class="form-label">Sujet :</label>
            <input type="text" id="sujet" name="sujet" required class="form-control"
                   value="<?= htmlspecialchars($plainte['sujet'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message :</label>
            <textarea id="message" name="message" rows="5" required class="form-control"><?= htmlspecialchars($plainte['message'] ?? '') ?></textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" id="visible" name="visible" class="form-check-input"
                    <?= (isset($plainte['visible']) && $plainte['visible'] == 1) || !isset($plainte['visible']) ? 'checked' : '' ?>>
            <label for="visible" class="form-check-label">Visible</label>
        </div>

        <button type="submit" class="btn btn-dark"><?= $edit ? "Modifier la plainte" : "Envoyer la plainte" ?></button>
        <a href="plainte.php" class="btn btn-secondary">Retour à la liste</a>
    </form>
</div>
</body>
</html>




