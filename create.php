<?php

session_start();

if (!isset($_SESSION['user']))
{
    header('Location: login.php');
}

// if ($_SESSION['user']['username'] != 'aayush')
// {
//     header('Location: index.php');
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Music</title>
    <link rel="stylesheet" href="style.css"/>
        <style>
    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }
</style>

</head>
<body>
    
    <form class="form" method="POST" enctype="multipart/form-data">
        <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                include "db.php";

                $name = $_POST['name'];
                $genre = $_POST['genre'];
                $artistband = $_POST['artistband'];

                if ( (!$_FILES['music']['error']) ){

                    $filename = hash('sha256', rand()) . ".mp3";
                    move_uploaded_file($_FILES['music']['tmp_name'], "music/$filename");
                    $temp_name=$_FILES['image']['tmp_name'];
                    $imagename=$_FILES['image']['name'];
                    $folder = "upload/".$imagename;
                    if (move_uploaded_file($temp_name, $folder))  {
                        $msg = "Image uploaded successfully";
                    }else{
                        $msg = "Failed to upload image";
                    }

                    $sql = "INSERT INTO songs(name, genre, artistband, filename, image) VALUES ('$name', '$genre', '$artistband', '$filename', '$imagename')";

                    mysqli_query($con, $sql);

                    echo "<br><p>Uploaded Sucessfully !</p><br>";
                }else {
                    echo "<br><p>Cannot upload the music !</p><br>";
                }

            }
        ?>
        <input class="login-input" name="name" placeholder="Song Name" required/>
        <input class="login-input" name="genre" placeholder="Song Genre" required/>
        <input class="login-input" name="artistband" placeholder="Artist/Band" required/>
        <label class="custom-file-upload">
            HHEHE
        <input class="login-button" type="file" name="image" value="My lady" required/>
        </label>
        
        <label class="custom-file-upload">
            Browse Music
            <input type="file" class="login-button" name="music" required/>
        </label>

        <input class="login-button" type="submit" value="Upload Music" style="margin-top: 5%;">
    
        <p><a href="index.php">Back</a>

    </form>
</body>
</html>
