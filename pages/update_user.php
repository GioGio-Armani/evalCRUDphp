<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php?auth=error');
    exit();
}
require_once '../utils/header.php';

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $query = $bdd->prepare('SELECT * FROM user WHERE id = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $user = $query->fetch();
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $username = $_POST['username'];
        $query = $bdd->prepare('SELECT * FROM user WHERE username = :username');
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch();
        if (!empty($user)) {
            header('Location: /pages/update_user.php?update=error');
            exit();
        }
        $query = $bdd->prepare('UPDATE user SET username = :username WHERE id = :id');
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query = $bdd->prepare('UPDATE user SET password = :password WHERE id = :id');
            $query->bindValue(':password', $password, PDO::PARAM_STR);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
        }
        header('Location: /index.php?update=ok');
        exit();
    }
}

?>

<h2>Modifier mon compte</h2>

<form action="#" method="post">
    <input type="text" name="username" id="username" placeholder="username" value="<?php $user['username'] ?>">
    <input type="password" name="password" id="password" placeholder="Mot de passe">
    <input type="submit" value="Modifier">
</form>
<a href="/utils/delete_user.php?id=<?php echo $_SESSION['user'] ?>">Supprimer mon compte</a>

<?php if (!empty($_GET['update']) && $_GET['update'] === 'error') {
    echo '<p>username déjà utilisé</p>';
} ?>

<?php require_once '../utils/footer.php'; ?>