<?php require 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<?php

if (!empty($_POST) && isset($_POST['button__add'])) {

    $sql = "INSERT INTO films (
    titre,
    realisateur,
    annee,
    genre_id,
    resume

    ) VALUES (
    :titre,
    :realisateur,
    :annee,
    :genre_id,
    :resume
    );";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'titre' => $_POST['titre'],
        'realisateur' => $_POST['realisateur'],
        'annee' => $_POST['annee'],
        'genre_id' => $_POST['genre'],
        'resume' => $_POST['resume']
    ]);

    $index_url = "index.php";

    if ($_POST == true) {
        header("location:" . $index_url);
        exit();
    };
};

$films = $pdo->query("SELECT * FROM films f INNER JOIN genres g ON g.id = f.genre_id ORDER BY annee DESC")->fetchAll();
$genres = $pdo->query("SELECT * FROM genres")->fetchAll();

?>

</div>

<div class="add__movie">
    <h2 class="secondary__title">Ajouter un film</h2>
    <div class="add__movie__container">
        <form action="ajouter.php" method="post" class="add__movie__form">
            <div class="form__input">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre">
            </div>
            <div class="form__input">
                <label for="realisateur">Réalisateur</label>
                <input type="text" name="realisateur" id="realisateur">
            </div>
            <div class="form__input">
                <label for="annee">Année</label>
                <input type="text" name="annee" id="annee">
            </div>
            <div class="form__input">
                <label for="genre">Genre</label>
                <select name="genre" id="genre">
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= htmlspecialchars($genre["id"]) ?>"><?= htmlspecialchars($genre["nom"]) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form__input">
                <label for="resume">Résumé</label>
                <input type="text" name="resume" id="resume">
            </div>
            <button type="submit" name="button__add" class="primary__button">Ajouter</button>
            <a href="index.php" class="menu__link">Retour à l'accueil</a>
        </form>
    </div>
</div>