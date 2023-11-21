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
        <h2>Add New Ticket</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="exhibition">Select an Exhibition:</label>
                <select name="exhibition" required>
                    <option value="">Select an Exhibition</option>
                    <?php
                    include '../function/config.php';

                    $exhibitionQuery = "SELECT exhibition_id, exhibition_title FROM exhibition";
                    $exhibitionResult = $conn->query($exhibitionQuery);

                    if ($exhibitionResult->num_rows > 0) {
                        while ($row = $exhibitionResult->fetch_assoc()) {
                            $exhibitionID = $row['exhibition_id'];
                            $exhibition_title = $row['exhibition_title'];
                            echo "<option value='$exhibitionID'>$exhibition_title</option>";
                        }
                    }
                    ?>
            </select>
            <label for="ticket_type">Ticket type:</label>
            <select name="ticket_type" required>
                <option value="">Select Ticket Type</option>
                <option value="vip">VIP</option>
                <option value="general">General</option>
                <option value="student">Student</option>
            </select>
            <input type="text" name="number" placeholder="Number of ticket" required>
            <input type="text" name="price" placeholder="Price" required>
            <button type="submit" name="add">Add Ticket</button>
        </form>

        <h2>Update Ticket</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="ticket">Select Ticket:</label>
                <select name="ticketID" required>
                    <option value="">Select Ticket</option>
                    <?php
                    include '../function/config.php';
                    
                    $ticketQuery = "SELECT ticket_id, exhibition_id, ticket_type FROM ticket";
                    $ticketResult = $conn->query($ticketQuery);

                    if ($ticketResult->num_rows > 0) {
                        while ($row = $ticketResult->fetch_assoc()) {
                            $ticketID = $row['ticket_id'];
                            $exhibitionID = $row['exhibition_id'];

                            $exhibitionTitleQuery = "SELECT exhibition_title FROM exhibition WHERE exhibition_id = $exhibitionID";
                            $exhibitionTitleResult = $conn->query($exhibitionTitleQuery);

                            if ($exhibitionTitleResult->num_rows > 0) {
                                $exhibitionTitleRow = $exhibitionTitleResult->fetch_assoc();
                                $exhibitionTitle = $exhibitionTitleRow['exhibition_title'];
                            } else {
                                $exhibitionTitle = "Unknown Exhibition";
                            }

                            echo "<option value='$ticketID'>$exhibitionTitle - {$row['ticket_type']}</option>";
                        }
                    }
                    ?>
            </select>
            <input type="text" name="new_number" placeholder="Number of ticket" >
            <input type="text" name="new_price" placeholder="Price" >
            <select name="new_availability_status" required>
                <option value="">Select Ticket Status</option>
                <option value="available">Available</option>
                <option value="not_available">Not available</option>
            </select>
            <button type="submit" name="update">Update Ticket</button>
        </form>

        <h2>Delete Ticket</h2>
        <form method="post" enctype="multipart/form-data">
        <label for="ticket">Select Ticket:</label>
                <select name="delete_ticketID" required>
                    <option value="">Select Ticket</option>
                    <?php
                    include '../function/config.php';
                    
                    $ticketQuery = "SELECT ticket_id, exhibition_id, ticket_type FROM ticket";
                    $ticketResult = $conn->query($ticketQuery);

                    if ($ticketResult->num_rows > 0) {
                        while ($row = $ticketResult->fetch_assoc()) {
                            $ticketID = $row['ticket_id'];
                            $exhibitionID = $row['exhibition_id'];

                            $exhibitionTitleQuery = "SELECT exhibition_title FROM exhibition WHERE exhibition_id = $exhibitionID";
                            $exhibitionTitleResult = $conn->query($exhibitionTitleQuery);

                            if ($exhibitionTitleResult->num_rows > 0) {
                                $exhibitionTitleRow = $exhibitionTitleResult->fetch_assoc();
                                $exhibitionTitle = $exhibitionTitleRow['exhibition_title'];
                            } else {
                                $exhibitionTitle = "Unknown Exhibition";
                            }

                            echo "<option value='$ticketID'>$exhibitionTitle - {$row['ticket_type']}</option>";
                        }
                    }
                    ?>
            </select>
            <button type="submit" name="delete">Delete Ticket</button>
        </form>

    </div>

    </body>
</html>

<?php

include '../function/config.php';

