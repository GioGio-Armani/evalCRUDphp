<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php?auth=error');
    exit();
}
require_once '../utils/header.php';


if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $query = $bdd->prepare('SELECT * FROM animal WHERE id = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $animal = $query->fetch();
    if (!empty($animal)) {
        if (isset($_POST['nom']) && !empty($_POST['nom'])) {
            $destinationPath = __DIR__ . '/../images/';
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath);
            }
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $ancienCheminImage = __DIR__ . '/..' . $animal['photo'];
                if (!empty($animal['photo'])) {
                    if (file_exists($ancienCheminImage)) {
                        unlink($ancienCheminImage);
                    }
                }
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
            $query = $bdd->prepare('UPDATE animal SET nom = :nom, poids = :poids, espece = :espece, histoire = :histoire, photo = :photo, date_de_naissance = :date_de_naissance WHERE id = :id');
            $query->bindValue(':nom', $nom, PDO::PARAM_STR);
            $query->bindValue(':id', $_GET['id'], PDO::PARAM_STR);

            if (!empty($poids)) {
                if (is_numeric($poids)) {
                    $query->bindValue(':poids', $poids, PDO::PARAM_STR);
                } else {
                    echo 'Le poids doit être un nombre';
                    exit();
                }
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
                $query->bindValue(':photo', $animal['photo'], PDO::PARAM_STR);
            }
            if (!empty($dateDeNaissance)) {
                $query->bindValue(':date_de_naissance', $dateDeNaissance);
            } else {
                $query->bindValue(':date_de_naissance', null, PDO::PARAM_NULL);
            }
            $query->execute();
            header('Location: /index.php?update=ok');
            exit();
        }
    } else {
        header('Location: /index.php?update=error');
        exit();
    }
}
?>

<section>
    <h2>Modifier un animal</h2>
    <form action="#" method="post" enctype="multipart/form-data">
        <input type="text" name="nom" id="nom" placeholder="nom de animal" value="<?php echo $animal['nom']; ?>">
        <label for="dateDeNaissance">Date de naissance</label>
        <input type="date" name="dateDeNaissance" id="dateDeNaissance"
            value="<?php echo $animal['date_de_naissance'] ?>">
        <input type="text" name="poids" id="poids" placeholder="Poids (en kg)" value="<?php echo $animal['poids']; ?>">
        <input type="text" name="espece" id="espece" placeholder="Espèce" value="<?php echo $animal['espece']; ?>">
        <textarea name="histoire" id="histoire" cols="30" rows="10"
            placeholder="Histoire de animal"><?php echo $animal['histoire']; ?></textarea>
        <label for="photo">Photo</label>
        <input type="file" name="photo" id="photo">
        <input type="submit" value="Modifier">
    </form>
</section>

<?php require_once '../utils/footer.php'; ?>