<?php

include "includes/db.php";
include "includes/header.php";
include "includes/menu.php";

if (isset($_GET)) {
    $request = strtolower($_GET['search']);
};

$search = "%$request%";
$stmt = $pdo->prepare("SELECT * FROM films WHERE titre LIKE :search OR realisateur LIKE :search");
$stmt->bindValue(':search', $search, PDO::PARAM_STR);
$stmt->execute();
$films = $stmt->fetchAll();
$nbFilms = count($films);

?>

<div class="results__container">
    <h3 class="third__title results__title">Résultats de la recherche : <span class="italic__accent"><?= $nbFilms ?> résultats</span> </h3>
    <div class="results">
        <?php foreach ($films as $film): ?>
            <div class="results__movie">
                <h4><?= htmlspecialchars($film['titre']) ?></h4>
                <p class="results__feature italic__accent"><?= htmlspecialchars($film['realisateur']) ?></p>
                <p class="results__feature"><?= htmlspecialchars($film['annee']) ?></p>
                <p class="results__resume"><?= htmlspecialchars($film['resume']) ?></p>
                <a href="film.php?id=<?= htmlspecialchars($film["id"]) ?>" class="secondary__button">Plus de détails</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>