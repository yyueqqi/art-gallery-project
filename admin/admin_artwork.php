<!DOCTYPE html>
<html>
<head>
    <title>Admin Artwork</title>
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
        <h2>Add New Artwork</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" required>
            <select name="artist" required>
                <option value="">Select an Artist</option>
                <?php
                include '../function/config.php';
                // Query your database to fetch artist IDs and names
                $artistQuery = "SELECT artist_id, fName, lName FROM artist";
                $artistResult = $conn->query($artistQuery);

                // Populate the dropdown with artist IDs and names
                if ($artistResult->num_rows > 0) {
                    while ($row = $artistResult->fetch_assoc()) {
                        $artistID = $row['artist_id'];
                        $artistName = $row['fName'] . ' ' . $row['lName'];
                        echo "<option value='$artistID'>$artistName</option>";
                    }
                }
                ?>
            </select>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="text" name="price" placeholder="Price" required>
            <input type="file" name="image" required>
            <button type="submit" name="add">Add Artwork</button>
        </form>

        <h2>Update Artwork</h2>
        <form method="post">
            <input type="text" name="update_id" placeholder="Artwork ID" required>
            <input type="text" name="new_title" placeholder="New Title">
            <select name="new_artist" >
                <option value="">Select an Artist</option>
                <?php
                include '../function/config.php';
                $artistQuery = "SELECT artist_id, fName, lName FROM artist";
                $artistResult = $conn->query($artistQuery);

                if ($artistResult->num_rows > 0) {
                    while ($row = $artistResult->fetch_assoc()) {
                        $artistID = $row['artist_id'];
                        $artistName = $row['fName'] . ' ' . $row['lName'];
                        echo "<option value='$artistID'>$artistName</option>";
                    }
                }
                ?>
            </select>
            <textarea name="new_description" placeholder="New Description"></textarea>
            <input type="text" name="new_price" placeholder="New Price">
            <button type="submit" name="update">Update Artwork</button>
        </form>

        <h2>Delete Artwork</h2>
        <form method="post">
            <input type="text" name="delete_id" placeholder="Artwork ID" required>
            <button type="submit" name="delete">Delete Artwork</button>
        </form>
    </div>
</body>
</html>

<?php

include '../function/config.php';

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO `artwork` (artwork_title, artist_id, description, price)
    VALUES ('$title', '$artist', '$description', '$price')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Artwork added successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_POST['update'])) {
    $id = $_POST['update_id'];
    $new_title = !empty($_POST['new_title']) ? $_POST['new_title'] : '';
    $new_artist = !empty($_POST['new_artist']) ? $_POST['new_artist'] : '';
    $new_description = !empty($_POST['new_description']) ? $_POST['new_description'] : '';
    $new_price = !empty($_POST['new_price']) ? $_POST['new_price'] : '';

    $sql = "UPDATE `artwork` SET ";

    if (!empty($new_title)) {
        $sql .= "artwork_title = '$new_title', ";
    }
    if (!empty($new_artist)) {
        $sql .= "artist_id = '$new_artist', ";
    }
    if (!empty($new_description)) {
        $sql .= "description = '$new_description', ";
    }
    if (!empty($new_price)) {
        $sql .= "price = '$new_price', ";
    }

    $sql = rtrim($sql, ', ');
    $sql .= " WHERE artwork_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Artwork updated successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM `artwork` WHERE artwork_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo  "<script> alert('Artwork deleted successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
