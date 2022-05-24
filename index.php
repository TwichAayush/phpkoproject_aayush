<?php

   session_start();

    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }

    if (!isset($_SESSION['genres']))
    {
        header('Location: genre.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="form" style="width: 50%;">
        <p>Hey, <?php echo $_SESSION['user']['username']; ?>! &nbsp;
        <a href="genre.php">Reselect Genres</a>&nbsp;
        <a href="create.php">create music</a>&nbsp;
        <a href="card_list.php">List music</a>&nbsp;

            <a href="logout.php">Logout</a>&nbsp;</p>
        <br><br>
        <?php

            $sql = "SELECT * FROM songs WHERE ";

            foreach($_SESSION['genres'] as $i => $genre)
            {
                if ($i == 0){
                    $sql = $sql . "genre = '$genre' ";
                }else {
                    $sql = $sql . "OR genre = '$genre' ";
                }
                
            }
            $sql = $sql . ";";
            
            include "db.php";

            $res = mysqli_query($con, $sql);

            if (mysqli_num_rows($res) == 0)
            {
                echo "<p>Could not find any songs</p>";
            }

            for ($i = 0; $i < mysqli_num_rows($res); $i++)
            {
                $row = mysqli_fetch_assoc($res);
                $name = $row["name"];
                $genre = $row['genre'];
                $artistband = $row["artistband"];
                $filename = $row['filename'];
                echo "
                <p> $name | $genre</p>
                <p>
                <audio controls>
                    <source src='music/$filename'>
                </audio></p>";
            }
        ?>
    
    </div>
</body>
</html>
