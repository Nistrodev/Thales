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
    $file_name = mysqli_real_escape_string($conn, $_POST['name']);
    $file_temp = $_FILES['image']['tmp_name'];
    $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $file_name = $file_name . '.' . $file_ext;
    if(check_if_image_exists($conn, $file_name)) {
        $_SESSION['message-success'] = "Ce nom d'image existe déjà, veuillez en choisir un autre.";
    } else {
        move_uploaded_file($file_temp, "../uploads/" . $file_name);
        $file_path = "../uploads/" . $file_name;
        $sql = "INSERT INTO `images`(`file_name`, `file_path`) VALUES ('$file_name', '$file_path')";
        mysqli_query($conn, $sql);
        $_SESSION['message-success'] = "Add";
        header("Location: gestion-images.php");
        exit;
    }
}
 else {
    $_SESSION['message-success'] = "Not add";
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
                <input type="file" class="form-control-file" name="image" id="image" required>
            </div>
            <!-- Bouton de soumission -->
            <a href="gestion-images.php" class="btn btn-secondary">Retour</a>
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Ajouter</button>
            <div id="file_name_error"></div>

        </form>

    </div>

</body>

</html>

<!-- Message de notification -->
<?php if ((isset($_SESSION['message-success'])) || (isset($_SESSION['message-failed']))) {
    if (isset($_SESSION['message-success'])) { ?>
        <div class="alert alert-success alert-dismissible fixed-bottom mr-5" role="alert">
            <?php echo $_SESSION['message-success']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php $_SESSION['message-success'] = null; ?>
    <?php }; ?>
<?php }; ?>