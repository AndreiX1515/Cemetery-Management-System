<?php
// session_start();
// require 'conn.php';

// if (isset($_POST['login'])) {
//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     // Basic input validation
//     if (empty($username) || empty($password)) {
//         echo "<div class='alert alert-secondary' role='alert' style='color: red;'>
//                     <center> Both Username and Password are required! </center>
//                 </div>    
//                 ";
//     } else {
//         // Use prepared statements to prevent SQL injection
//         $query = "SELECT * FROM `users` WHERE `username` = ? AND `password` = ?";
//         $stmt = $conn->prepare($query);

//         if ($stmt) {
//             $stmt->bind_param("ss", $username, $password);
//             $stmt->execute();
//             $result = $stmt->get_result();
            
//             if ($result->num_rows > 0) {
//                 $fetch = $result->fetch_assoc();
//                 $_SESSION['user'] = $fetch['userid'];
//                 $_SESSION['userType'] = $fetch['userType'];
//                 header("location: Dashboard.php");
//             } else {
//                 echo "<div class='alert alert-secondary' role='alert' style='color: red;'>
//                         <center> Incorrect Username or Password </center>
//                     </div>    
//                 ";
//             }
//         } else {
//             echo "<div class='alert alert-secondary' role='alert' style='color: red;'>
//                     <center> Error in Query Preparation </center>
//                     </div>    
//                 ";
//         }
//     }
// }
?>

<?php
session_start(); // This should be at the top of your file
include "../Admin Page/dbconn.php";

// Your login logic here...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure variables are set and not empty
    $user_name = isset($_POST['form3Example3']) ? $_POST['form3Example3'] : '';
    $password = isset($_POST['form3Example4']) ? $_POST['form3Example4'] : '';

    if (!empty($user_name) && !empty($password)) {
        // Prepare and execute SQL statement to find the user
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = ? AND is_active = 1");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Direct password comparison without hashing
            if ($password === $user['password']) {
                // Login success, set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['position'] = $user['position'];

                // Update last_login field
                $stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?");
                $stmt->bind_param("i", $user['user_id']);
                $stmt->execute();

                // Redirect to a protected page (e.g., index.php)
                header("Location: ../Admin Page/index.php");
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password/Username";
            }
        } else {
            $_SESSION['error'] = "User not found or inactive";
        }
    } else {
        $_SESSION['error'] = "Please fill in both username and password.";
    }

    // Redirect back to the login page to show the error
    header("Location: ../admin-login.php");
    exit();
}



?>



