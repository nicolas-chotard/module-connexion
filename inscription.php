<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inscription.css">
    <title>Inscription</title>
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lastname = $_POST["nom"];
    $firstname = $_POST["prenom"];
    $login = $_POST["login"];
    $password = $_POST["mot_de_passe"];
    $password_confirm = $_POST["mot_de_passe_confirm"];


    if ($password !== $password_confirm) {
        echo "Les mots de passe ne correspondent pas.";
    } else {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
            echo "Le mot de passe doit contenir au moins huit caractères, une majuscule, un chiffre et un caractère spécial.";
        } else {

            $query = "SELECT * FROM user WHERE login = '$login'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "Ce login est déjà utilisé. Veuillez en choisir un autre.";
            } else {

                $query = "INSERT INTO user (lastname, firstname, login, password) VALUES ('$lastname', '$firstname', '$login', '$password')";
                if (mysqli_query($conn, $query)) {
                    header("Location: connexion.php");
                    exit();
                } else {
                    echo "Erreur lors de l'inscription : " . mysqli_error($conn);
                }
            }
        }
    }
}

?>

<h2>Inscription</h2>

<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" required><br>

    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" required><br>

    <label for="login">Login :</label>
    <input type="text" name="login" required><br>

    <label for="mot_de_passe">Mot de passe :</label>
    <input type="password" name="mot_de_passe" required><br>
    
    <label for="mot_de_passe_confirm">Confirmer le mot de passe :</label>
    <input type="password" name="mot_de_passe_confirm" required><br>
    
    <input type="submit" value="Submit">

</form>

<footer>
    <p>© 2023 Mon Site. Tous droits réservés.</p>
</footer>

</body>
</html>