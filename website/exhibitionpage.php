<?php
    include '../function/config.php';

    $sql = "SELECT * FROM `exhibition`";
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $exhibitions = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $exhibitions = array();
        }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exhibition page</title>
    <link rel="stylesheet" href="../style/exhibition_styles.css">
</head>

<body>
<?php include('header.php'); ?>
    <main>
        <h2>Exhibition</h2>
        <p>Finding out exhibitions happening at art galleries. These exhibitions cover a wide range of art, including contemporary art, historical exhibits, design, photography, architecture, sculpture, handicrafts...</p>
        <section class="exhibitions">
            <?php foreach ($exhibitions as $exhibition) : ?>
                <div class="exhibition2">
                    <div class="container">
                        <div class="image-ex">
                              <img src="<?php echo $exhibition['exhibition_img']; ?>" alt="<?php echo $exhibition['exhibition_id']; ?>" class="image">
                            <div class="overlay">
                                <div class="text">
                                    <h3>Title: <?php echo $exhibition['exhibition_title']; ?></h3>
                                    <p>Date: <?php echo $exhibition['exhibition_date']; ?></p>
                                    <p>Location: <?php echo $exhibition['location']; ?></p>
                                    <button class="buy-ticket">
                                        <a href="ticketpage.php?exhibition_id=<?php echo $exhibition['exhibition_id']; ?>">Buy Ticket</a>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

    </main>



            </div>
        </section>
    </main>

    <?php include('footer.php'); ?>
</body>
</html>