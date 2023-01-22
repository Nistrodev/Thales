<?php
// Importer la base de données
include 'config.php';
include_once "navbar.php";
// Récupérer l'ID de l'utilisateur à partir de la requête GET
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID d'utilisateur n'a été spécifié, rediriger l'utilisateur vers la page de gestion des utilisateurs
if (!$user_id) {
   header("Location: gestion-utilisateurs.php");
   exit;
}

// Récupérer les informations sur l'utilisateur à partir de la base de données
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Si l'utilisateur n'a pas été trouvé, rediriger l'utilisateur vers la page de gestion des utilisateurs
if (!$user) {
   header("Location: gestion-utilisateurs.php");
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thales - Profil utilisateur</title>
</head>

<body>
    <div class="container mt-4">
        <h1>Profil utilisateur</h1>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informations de compte</h4>
                <p>Identifiant :
                    <?php echo $user['username']; ?>
                </p>
                <p>Adresse e-mail :
                    <?php echo $user['email']; ?>
                </p>
                <p>Nombre de crédits :
                    <?php echo $user['credits']; ?>
                </p>
            </div>
            <a href="index.php" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</body>

</html>