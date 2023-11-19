<?php
session_start();
include '../function/config.php';
include '../function/addtocart.php';
if (isset($_GET['exhibition_id'])) {
    $exhibition_id = $_GET['exhibition_id'];

    $query = "SELECT exhibition.*, ticket.* FROM `exhibition` 
              LEFT JOIN `ticket` ON exhibition.exhibition_id = ticket.exhibition_id 
              WHERE exhibition.exhibition_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $exhibition_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $exhibitionDetails = $result->fetch_assoc();
    } else {
        $exhibitionDetails = null;
    }

    $stmt->close();
} else {
    $exhibitionDetails = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Page</title>
    <link rel="stylesheet" href="../style/ticket_styles.css">
</head>
<body>
    <?php include('header.php'); ?>

    <main>
        <div class="top">
            <h5>Select your ticket type</h5>
            <select name="ticketID" id="ticketID" required>
                                <option value="" data-price="">Select Ticket</option>
                                <?php
                                include '../function/config.php';

                                if (isset($exhibition_id)) {
                                    $ticketQuery = "SELECT ticket_id, exhibition_id, ticket_type, price FROM ticket WHERE exhibition_id = $exhibition_id";
                                    $ticketResult = $conn->query($ticketQuery);

                                    if ($ticketResult->num_rows > 0) {
                                        while ($row = $ticketResult->fetch_assoc()) {
                                            $ticketID = $row['ticket_id'];
                                            $ticketType = $row['ticket_type'];
                                            $ticketPrice = $row['price'];
                                            echo "<option value='$ticketID' data-price='$ticketPrice'>$ticketType</option>";
                                        }
                                    } else {
                                        echo "<option value='' data-price='' disabled>No tickets available</option>";
                                    }
                                } else {
                                    echo "<option value='' data-price='' disabled>Please select an exhibition first</option>";
                                }
                                ?>
                            </select>
        </div>
        <div class="ticket-frame">
            <?php if ($exhibitionDetails) : ?>
                <div class="ticket-details">
                    <h6><?php echo $exhibitionDetails['exhibition_title']; ?></h6>
                    <img src="<?php echo $exhibitionDetails['exhibition_img']; ?>" alt="<?php echo $exhibitionDetails['exhibition_id']; ?>">
                    <div class="td">
                        <div class="td1">
                            <img src="../image/calendar.png" alt="">
                            <p>Date: <?php echo $exhibitionDetails['exhibition_date']; ?></p>
                        </div>
                        <div class="td2">
                            <img src="../image/location.png" alt="">
                            <p>Location: <?php echo $exhibitionDetails['location']; ?></p>
                        </div>
                        <div class="td3">
                            <img src="../image/invoice.png" alt="">
                            <p id="ticketPriceDisplay">Ticket Price: ฿<span id="selectedTicketPrice">0.00</span></p>
                        </div>
                        <div class="td4">
                            <img src="../image/barcode.png" alt="">
                            <div >
                                <a id="addToCartLink" class="addtocart" href="#">ADD TO CART</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <p>Exhibition not found.</p>
            <?php endif; ?>

        <script>
            document.getElementById('ticketID').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var selectedTicketID = selectedOption.value; // Get the selected ticket ID
                var selectedPrice = selectedOption.getAttribute('data-price');
                document.getElementById('selectedTicketPrice').textContent = selectedPrice;

                // Update the link with the selected ticket ID
                var addToCartLink = document.getElementById('addToCartLink');
                addToCartLink.href = "ticketpage.php?add_to_cart_ticket=" + selectedTicketID;
            });
        </script>

    </div>
    </main>

    <?php include('footer.php'); ?>
</body>
</html>
