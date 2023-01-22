<?php
// Importer le fihcier de config
require_once '../config.php';
// Vérifie si l'utilisateur a la permission de voir la page
if ((!check_permission($conn, 'view_admin_panel'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thales - Panel administrateur</title>
</head>

<body>
    <!-- Import la sidebar -->
    <?php include "navbar-admin.php" ?>

    <div class="container mt-4">


        <div class="alert alert-secondary" role="alert">
            <div class="row d-flex align-items-center justify-content-between">
                <div id="total-users" class="col-auto text-secondary font-weight-bold">Nombre total d'utilisateurs : <?php echo get_user_count($conn); ?></div>
                <div class="col-auto">
                    <?php if ((check_permission($conn, 'manage_users'))) { ?>
                        <a href="gestion-utilisateurs.php" class="btn btn-primary">Gérer les utilisateurs</a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="alert alert-secondary" role="alert">
            <div class="row d-flex justify-content-between">
                <div id="total-users" class="col-auto text-secondary font-weight-bold">Nombre total de rôles : <?php echo get_role_count($conn); ?></div>
                <div class="col-auto">
                    <?php if ((check_permission($conn, 'manage_roles'))) { ?>
                        <a href="gestion-roles.php" class="btn btn-primary">Gérer les rôles</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="alert alert-secondary" role="alert">
            <div class="row d-flex justify-content-between">
                <div id="total-users" class="col-auto text-secondary font-weight-bold">Nombre total de catégories : <?php echo get_categories_count($conn); ?></div>
                <div class="col-auto">
                    <?php if ((check_permission($conn, 'manage_categories'))) { ?>
                        <a href="gestion-categories.php" class="btn btn-primary">Gérer les catégories</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="alert alert-secondary" role="alert">
            <div class="row d-flex justify-content-between">
                <div id="total-users" class="col-auto text-secondary font-weight-bold">Nombre total de sous-catégories : <?php echo get_subcategories_count($conn); ?></div>
                <div class="col-auto">
                    <?php if ((check_permission($conn, 'manage_subcategories'))) { ?>
                        <a href="gestion-sous-categories.php" class="btn btn-primary">Gérer les sous-catégories</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


</body>

</html>