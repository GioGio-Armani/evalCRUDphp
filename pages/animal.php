<?php require_once '../utils/header.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $query = $bdd->prepare('SELECT * FROM animal WHERE id = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $animal = $query->fetch();
}
var_dump($animal['photo'])

    ?>

<section>
    <h2>
        <?php echo $animal['nom']; ?>
    </h2>

    <img src="<?php echo $animal['photo']; ?>" alt="<?php echo $animal['nom']; ?>">
    <p>
        <?php echo $animal['date_de_naissance']; ?>
    </p>
    <p>
        <?php echo $animal['poids'];
        if (!empty($animal['poids'])) {
            echo ' kg';
        }
        ?>
    </p>
    <p>
        <?php echo $animal['espece']; ?>
    </p>
    <p>
        <?php echo $animal['histoire']; ?>
    </p>
    <?php if (!empty($_SESSION['user'])) { ?>
    <a href="/pages/update_animal.php?id=<?php echo $animal['id']; ?>">Modifier</a>
    <a href="/utils/delete_animal.php?id=<?php echo $animal['id']; ?>">Supprimer</a>
    <?php } ?>
</section>

<?php require_once '../utils/footer.php'; ?>