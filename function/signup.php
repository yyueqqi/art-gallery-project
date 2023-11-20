<?php

include 'config.php';

$signupSuccessMessage = '';

if (isset($_POST['signup'])) {
    $signup_fname = $_POST['fname'];
    $signup_lname = $_POST['lname'];
    $signup_email = $_POST['email'];
    $signup_phonenumber = $_POST['phone_number'];
    $signup_dob = $_POST['dob'];
    $signup_username = $_POST['username'];
    $signup_password = $_POST['password'];
    $signup_confpass = $_POST['confirm_password'];

    if (
        $signup_fname == '' || $signup_lname == '' || $signup_email == '' ||
        $signup_phonenumber == '' || $signup_dob == '' || $signup_username == '' ||
        $signup_password == '' || $signup_confpass == ''
    ) {
        echo "<script> alert('Please fill in all fields')</script>";
    } else {
        // Use prepared statement to prevent SQL injection
        $select = "SELECT * FROM `account` WHERE username = ?";
        $stmt_select = $conn->prepare($select);
        $stmt_select->bind_param('s', $signup_username);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
        $number = $result_select->num_rows;

        if ($number > 0) {
            echo "<script> alert('This username is already in use')</script>";
        } else {
            $encpassword = password_hash($signup_password, PASSWORD_DEFAULT);

            if ($signup_password == $signup_confpass) {
                $insert = "INSERT INTO `account` (username, user_password, user_profile, fName, lName, email, dob, phone_number) 
                VALUES (?, ?, '../image/dummy.png', ?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($insert);
                $stmt_insert->bind_param('sssssss', $signup_username, $encpassword, $signup_fname, $signup_lname, $signup_email, $signup_dob, $signup_phonenumber);
                $result = $stmt_insert->execute();

                if ($result) {
                    session_start();
                    $signupSuccessMessage = 'Signup successful! Please log in.';
                    header('Location: ../website/loginpage.php');
                    exit;
                } else {
                    echo "<script> alert('Error')</script>";
                }
            } else {
                echo "<script> alert('Wrong password confirmation')</script>";
            }
        }
    }

    // Close prepared statements
    $stmt_select->close();
    $stmt_insert->close();
    $conn->close();
}

?>
