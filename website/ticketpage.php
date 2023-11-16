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
        <?php if ($exhibitionDetails) : ?>
            <div class="ticket-details">
                <h2>Exhibition Details</h2>
                <p>Title: <?php echo $exhibitionDetails['exhibition_title']; ?></p>
                <p>Date: <?php echo $exhibitionDetails['exhibition_date']; ?></p>
                <p>Location: <?php echo $exhibitionDetails['location']; ?></p>
                <p>Price: <?php echo $exhibitionDetails['ticket_price']; ?></p>
            </div>
        <?php else : ?>
            <p>Exhibition not found.</p>
        <?php endif; ?>


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

            <p id="ticketPriceDisplay">Ticket Price: $<span id="selectedTicketPrice">0.00</span></p>

            <script>
                document.getElementById('ticketID').addEventListener('change', function() {
                    var selectedOption = this.options[this.selectedIndex];
                    var selectedPrice = selectedOption.getAttribute('data-price');
                    document.getElementById('selectedTicketPrice').textContent = selectedPrice;
                });
            </script>
            <div style="display:flex; flex-direction:row; padding-left: 800px;">
                <a class="addtocart" href="ticketpage.php.?add_to_cart_ticket=<?php echo $exhibitionDetails['ticket_id'] ?>">ADD TO CART</a>
            </div>


    </main>

    <iframe src="footer.html" width="100%" height="300" frameborder="0" scrolling="no"></iframe>
</body>
</html>
