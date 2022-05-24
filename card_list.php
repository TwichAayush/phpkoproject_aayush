<?php
require_once "db.php";
$sql = "SELECT * FROM songs";
$result = mysqli_query($con, $sql)
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css"/>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

    <?php foreach ($result as $row) { ?>
        <div class="card" style="width: 25rem;">
            <img src="upload/<?php echo $row['image']?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['name'] ?></h5>
                <p class="card-text"><?php echo $row['genre'] ?></p>
                <?php echo $row['artistband'] ?>
                <div style="{ width: 50px; }">
                <audio controls >
                    <source src='music/<?php echo $row['filename'] ?>' >
                </audio>

                </div>
                <a href="update.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">Delete
           </a>
            </div>
        </div>
    <?php } ?>
