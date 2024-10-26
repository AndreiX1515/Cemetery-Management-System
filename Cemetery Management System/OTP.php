<?php
session_start(); // Start the session at the beginning

$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$middleName = $_SESSION['middleName'];
$email = $_SESSION['email']; // Email is directly assigned from POST
$contactNumber = $_SESSION['contactNumber']; // Store contact number
$relativeName = $_SESSION['relativeName']; // Store relative name
$deathDate = $_SESSION['deathDate']; // Store death date
$password = $_SESSION['password']; // Store hashed password
$otp = $_SESSION['otp']; // Initialize OTP session variable


error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OTP Verification</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/otp.css">
  <link rel="stylesheet" href="assets/css/modal-styles.css">
</head>

<body>
<a href="" class="back-btn" data-bs-toggle="modal" data-bs-target="#confirmModal">
    <i class="fas fa-arrow-left"></i> Back to Login Page
</a>

<div class="card py-4 px-3 text-center">
    <form id="otpForm">
        <h6>An OTP has been sent <br> to verify your account</h6>
        <div>
            <span>A code has been sent to</span> <small>*******@gmail.com</small> 
        </div>
        
        <div id="otp" class="inputs d-flex flex-row justify-content-center my-4"> 
            <input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" /> 
            <input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" /> 
            <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" /> 
            <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" /> 
            <input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" /> 
            <input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" /> 
        </div>
        

        <div class="message-otp" id="message-otp"></div>

        <a class="link-opacity-5 " href="#" id="resendOtpButton" role="button">Resend</a>

        
        <div class="mt-4"> 
            <button type="submit" class="btn btn-danger px-4" id="verifyOtpButton">Verify</button> 
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function(event) {
    function OTPInput() {
        const inputs = document.querySelectorAll('#otp > input');

        inputs.forEach((input, index) => {
            input.addEventListener('keydown', function(event) {
                // Allow Backspace to clear the current input
                if (event.key === "Backspace") {
                    inputs[index].value = '';
                    if (index !== 0) {
                        inputs[index - 1].focus();
                    }
                } 
                // Allow only digits (0-9)
                else if (event.key.length === 1 && /^[0-9]$/.test(event.key)) {
                    inputs[index].value = event.key;
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    event.preventDefault();
                }
            });
        });

        // Focus on the first input when the page loads
        inputs[0].focus();

        // Automatically move focus to the next input on input event
        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });
    }

    OTPInput();

    // Function to get OTP from the inputs
    function getOTP() {
        const inputs = document.querySelectorAll('#otp > *[id]');
        return Array.from(inputs).map(input => input.value).join('');
    }

    // OTP verification handler
    $('#verifyOtpButton').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Check for blank OTP fields
        const otpFields = document.querySelectorAll('#otp input');
        let allFieldsFilled = true;

        otpFields.forEach((field) => {
            if (field.value.trim() === '') {
                allFieldsFilled = false; // Set flag to false if any field is empty
                field.style.border = '2px solid red'; // Add red border for visual feedback
            } else {
                field.style.border = ''; // Remove red border if field is filled
            }
        });

        // Show alert if any fields are blank
        if (!allFieldsFilled) {
            const alertDiv = `
                <div class="alert alert-danger py-2 px-2" role="alert" id="otpAlert">
                    Please fill in all OTP fields.
                </div>
            `;
            $('#message-otp').html(alertDiv).addClass('show'); // Display alert message

            // Hide the alert after 5 seconds
            setTimeout(() => {
                $('#otpAlert').fadeOut(); // Fade out the alert
                $('#message-otp').empty(); // Clear the message container
            }, 5000); // 5000 milliseconds = 5 seconds

            // Add focus event to hide the alert
            otpFields.forEach((field) => {
                field.addEventListener('focus', () => {
                    $('#otpAlert').fadeOut(); // Fade out the alert
                    $('#message-otp').empty(); // Clear the message container
                });
            });

            return; // Stop the execution if any field is blank
        }

        // Get the OTP value
        let otp = getOTP(); // Use getOTP function to get the OTP

        // Prepare the form data for verification
        let formData = {
            'Reg-OTP': otp // Key must match the name attribute in your HTML form field
        };

        console.log(otp);

        // Send OTP for verification
        $.post('verify-otp.php', formData, function (response) {
            console.log(response); // Log the response for debugging
            
            // Parse the JSON response
            var data = JSON.parse(response);
            
            // Check if the OTP verification was successful
            if (data.success) {
                triggerSuccessModal(); 
                console.log("Account Created!");
            } else {
                triggerErrorModal();
            }
        }).fail(function () {
            // Handle the error when the request fails
            $('#message-otp').text('Failed to verify OTP. Please try again.').addClass('show');
        });
    });
});
</script>

