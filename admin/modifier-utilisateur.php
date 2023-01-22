<?php
// Importer la base de données
include '../config.php';

// Vérifie si l'utilisateur à la permission de voir la page
if (!(check_permission($conn, 'modify_users'))) {
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


// Si le formulaire a été soumis
if (isset($_POST['submit'])) {
   // Récupérer les données du formulaire
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $credits = intval($_POST['credits']);
   $role = mysqli_real_escape_string($conn, $_POST['role']);

   if (empty($password)){
      if (empty($role)){
          $sql = "UPDATE users SET username = '$username', email = '$email', credits = $credits WHERE id = $user_id";
      } else {
        $sql = "UPDATE users SET username = '$username', email = '$email', credits = $credits, role = '$role' WHERE id = $user_id";
      }
    } else {
        // Hacher le mot de passe
        $password = password_hash($password, PASSWORD_DEFAULT);
        if (empty($role)){
            $sql = "UPDATE users SET username = '$username', password = '$password', email = '$email', credits = $credits WHERE id = $user_id";
        } else {
            $sql = "UPDATE users SET username = '$username', password = '$password', email = '$email', credits = $credits, role = '$role' WHERE id = $user_id";
        }
    }

    mysqli_query($conn, $sql);
    // Ajouter un message de réussite
    $_SESSION['message-success'] = "L'utilisateur à été modifié avec succès.";

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
    <title>Thales - Modifier un utilisateur</title>
</head>

<body>
    <!-- Sidebar -->
    <?php include "navbar-admin.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1>Modifier un utilisateur</h1>
        <form action="modifier-utilisateur.php?id=<?php echo $user_id; ?>" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Laissez vide pour ne pas changer">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
            </div>
            <div class="form-group">
                <label for="credits">Crédits</label>
                <input type="number" class="form-control" id="credits" name="credits" value="<?php echo $user['credits']; ?>">
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select class="form-control" id="role" name="role" value="user">
                    <!-- Afficher les rôles disponibles -->
                    <option value="" selected disabled hidden>Choissisez un rôle</option>
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
            <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</body>
</html>