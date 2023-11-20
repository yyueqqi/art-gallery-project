<?php
include '../function/config.php';

if (isset($_GET['artist_id'])) {//expects to receive an artist ID as a parameter in the URL
    $artist_id = $_GET['artist_id'];//it retrieves the artist ID from the URL.
    
    $query = "SELECT * FROM `artist` WHERE artist_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $artist_id); 
    $stmt->execute();
    $result = $stmt->get_result();
    //uses a prepared statement to prevent SQL injection by binding the artist ID as a parameter.
    if ($result->num_rows > 0) {
        $artist = $result->fetch_assoc();
    } else {
        $artist = null;
    }

    $stmt->close();//close prepare parameter
} else {
    $artist = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Profile Page</title>
    <link rel="stylesheet" href="../style/artistprofile_styles.css">
</head>

<body>
<?php include('header.php'); ?>
        <main>
            <?php if ($artist) : ?>
                <div class="artist-container">
                    <div class="image">
                        <div class="image-wrap">
                        <img src="<?php echo $artist['artist_profile']; ?>" alt="<?php echo $artist['artist_id']; ?>">
                        </div>
                    </div>

                    <div class="text-frame">
                        <h2><?php echo $artist['fName'] . ' ' . $artist['lName']; ?></h2>
                        <div class="bio">
                            <strong>Biography</strong>
                            <p><?php echo $artist['artist_biography']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="history">
                        <div class="sub-heading">
                            <span><strong>Artwork History</strong></span>
                        </div>    
                            <div class="slideshow-container">
                            <?php
                            $artist_id = $artist['artist_id'];

                            $artwork_query = "SELECT artwork_id, artwork_img, artwork_title FROM artwork WHERE artist_id = $artist_id";
                            $artwork_result = mysqli_query($conn, $artwork_query);

                            if ($artwork_result) {
                                foreach ($artwork_result as $artwork_row) {
                                    $artwork_id = $artwork_row['artwork_id'];
                                    $artwork_img = $artwork_row['artwork_img'];
                                    $artwork_title = $artwork_row['artwork_title'];
                        
                                    echo '<div class="slide">';
                                    echo '<a href="artworkprofile.php?artwork_id=' . $artwork_id . '">';
                                    echo '<img src="' . $artwork_img . '" alt="' . $artwork_title . '">';
                                    echo '<p>' . $artwork_title . '</p>';
                                    echo '</a>';
                                    echo '</div>';
                                }
                            } 
                            else {
                                echo 'Error fetching artwork information: ' . mysqli_error($conn);
                            }
                            ?>
                            </div>
                        </div>

            <?php else : ?>
                <p>Artist not found.</p>
            <?php endif; ?>
        </main>
        <?php include('footer.php'); ?>

        
</body>
</html>
