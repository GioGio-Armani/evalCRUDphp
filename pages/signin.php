<?php require_once '../utils/header.php';

if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = $bdd->prepare('SELECT * FROM user WHERE username = :username');
    $query->bindValue(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();
    if (!empty($user)) {
        header('Location: /pages/signin.php?signin=error');
        exit();
    }

    $query = $bdd->prepare('INSERT INTO user (username, password) VALUES (:username, :password)');
    $query->bindValue(':username', $username, PDO::PARAM_STR);
    $query->bindValue(':password', $password, PDO::PARAM_STR);
    $query->execute();
    header('Location: /pages/login.php?signin=ok');
    exit();
}

?>

<h2>Inscription</h2>

<form action="#" method="post">
    <input type="text" name="username" id="username" placeholder="username">
    <input type="password" name="password" id="password" placeholder="Mot de passe">
    <input type="submit" value="S'inscrire">
</form>

<?php if (!empty($_GET['signin']) && $_GET['signin'] === 'error') {
    echo '<p>username déjà utilisé</p>';
} ?>

<?php require_once '../utils/footer.php'; ?>