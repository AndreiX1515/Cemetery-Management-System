<?php 
session_start(); // Start the session
require 'conn.php'; // Your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Common function to output JSON response
    function jsonResponse($success, $message) {
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }

    // Check if OTP is being verified
    if (isset($_POST['Reg-OTP'])) {
        $enteredOtp = $_POST['Reg-OTP'];

        // Validate OTP
        if (!isset($_SESSION['otp'])) {
            jsonResponse(false, 'OTP session not found. Please request a new OTP.');
        }

        if ($enteredOtp !== $_SESSION['otp']) {
            jsonResponse(false, 'Invalid OTP. Please try again.');
        }

        // OTP verified successfully, now register the user
        $firstName = $_SESSION['firstName'] ?? '';
        $lastName = $_SESSION['lastName'] ?? '';
        $middleName = $_SESSION['middleName'] ?? '';
        $email = $_SESSION['email'] ?? '';
        $password = mb_convert_encoding(trim($_SESSION['password'] ?? ''), 'UTF-8');

        // Additional fields
        $contactNumber = $_SESSION['contactNumber'] ?? ''; // Assuming contact number is also in the form
        $relativeName = $_SESSION['relativeName'] ?? ''; // Assuming relative name is in the form
        $deathDate = $_SESSION['deathDate'] ?? null; // Assuming death date is in the form, use null if not provided
        $confirmationStatus = 'Pending'; // Default to 'Pending'
        $created_at = date('Y-m-d H:i:s'); // Current timestamp

        // Insert data into the clients table using a prepared statement
        $stmt = $conn->prepare("INSERT INTO clients (first_name, middle_name, last_name, email, password, contact_number, relative_name, death_date, confirmation_status, created_at) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $firstName, $middleName, $lastName, $email, $password, $contactNumber, $relativeName, $deathDate, $confirmationStatus, $created_at);

        if ($stmt->execute()) {
            // Get the newly inserted client ID
            $client_id = $stmt->insert_id;

            // Now, insert into the relatives table
            $buriedDate = $deathDate; // Adjust based on your form inputs
            $graveLocation = ''; // Adjust based on your form inputs
            $status = 'To Confirm'; // Default status

            $rel_stmt = $conn->prepare("INSERT INTO relatives (client_id, name, buried_date, death_date, grave_location, status) VALUES (?, ?, ?, ?, ?, ?)");
            $rel_stmt->bind_param("isssss", $client_id, $relativeName, $buriedDate, $deathDate, $graveLocation, $status);


            if ($rel_stmt->execute()) {
                // Clear session variables after successful registration
                unset($_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['middleName'], $_SESSION['email'], $_SESSION['password'], $_SESSION['otp'], $_SESSION['contactNumber'], $_SESSION['relativeName'], $_SESSION['deathDate']);
                jsonResponse(true, 'Registration and relative data insertion successful!');
            } else {
                jsonResponse(false, "Error inserting into relatives table: " . $rel_stmt->error);
            }

            $rel_stmt->close();
        } else {
            jsonResponse(false, "Error: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
        
    } else {
        // Registration data submission
        $firstName = $_POST['Reg-FirstName'] ?? '';
        $lastName = $_POST['Reg-LastName'] ?? '';
        $middleName = $_POST['Reg-MiddleName'] ?? '';
        $email = $_POST['Reg-Email'] ?? '';
        $password = $_POST['Reg-Password'] ?? '';
        $contactNumber = $_POST['Reg-ContactNumber'] ?? ''; // New field
        $relativeName = $_POST['Reg-RelativeName'] ?? ''; // New field
        $deathDate = $_POST['Reg-DeathDate'] ?? null; // New field

        // Validation: Check if fields are not empty
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            jsonResponse(false, 'Please fill in all required fields.');
        }

        // Validation: Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            jsonResponse(false, 'Please enter a valid email address.');
        }

        // Store registration data in session for later use (after OTP verification)
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['middleName'] = $middleName;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['contactNumber'] = $contactNumber; // Store in session
        $_SESSION['relativeName'] = $relativeName; // Store in session
        $_SESSION['deathDate'] = $deathDate; // Store in session

        // Generate and store OTP
        $_SESSION['otp'] = generateVerificationCode();

        // Placeholder: Print OTP for demonstration (remove this in production)
        echo jsonResponse(true, 'OTP sent to your email. Your OTP is: ' . $_SESSION['otp']);
    }
}

// Function to generate a 6-digit OTP
function generateVerificationCode() {
    return substr(number_format(time() * rand(), 0, '', ''), 0, 6);
}
?>
