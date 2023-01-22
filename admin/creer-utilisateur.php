<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'create_users'))) {
    // L'utilisateur n'a pas la permission, redirigez-le vers une autre page
    $_SESSION['message-failed'] = "Vous n'avez pas la permission de voir cette page.";
    header("Location: admin.php");
    exit;
  }

// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
   // Récupérer les données du formulaire
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $credits = intval($_POST['credits']);
   $role = mysqli_real_escape_string($conn, $_POST['role']);

   // Hacher le mot de passe
   $password = password_hash($password, PASSWORD_DEFAULT);

   // Insérer l'utilisateur dans la base de données
   $sql = "INSERT INTO users (username, password, email, credits, role) VALUES ('$username', '$password', '$email', '$credits', '$role')";
   mysqli_query($conn, $sql);

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
    <title>Thales - Créer un utilisateur</title>
</head>

<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1>Créer un utilisateur</h1>
        <form action="creer-utilisateur.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="credits">Crédits</label>
                <input type="number" class="form-control" id="credits" name="credits" value="0" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select class="form-control" id="role" name="role" required>
                <option value="" selected disabled hidden>Choissisez un rôle</option>
                    <!-- Afficher les rôles disponibles -->
                    <?php
                    $sql = "SELECT * FROM roles";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <a href="gestion-utilisateurs.php" class="btn btn-secondary">Retour</a>
            <button type="submit" name="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>
</body>
</html>