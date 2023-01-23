<?php
// Importer la base de données
include 'config.php';
include_once "navbar.php";
// Récupérer l'ID de l'utilisateur à partir de la requête GET
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID d'utilisateur n'a été spécifié, rediriger l'utilisateur vers la page de gestion des utilisateurs
if (!$user_id) {
    $_SESSION['message-failed'] = NO_ID_USERS;
    header("Location: gestion-utilisateurs.php");
    exit;
}

// Récupérer les informations sur l'utilisateur à partir de la base de données
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Si l'utilisateur n'a pas été trouvé, rediriger l'utilisateur vers la page de gestion des utilisateurs
if (!$user) {
    $_SESSION['message-failed'] = NO_USERS;
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
    <title>Thales - <?php echo USER_PROFILE?></title>
</head>

<body>
    <div class="container mt-4">
        <h1><?php echo USER_PROFILE?></h1>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo PROFIL_INFOS?></h4>
                <p><?php echo IDENTIFIANT?>
                    <?php echo $user['username']; ?>
                </p>
                <p><?php echo EMAIL?>
                    <?php echo $user['email']; ?>
                </p>
                <p><?php echo NB_CREDITS?>
                    <?php echo $user['credits']; ?>
                </p>
            </div>
            <a href="index.php" class="btn btn-secondary"><?php echo RETOUR?></a>
        </div>
    </div>
</body>

</html>