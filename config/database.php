<?php
// Connexion à la base de données
$host = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Créer la connexion
$conn = mysqli_connect($host, $username, $password, $dbname);
$sql = "SELECT * FROM users WHERE username = '$username'";

// Vérifier la connexion
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}
?>