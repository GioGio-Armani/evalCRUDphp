<?php
require_once './utils/header.php';
if (!empty($_POST['search'])) {
    $search = $_POST['search'];
    $query = $bdd->prepare('SELECT * FROM animal WHERE nom LIKE :search');
    $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $query->execute();
    $animauxSearch = $query->fetchAll();
}
?>
<section>
    <h2>Répertoire de vos animaux</h2>

    <form action="#" method="post">
        <input type="text" name="search" id="search" placeholder="Rechercher un animal">
        <input type="submit" value="Rechercher">
        <?php if (!empty($_POST['search'])) {
            echo '<a href="/">Annuler la recherche</a>';
        } ?>
    </form>

    <?php
    if (isset($_GET['update']) && $_GET['update'] == 'ok') {
        echo '<p>Animal Modifié</p>';
    }
    if (isset($_GET['update']) && $_GET['update'] == 'error') {
        echo '<p>Une erreur est arrivé</p>';
    }
    if (isset($_GET['delete']) && $_GET['delete'] == 'ok') {
        echo '<p>Animal Supprimé</p>';
    }
    if (isset($_GET['delete']) && $_GET['delete'] == 'error') {
        echo '<p>Une erreur est arrivé</p>';
    }
    if (isset($_GET['auth']) && $_GET['auth'] == 'error') {
        echo '<p>Vous n\'êtes pas authorisé</p>';
    }
    if (isset($_GET['deleteuser']) && $_GET['deleteuser'] == 'ok') {
        echo '<p>utilisateur supprimer</p>';
    }
    ?>

    <ul>
        <?php
        if (!empty($_POST['search'])) {
            if (!empty($animauxSearch)) {
                foreach ($animauxSearch as $animal) {
                    echo '<li>' . $animal['nom'] . '<a href="/pages/animal.php?id=' . $animal['id'] . '">+</a></li>';
                    if (!empty($_SESSION['user'])) {
                        echo '<a href="/pages/update_animal.php?id=' . $animal['id'] . '">&#10000;</a><a href="/utils/delete_animal.php?id=' . $animal['id'] . '">&#10006;</a>';
                    }
                }
            } else {
                echo '<p>Aucun animal trouvé</p>';
            }
        } else {
            $query = $bdd->prepare('SELECT * FROM animal');
            $query->execute();
            $animaux = $query->fetchAll();
            foreach ($animaux as $animal) {
                echo '<li>' . $animal['nom'] . '<a href="/pages/animal.php?id=' . $animal['id'] . '">+</a></li>';
                if (!empty($_SESSION['user'])) {
                    echo '<a href="/pages/update_animal.php?id=' . $animal['id'] . '">&#10000;</a><a href="/utils/delete_animal.php?id=' . $animal['id'] . '">&#10006;</a>';
                }
            }
        }
        ?>
    </ul>
</section>
<?php require_once './utils/footer.php'; ?>