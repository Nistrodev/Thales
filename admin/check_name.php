<?php
    require_once '../config.php';
    $name = $_POST["name"];
    $sql = "SELECT * FROM images WHERE name='$name'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        echo "exists";
    } else {
        echo "not exists";
    }
?>
