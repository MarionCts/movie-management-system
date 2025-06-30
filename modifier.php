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

if (!empty($_POST) && isset($_POST['button__update']) && isset($filmId)) {

    $sql = "UPDATE films
    SET titre = :titre,
    realisateur = :realisateur,
    annee = :annee,
    genre_id = :genre_id,
    resume = :resume
    WHERE id = :id;";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'titre' => $_POST['titre'],
        'realisateur' => $_POST['realisateur'],
        'annee' => $_POST['annee'],
        'genre_id' => (int) $_POST['genre'],
        'resume' => $_POST['resume'],
        'id' => $filmId
    ]);

    $index_url = "index.php";

    if ($_POST == true) {
        header("location:" . $index_url);
        exit();
    };
};

$films = $pdo->query("SELECT * FROM films f INNER JOIN genres g ON g.id = f.genre_id ORDER BY annee DESC")->fetchAll();
$film = $pdo->query("SELECT * FROM films f INNER JOIN genres g ON g.id = f.genre_id WHERE f.id = $filmId")->fetch();
$genres = $pdo->query("SELECT * FROM genres")->fetchAll();

?>

<h1>Modifier un film</h1>

<div class="update__text">
    <h3>Vous modifiez le film :</h3>
    <div class="update__text__infos">
        <h5>Titre :</h5>
                <p><?= htmlspecialchars($film["titre"]); ?></p>
    </div>
    <div class="update__text__infos">
        <h5>Réalisateur :</h5>
                <p><?= htmlspecialchars($film["realisateur"]); ?></p>
    </div>
    <div class="update__text__infos">
        <h5>Année :</h5>
                <p><?= htmlspecialchars($film["annee"]); ?></p>
    </div>
    <div class="update__text__infos">
        <h5>Genre :</h5>
                <p><?= htmlspecialchars($film["nom"]); ?></p>
    </div>
    <div class="update__text__infos">
        <h5>Résumé :</h5>
                <p><?= htmlspecialchars($film["resume"]); ?></p>
    </div>
</div>

<form action="modifier.php?id=<?= htmlspecialchars($filmId) ?>" method="post">
    <div class="form__input">
        <label for="nouveau__titre">Nouveau titre :</label>
        <input type="text" name="titre" id="titre" value="<?= $film["titre"] ?>">
    </div>
    <div class="form__input">
        <label for="nouveau__realisateur">Nouveau réalisateur :</label>
        <input type="text" name="realisateur" id="realisateur" value="<?= $film["realisateur"] ?>">
    </div>
    <div class="form__input">
        <label for="nouvelle__annee">Nouvelle année :</label>
        <input type="text" name="annee" id="annee" value="<?= $film["annee"] ?>">
    </div>
    <div class="form__input">
        <label for="nouveau__genre">Nouveau genre :</label>
        <select name="genre" id="genre">
            <?php foreach ($genres as $genre): ?>
                <option value="<?= htmlspecialchars($genre["id"]) ?>"><?= htmlspecialchars($genre["nom"]) ?></option>
                <?php endforeach; ?>
        </select>
    </div>
    <div class="form__input">
        <label for="nouveau__resume">Nouveau résumé :</label>
        <input type="text" name="resume" id="resume" value="<?= $film["resume"] ?>">
    </div>
    <button type="submit" name="button__update">Modifier</button>
</form>

<a href="index.php">Retour à l'accueil</a>

<?php include 'includes/header.php'; ?>