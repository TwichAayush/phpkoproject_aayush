<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Select Genre</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <form class="form" method="POST">
        <select name="genres[]" multiple  class="login-input" style="height: 100%;">
            <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    $genres = $_POST['genres'];
                    $_SESSION['genres'] = $genres;

                    header('Location: index.php');
                }

                $sql = "SELECT DISTINCT genre FROM songs;";

                include "db.php";

                $res = mysqli_query($con, $sql);

                for ($i = 0; $i < mysqli_num_rows($res); $i++){

                    $row = mysqli_fetch_assoc($res);
                    $genre = $row['genre'];
                    echo "<option value='$genre'>$genre</options>";
                }
            ?>
        </select>

        <button class="login-button">Select Genre</button>

        <?php
            if (isset($_SESSION['genres'])){
                echo '<p><a href="index.php">Back</a>';
            }
        ?>
    </form>

</body>
</html>