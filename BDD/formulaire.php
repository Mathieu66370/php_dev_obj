<?php
require_once "bdd.php"; // Inclusion du fichier de connexion à la base de données (PDO)

// Vérifier si on édite une plainte existante
$edit = false; // Par défaut, on est en mode ajout
if (isset($_GET['id'])) { // Si un ID est présent dans l'URL
    $id = (int)$_GET['id']; // On force l'ID en entier (sécurité)
    $stmt = $bdd->prepare("SELECT * FROM plainte WHERE id = :id"); // Préparation de la requête SQL
    $stmt->execute([':id' => $id]); // Exécution avec liaison du paramètre
    $plainte = $stmt->fetch(PDO::FETCH_ASSOC); // Récupération de la plainte sous forme de tableau associatif
    if ($plainte) {
        $edit = true; // Si la plainte existe, on passe en mode "édition"
    }
}

// Traitement du formulaire (ajout ou modification)
if ($_SERVER["REQUEST_METHOD"] === "POST") { // Vérifie si le formulaire a été soumis en POST
    $nom = trim($_POST["nom"]); // Récupère le nom en supprimant les espaces
    $sujet = trim($_POST["sujet"]); // Récupère le sujet
    $message = trim($_POST["message"]); // Récupère le message
    $visible = isset($_POST["visible"]) ? 1 : 0; // Si la case "visible" est cochée → 1 sinon 0

    // Vérifie que tous les champs obligatoires sont remplis
    if (!empty($nom) && !empty($sujet) && !empty($message)) {
        if ($edit) {
            // Si on édite une plainte existante → mise à jour
            $sql = "UPDATE plainte SET nom=:nom, sujet=:sujet, message=:message, visible=:visible WHERE id=:id";
            $stmt = $bdd->prepare($sql); // Préparation de la requête
            $stmt->execute([
                    ':nom' => $nom,
                    ':sujet' => $sujet,
                    ':message' => $message,
                    ':visible' => $visible,
                    ':id' => $id
            ]); // Exécution avec les paramètres
        } else {
            // Si on ajoute une nouvelle plainte → insertion
            $sql = "INSERT INTO plainte (nom, sujet, message, date_plainte, visible)
                    VALUES (:nom, :sujet, :message, NOW(), :visible)";
            $stmt = $bdd->prepare($sql); // Préparation de la requête
            $stmt->execute([
                    ':nom' => $nom,
                    ':sujet' => $sujet,
                    ':message' => $message,
                    ':visible' => $visible
            ]); // Exécution avec les paramètres
        }

        // Une fois l'opération terminée → redirection vers la liste des plaintes
        header("Location: plainte.php");
        exit();
    } else {
        // Si des champs sont vides → message d’erreur
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $edit ? "Modifier la plainte" : "Ajouter une plainte" ?></title>
    <!-- Lien vers Bootstrap pour le style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <!-- Titre dynamique selon le mode -->
    <h1><?= $edit ? "Modifier la plainte" : "Ajouter une plainte" ?></h1>

    <!-- Affichage du message d'erreur s'il existe -->
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>

    <!-- Formulaire d'ajout ou de modification -->
    <form method="post" class="mt-3">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom complet :</label>
            <input type="text" id="nom" name="nom" required class="form-control"
                   value="<?= $edit ? htmlspecialchars($plainte['nom']) : '' ?>">
            <!-- Si on édite, on préremplit avec la valeur existante -->
        </div>

        <div class="mb-3">
            <label for="sujet" class="form-label">Sujet :</label>
            <input type="text" id="sujet" name="sujet" required class="form-control"
                   value="<?= $edit ? htmlspecialchars($plainte['sujet']) : '' ?>">
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message :</label>
            <textarea id="message" name="message" rows="5" required class="form-control"><?= $edit ? htmlspecialchars($plainte['message']) : '' ?></textarea>
        </div>

        <!-- Case à cocher pour la visibilité -->
        <div class="form-check mb-3">
            <input type="checkbox" id="visible" name="visible" class="form-check-input"
                    <?= $edit && $plainte['visible'] == 1 ? 'checked' : 'checked' ?>>
            <!-- Remarque : ici la case est toujours cochée par défaut ('checked' est présent dans les deux cas) -->
            <label for="visible" class="form-check-label">Visible</label>
        </div>

        <!-- Boutons -->
        <button type="submit" class="btn btn-dark"><?= $edit ? "Modifier la plainte" : "Envoyer la plainte" ?></button>
        <a href="plainte.php" class="btn btn-secondary">Retour à la liste</a>
    </form>
</div>
</body>
</html>





