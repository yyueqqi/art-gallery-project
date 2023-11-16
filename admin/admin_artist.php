<?php 
     include '../function/config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Artists</title>
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
        <h2>Add New Artist</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="artist_img">Artist Image:</label>
            <input type="file" name="artist_img" required>
            <input type="text" name="fName" placeholder="Artist Firstname" required>
            <input type="text" name="lName" placeholder="Artist Lastname" required>
            <input type="date" name="dob" required>
            <textarea name="artwork_history" placeholder="Artwork History"></textarea>
            <textarea name="artist_biography" placeholder="Artist Biography"></textarea>
            <button type="submit" name="add">Add Artist</button>
        </form>

        <h2>Update Artist</h2>
        <form method="post" enctype="multipart/form-data" >
            <select name="update_artist_id" required>
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
            <label for="new_artist_img">New Artist Image:</label>
            <input type="file" name="new_artist_img">
            <input type="text" name="new_fName" placeholder="New Artist Firstname">
            <input type="text" name="new_lName" placeholder="New Artist Lastname">
            <input type="date" name="new_dob">
            <textarea name="new_artwork_history" placeholder="New Artwork History"></textarea>
            <textarea name="new_artist_biography" placeholder="New Artist Biography"></textarea>
            <button type="submit" name="update">Update Artist</button>
        </form>

        <h2>Delete Artist</h2>
        <form method="post">
        <select name="delete_artist" required>
                <option value="">Select an Artist</option>
                <?php
           
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
            <button type="submit" name="delete">Delete Artist</button>
        </form>
    </div>

    </body>
</html>


<?php



if (isset($_POST['add'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $dob = $_POST['dob'];
    $artwork_history = $_POST['artwork_history'];
    $artist_biography = $_POST['artist_biography'];
    // Get the name of the uploaded image file
    $artist_img = $_FILES['artist_img']['name'];

    // Get the temporary location of the uploaded image file
    $temp_img = $_FILES['artist_img']['tmp_name'];

    // Define the destination directory where the image will be stored
    $upload_dir = '../artist_image/';

    // Specify the path for the uploaded image
    $target_file = $upload_dir . $artist_img;

    // Check if the file was successfully uploaded
    if (move_uploaded_file($temp_img, $target_file)) {

        $sql = "INSERT INTO artist (artist_profile, fName, lname, dob, artwork_history, artist_biography)
        VALUES ('$target_file', '$fName', '$lName', '$dob', '$artwork_history', '$artist_biography')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('Artist added successfully!');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}



if (isset($_POST['update'])) {
    $update_id = $_POST['update_artist_id'];
    $new_fName = !empty($_POST['new_fName']) ? $_POST['new_fName'] : ''; 
    $new_lName = !empty($_POST['new_lName']) ? $_POST['new_lName'] : ''; 
    $new_dob = !empty($_POST['new_dob']) ? $_POST['new_dob'] : ''; 
    $new_artwork_history = !empty($_POST['new_artwork_history']) ? $_POST['new_artwork_history'] : '';
    $new_artist_biography = !empty($_POST['new_artist_biography']) ? $_POST['new_artist_biography'] : '';

    // Get the name of the new uploaded image file
    $new_artist_img = $_FILES['new_artist_img']['name'];

    // // Get the temporary location of the new uploaded image file
    $temp_new_img = $_FILES['new_artist_img']['tmp_name'];

    // // Define the destination directory where the new image will be stored
    $upload_dir = '../artist_image/';

    // Specify the path for the new uploaded image
    $new_target_file = $upload_dir . $new_artist_img;

    // Check if a new file was uploaded and move it to the destination directory
    isset($_FILES['new_artist_img']) && !empty($_FILES['new_artist_img']['name']);
        // Include the new image file in the SQL update statement
        if(move_uploaded_file($temp_new_img, $new_target_file)){
        $sql = "UPDATE artist SET ";
        if (!empty($new_artist_img)) {
            $sql .= "artist_profile = '$new_target_file', ";
        }
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
        if (!empty($new_artist_biography)) {
            $sql .= "artist_biography = '$new_artist_biography', ";
        }
        
        $sql = rtrim($sql, ', '); // Remove the trailing comma
        $sql .= " WHERE artist_id = '$update_id'";
    } 
    else {
        // If no new image is uploaded, update other fields without changing the image
        $sql = "UPDATE artist SET ";
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
        if (!empty($new_artist_biography)) {
            $sql .= "artist_biography = '$new_artist_biography', ";
        }
        
        $sql = rtrim($sql, ', '); // Remove the trailing comma
        $sql .= " WHERE artist_id = $update_id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Artist updated successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



if (isset($_POST['delete'])) {
    $id = $_POST['delete_artist'];

    $artworkQuery = "SELECT artwork_id, artwork_img FROM artwork WHERE artist_id = $id";
    $artworkResult = $conn->query($artworkQuery);

    if ($artworkResult->num_rows > 0) {
        while ($row = $artworkResult->fetch_assoc()) {
            $artworkId = $row['artwork_id'];
            $artworkImg = $row['artwork_img'];

            if (file_exists($artworkImg) && unlink($artworkImg)) {
                $deleteArtworkSql = "DELETE FROM artwork WHERE artwork_id = $artworkId";

                if ($conn->query($deleteArtworkSql) !== TRUE) {
                    echo "Error deleting artwork record: " . $conn->error;
                }
            } else {
                echo "Error deleting artwork picture: " . $artworkImg;
            }
        }

        $deleteArtistSql = "DELETE FROM artist WHERE artist_id = $id";

        if ($conn->query($deleteArtistSql) === TRUE) {
            echo "<script> alert('Artist and associated artwork records deleted successfully!');</script>";
        } else {
            echo "Error deleting artist record: " . $conn->error;
        }
    } else {
        $deleteArtistSql = "DELETE FROM artist WHERE artist_id = $id";

        if ($conn->query($deleteArtistSql) === TRUE) {
            echo "<script> alert('Artist deleted successfully!');</script>";
        } else {
            echo "Error deleting artist record: " . $conn->error;
        }
    }
}



$conn->close();

?>