<?php
require_once "bdd.php"; // Connexion PDO
if (session_status() === PHP_SESSION_NONE) session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'])); // minuscule + trim
    $motdepasse = trim($_POST['mot_de_passe']);

    // Récupération de l'utilisateur
    $stmt = $bdd->prepare("SELECT id, nom, email, mot_de_passe FROM utilisateurs WHERE LOWER(email) = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Nettoyage du hash pour supprimer tous caractères invisibles
        $storedHash = trim($user['mot_de_passe'], " \t\n\r\0\x0B");

        $isValid = false;

        // 1️⃣ Cas bcrypt
        if (password_verify($motdepasse, $storedHash)) {
            $isValid = true;
        }
        // 2️⃣ Cas ancien hash SHA256
        elseif (hash('sha256', $motdepasse) === $storedHash) {
            $isValid = true;
        }
        // 3️⃣ Cas mot de passe en clair (temporaire)
        elseif ($motdepasse === $storedHash) {
            $isValid = true;
        }

        if ($isValid) {
            // Connexion réussie : création de la session
            $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'email' => $user['email']
            ];

            header("Location: plainte.php");
            exit();
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    } else {
        $error = "Aucun compte trouvé avec cet email.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Connexion</h3>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                    </form>

                    <hr>
                    <a href="plainte.php" class="btn btn-secondary w-100">Retour à la liste des plaintes</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>


