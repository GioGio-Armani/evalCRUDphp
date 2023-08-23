<?php
require_once __DIR__ . '/../db/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZooColliders</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <h1>ZooColliders</h1>
    </header>

    <main>

        <nav>
            <ul>
                <li><a href="/">Accueil</a></li>
                <?php if (!empty($_SESSION['user'])) {
                    echo '<li><a href="/pages/add_animal.php">Ajouter un animal</a></li>';
                    echo '<li><a href="/pages/update_user.php?id=' . $_SESSION['user'] . '">Modifier mon compte</a></li>';
                    echo '<li><a href="/utils/logout.php">logout</a></li>';
                } else { ?>
                <li><a href="/pages/login.php">Login</a></li>
                <li><a href="/pages/signin.php">Sign in</a></li>
                <?php } ?>
            </ul>
        </nav>