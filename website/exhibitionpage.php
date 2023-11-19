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
    <section class="sub-header">
            <div class="art-text">
                <h1>EXHIBITION</h1>
                <p>***</p>
            </div>  
    </section>
    <main>
         <div class="sub-heading">
            <span>Explore the Latest Exhibitions</span>
        </div>
        <p>Finding out exhibitions happening at art galleries. These exhibitions cover a wide range of art,<br> including contemporary art, historical exhibits, design, photography, architecture, sculpture, handicrafts...</p>
        <section class="exhibitions">
            <?php foreach ($exhibitions as $exhibition) : ?>
                <div class="exhibition2">
                    <div class="container">
                        <div class="image-ex">
                              <img src="<?php echo $exhibition['exhibition_img']; ?>" alt="<?php echo $exhibition['exhibition_id']; ?>" class="image">
                            <div class="overlay">
                                <div class="text">
                                    <h3><?php echo $exhibition['exhibition_title']; ?></h3>
                                    <p>Date: <?php echo $exhibition['exhibition_date']; ?></p>
                                    <p>Location: <?php echo $exhibition['location']; ?></p>
                            
                                    <div class="buy-ticket">
                                        <a class='addtocart' href="
                                        <?php
                                            if (!isset($_SESSION['logged_in']) || !isset($_SESSION['login_username'])) {
                                                echo 'javascript:void(0);" onclick="alert(\'Please log in before buying items.\'); window.location.href=\'loginpage.php\';';
                                            } else {
                                                echo 'ticketpage.php?exhibition_id=' . $exhibition['exhibition_id'];
                                            }
                                        ?>" >BUY TICKET</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

    </main>





    <?php include('footer.php'); ?>
    
</body>
</html>