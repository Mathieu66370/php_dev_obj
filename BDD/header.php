<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <!-- 🔹 Le lien vers la liste des plaintes stylisé comme un bouton -->
        <a href="plainte.php" class="btn btn-outline-light btn-sm me-3">
            Gestion des plaintes
        </a>

        <div class="d-flex">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="navbar-text text-white me-3">
                    Bonjour, <?= htmlspecialchars($_SESSION['user']['nom']) ?>
                </span>
                <a href="profil.php" class="btn btn-outline-info btn-sm me-2">Mon profil</a>
                <a href="deco.php" class="btn btn-outline-light btn-sm">Déconnexion</a>
            <?php else: ?>
                <a href="connexion.php" class="btn btn-outline-light btn-sm">Connexion</a>
            <?php endif; ?>
        </div>
    </div>
</nav>



