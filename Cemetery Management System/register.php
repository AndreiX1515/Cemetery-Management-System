<?php 
session_start(); // Start the session
require 'conn.php'; // Your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $lastName = $_POST['last_name'];
    $relativeName = $_POST['relative_name'];
    $deathDate = $_POST['death_date'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contact_number'];
    $password = $_POST['password'];

    // Input validation (add more validations as needed)
    if (empty($firstName) || empty($lastName) || empty($relativeName) || empty($deathDate) || empty($email) || empty($contactNumber) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert data
    $sql = "INSERT INTO clients (first_name, middle_name, last_name, relative_name, death_date, email, contact_number, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssss", $firstName, $middleName, $lastName, $relativeName, $deathDate, $email, $contactNumber, $hashedPassword);
        
        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Registration successful! Await email confirmation from admin before logging in.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration failed! Please try again.']);
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database query failed!']);
    }

    // Close the database connection
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>