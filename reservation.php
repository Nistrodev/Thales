<?php
// Importer la base de données
include 'config.php';

// Vérifie si l'utilisateur est connecté
if (!is_logged()) {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    $_SESSION['message-failed'] = NO_CONNECTED;
    header("Location: login.php");
    exit;
}

// Récupérer l'ID de l'article à partir de la requête GET
$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si aucun ID d'article n'a été spécifié, rediriger l'utilisateur vers la page d'accueil
if (!$article_id) {
    $_SESSION['message-failed'] = NO_ID_ARTICLES;
    header("Location: index.php");
    exit;
}

// Récupérer les informations sur l'article à partir de la base de données
$sql = "SELECT * FROM articles WHERE id = $article_id";
$result = mysqli_query($conn, $sql);
$article = mysqli_fetch_assoc($result);

// Si l'article n'a pas été trouvé, rediriger l'utilisateur vers la page d'accueil
if (!$article) {
    $_SESSION['message-failed'] = NO_ARTICLES;
    header("Location: index.php");
    exit;
}

// Si le formulaire de réservation a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $quantity = intval($_POST['quantity']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $user_id = $_SESSION['id'];
    $article_id = $article['id'];
    $status = "pending";

    // Ajouter la réservation dans la base de données
    $sql = "INSERT INTO reservations (quantity, start_date, end_date, user_id, article_id, status) VALUES ($quantity, '$start_date', '$end_date', $user_id, $article_id, '$status')";
    mysqli_query($conn, $sql);

    // Afficher un message de succès
    $_SESSION['message-success'] = RESERVATION_SUCCESS;

    // Rediriger l'utilisateur vers la page de réservations
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo RESERVATION_TITLE?></title>
</head>

<body>
    <!-- Barre de navigation -->
    <?php include "navbar.php"; ?>
    <!-- Contenu principal -->
    <div class="container mt-4">
        <!-- Contenu de la page -->
        <h1><?php echo RESERVATION_TITLE?> <?php echo $article['name']; ?></h1>
        <form action="reservation.php?id=<?php echo $article_id; ?>" method="post">
            <div class="form-group">
                <label for="quantity"><?php echo QUANTITY?></label>
                <input type="number" class="form-control" name="quantity" id="quantity" min="1" value="1" required>
            </div>
            <div class="form-group">
                <label for="start_date"><?php echo START_DATE?></label>
                <input type="date" class="form-control" name="start_date" id="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date"><?php echo END_DATE?></label>
                <input type="date" class="form-control" name="end_date" id="end_date" required>
            </div>
            <!-- Bouton de soumission -->
            <a href="index.php" class="btn btn-secondary"><?php echo RETOUR?></a>
            <button type="submit" name="submit" class="btn btn-primary"><?php echo RESERVE?></button>
        </form>
    </div>
</body>

</html>