<?php
session_start(); // Start the session
require 'conn.php'; // Your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data sent via AJAX
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain-text password from the form

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM clients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the account status is 'active'
        if ($user['confirmation_status'] !== 'Confirmed') {
            echo json_encode(['success' => false, 'message' => 'Your account is not yet active. Please await confirmation or contact support.']);

            exit();
        }

        // Directly compare the plain-text passwords (no hashing)
        if ($password === $user['password']) {
            // Store user credentials in session variables
            $_SESSION['client_id'] = $user['client_id']; // Save client ID in session
            $_SESSION['first_name'] = $user['first_name']; // Save first name in session
            $_SESSION['last_name'] = $user['last_name']; // Save last name in session
            $_SESSION['email'] = $user['email']; // Save email in session

            // Send success response
            echo json_encode(['success' => true]);
        } else {
            // Incorrect password
            echo json_encode(['success' => false, 'message' => 'Incorrect email or password.']);
        }
    } else {
        // No user found
        echo json_encode(['success' => false, 'message' => 'No user found with this email.']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
