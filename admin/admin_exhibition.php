<!DOCTYPE html>
<html>
<head>
    <title>Admin Exhibition</title>
    <link rel="stylesheet" type="text/css" href="admin_styles.css">
</head>

<body>
    <div class="menu-container">
        <ul class="menu">
            <li><a href="admin_artist.php">Artist</a></li>
            <li><a href="admin_artwork.php">Artwork</a></li>
            <li><a href="admin_exhibition.php">Exhibition</a></li>
        </ul>
    </div>

    <div class="admin-container">
        <h2>Add New Exhibition</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="exhibition_img" required>
            <input type="text" name="exhibition_title" placeholder="Exhibition Title" required>
            <input type="date" name="exhibition_date" required>
            <input type="text" name="location" placeholder="Exhibition Location" required>
            <button type="submit" name="add">Add Exhibition</button>
        </form>

        <h2>Update Exhibition</h2>
        <form method="post">
            <input type="text" name="update_id" placeholder="Exhibition ID" required>
            <input type="text" name="new_exhibition_title" placeholder="New Exhibition Title" >
            <input type="date" name="new_exhibition_date" >
            <input type="text" name="new_location" placeholder="New Exhibition Location" >
            <button type="submit" name="update">Update Exhibition</button>
        </form>

        <h2>Delete Exhibition</h2>
        <form method="post">
            <input type="text" name="delete_id" placeholder="Exhibition ID" required>
            <button type="submit" name="delete">Delete Exhibition</button>
        </form>
    </div>

    </body>
</html>

<?php

include '../function/config.php';

if (isset($_POST['add'])) {
    $exhibition_title = $_POST['exhibition_title'];
    $exhibition_date = $_POST['exhibition_date'];
    $location = $_POST['location'];

    // Get the name of the uploaded image file
    $exhibition_img = $_FILES['exhibition_img']['name'];

    // Get the temporary location of the uploaded image file
    $temp_img = $_FILES['exhibition_img']['tmp_name'];

    // Define the destination directory where the image will be stored
    $upload_dir = '../exhibition_image/';

    // Specify the path for the uploaded image
    $target_file = $upload_dir . $exhibition_img;

    // Check if the file was successfully uploaded
    if (move_uploaded_file($temp_img, $target_file)) {

        $sql = "INSERT INTO `exhibition` (exhibition_img, exhibition_title, exhibition_date, location)
        VALUES ('$target_file', '$exhibition_title', '$exhibition_date', '$location')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('Exhibition added successfully!');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


if (isset($_POST['update'])) {
    $update_id = $_POST['update_id'];
    $new_exhibition_title = !empty($_POST['new_exhibition_title']) ? $_POST['new_exhibition_title'] : '';
    $new_exhibition_date = !empty($_POST['new_exhibition_date']) ? $_POST['new_exhibition_date'] : '';
    $new_location = !empty($_POST['new_location']) ? $_POST['new_location'] : '';

    $sql = "UPDATE `exhibition` SET ";

    if (!empty($new_exhibition_title)) {
        $sql .= "exhibition_title = '$new_exhibition_title', ";
    }
    if (!empty($new_exhibition_date)) {
        $sql .= "exhibition_date = '$new_exhibition_date', ";
    }
    if (!empty($new_location)) {
        $sql .= "location = '$new_location', ";
    }

    $sql = rtrim($sql, ', '); // Remove the trailing comma
    $sql .= " WHERE exhibition_id = $update_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Exhibition updated successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM `exhibition` WHERE exhibition_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Exhibition deleted successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
