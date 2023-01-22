<?php
// Démarrer la session
session_start();

// Inclusion du fichier config.php
require_once "config.php";
require_once "navbar.php";

// Si l'utilisateur est déjà connecté, redirige vers la page d'accueil
if (is_logged()) {
    // Redirection vers la page protégée
    header("Location: index.php");
    exit;
}

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Requête pour récupérer l'utilisateur avec le nom d'utilisateur spécifié
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    // Si l'utilisateur existe
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Vérification du mot de passe
        if (password_verify($password, $user['password'])) {
            // Connexion réussie
            // Enregistrer le nom d'utilisateur dans la variable de session
            $_SESSION['username'] = $username;

            // Redirection vers la page protégée
            header("Location: index.php");
            exit;
        } else {
            // Mot de passe incorrect
            // Afficher un message d'erreur
            $error = "Nom d'utilisateur ou mot de passe incorrect";
        }
    }
}
    ?>
    <div class="container mt-5">
    <h1>Connexion</h1>
    <?php if (isset($error)) { ?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
    <?php } ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Identifiant</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

    <?php

if (isset($error)) {
    echo $error;
}

// Fermeture de la connexion
mysqli_close($conn);

?>