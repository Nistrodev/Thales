<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'delete_subcategories'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = NO_PERMISSIONS;
    header("Location: admin.php");
    exit;
}

// Récupérer l'ID de la sous catégories à partir de la requête GET
$subcategories_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID de sous catégories n'a été spécifié, rediriger l'utilisateur vers la page de gestion des sous-catégories
if (!$subcategories_id) {
    $_SESSION['message-failed'] = NO_ID_SUBCATEGORIES;
    header("Location: gestion-sous-categories.php");
    exit;
}

// Récupérer les informations sur l'utilisateur à partir de la base de données
$sql = "SELECT * FROM subcategories WHERE id = $subcategories_id";
$result = mysqli_query($conn, $sql);
$subcategories = mysqli_fetch_assoc($result);

// Si la sous catégorie n'a pas été trouvé, redirige l'utilisateur vers la page de gestion des sous catégories
if (!$subcategories) {
    $_SESSION['message-failed'] = NO_SUBCATEGORIES;
    header("Location: gestion-sous-categories.php");
    exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Vérifie s'il reste des articles dans la sous-catégorie
    $sql = "SELECT COUNT(*) FROM articles WHERE subcategory_id = $subcategories_id";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_fetch_row($result)[0];

    if ($count > 0) {
        $_SESSION['message-failed'] = SUBCATEGORIES_DELETE_ARTICLES;
        header("Location: gestion-sous-categories.php");
        exit;
    }

    // Supprimer l'utilisateur de la base de données
    $sql = "DELETE FROM subcategories WHERE id = $subcategories_id";
    mysqli_query($conn, $sql);

    // Ajouter un message de réussite
    $_SESSION['message-success'] = SUBCATEGORIES_DELETE_SUCCESS;

    // Rediriger l'utilisateur vers la page de gestion des sous catégories
    header("Location: gestion-sous-categories.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thales - <?php echo SUBCATEGORIES_DELETE_TITLE?></title>
</head>

<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1><?php echo SUBCATEGORIES_DELETE_TITLE?></h1>

        <p><?php echo SUBCATEGORIES_DELETE_CONFIRM?> <strong><?php echo $subcategories["name"]; ?></strong> ?</p>

        <form action="supprimer-sous-categories.php?id=<?php echo $subcategories_id; ?>" method="post">
            <button type="submit" name="submit" class="btn btn-danger"><?php echo YES?></button>
            <a href="gestion-sous-categories.php" class="btn btn-secondary"><?php echo NO?></a>
        </form>
    </div>
</body>

</html>