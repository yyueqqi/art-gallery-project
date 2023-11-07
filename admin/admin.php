<?php

include '../function/config.php';

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $description = $_POST['description'];

    $sql = "INSERT INTO artwork (title, artist, description)
    VALUES ('$title', '$artist', '$description')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Artwork added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_POST['update'])) {
    $id = $_POST['update_id'];
    $new_title = $_POST['new_title'];
    $new_artist = $_POST['new_artist'];
    $new_description = $_POST['new_description'];

    $sql = "UPDATE artwork SET title = '$new_title', artist = '$new_artist', description = '$new_description' WHERE artwork_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Artwork updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM artwork WHERE artwork_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Artwork deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
