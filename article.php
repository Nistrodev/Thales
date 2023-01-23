<?php
// Inclusion du fichier de configuration de la base de données
require_once "config.php";

$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$article_id) {
    $_SESSION['message-failed'] = NO_ID_ARTICLES;
   header("Location: index.php");
   exit;
}

// Requête pour récupérer les détails de l'article
$article_query = "SELECT * FROM articles WHERE id = $article_id";
$article_result = mysqli_query($conn, $article_query);
$article = mysqli_fetch_assoc($article_result);

if (!$article_result) {
    echo ERROR_MYSQL . mysqli_error($conn);
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Thales - <?php echo $article['name']; ?></title>
</head>

<body>

    <!-- Include navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $article['image']; ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h1><?php echo $article['name']; ?></h1>
                <p><?php echo $article['description']; ?></p>
                <p><?php echo PRICE ?> <?php echo $article['price']; ?> €</p>
                <p><?php echo CATEGORIES ?> <?php echo $subcategory['name']; ?></p>
                <button class="btn btn-secondary" onclick="location.href='categorie.php?id=<?php echo $subcategory['id'] ?>'"><?php echo RETOUR?></button>
                <button class="btn btn-primary" onclick="location.href='reservation.php?id=<?php echo $article['id']?>'"><?php echo RESERVE?></button>
            </div>
        </div>
    </div>

    <?php require_once "footer.php"; ?>
</body>

</html>
