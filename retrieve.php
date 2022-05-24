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
<table class="table table-dark table-striped">
    <tr>
        <th>id</th>
        <th>Name</th>
        <th>Genre</th>
        <th>Filename</th>
        <th>Artist</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php foreach ($result as $row) { ?>
        <tr>
            <td><?php echo $row['id'] ?></td>

<!--            <td>--><?php //echo $row['filename'] ?><!-- </td>-->
            <td>
                <audio controls>
                    <source src='music/<?php echo $row['filename'] ?>'>
                </audio>

            </td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['genre'] ?></td>
            <td><?php echo $row['artistband'] ?></td>
            <td><a href="update.php?id=<?php echo $row['id'] ?>">Edit</a></td>
            <td><a href="delete.php?id=<?php echo $row['id'] ?>">Delete</a></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>