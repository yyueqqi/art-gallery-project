<!DOCTYPE html>
<html>
<head>
    <title>Admin Artist</title>
    <link rel="stylesheet" type="text/css" href="admin_styles.css">
</head>

<body>
    <div class="menu-container">
        <ul class="menu">
            <li><a href="admin_exhibition.php">Exhibition</a></li>
            <li><a href="admin_artist.php">Artist</a></li>
            <li><a href="admin_artwork.php">Artwork</a></li>
        </ul>
    </div>

    <div class="admin-container">
        <h2>Add New Artist</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="fName" placeholder="Artist Firstname" required>
            <input type="text" name="lName" placeholder="Artist Lastname" required>
            <input type="date" name="dob" required>
            <textarea name="artwork_history" placeholder="Artwork History"></textarea>
            <button type="submit" name="add">Add Artist</button>
        </form>

        <h2>Update Artist</h2>
        <form method="post">
            <input type="text" name="update_id" placeholder="Artist ID" required>
            <input type="text" name="new_fName" placeholder="New Artist Firstname">
            <input type="text" name="new_lName" placeholder="New Artist Lastname">
            <input type="date" name="new_dob">
            <textarea name="new_artwork_history" placeholder="New Artwork History"></textarea>
            <button type="submit" name="update">Update Artist</button>
        </form>

        <h2>Delete Artist</h2>
        <form method="post">
            <input type="text" name="delete_id" placeholder="Artist ID" required>
            <button type="submit" name="delete">Delete Artist</button>
        </form>
    </div>

    </body>
</html>

<?php

include '../function/config.php';

if (isset($_POST['add'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lname'];
    $dob = $_POST['dob'];
    $artwork_history = $_POST['artwork_history'];

    $sql = "INSERT INTO `artist` (fName, lname, dob, artwork_history)
    VALUES ('$fName', '$lName', '$dob', '$artwork_history')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Artist added successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_POST['update'])) {
    $update_id = $_POST['update_id'];
    $new_fName = !empty($_POST['new_fName']) ? $_POST['new_fName'] : ''; 
    $new_lName = !empty($_POST['new_lName']) ? $_POST['new_lName'] : ''; 
    $new_dob = !empty($_POST['new_dob']) ? $_POST['new_dob'] : ''; 
    $new_artwork_history = !empty($_POST['new_artwork_history']) ? $_POST['new_artwork_history'] : ''; 

    $sql = "UPDATE `artist` SET ";

    if (!empty($new_fName)) {
        $sql .= "fName = '$new_fName', ";
    }
    if (!empty($new_lName)) {
        $sql .= "lName = '$new_lName', ";
    }
    if (!empty($new_dob)) {
        $sql .= "dob = '$new_dob', ";
    }
    if (!empty($new_artwork_history)) {
        $sql .= "artwork_history = '$new_artwork_history', ";
    }

    $sql = rtrim($sql, ', '); 
    $sql .= " WHERE artist_id = $update_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Artist updated successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM `artist` WHERE artist_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Artist deleted successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
