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
<h2 style="color: #003B5E;">Accueil SAE61</h2>
<br>
<?php echo "Bonjour $usernamesave"; ?>
</span></td></tr>
</table>
</body>
</html>
