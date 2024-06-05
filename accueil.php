<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if the username is set in the session
$usernamesave = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Redirect to login page if username is not set
if (empty($usernamesave)) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil SAE61</title>
    <style>
        /* Ajoutez vos styles CSS ici */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }

        .headerbottom {
            /* Ajoutez les styles de l'en-tête inférieur ici */
        }

        .pagecontent {
            padding: 20px;
        }

        .longtext {
            color: #003B5E;
        }
    </style>
</head>
<body>
    <table class="header">
        <tr><td></td><td class="headerright"></td></tr>
    </table>
    <table class="headerbottom"><tr><td></td></table>
    <table class="pagecontent">
        <tr><td><span class="longtext">
            <h2>Accueil SAE61</h2>
            <br>
            <?php echo "Bonjour $usernamesave"; ?>
        </span></td></tr>
    </table>
</body>
</html>

