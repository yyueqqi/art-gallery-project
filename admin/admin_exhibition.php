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
            <li><a href="admin_ticket.php">Exhibition Ticket</a></li>
            <li><a href="../index.php">Home Page</a></li>
        </ul>
    </div>

    <div class="admin-container">
        <h2>Add New Exhibition</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="exhibition_img">Exhibition Image:</label>
            <input type="file" name="exhibition_img" required>
            <input type="text" name="exhibition_title" placeholder="Exhibition Title" required>
            <input type="date" name="exhibition_date" required>
            <input type="text" name="location" placeholder="Exhibition Location" required>
            <button type="submit" name="add">Add Exhibition</button>
        </form>

        <h2>Update Exhibition</h2>
        <form method="post">
        <select name="update_exhibition_id" required>
                    <option value="">Select an Exhibition</option>
                    <?php
                    include '../function/config.php';
                    // Query your database to fetch artist IDs and names
                    $ExhibitionQuery = "SELECT exhibition_id, exhibition_title FROM exhibition";
                    $ExhibitionResult = $conn->query($ExhibitionQuery);

                    // Populate the dropdown with artist IDs and names
                    if ($ExhibitionResult->num_rows > 0) {
                        while ($row = $ExhibitionResult->fetch_assoc()) {
                            $exhibition_id = $row['exhibition_id'];
                            $exhibition_title = $row['exhibition_title'];
                            echo "<option value='$exhibition_id'>$exhibition_title</option>";
                        }
                    }
                    ?>
            </select>
            <input type="text" name="new_exhibition_title" placeholder="New Exhibition Title" >
            <input type="date" name="new_exhibition_date" >
            <input type="text" name="new_location" placeholder="New Exhibition Location" >
            <button type="submit" name="update">Update Exhibition</button>
        </form>

        <h2>Delete Exhibition</h2>
        <form method="post">
        <select name="delete_exhibition_id" required>
                    <option value="">Select an Exhibition</option>
                    <?php
                    include '../function/config.php';
                    // Query your database to fetch artist IDs and names
                    $ExhibitionQuery = "SELECT exhibition_id, exhibition_title FROM exhibition";
                    $ExhibitionResult = $conn->query($ExhibitionQuery);

                    // Populate the dropdown with artist IDs and names
                    if ($ExhibitionResult->num_rows > 0) {
                        while ($row = $ExhibitionResult->fetch_assoc()) {
                            $exhibition_id = $row['exhibition_id'];
                            $exhibition_title = $row['exhibition_title'];
                            echo "<option value='$exhibition_id'>$exhibition_title</option>";
                        }
                    }
                    ?>
            </select>
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

        $sql = "INSERT INTO `exhibition` (exhibition_img, exhibition_title, exhibition_date, location, ticket_number)
        VALUES ('$target_file', '$exhibition_title', '$exhibition_date', '$location', '0')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('Exhibition added successfully!');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    else{
        echo "<script> alert('error!');</script>";
    }
}


if (isset($_POST['update'])) {
    $update_id = $_POST['update_exhibition_id'];
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
    $id = $_POST['delete_exhibition_id'];

    $imagePathQuery = "SELECT exhibition_img FROM exhibition WHERE exhibition_id = $id";
    $ticketIdsQuery = "SELECT ticket_id FROM ticket WHERE exhibition_id = $id";

    $imagePathResult = $conn->query($imagePathQuery);
    $ticketIdsResult = $conn->query($ticketIdsQuery);

    if ($imagePathResult->num_rows > 0) {
        $row = $imagePathResult->fetch_assoc();
        $imagePath = $row['exhibition_img'];

        if (unlink($imagePath)) {
            $deleteTicketsQuery = "DELETE FROM `ticket` WHERE exhibition_id = $id";
            
            if ($conn->query($deleteTicketsQuery) === TRUE) {
                $sql = "DELETE FROM `exhibition` WHERE exhibition_id = $id";

                if ($conn->query($sql) === TRUE) {
                    echo "<script> alert('Exhibition and associated tickets deleted successfully!');</script>";
                } else {
                    echo "Error deleting exhibition record: " . $conn->error;
                }
            } else {
                echo "Error deleting tickets: " . $conn->error;
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
