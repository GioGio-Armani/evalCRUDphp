<?php require_once '../utils/header.php';

if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $query = $bdd->prepare('SELECT * FROM user WHERE username = :username');
    $query->bindValue(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();
    if (empty($user)) {
        header('Location: /pages/login.php?login=error');
        exit();
    }
    if (password_verify($_POST['password'], $user['password'])) {
        session_start();
        $_SESSION['user'] = $user['id'];
        header('Location: /');
        exit();
    } else {
        header('Location: /pages/login.php?login=error');
        exit();
    }
}

?>

<h2>Connexion</h2>
<?php
if (!empty($_GET['signin']) && $_GET['signin'] === 'ok') {
    echo '<p>Vous êtes bien inscrit</p>';
}
if (!empty($_GET['login']) && $_GET['login'] === 'error') {
    echo '<p>Identifiants incorrects ou n\'éxiste pas</p>';
}
?>

<form action="#" method="post">
    <input type="text" name="username" id="username" placeholder="username">
    <input type="password" name="password" id="password" placeholder="Mot de passe">
    <input type="submit" value="Se connecter">
</form>

<?php require_once '../utils/footer.php'; ?>