<?php
// Include config file
require_once "db.php";

//Define variables and initialize with empty values
$id = $name = $genre = $filename =$artistband = $image = "";
$id_err = $name_err = $genre_err = $filename_err =$artistband_err = $image_err = "";
// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    echo "1";

// Get hidden input value
    $id = $_POST["id"];
    $temp_name = $_FILES['image']['tmp_name'];
    $filename = $_FILES['image']['name'];
    $folder = "upload/" . $filename;


//Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $first_name_err = "Please enter a name";
        echo "Please enter a  name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name";
        echo "Please enter a valid name";
    } else {
        $name = $input_name;
    }

//Validate genre
    $input_genre= trim($_POST["genre_name"]);
    if (empty($input_genre)) {
        $genre_err = "Please enter a genre";
        echo "Please enter a genre.";
    } elseif (!filter_var($input_genre, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $genre_err = "Please enter a valid genre";
        echo "Please enter a valid genre name";

    } else {
        $genre = $input_genre;
    }
//Validate artistband
$input_artistband= trim($_POST["artistband_name"]);
if (empty($input_artistband)) {
    $artistband_err = "Please enter a artistband";
    echo "Please enter a artistband.";
} elseif (!filter_var($input_artistband, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
    $artistband_err = "Please enter a valid artistband";
    echo "Please enter a valid artistband name";

} else {
    $artistband = $input_artistband;
}

// Check input errors before inserting in database
    if (empty($name_err) && empty($genre_err) && empty($filename_err) && empty($artistband_err)) {
        echo "2";
        // Prepare an update statement
        if ($filename == "") {
            $sql = "UPDATE songs SET name=?, genre=?, image=?, artistband=? WHERE id=?";
            if ($stmt = mysqli_prepare($con, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssi", $param_name, $param_ganre, $param_filename, $param_artistband, $param_id);

                // Set parameters
                $param_name = $name;
                $param_genre = $genre;
                $param_filename = $filename;
                $param_artistband = $artistband;
                $param_id = $id;
            }
        } else {
            $sql = "UPDATE songs SET name=?, genre=?, filename=?, artistband=? WHERE id=?";
            if ($stmt = mysqli_prepare($con, $sql)) {

                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssi", $param_name, $param_ganre, $param_filename, $param_artistband, $param_id);
                // Set parameters
                $param_name = $name;
                $param_genre = $genre;
                $param_filename = $filename;
                $param_artistband = $artistband;
                $param_id = $id;
            }
        }
        if (move_uploaded_file($temp_name, $folder)) {
            $msg = "Image uploaded successfully";
        } else {
            $msg = "Failed to upload image";
        }
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Records updated successfully. Redirect to landing page
            header("location: retrieve.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
// Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($con);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM songs WHERE id = ?";
        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result);

                    // Retrieve individual field value
                    $name = $row["name"];
                    $genre = $row["genre"];
                    $filename = $row["filename"];
                    $artistband = $row["artistband"];
                    $image = $row["image"];

                } else {

                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($con);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>
<a href="retrieve.php">Home</a>
<br><br>
<form method="post" action="" enctype="multipart/form-data">
    <input type="text" name="name" value="<?php echo $name ?>"<br><br>
    <input type="text" name="genre_name" value="<?php echo $genre ?>"<br><br>
    <input type="text" name="filename" value="<?php echo $filename ?>" <br><br>
    <input type="artistband" name="artistband_name" value="<?php echo $artistband ?>" <br><br>
    <input type="file" name="image"><br><br><?php echo $image ?><br>
    <input type="hidden" name="id" value="<?php echo $id ?>"/>
    <input type="submit" value="update">
</form>

</body>
</html>