if (isset($_POST['add'])) {
    $exhibition = $_POST['exhibition'];
    $ticket_type = $_POST['ticket_type'];
    $price = $_POST['price'];
    $number = $_POST['number'];

    $updateExhibitionSql = "UPDATE exhibition SET ticket_number = ticket_number + $number WHERE exhibition_id = $exhibition";
    $conn->query($updateExhibitionSql);

    $sql = "INSERT INTO `ticket` (exhibition_id, ticket_type, price, ticket_number, ticket_availability)
    VALUES ('$exhibition', '$ticket_type', '$price', '$number', 'Available')";
        
    if ($conn->query($sql) === TRUE) {
        echo "<script> alert('Ticket added successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_POST['update'])) {
    $ticketID = $_POST['ticketID'];
    $new_number = !empty($_POST['new_number']) ? $_POST['new_number'] : '';
    $new_price = !empty($_POST['new_price']) ? $_POST['new_price'] : '';
    $new_availability_status = !empty($_POST['new_availability_status']) ? $_POST['new_availability_status'] : '';

    $ticketQuery = "SELECT ticket_number, exhibition_id, ticket_availability FROM ticket WHERE ticket_id = $ticketID";
    $ticketResult = $conn->query($ticketQuery);

    if ($ticketResult->num_rows > 0) {
        $ticketRow = $ticketResult->fetch_assoc();
        $currentTicketNumber = $ticketRow['ticket_number'];
        $exhibitionID = $ticketRow['exhibition_id'];
        $availabilityStatus = $ticketRow['ticket_availability'];

        if ($availabilityStatus == 'not_available') {
            $updateExhibitionQuery = "UPDATE exhibition SET ticket_number = ticket_number - $currentTicketNumber WHERE exhibition_id = $exhibitionID";
            $conn->query($updateExhibitionQuery);
            $updateTicketNumberToZeroQuery = "UPDATE ticket SET ticket_number = 0 WHERE ticket_id = $ticketID";
            $conn->query($updateTicketNumberToZeroQuery);
        }
        else{
            if ($new_number > $currentTicketNumber) {
                $increaseBy = $new_number - $currentTicketNumber;
                $updateExhibitionQuery = "UPDATE exhibition SET ticket_number = ticket_number + $increaseBy WHERE exhibition_id = $exhibitionID";
                $conn->query($updateExhibitionQuery);
            } elseif ($new_number < $currentTicketNumber) {
                $decreaseBy = $currentTicketNumber - $new_number;
                $updateExhibitionQuery = "UPDATE exhibition SET ticket_number = ticket_number - $decreaseBy WHERE exhibition_id = $exhibitionID";
                $conn->query($updateExhibitionQuery);
            }
        }

            $updateTicketQuery = "UPDATE ticket SET ";

            if (!empty($new_number)) {
                $updateTicketQuery .= "ticket_number = '$new_number', ";
            }
            if (!empty($new_price)) {
                $updateTicketQuery .= "price = '$new_price', ";
            }
            if (!empty($new_availability_status)) {
                $updateTicketQuery .= "ticket_availability = '$new_availability_status', ";
            }

            $updateTicketQuery = rtrim($updateTicketQuery, ', ');
            $updateTicketQuery .= " WHERE ticket_id = $ticketID";

            if ($conn->query($updateTicketQuery) === TRUE) {
                echo "<script> alert('Ticket updated successfully!');</script>";
            } else {
                echo "Error: " . $updateTicketQuery . "<br>" . $conn->error;
            }
        }
    }


    if (isset($_POST['delete'])) {
        $ticketID = $_POST['delete_ticketID'];
    
        $ticketQuery = "SELECT ticket_number, exhibition_id, ticket_availability FROM ticket WHERE ticket_id = $ticketID";
        $ticketResult = $conn->query($ticketQuery);
    
        if ($ticketResult->num_rows > 0) {
            $ticketData = $ticketResult->fetch_assoc();
            $exhibitionID = $ticketData['exhibition_id'];
            $currentTicketNumber = $ticketData['ticket_number'];
    
            $updateExhibitionQuery = "UPDATE exhibition SET ticket_number = ticket_number - $currentTicketNumber WHERE exhibition_id = $exhibitionID";
            $conn->query($updateExhibitionQuery);
    
            $deleteCartTicketQuery = "DELETE FROM cart_ticket WHERE item_id = $ticketID AND item_type = 'Ticket'";
            if ($conn->query($deleteCartTicketQuery) === TRUE) {
                $sql = "DELETE FROM `ticket` WHERE ticket_id = $ticketID";
    
                if ($conn->query($sql) === TRUE) {
                    echo "<script> alert('Ticket and associated cart item deleted successfully!');</script>";
                } else {
                    echo "Error deleting ticket record: " . $conn->error;
                }
            } else {
                echo "Error deleting cart item: " . $conn->error;
            }
        } else {
            echo "Ticket not found.";
        }
    }
    

$conn->close();

?>
