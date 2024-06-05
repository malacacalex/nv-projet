<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $adressemail = trim($_POST["adressemail"]);
    $password = trim($_POST["password"]);

    // If the username or password is blank then return FALSE.
    if (empty($username) || empty($password)) {
        echo "Username or password cannot be empty";
        return FALSE;
    }

    // Get the salt and hashed password from the database.
    $conn = mysqli_connect("db", "user", "user", "test"); // Utiliser "db" comme hôte et "user" comme mot de passe
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = mysqli_prepare($conn, "SELECT password, salt FROM user WHERE username=? AND adressemail=?");
    mysqli_stmt_bind_param($query, "ss", $username, $adressemail);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $storedHash = $row['password'];
        $salt = $row['salt'];

        // Combine password with salt and hash it.
        $combinedPassword = $password . $salt;
        $hashedPassword = md5($combinedPassword);

        // If the hashed password matches the stored hash, log the user in.
        if ($storedHash === $hashedPassword) {
            $_SESSION['username'] = $username;
            header('Location: accueil.php');
            exit();
        } else {
            echo "Utilisateur, adresse mail ou mot de passe incorrect";
        }
    } else {
        echo "Utilisateur, adresse mail ou mot de passe incorrect";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connection - SAE61</title>
    <style>
        /* Styles CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .button {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .button:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Page d'authentification pour la SAE61</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <br>Votre username :<br>
        <input type="text" name="username" id="username"/>
        <br>Votre adressemail :<br>
        <input type="text" name="adressemail" id="adressemail"/>
        <br>Votre mot de passe :<br>
        <input type="password" name="password" id="password"/>
        <br>
        <input type="submit" value="Connection">
        <a href="creation_compte.php" class="button">Pas de compte ? Appuyer pour en créer un !</a>
    </form>
</body>
</html>

