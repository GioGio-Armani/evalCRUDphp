<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php?auth=error');
    exit();
}

require_once 'header.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $query = $bdd->prepare('DELETE FROM animal WHERE id = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    header('Location: /index.php?delete=ok');
    exit();
} else {
    header('Location: /index.php?delete=error');
    exit();
}


?>