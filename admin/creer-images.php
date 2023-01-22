<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'add_images'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
    header("Location: admin.php");
    exit;
}

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $file_name = $_FILES['image']['name'];
    $file_temp = $_FILES['image']['tmp_name'];
    $file_path = "../uploads/" . $file_name;
    move_uploaded_file($file_temp, $file_path);

    // Vérifie si le nom d'image existe déjà
    if (check_if_image_exists($conn, $name)) {
        echo '<p class="text-danger text-center">Ce nom d\'image existe déjà, veuillez en choisir un autre.</p>';
    } else {
        $sql = "INSERT INTO `images`(`name`, `file_name`, `file_path`) VALUES ('$name', '$file_name', '$file_path')";
        mysqli_query($conn, $sql);
        $_SESSION['message-success'] = "Image ajouté avec succès";
        // Rediriger l'utilisateur vers la page de gestion des catégories
        header("Location: gestion-images.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thales - Ajout d'images</title>
</head>

<body>
    <!-- Barre de navigation -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1>Ajout d'image</h1>
        <form action="creer-images.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" name="name" id="name" required>
                <label for="image">Image</label>
                <input type="file" class="form-control-file" name="image" id="image" accept="image/*" required>
            </div>
            <p class="error" style="display:none"></p>
            <!-- Bouton de soumission -->
            <a href="gestion-images.php" class="btn btn-secondary">Retour</a>
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>

</html>