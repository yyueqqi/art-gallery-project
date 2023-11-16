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
            <li><a href="admin_ticket.php">Exhibition Ticket</a></li>
        </ul>
    </div>

    <div class="admin-container">
        <h2>Add New Artwork</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" required>
            <label for="artist">Select an Artist:</label>
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
            <label for="artwork_genre">Artwork Genre:</label>
            <select name="artwork_genre" required>
                <option value="">Select Artwork Genre</option>
                <option value="Painting">Painting</option>
                <option value="Sculpture">Sculpture</option>
                <option value="Photography">Photography</option>
            </select>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="text" name="price" placeholder="Price" required>
            <label for="artwork_img">Artwork Image:</label>
            <input type="file" name="artwork_img" required>
            <input type="text" name="scale" placeholder="Artwork Scale" required>
            <button type="submit" name="add">Add Artwork</button>
        </form>

        <h2>Update Artwork</h2>
        <form method="post">
            <select name="update_id" required>
                <option value="">Select an Artwork</option>
                    <?php
                    include '../function/config.php';
                    $artworkQuery = "SELECT artwork_id, artwork_title FROM artwork";
                    $artworkResult = $conn->query($artworkQuery);

                    if ($artworkResult->num_rows > 0) {
                        while ($row = $artworkResult->fetch_assoc()) {
                            $artworkID = $row['artwork_id'];
                            $artwork_title = $row['artwork_title'];
                            echo "<option value='$artworkID'>$artwork_title</option>";
                        }
                    }
                    ?>
            </select>
            <input type="text" name="new_title" placeholder="New Title">
            <label for="new_artist">New Artist:</label>
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
            <label for="new_artwork_genre">New Artwork Genre:</label>
            <select name="new_artwork_genre">
                <option value="">Select Artwork Genre</option>
                <option value="Painting">Painting</option>
                <option value="Sculpture">Sculpture</option>
                <option value="Photography">Photography</option>
            </select>
            <textarea name="new_description" placeholder="New Description"></textarea>
            <input type="text" name="new_price" placeholder="New Price">
            <label for="availability_status">Artwork Availability Status:</label>
            <select name="new_availability_status">
                <option value="">Select Artwork Status</option>
                <option value="available">Available</option>
                <option value="not_available">Not available</option>
            </select>
            <button type="submit" name="update">Update Artwork</button>
        </form>

        <h2>Delete Artwork</h2>
        <form method="post">
            <select name="delete_id" required>
                <option value="">Select an Artwork</option>
                    <?php
                    include '../function/config.php';
                    $artworkQuery = "SELECT artwork_id, artwork_title FROM artwork";
                    $artworkResult = $conn->query($artworkQuery);

                    if ($artworkResult->num_rows > 0) {
                        while ($row = $artworkResult->fetch_assoc()) {
                            $artworkID = $row['artwork_id'];
                            $artwork_title = $row['artwork_title'];
                            echo "<option value='$artworkID'>$artwork_title</option>";
                        }
                    }
                    ?>
            </select>
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
    $genre = $_POST['artwork_genre'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $scale = $_POST['scale'];

    // Get the name of the uploaded image file
    $artwork_img = $_FILES['artwork_img']['name'];

    // Get the temporary location of the uploaded image file
    $temp_img = $_FILES['artwork_img']['tmp_name'];

    // Define the destination directory where the image will be stored
    $upload_dir = '../artwork_image/';

    // Specify the path for the uploaded image
    $target_file = $upload_dir . $artwork_img;

    // Check if the file was successfully uploaded
    if (move_uploaded_file($temp_img, $target_file)) {
        $sql = "INSERT INTO `artwork` (artwork_title, artwork_img, scale, artist_id, genre, description, price, availability_status)
                VALUES ('$title', '$target_file', '$scale', '$artist', '$genre', '$description', '$price', 'Available')";

        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('Artwork added successfully!');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: File upload failed.";
    }
}


if (isset($_POST['update'])) {
    $id = $_POST['update_id'];
    $new_title = !empty($_POST['new_title']) ? $_POST['new_title'] : '';
    $new_artist = !empty($_POST['new_artist']) ? $_POST['new_artist'] : '';
    $new_genre = !empty($_POST['new_artwork_genre']) ? $_POST['new_artwork_genre'] : '';
    $new_description = !empty($_POST['new_description']) ? $_POST['new_description'] : '';
    $new_price = !empty($_POST['new_price']) ? $_POST['new_price'] : '';
    $new_availability_status = !empty($_POST['new_availability_status']) ? $_POST['new_availability_status'] : '';

    $sql = "UPDATE `artwork` SET ";

    if (!empty($new_title)) {
        $sql .= "artwork_title = '$new_title', ";
    }
    if (!empty($new_artist)) {
        $sql .= "artist_id = '$new_artist', ";
    }
    if (!empty($new_genre)) {
        $sql .= "genre = '$new_genre', ";
    }
    if (!empty($new_description)) {
        $sql .= "description = '$new_description', ";
    }
    if (!empty($new_price)) {
        $sql .= "price = '$new_price', ";
    }
    if (!empty($new_availability_status)) {
        $sql .= "availability_status = '$new_availability_status', ";
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
    $itemType = 'Artwork'; 

    $imagePathQuery = "SELECT artwork_img FROM artwork WHERE artwork_id = $id";
    $imagePathResult = $conn->query($imagePathQuery);

    if ($imagePathResult->num_rows > 0) {
        $row = $imagePathResult->fetch_assoc();
        $imagePath = $row['artwork_img'];

        if (unlink($imagePath)) {
            $deleteFromCartQuery = "DELETE FROM `cart` WHERE item_id = $id AND item_type = '$itemType'";

            if ($conn->query($deleteFromCartQuery) === TRUE) {
                $sql = "DELETE FROM `artwork` WHERE artwork_id = $id";

                if ($conn->query($sql) === TRUE) {
                    echo "<script> alert('Artwork and associated image deleted successfully from the cart and database!');</script>";
                } else {
                    echo "Error deleting artwork record: " . $conn->error;
                }
            } else {
                echo "Error deleting cart entry: " . $conn->error;
            }
        } else {
            echo "<script> alert('Error deleting image file!');</script>";
        }
    } else {
        echo "<script> alert('Image file not found in the database!');</script>";
    }
}



$conn->close();

?>
