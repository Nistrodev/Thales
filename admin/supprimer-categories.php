<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'delete_categories'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = NO_PERMISSIONS;
    header("Location: admin.php");
    exit;
}

// Récupérer l'ID de la sous catégories à partir de la requête GET
$categories_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID de sous catégories n'a été spécifié, rediriger l'utilisateur vers la page de gestion des sous-catégories
if (!$categories_id) {
    $_SESSION['message-failed'] = NO_ID_SUBCATEGORIES;
    header("Location: gestion-categories.php");
    exit;
}


// Récupérer les informations sur l'utilisateur à partir de la base de données
$sql = "SELECT * FROM categories WHERE id = $categories_id";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_assoc($result);

// Si la sous catégorie n'a pas été trouvé, redirige l'utilisateur vers la page de gestion des sous catégories
if (!$categories) {
    $_SESSION['message-failed'] = NO_SUBCATEGORIES;
    header("Location: gestion-categories.php");
    exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Vérifier si la catégorie contient des sous-catégories
    $sql = "SELECT COUNT(*) as count FROM subcategories WHERE parent_id = $categories_id";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_fetch_assoc($result)['count'];

    // Si il reste des sous-catégories dans la catégorie, afficher un message d'erreur
    if ($count > 0) {
        $_SESSION['message-failed'] = CATEGORIES_DELETE_CONTAINS_SUBCATEGORIES;
        header("Location: gestion-categories.php");
        exit;
    }

    // Supprimer l'utilisateur de la base de données
    $sql = "DELETE FROM categories WHERE id = $categories_id";
    mysqli_query($conn, $sql);

    // Ajouter un message de réussite
    $_SESSION['message-success'] = CATEGORIES_DELETE_SUCCESS;

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
    <title>Thales - <?php echo CATEGORIES_DELETE_TITLE?></title>
</head>

<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1><?php echo CATEGORIES_DELETE_TITLE?></h1>

        <p><?php echo CATEGORIES_DELETE_CONFIRM?> <strong><?php echo $categories["name"]; ?></strong> ?</p>

        <form action="supprimer-categories.php?id=<?php echo $categories_id; ?>" method="post">
            <button type="submit" name="submit" class="btn btn-danger"><?php echo YES?></button>
            <a href="gestion-categories.php" class="btn btn-secondary"><?php echo NO?></a>
        </form>
    </div>
</body>

</html>