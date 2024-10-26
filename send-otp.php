<?php
session_start(); // Start the session at the beginning
include "conn.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$response = ['success' => false, 'message' => '']; // Initialize response with a success flag

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form fields from the POST request
    $firstName = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $lastName = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $middleName = isset($_POST['middle_name']) ? $_POST['middle_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $contactNumber = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
    $relativeName = isset($_POST['relative_name']) ? $_POST['relative_name'] : ''; // Added relative name
    $deathDate = isset($_POST['death_date']) ? $_POST['death_date'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Store the values in session variables
    $_SESSION['firstName'] = $firstName;
    $_SESSION['lastName'] = $lastName;
    $_SESSION['middleName'] = $middleName;
    $_SESSION['email'] = $email; // Email is directly assigned from POST
    $_SESSION['contactNumber'] = $contactNumber; // Store contact number
    $_SESSION['relativeName'] = $relativeName; // Store relative name
    $_SESSION['deathDate'] = $deathDate; // Store death date
    $_SESSION['password'] = $password; // Store hashed password
    $_SESSION['otp'] = ""; // Initialize OTP session variable

    // Function to generate a verification code
    function generateVerificationCode() {
        return substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    }

    // Generate new verification code
    $verificationCode = generateVerificationCode();
    $_SESSION['otp'] = $verificationCode;
    
    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->SMTPDebug = 0; // Set to 2 for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply.stjosephcemetery@gmail.com'; // Replace with your actual email
        $mail->Password = 'mnin icsr jfvd keav'; // Replace with your actual password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set sender and recipient
        $mail->setFrom('noreply.stjosephcemetery@gmail.com', 'St. Joseph Catholic Cemetery'); // Set a valid email and name
        $mail->addAddress($email, "Recipient"); // The recipient

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'One-Time-Password for Email Verification';
        $mail->Body = '<div style="font-family: Arial, sans-serif; padding: 20px 0px 10px 0px; background-color: #fff; line-height: 1.6; text-align: left;">
            <p style="font-size: 1em;">Hi,</p>
            <p>Use the One-Time Password (OTP) below to verify your account:</p>
            <h2 style="padding: 10px; background-color: #333; color: #fff; border-radius: 5px; letter-spacing: 5px; width: 90px;">'.$verificationCode.'</h2>
            <p>This OTP is valid for 10 minutes. Do not share it with anyone.</p>
            <hr style="border-top: 1px solid #eee;" />
            <p style="font-size: 0.9em; color: #999;">If this not for you, please ignore this email or contact support.</p>
        </div>';

        // Send the email
        $mail->send();
        $response['success'] = true; // Set success to true if email was sent
        $response['message'] = "OTP has been sent to your email."; // Store success message
    } catch (Exception $e) {
        $response['success'] = false; // Set success to false on failure
        $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; // Store error message
    }
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
