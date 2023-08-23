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
    <div class="message">
        <?php
        if (isset($_GET['update']) && $_GET['update'] == 'ok') {
            echo '<p class="success">Animal Modifié</p>';
        }
        if (isset($_GET['update']) && $_GET['update'] == 'error') {
            echo '<p class="error">Une erreur est arrivé</p>';
        }
        if (isset($_GET['delete']) && $_GET['delete'] == 'ok') {
            echo '<p class="success">Animal Supprimé</p>';
        }
        if (isset($_GET['delete']) && $_GET['delete'] == 'error') {
            echo '<p class="error">Une erreur est arrivé</p>';
        }
        if (isset($_GET['auth']) && $_GET['auth'] == 'error') {
            echo '<p class="error">Vous n\'êtes pas authorisé</p>';
        }
        if (isset($_GET['deleteuser']) && $_GET['deleteuser'] == 'ok') {
            echo '<p class="success">utilisateur supprimer</p>';
        }
        ?>
    </div>

    <div class="cards">
        <?php
        if (!empty($_POST['search'])) {
            if (!empty($animauxSearch)) {
                foreach ($animauxSearch as $animal) {
                    if (!empty($animal['date_de_naissance'])) {
                        $date_naissance = new DateTimeImmutable($animal['date_de_naissance']);
                    }
                    ?>
        <div class="card">
            <div class="card__img">
                <img src="<?= $animal['photo'] ?>" alt="<?= $animal['nom'] ?>">
            </div>
            <div class="card__content">
                <h3>
                    <?= $animal['nom'] ?>
                </h3>
                <p>
                    <?= $animal['espece'] ?>
                </p>
                <p>
                    Date de naissance:
                    <?= ($animal['date_de_naissance'] !== null) ? $animal['date_de_naissance'] : 'Non renseigné' ?>
                </p>
                <p>
                    <?= $animal['histoire'] ?>
                </p>
            </div>
            <div class="lien">
                <a href="/pages/animal.php?id=<?= $animal['id'] ?>">Voir plus</a>
                <?php
                            if (!empty($_SESSION['user'])) {
                                ?>
                <a href="/pages/update_animal.php?id=<?= $animal['id'] ?>">&#10000;</a>
                <a href="/utils/delete_animal.php?id=<?= $animal['id'] ?>">&#10006;</a>
                <?php
                            }
                            ?>
            </div>


        </div>
        <?php
                }
            } else {
                echo '<p>Aucun animal trouvé</p>';

            }

        } else {
            $query = $bdd->prepare('SELECT * FROM animal');
            $query->execute();
            $animaux = $query->fetchAll();
            $date_naissance = null;
            foreach ($animaux as $animal) {
                if (!empty($animal['date_de_naissance'])) {
                    $date_naissance = new DateTimeImmutable($animal['date_de_naissance']);
                }
                ?>
        <div class="card">
            <div class="card__img">
                <img src="<?= $animal['photo'] ?>" alt="<?= $animal['nom'] ?>">
            </div>
            <div class="card__content">
                <h3>
                    <?= $animal['nom'] ?>
                </h3>
                <p>
                    <?= $animal['espece'] ?>
                </p>
                <p>
                    naissance:
                    <?= ($animal['date_de_naissance'] !== null) ? $animal['date_de_naissance'] : 'Non renseigné' ?>
                </p>
                <p>
                    <?= $animal['histoire'] ?>
                </p>
            </div>
            <div class="lien">
                <a href="/pages/animal.php?id=<?= $animal['id'] ?>">Voir plus</a>
                <?php
                        if (!empty($_SESSION['user'])) {
                            ?>
                <a href="/pages/update_animal.php?id=<?= $animal['id'] ?>">&#10000;</a>
                <a href="/utils/delete_animal.php?id=<?= $animal['id'] ?>">&#10006;</a>
                <?php
                        }
                        ?>
            </div>


        </div>
        <?php
            }
        }
        ?>
    </div>
</section>
<?php require_once './utils/footer.php'; ?>