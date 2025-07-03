<?php 

include "includes/db.php";

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

if ($filmId) {

    $sql = "DELETE FROM films
    WHERE id = :id;";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'id' => $filmId
    ]);
};

$index_url = "index.php";

header("location:" .$index_url);
        exit();

?>