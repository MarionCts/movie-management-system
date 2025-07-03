<?php

include "includes/db.php";
include "includes/header.php";
include "includes/menu.php";

$sql = "SELECT * FROM films WHERE id = :id;";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $_GET['id']]);

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

<div class="update__movie">
    <h2 class="secondary__title">Modifier un film</h2>

    <div class="update__text">
        <h3>Vous modifiez le film :</h3>
        <div class="update__text__infos">
            <h5><?= htmlspecialchars($film["titre"]); ?></h5>
        </div>
    </div>

    <form action="modifier.php?id=<?= htmlspecialchars($filmId) ?>" method="post" class="update__form">
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
        <button type="submit" name="button__update" class="primary__button">Modifier</button>
        <a href="index.php" class="menu__link">Retour à l'accueil</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>