<script>
    // Resend OTP handler
    $('#resendOtpButton').on('click', function (e) {
        e.preventDefault(); // Prevent default button behavior

        // Get the resend button
        const resendButton = $('#resendOtpButton');
        
        // Disable the button and show loading indicator
        resendButton.prop('disabled', true).text('Sending...');

        // Prepare form data for OTP resending
        let formData = {
            first_name: '<?php echo isset($_SESSION['firstName']) ? $_SESSION['firstName'] : ''; ?>',
            middle_name: '<?php echo isset($_SESSION['middleName']) ? $_SESSION['middleName'] : ''; ?>',
            last_name: '<?php echo isset($_SESSION['lastName']) ? $_SESSION['lastName'] : ''; ?>',
            relative_name: '<?php echo isset($_SESSION['relativeName']) ? $_SESSION['relativeName'] : ''; ?>',
            death_date: '<?php echo isset($_SESSION['deathDate']) ? $_SESSION['deathDate'] : ''; ?>',
            email: '<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>', // Include email from session
            password: '<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>', // Include email from session
            contact_number: '<?php echo isset($_SESSION['contactNumber']) ? $_SESSION['contactNumber'] : ''; ?>', // Include contact number from session
        };

        // Debugging output
        console.log(formData);

        // Client-side validation (if needed)
        // Skipping validation as per your earlier implementation

        // Send AJAX POST request to send OTP
        $.ajax({
            url: 'send-otp.php',
            method: 'POST',
            data: formData,
            dataType: 'json', // Expect a JSON response
            success: function (response) {
                console.log('Success response:', response); // Log the response for debugging

                // Handle the response from the server
                if (response.success) {
                    showMessage('A new OTP has been sent to your email', 'success');
                    startResendTimer(resendButton); // Call function to start resend timer
                } else {
                    console.log('OTP sending failed:', response.message);
                    showMessage(response.message, 'danger'); // Show error message
                }
            },
            error: function (xhr, status, error) {
                console.log('Error:', error); // Log error
                console.log('Response:', xhr.responseText); // Log the response for debugging
                showMessage('Failed to resend OTP. Please try again.', 'danger'); // Handle error display
            }
        });
    });

    // Function to display messages
    function showMessage(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        $('#message-otp').html(`<div class="alert ${alertClass}">${message}</div>`).addClass('show');

        // Hide the message after 5 seconds
        setTimeout(function () {
            $('#message-otp').removeClass('show').html(''); // Remove the message
        }, 5000); // 5000 milliseconds = 5 seconds
    }

    // Function to start the resend timer
    function startResendTimer(button) {
        const countdownDuration = 30; // Countdown duration in seconds
        let remainingTime = countdownDuration;

        // Disable the button and add the disabled class
        button.prop('disabled', true).addClass('disabled-button');

        // Update the button text immediately
        button.text(`Resend OTP (${remainingTime}s)`); // Set initial text

        const interval = setInterval(function () {
            remainingTime--;
            button.text(`Resend OTP (${remainingTime}s)`); // Update button text

            if (remainingTime <= 0) {
                clearInterval(interval); // Clear the interval
                button.prop('disabled', false).removeClass('disabled-button'); // Enable the button and remove the class
                button.text('Resend OTP'); // Reset button text
            }
        }, 1000); // 1000ms = 1 second
    }

</script>

<script>
// Assume success condition is triggered here
function triggerSuccessModal() {
    var modalElement = new bootstrap.Modal(document.getElementById('statusSuccessModal'), {
        backdrop: 'static',
        keyboard: false
    });
    modalElement.show(); // Show the modal

    // Add event listener for the "OK" button
    document.querySelector('#statusSuccessModal .btn-success').addEventListener('click', function () {
        window.location.href = 'client-login.php'; // Replace with the actual URL
    });
}


function triggerErrorModal() {
    var modalElement = new bootstrap.Modal(document.getElementById('statusErrorsModal'), {
        backdrop: 'static',
        keyboard: false
    });
    modalElement.show(); // Show the modal
}
</script>


<!-- Modal for confirmation (already included) -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Navigation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Do you want to return to the login page? Any entered information will be lost.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="client-login.php" class="btn btn-primary">Yes, go to Login Page</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusErrorsModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"> 
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document"> 
        <div class="modal-content"> 
            <div class="modal-body text-center p-lg-4"> 
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#db3646" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" /> 
                    <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3" />
                    <line class="path line" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" X2="34.4" y2="92.2" /> 
                </svg> 
                <h4 class="alert-heading">Invalid OTP</h4>
                <p>The OTP you entered does not match our records. <strong>Please request a new OTP</strong> and ensure your entry is correct before trying again!</p>
                <button type="button" class="btn btn-sm mt-3 btn-danger" data-bs-dismiss="modal">Ok</button> 
            </div> 
        </div> 
    </div> 
</div>

<div class="modal fade" id="statusSuccessModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"> 
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document"> 
        <div class="modal-content"> 
            <div class="modal-body text-center p-lg-4"> 
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                    <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                    <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " /> 
                </svg> 
                <h4 class="text-success mt-3">Congratulations!</h4> 
                <p class="mt-3">You have successfully registered. Please await email confirmation before logging in.</p>
                <button type="button" class="btn btn-sm mt-3 btn-success" data-bs-dismiss="modal">Ok</button> 
            </div> 
        </div> 
    </div> 
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js'></script>




</body>
</html>

