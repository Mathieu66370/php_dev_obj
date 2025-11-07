<?php
require_once "bdd.php"; // Inclusion du fichier de connexion à la base de données (via PDO)

// -----------------------------------------------------------
// 🔹 Vérification si on édite une plainte existante
// -----------------------------------------------------------
$edit = false; // Par défaut, on est en mode "ajout"

if (isset($_GET['id'])) { // Si l'URL contient un paramètre "id"
    $id = (int)$_GET['id']; // On le convertit en entier (sécurité)

    // Prépare la requête pour récupérer la plainte correspondante
    $stmt = $bdd->prepare("SELECT * FROM plainte WHERE id = :id");
    $stmt->execute([':id' => $id]); // Liaison sécurisée du paramètre
    $plainte = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère la plainte sous forme de tableau associatif

    if ($plainte) {
        $edit = true; // Si une plainte est trouvée, on passe en mode "édition"
    }
}

// -----------------------------------------------------------
// 🔹 Traitement du formulaire (ajout ou modification)
// -----------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") { // Si le formulaire est soumis en méthode POST
    $nom = trim($_POST["nom"]); // Nettoie le champ nom (supprime espaces inutiles)
    $sujet = trim($_POST["sujet"]); // Nettoie le champ sujet
    $message = trim($_POST["message"]); // Nettoie le champ message
    $visible = isset($_POST["visible"]) ? 1 : 0; // Convertit la case à cocher en 1 ou 0

    // Vérifie que tous les champs sont remplis
    if (!empty($nom) && !empty($sujet) && !empty($message)) {
        if ($edit) {
            // -----------------------------------------------------------
            // ✏️ Si on modifie une plainte existante → UPDATE
            // -----------------------------------------------------------
            $sql = "UPDATE plainte 
                    SET nom = :nom, sujet = :sujet, message = :message, visible = :visible 
                    WHERE id = :id";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':sujet' => $sujet,
                ':message' => $message,
                ':visible' => $visible,
                ':id' => $id
            ]);
        } else {
            // -----------------------------------------------------------
            // 🆕 Si on ajoute une nouvelle plainte → INSERT
            // -----------------------------------------------------------
            $sql = "INSERT INTO plainte (nom, sujet, message, date_plainte, visible)
                    VALUES (:nom, :sujet, :message, NOW(), :visible)";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':sujet' => $sujet,
                ':message' => $message,
                ':visible' => $visible
            ]);
        }

        // Après ajout ou modification → redirection vers la liste
        header("Location: plainte.php");
        exit();
    } else {
        // Si au moins un champ est vide, on affiche un message d'erreur
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Titre dynamique : dépend si on ajoute ou modifie -->
    <title><?= $edit ? "Modifier la plainte" : "Ajouter une plainte" ?></title>

    <!-- Lien vers Bootstrap (pour le design) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <!-- Titre principal -->
    <h1><?= $edit ? "Modifier la plainte" : "Ajouter une plainte" ?></h1>

    <!-- Message d'erreur s'il existe -->
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>

    <!-- Formulaire d'ajout ou de modification -->
    <form method="post" class="mt-3">

        <!-- Champ nom -->
        <div class="mb-3">
            <label for="nom" class="form-label">Nom complet :</label>
            <input type="text" id="nom" name="nom" required class="form-control"
                   value="<?= $edit ? htmlspecialchars($plainte['nom']) : '' ?>">
            <!-- Si on édite, le champ est pré-rempli -->
        </div>

        <!-- Champ sujet -->
        <div class="mb-3">
            <label for="sujet" class="form-label">Sujet :</label>
            <input type="text" id="sujet" name="sujet" required class="form-control"
                   value="<?= $edit ? htmlspecialchars($plainte['sujet']) : '' ?>">
        </div>

        <!-- Champ message -->
        <div class="mb-3">
            <label for="message" class="form-label">Message :</label>
            <textarea id="message" name="message" rows="5" required class="form-control"><?= $edit ? htmlspecialchars($plainte['message']) : '' ?></textarea>
        </div>

        <!-- Case à cocher "Visible" -->
        <div class="form-check mb-3">
            <!-- ⚠️ Ici, la condition est erronée : la case est toujours cochée -->
            <!-- Pour corriger : <?= $edit && $plainte['visible'] == 1 ? 'checked' : '' ?> -->
            <input type="checkbox" id="visible" name="visible" class="form-check-input" <?= $edit && $plainte['visible'] == 1 ? 'checked' : 'checked' ?>>
            <label for="visible" class="form-check-label">Visible</label>
        </div>

        <!-- Boutons -->
        <button type="submit" class="btn btn-dark"><?= $edit ? "Modifier la plainte" : "Envoyer la plainte" ?></button>

        <!-- Bouton de retour vers la liste -->
        <!-- ⚠️ Le lien actuel redirige vers "editPlainte.php" → il faudrait sûrement "plainte.php" -->
        <a href="editPlainte.php" class="btn btn-secondary">Retour à la liste</a>
    </form>
</div>
</body>
</html>





