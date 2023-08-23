<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php?auth=error');
    exit();
}
require_once '../utils/header.php';


if (isset($_POST['nom']) && !empty($_POST['nom'])) {
    $destinationPath = __DIR__ . '/../images/';
    if (!is_dir($destinationPath)) {
        mkdir($destinationPath);
    }
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_POST['nom'] . '_' . time() . '_' . $_FILES['photo']['name'];
        $destinationFile = $destinationPath . $fileName;
        $photo = '/images/' . $fileName;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $destinationFile)) {
        } else {
            echo 'Erreur lors de l\'upload';
        }
    }
    $nom = $_POST['nom'];
    $dateDeNaissance = $_POST['dateDeNaissance'];
    $poids = $_POST['poids'];
    $espece = $_POST['espece'];
    $histoire = $_POST['histoire'];

    $query = $bdd->prepare('INSERT INTO animal (nom, poids, espece, histoire, photo, date_de_naissance ) VALUES (:nom, :poids, :espece, :histoire, :photo, :date_de_naissance)');

    $query->bindValue(':nom', $nom, PDO::PARAM_STR);

    if (!empty($poids)) {
        $query->bindValue(':poids', $poids, PDO::PARAM_INT);
    } else {
        $query->bindValue(':poids', null, PDO::PARAM_NULL);
    }

    if (!empty($espece)) {
        $query->bindValue(':espece', $espece, PDO::PARAM_STR);
    } else {
        $query->bindValue(':espece', null, PDO::PARAM_NULL);
    }

    if (!empty($histoire)) {
        $query->bindValue(':histoire', $histoire, PDO::PARAM_STR);
    } else {
        $query->bindValue(':histoire', null, PDO::PARAM_NULL);
    }

    if (!empty($photo)) {
        $query->bindValue(':photo', $photo, PDO::PARAM_STR);
    } else {
        $query->bindValue(':photo', null, PDO::PARAM_NULL);
    }
    if (!empty($dateDeNaissance)) {
        $query->bindValue(':date_de_naissance', $dateDeNaissance);
    } else {
        $query->bindValue(':date_de_naissance', null, PDO::PARAM_NULL);
    }

    $query->execute();

    header('Location: /');
    exit();
}
?>
<section>
    <h2>Ajouter un animal</h2>
    <form action="#" method="post" enctype="multipart/form-data">
        <input type="text" name="nom" id="nom" placeholder="Nom de l'animal">
        <label for="dateDeNaissance">Date de naissance</label>
        <input type="date" name="dateDeNaissance" id="dateDeNaissance">
        <input type="number" name="poids" id="poids" placeholder="Poids (en kg)">
        <input type="text" name="espece" id="espece" placeholder="Son espèce">
        <textarea name="histoire" id="histoire" cols="30" rows="10" placeholder="Histoire de l'animal"></textarea>
        <label for="photo">Photo</label>
        <input type="file" name="photo" id="photo">
        <input type="submit" value="Ajouter">
    </form>
</section>

<?php require_once '../utils/footer.php'; ?>