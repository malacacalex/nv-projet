<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$usernamesave = isset($_POST['username']) ? $_POST['username'] : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Creation de compte - SAE61</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<table class="header">
<tr><td>
</td><td class="headerright">
</td></tr></table>
<table class="headerbottom"><tr><td>
</table>
<table class="pagecontent">
<tr><td><span class="longtext">
<h2 style="color: #003B5E;">Creation de compte</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <br>Votre username :<br>    
    <input type="text" name="username" id="username" required/>
    <br>Votre adresse mail :<br>
    <input type="email" name="adressemail" id="adressemail" required/>
    <br>Votre mot de passe :<br>
    <input type="password" name="password" id="password" minlength="6" maxlength="15" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[#%{}@]).{6,15}" required/>
    <br>
    <input type="submit" value="creation">
    <br>
    <a href="index.php" class="button">Page précédente</a>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $adressemail = $_POST["adressemail"];
    $password = $_POST["password"];

    // Générer un sel aléatoire
    $salt = generateSalt();

    // Concaténer le sel avec le mot de passe
    $hashed_password = md5($password . $salt);

    // Establish a database connection
    $conn = new mysqli("db", "user", "user", "test");  // Utiliser "db" comme hôte et "user" comme mot de passe

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user already exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND adressemail=?");
    $stmt->bind_param("ss", $username, $adressemail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Utilisateur existe déjà
        echo "L'utilisateur existe déjà";
    } else {
        // Utilisateur n'existe pas
        $stmt = $conn->prepare("INSERT INTO user (username, password, adressemail, salt) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $adressemail, $salt);

        if ($stmt->execute()) {
            echo "Utilisateur a été créé";
            echo "<a href='index.php' class='button'>Retour</a>";
        } else {
            echo "Erreur lors de la création de l'utilisateur: " . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
}

// Fonction pour générer un sel aléatoire
function generateSalt($length = 16) {
    return bin2hex(random_bytes($length));
}
?>
</span></td></tr>
</table>
</body

