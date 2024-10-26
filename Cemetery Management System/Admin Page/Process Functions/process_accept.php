<?php
session_start(); // Start the session at the beginning

include "../conn.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor\autoload.php';

$response = ['success' => false, 'message' => '']; // Initialize response with a success flag

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_id'])) {
    $client_id = $_POST['client_id'];

    // Query to get email and name based on client_id
    $query = "SELECT email, first_name, last_name FROM clients WHERE client_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if record exists and fetch data
    if ($result->num_rows > 0) {
     $row = $result->fetch_assoc();
     $email = $row['email'];
     $name = $row['first_name'] . ' ' . $row['last_name']; // Concatenate first and last names

     // Update the confirmation status to 'Confirmed'
     $updateQuery = "UPDATE clients SET confirmation_status = 'Confirmed' WHERE client_id = ?";
     $updateStmt = $conn->prepare($updateQuery);
     $updateStmt->bind_param("i", $client_id);
     $updateStmt->execute();


    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Client not found']);
        exit;
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

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
    $mail->addAddress($email, $name); // Use retrieved email and name for recipient

    // Updated email content for account acceptance
    $mail->isHTML(true);
    $mail->Subject = 'Your Account Has Been Accepted!';
    $mail->Body = '<div style="font-family: Arial, sans-serif; padding: 20px; background-color: #fff; line-height: 1.6; text-align: left;">
        <p style="font-size: 1em;">Hello ' . htmlspecialchars($name) . ',</p>
        <p>We are pleased to inform you that your account has been accepted and is now active. You can now log in and start using your account at St. Joseph Catholic Cemetery.</p>
        <p>Thank you for your patience, and we look forward to serving you.</p>
        <hr style="border-top: 1px solid #eee;" />
        <p style="font-size: 0.9em; color: #999;">If you did not request this account, please contact support.</p>
    </div>';

    // Send the email
    $mail->send();
    $response['success'] = true; // Set success to true if email was sent
    $response['message'] = "Account acceptance notification sent to the user's email."; // Store success message
} catch (Exception $e) {
    $response['success'] = false; // Set success to false on failure
    $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; // Store error message
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
