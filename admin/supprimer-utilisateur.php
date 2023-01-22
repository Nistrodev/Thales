<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'delete_users'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
    header("Location: admin.php");
    exit;
  }

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

// Ne pas permettre la suppression de l'utilisateur "admin"
if ($user['username'] == 'admin') {
   // Rediriger l'utilisateur vers la page de gestion des utilisateurs
   header("Location: gestion-utilisateurs.php");
   exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Supprimer l'utilisateur de la base de données
    $sql = "DELETE FROM users WHERE id = $user_id";
    mysqli_query($conn, $sql);

    // Ajouter un message de réussite
   $_SESSION['message-success'] = "L'utilisateur à été supprimé avec succès.";

    // Rediriger l'utilisateur vers la page de gestion des utilisateurs
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
    <title>Thales - Supprimer un utilisateur</title>
</head>
<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1>Supprimer un utilisateur</h1>

        <p>Êtes-vous sûr de vouloir supprimer l'utilisateur <strong><?php echo $user["username"]; ?></strong> ?</p>

        <form action="supprimer-utilisateur.php?id=<?php echo $user_id; ?>" method="post">
            <button type="submit" name="submit" class="btn btn-danger">Oui</button>
            <a href="gestion-utilisateurs.php" class="btn btn-secondary">Non</a>
        </form>
    </div>
</body>
</html>