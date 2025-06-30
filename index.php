<?php require 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>
<?php include 'includes/hero.php'; ?>

<div class="movies__list__container">
    <h2 class="secondary__title">Liste des films</h2>
    <table class="movies__list">
        <tr class="table__header">
            <th>Titre</th>
            <th>Réalisateur</th>
            <th>Année</th>
            <th>Genre</th>
            <th>Actions</th>
        </tr>

        <?php
        $films = $pdo->query("SELECT f.id AS film_id, f.titre, f.realisateur, f.annee, f.resume, g.nom AS genre_nom FROM films f INNER JOIN genres g ON g.id = f.genre_id ORDER BY annee DESC")->fetchAll();
        foreach ($films as $film):
        ?>
            <tr>
                <td><?= htmlspecialchars($film['titre']) ?></td>
                <td><?= htmlspecialchars($film['realisateur']) ?></td>
                <td><?= $film['annee'] ?></td>
                <td><?= htmlspecialchars($film['genre_nom']) ?></td>
                <td>
                    <a href="modifier.php?id=<?= htmlspecialchars($film['film_id']) ?>" class="primary__button">Modifier</a>
                    <a href="supprimer.php?id=<?= htmlspecialchars($film['film_id']) ?>" class="primary__button" onclick="return confirm('Supprimer ce film ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="ajouter.php" class="primary__button">➕ Ajouter un film</a>

</div>

<?php include 'includes/footer.php'; ?>