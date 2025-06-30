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

?>

<?php include 'includes/header.php'; ?>