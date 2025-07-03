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
        $nbFilmsPages = 5;
        $allFilms = $pdo->query("SELECT * FROM films;")->fetchAll();
        $films = $pdo->query("SELECT f.id AS film_id, f.titre, f.realisateur, f.annee, f.resume, g.nom AS genre_nom FROM films f INNER JOIN genres g ON g.id = f.genre_id ORDER BY annee DESC LIMIT $nbFilmsPages")->fetchAll();
        $countFilms = count($allFilms);
        $nbPages = [];
        $countPages = $countFilms / $nbFilmsPages;
        for ($i = 1; $i <= ceil($countPages); $i++) {
            array_push($nbPages, $i);
        };
        foreach ($films as $film):
        ?>
            <tr>
                <td><a href="film.php?id=<?= htmlspecialchars($film["film_id"]) ?>" class="movie__link"><?= htmlspecialchars($film['titre']) ?></a></td>
                <td><?= htmlspecialchars($film['realisateur']) ?></td>
                <td><?= $film['annee'] ?></td>
                <td><?= htmlspecialchars($film['genre_nom']) ?></td>
                <td>
                    <a href="modifier.php?id=<?= htmlspecialchars($film['film_id']) ?>" class="primary__button">Modifier</a>
                    <a href="supprimer.php?id=<?= htmlspecialchars($film['film_id']) ?>" class="secondary__button" onclick="return confirm('Supprimer ce film ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="pagination">
        <?php foreach ($nbPages as $page): ?>
            <a href="index.php?page=<?= htmlspecialchars($page) ?>" class="pagination__link"><?= htmlspecialchars($page) ?></a>
        <?php endforeach; ?>
    </div>
    <a href="ajouter.php" class="primary__button">➕ Ajouter un film</a>

</div>

<?php include 'includes/footer.php'; ?>