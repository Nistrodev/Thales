<?php

function is_logged()
{
    // Démarrer la session s'il n'est pas déjà fait
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Retourner vrai si la variable de session 'username' est définie, faux sinon
    return isset($_SESSION['username']);
}

function get_username()
{
    // Démarrer la session s'il n'est pas déjà fait
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Retourner le nom d'utilisateur de l'utilisateur connecté
    return isset($_SESSION['username']) ? $_SESSION['username'] : "";
}

function check_permission($conn, $permission)
{
    // Démarrer la session s'il n'est pas déjà fait
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Si l'utilisateur n'est pas connecté
    if (!isset($_SESSION['username'])) {
        return false;
    }

    // Récupération du nom d'utilisateur de l'utilisateur connecté
    $username = $_SESSION['username'];

    // Requête pour récupérer le rôle de l'utilisateur avec le nom d'utilisateur spécifié
    $sql = "SELECT role FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    // Si l'utilisateur existe
    if (mysqli_num_rows($result) == 1) {
        // Récupération du rôle de l'utilisateur
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];

        // Requête pour récupérer les permissions du rôle avec le nom de rôle spécifié
        $sql = "SELECT permissions FROM roles WHERE name = '$role'";
        $result = mysqli_query($conn, $sql);

        // Si le rôle existe
        if (mysqli_num_rows($result) == 1) {
            // Récupération des permissions du rôle
            $row = mysqli_fetch_assoc($result);
            $permissions = explode(";", $row['permissions']);

            // Vérifier si le rôle a la permission spécifiée
            return in_array($permission, $permissions);
        }

        // Si le rôle n'existe pas ou n'a pas la permission spécifiée, retourner faux
        return false;
    }

    // Fermeture de la connexion
    mysqli_close($conn);
}

function get_user_count($conn)
{
    $sql = "SELECT COUNT(*) AS count FROM users";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
    return 0;
}

function get_role_count($conn)
{
    $sql = "SELECT COUNT(DISTINCT name) AS count FROM roles";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
    return 0;
}
function get_categories_count($conn)
{
    $sql = "SELECT COUNT(*) AS count FROM categories";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
    return 0;
}
function get_subcategories_count($conn)
{
    $sql = "SELECT COUNT(*) AS count FROM subcategories";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
    return 0;
}
// Fonction pour récupérer toutes les permissions de la base de données
function get_permissions($conn)
{
    // Requête pour récupérer toutes les permissions
    $sql = "SELECT * FROM permissions";
    $result = mysqli_query($conn, $sql);

    // Créer un tableau vide
    $permissions = array();

    // Pour chaque permission dans la base de données
    while ($permission = mysqli_fetch_assoc($result)) {
        // Ajouter la permission au tableau
        $permissions[] = $permission;
    }

    // Retourner le tableau de permissions
    return $permissions;
}

function check_if_image_exists($conn, $file_name)
{
    $sql = "SELECT * FROM images WHERE file_name = '$file_name'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
