<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des plaintes</title>
</head>
<body>
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
</body>
</html>
