<?php

include "includes/db.php";
include "includes/header.php";
include "includes/menu.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    if (isset($films[$id])) {
        $film = $films[$id];
    } else {
        $erreur = "Film introuvable.";
    }
};

$filmId = $_GET['id'];

$sql = "SELECT * FROM films f INNER JOIN genres g ON f.genre_id = g.id WHERE f.id = $filmId;";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$films = $stmt->fetchAll();

?>

<div class="movie">
    <?php foreach ($films as $film): ?>
        <div class="movie__details">
            <h4><?= htmlspecialchars($film['titre']) ?></h4>
            <p class="movie__details__feature italic__accent"><?= htmlspecialchars($film['realisateur']) ?></p>
            <p class="movie__details__feature"><?= htmlspecialchars($film['annee']) ?></p>
            <p class="movie__details__feature--genre"><?= htmlspecialchars($film['nom']) ?></p>
            <p class="movie__details__resume"><?= htmlspecialchars($film['resume']) ?></p>
            <a href="index.php" class="secondary__button">Retour à l'accueil</a>
        </div>
    <?php endforeach; ?>
</div>