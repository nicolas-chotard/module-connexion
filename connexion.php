<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="connexion.css">
    <title>Connexion</title>
</head>
<body>
<header>
    <h1>Bienvenue sur Mon Site</h1>
</header>

<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="connexion.php">Connexion</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="admin.php">Admin</a></li>
    </ul>
</nav>

<?php

$servername = 'localhost';
$username = 'root';
$password = '1234';
$dbname = 'moduleconnexion';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (!empty($login) && !empty($password)) {
        $query = "SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $_SESSION['loggedin'] = true;
            $_SESSION['login'] = $login;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Identifiants invalides. Veuillez réessayer.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

if (isset($error)) {
    echo '<p style="color: red;">' . $error . '</p>';
}
?>

<h1>Connexion</h1>

<form method="POST" action="connexion.php">
    <label for="login">Login:</label>
    <input type="text" id="login" name="login" required><br>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Se connecter">
</form>

<footer>
    <p>© 2023 Mon Site. Tous droits réservés.</p>
</footer>

</body>
</html>
