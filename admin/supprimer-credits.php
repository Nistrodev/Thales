<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'delete_credits'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = NO_PERMISSIONS;
    header("Location: admin.php");
    exit;
  }

// Récupérer l'ID de l'utilisateur à partir de la requête GET
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID d'utilisateur n'a été spécifié, rediriger l'utilisateur vers la page de gestion des credits
if (!$user_id) {
    $_SESSION['message-failed'] = NO_ID_USERS;
   header("Location: gestion-credits.php");
   exit;
}

// Récupérer les informations sur l'utilisateur à partir de la base de données
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Si l'utilisateur n'a pas été trouvé, rediriger l'utilisateur vers la page de gestion des credits
if (!$user) {
    $_SESSION['message-failed'] = NO_USERS;
   header("Location: gestion-credits.php");
   exit;
}


// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Supprimer l'utilisateur de la base de données
    $sql = "UPDATE users SET credits= '0' WHERE id='$user_id'";
    mysqli_query($conn, $sql);

    // Ajouter un message de réussite
   $_SESSION['message-success'] = CREDITS_DELETE_SUCCESS;

    // Rediriger l'utilisateur vers la page de gestion des crédits
    header("Location: gestion-credits.php");
    exit;
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thales - <?php echo CREDITS_DELETE_TITLE?></title>
</head>
<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1><?php echo CREDITS_DELETE_TITLE?></h1>

        <p><?php echo CREDITS_DELETE_CONFIRM?> <strong><?php echo $user["username"]; ?></strong> ?</p>

        <form action="supprimer-credits.php?id=<?php echo $user_id; ?>" method="post">
            <button type="submit" name="submit" class="btn btn-danger"><?php echo YES?></button>
            <a href="gestion-credits.php" class="btn btn-secondary"><?php echo NO?></a>
        </form>
    </div>
</body>
</html>