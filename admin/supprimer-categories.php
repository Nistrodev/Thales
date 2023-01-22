<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'delete_categories'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
    header("Location: admin.php");
    exit;
  }

// Récupérer l'ID de la sous catégories à partir de la requête GET
$categories_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID de sous catégories n'a été spécifié, rediriger l'utilisateur vers la page de gestion des sous-catégories
if (!$categories_id) {
   header("Location: gestion-categories.php");
   exit;
}


// Récupérer les informations sur l'utilisateur à partir de la base de données
$sql = "SELECT * FROM categories WHERE id = $categories_id";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_assoc($result);

// Si la sous catégorie n'a pas été trouvé, redirige l'utilisateur vers la page de gestion des sous catégories
if (!$categories) {
   header("Location: gestion-categories.php");
   exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Supprimer l'utilisateur de la base de données
    $sql = "DELETE FROM categories WHERE id = $categories_id";
    mysqli_query($conn, $sql);

    // Ajouter un message de réussite
   $_SESSION['message-success'] = "La catégorie à été supprimé avec succès.";

    // Rediriger l'utilisateur vers la page de gestion des sous catégories
    header("Location: gestion-categories.php");
    exit;
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thales - Supprimer une catégorie</title>
</head>
<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1>Supprimer une catégorie</h1>

        <p>Êtes-vous sûr de vouloir supprimer la catégorie <strong><?php echo $categories["name"]; ?></strong> ?</p>

        <form action="supprimer-categories.php?id=<?php echo $categories_id; ?>" method="post">
            <button type="submit" name="submit" class="btn btn-danger">Oui</button>
            <a href="gestion-categories.php" class="btn btn-secondary">Non</a>
        </form>
    </div>
</body>
</html>