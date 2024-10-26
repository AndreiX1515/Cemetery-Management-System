<?php
session_start(); // Make sure to start the session
?>



<head>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet">
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="assets/css/client-login.css" rel="stylesheet">

  <style>
    .bg-image {
      background-image: url('assets/Images/ExploreHistory_HERO.jpg');
      background-size: cover;
      background-position: center;
      position: relative;
      height: 100vh;
    }

    .bg-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8); /* 80% dark opacity */
      z-index: 1;
    }

    .content-wrapper {
      position: relative;
      z-index: 2;
      padding: 30px;
    }

    .clear-background {
      background-color: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border-radius: 10px;
      padding: 30px;
      max-width: 500px;
      width: 100%;
    }

    /* Back to Homepage button */
    .back-btn {
      position: absolute;
      top: 20px;
      left: 20px;
      z-index: 3; /* Higher z-index than other content */
      background-color: rgba(255, 255, 255, 0.2);
      padding: 10px 20px;
      border-radius: 5px;
      border: none;
      font-size: 16px;
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .back-btn:hover {
      background-color: rgba(255, 255, 255, 0.5);
    }

    /* Show/Hide Password Icon */
    .toggle-password {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #aaa;
    }

    .form-outline {
      position: relative;
      color: #fff;
    }

    .form-outline label{
      color: #fff;
    }

  </style>
</head>

<body>
  <!-- Back to homepage button -->
  <a href="index.php" class="back-btn">
    <i class="fas fa-arrow-left"></i> Back to Homepage
  </a>

  <section class="vh-100 bg-image">
    <div class="bg-overlay"></div>

    <div class="container-fluid content-wrapper align-center">
        <div class="clear-background">
        
      <!-- Uncommented sign-in options -->
      <!-- <div class="d-flex flex-row align-items-center justify-content-center">
          <p class="lead fw-normal mb-0 me-3">Sign in with</p>
          <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-facebook-f"></i>
          </button>
          <button type="button" class="btn btn-warning btn-floating mx-1">
              <i class="fab fa-google"></i>
          </button>
      </div>
      <div class="divider d-flex align-items-center my-4">
          <p class="text-center fw-bold mx-3 mb-0">Or</p>
      </div> -->
      
      <form id="loginForm">
        <!-- Email input -->
        <div class="form-outline mb-4">
            <input type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter a valid email address" style="color: white;" name="email" required />
            <label class="form-label text-light" for="form3Example3">Email address</label>
        </div>

        <!-- Password input with toggle icon -->
        <div class="form-outline mb-3">
            <input type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" name="password" required style="color: white;"/>
            <label class="form-label text-light" for="form3Example4">Password</label>
            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <div class="form-check mb-0">
                <!-- Uncomment this if you want to include the 'Remember me' checkbox -->
                <!-- 
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                <label class="form-check-label" for="form2Example3">
                    Remember me
                </label>
                -->
            </div>
            <a href="#!" class="text-light text-decoration-underline">Forgot password?</a>
        </div>

        <!-- Alert message container -->
        <div id="alertMessage" class="alert text-center" style="display: none; padding: 15px 15px; margin-top: 10px;"></div>

        <div class="text-center mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem; margin-bottom: 10px;" id="loginBtn">Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">
                Don't have an account?
                <a href="#!" class="link-danger text-decoration-underline" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
            </p>
        </div>
    </form>
  </div>
    <a href="admin-login.php" class="text-white-50 text-decoration-underline" style="position: absolute; bottom: 30px; right: 30px;">Admin Login</a>
  </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
      $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Gather form data
            var formData = {
                email: $('#form3Example3').val(), // Get email value
                password: $('#form3Example4').val() // Get password value
            };

            // Clear previous alert message
            $('#alertMessage').hide().removeClass('alert-success alert-danger').text('');

            // AJAX request
            $.ajax({
                url: 'login-process.php', // The PHP script that will handle the login
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Check if the login was successful
                    if (response.success) {
                        // Redirect to a dashboard page after successful login
                        window.location.href = 'client-dashboard.php';
                    } else {
                        // Show error message returned from the server
                        $('#alertMessage').text(response.message).addClass('alert-danger').show();
                        autoCloseAlert(); // Call the function to auto-close the alert
                        focusOnField(); // Focus on the email field if there's an error
                    }
                },
                error: function(xhr, status, error) {
                    // Clear previous messages
                    $('#alertMessage').hide().removeClass('alert-success alert-danger');

                    // Provide more specific error handling
                    if (xhr.status === 0) {
                        $('#alertMessage').text('Network error: Please check your internet connection.').addClass('alert-danger').show();
                    } else if (xhr.status >= 400 && xhr.status < 500) {
                        $('#alertMessage').text('Client error: Please check the entered credentials.').addClass('alert-danger').show();
                    } else if (xhr.status >= 500) {
                        $('#alertMessage').text('Server error: Please try again later.').addClass('alert-danger').show();
                    } else {
                        $('#alertMessage').text('An unexpected error occurred. Please try again later.').addClass('alert-danger').show();
                    }

                    // Log detailed error for debugging
                    console.error('AJAX Error: ', status, error);
                    
                    // Call the function to auto-close the alert
                    autoCloseAlert();
                    focusOnField(); // Focus on the email field if there's an error
                }
            });
        });

        // Function to auto-close the alert message after 5 seconds
        function autoCloseAlert() {
            setTimeout(function() {
                $('#alertMessage').fadeOut(300, function() {
                    $(this).removeClass('alert-danger').text(''); // Optional: clear message after fading out
                });
            }, 5000); // 5000 milliseconds = 5 seconds
        }

        // Function to focus on the email field when there's an error
        function focusOnField() {
            $('#form3Example3').focus(); // Focus on the email field
        }
    });


</script>

    <!-- Modals -->
    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="otpForm">
              <div class="mb-3">
                <label for="emailInput" class="form-label text-dark">Enter your email</label>
                <input type="email" class="form-control" id="emailInput" name="email" placeholder="Enter your email" required>
              </div>
              <div id="emailWarning" class="text-danger" style="display:none;">Please enter a valid email before sending OTP.</div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" id="sendOtpBtn">Send OTP</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Registration Modal -->
      <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="registerModalLabel">Create an Account</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <!-- method="POST" action="register.php" -->
                  <form id="registerForm" method="POST">
                      <!-- Name Section (First Name, Middle Name, Last Name) -->
                      <div class="row g-3">
                          <div class="col-md-4">
                              <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="firstName" name="first_name" required>
                          </div>
                          <div class="col-md-4">
                              <label for="middleName" class="form-label">Middle Name</label>
                              <input type="text" class="form-control" id="middleName" name="middle_name">
                          </div>
                          <div class="col-md-4">
                              <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="lastName" name="last_name" required>
                          </div>
                      </div>
                      <br>
                      <!-- Relative Name and Date of Death Section -->
                      <div class="row g-3">
                          <div class="col-md-6">
                              <label for="relativeName" class="form-label">Relative's Name at Cemetery <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="relativeName" name="relative_name" required>
                          </div>
                          <div class="col-md-6">
                              <label for="deathDate" class="form-label">Date of Death <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="deathDate" name="death_date" required>
                          </div>

                          <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Get today's date in the format 'YYYY-MM-DD'
                                var today = new Date().toISOString().split('T')[0];

                                // Set the max attribute to today's date
                                document.getElementById('deathDate').setAttribute('max', today);
                            });
                        </script>

                      </div>
                      <br>
                      <!-- Email -->
                      <div class="mb-3">
                          <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                          <input type="email" class="form-control" id="email" name="email" required>
                      </div>

                      <div class="message-1 mb-3 fw-bold" id="message-1"> </div>


                      <!-- Contact Number -->
                      <div class="mb-3">
                          <label for="contactNumber" class="form-label">Contact Number <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="contactNumber" name="contact_number" required>
                      </div>

                      <!-- Password and Confirm Password -->
                      <div class="mb-3">
                          <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                          <div class="input-group">
                              <input type="password" class="form-control" id="registerPassword" name="password" required minlength="6">
                              <button class="btn btn-secondary password-toggle" type="button" id="toggleRegisterPassword">Show</button>
                          </div>
                      </div>
                      
                      <div class="mb-3">
                          <label for="confirmPassword" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                          <div class="input-group">
                              <input type="password" class="form-control" id="registerConfirmPassword" name="confirm_password" required>
                              <button class="btn btn-secondary password-toggle" type="button" id="toggleRegisterConfirmPassword">Show</button>
                          </div>
                      </div>

                      <!-- Alert Box for Messages -->
                      <div id="alertBox" class="alert alert-danger" style="display: none;"></div>

              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success" form="registerForm" id="registerBtn">Register</button>
              </div>
          </div>
      </div>
  </div>

  <!-- Modal for OTP 
  <div class="modal fade" id="OTPModal" tabindex="-1" aria-labelledby="OTPModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Centered modal 
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="OTPModalLabel">Enter OTP</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>A 6-digit OTP has been sent to your email/phone number. Please enter it below:</p>
          <div class="mb-3">
            <label for="otpInput" class="form-label">One-Time Password</label>
            <input type="text" class="form-control" id="otpInput" placeholder="Enter OTP" maxlength="6">
          </div>
          <p id="otpMessage" class="text-danger d-none">Invalid OTP. Please try again.</p>
          <div class="mt-3">
            <a href="#" id="resendOtpLink">Resend OTP</a>
            <span id="resendTimer" class="text-muted ms-2"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="verifyOtpBtn">Verify OTP</button>
        </div>
      </div>
    </div>
  </div> -->

  <!-- OTP Modal -->
  <div class="modal fade" id="OtpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Enter the Confirmation Code sent to your Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

        <div class="modal-body p-4">
            <div class="primary-text mb-4">
                Let us know this email belongs to you. Enter the code in the email sent to your provided email.
            </div>

            <div class="otp-field-container mb-4">
                <div class="send-otp d-flex flex-row align-items-center mb-4">
                        <div class="form-floating me-3 flex-grow-1">
                            <input type="text" class="form-control" id="floatingOtp" name="Reg-OTP" placeholder="Enter OTP">
                            <label for="floatingOtp">OTP</label>
                        </div>
                </div>

                <!-- Send OTP link with countdown -->
                <a href="#" id="sendOtpLink-modal">Send OTP <span id="otpCountdown"></span></a>
                <div class="message-otp mt-2 fw-bold" id="message-otp"> </div>
            </div>
            
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit Contact Info</button>
            <button type="button" class="btn btn-primary" id="verifyOtpButton">Submit</button>
        </div>

        </div>
    </div>
  </div>

  <!-- REGISTER JS -->
  <script>
    $(document).ready(function () {
    // Email blur event
    $('#email').on('blur', function () {
        let emailField = $(this);
        let email = emailField.val();

        console.log('Email blur triggered'); // Debugging line

        // Clear previous message and reset border
        $('#message-1').text('').removeClass('show');
        emailField.css('border', '');

        // Email format validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            $('#message-1').text('Please enter a valid email address').addClass('show');
            emailField.css('border', '1px solid lightcoral');
            showMessage(); // Call to handle fade out
            return;
        }

        // Check if email is already in use
        $.ajax({
            url: 'email-check.php',
            method: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function (response) {
                if (response.exists) {
                    $('#message-1').text('This email is already in use.').addClass('show');
                    emailField.css('border', '1px solid lightcoral');
                    showMessage(); // Call to handle fade out
                } else {
                    // Reset border if valid
                    emailField.css('border', '');
                }
            },
            error: function () {
                $('#message-1').text('Error checking email. Please try again.').addClass('show');
                showMessage(); // Handle error display
            }
        });
    });

    // Register button event handler
    $('#registerBtn').off('click').on('click', function (e) {
        e.preventDefault();
        handleRegistration();
    });

    // Function to handle message fade out
      function showMessage() {
          // Handle #message-1
          setTimeout(function () {
              $('#message-1').fadeOut(500, function () {
                  $('#alertBox').text('').removeClass('show').hide(); // Reset and hide after fade out
              });
          }, 5000); // 5 seconds delay

          // Handle #message-otp
          setTimeout(function () {
              $('#message-otp').fadeOut(500, function () {
                  $('#alertBox').text('').removeClass('show').hide(); // Reset and hide after fade out
              });
          }, 5000); // 5 seconds delay
      }



    // Registration handler
    function handleRegistration() {
      
      console.log('Handling registration'); // Debugging line
      // Select the fields and trim the values
      let firstNameField = $('#firstName');
      let firstName = firstNameField.val().trim();

      let middleNameField = $('#middleName');
      let middleName = middleNameField.val().trim();

      let lastNameField = $('#lastName');
      let lastName = lastNameField.val().trim();

      let relativeNameField = $('#relativeName');
      let relativeName = relativeNameField.val().trim();

      let deathDateField = $('#deathDate');
      let deathDate = deathDateField.val().trim();

      let emailField = $('#email');
      let email = emailField.val().trim();

      let contactNumberField = $('#contactNumber');
      let contactNumber = contactNumberField.val().trim();

      let passwordField = $('#registerPassword');
      let password = passwordField.val().trim();

      let confirmPasswordField = $('#registerConfirmPassword');
      let confirmPassword = confirmPasswordField.val().trim();

      // Clear previous alert messages and reset borders
      $('#alertBox').hide();
      $('input').css('border', ''); // Reset all input borders

      // Validation logic
      let hasError = false;
      let errorMessage = '';

      if (!firstName) {
          hasError = true;
          firstNameField.css('border', '1px solid lightcoral');
      }

      if (!lastName) {
          hasError = true;
          lastNameField.css('border', '1px solid lightcoral');
      }

      if (!relativeName) {
          hasError = true;
          relativeNameField.css('border', '1px solid lightcoral');
      }

      if (!deathDate) {
          hasError = true;
          deathDateField.css('border', '1px solid lightcoral');
      }

      if (!email) {
          hasError = true;
          emailField.css('border', '1px solid lightcoral');
      }

      if (!contactNumber) {
          hasError = true;
          contactNumberField.css('border', '1px solid lightcoral');
      }

      if (!password) {
          hasError = true;
          passwordField.css('border', '1px solid lightcoral');
      }

      if (!confirmPassword) {
          hasError = true;
          confirmPasswordField.css('border', '1px solid lightcoral');
      }

      // Display alert for missing fields
      if (hasError) {
          $('#alertBox').text('All fields are required').show();
          return;
      }

      // Password length validation
      if (password.length < 8) {
          $('#alertBox').text('Password must be at least 8 characters long').show();
          passwordField.css('border', '1px solid lightcoral');
          return;
      }

      // Check if passwords match
      if (password !== confirmPassword) {
          $('#alertBox').text('Passwords do not match').show();
          confirmPasswordField.css('border', '1px solid lightcoral');
          return;
      }

      // Contact number validation (simple check for 10-15 digits)
      const contactNumberRegex = /^\d{10,15}$/;
      if (!contactNumberRegex.test(contactNumber)) {
          $('#alertBox').text('Please enter a valid contact number (10-15 digits)').show();
          contactNumberField.css('border', '1px solid lightcoral');
          return;
      }

      // Death date validation (assuming date in format YYYY-MM-DD)
      const deathDateRegex = /^\d{4}-\d{2}-\d{2}$/;
      if (!deathDateRegex.test(deathDate)) {
          $('#alertBox').text('Please enter a valid death date (YYYY-MM-DD)').show();
          deathDateField.css('border', '1px solid lightcoral');
          return;
      }

      // Prepare form data for submission
      let formData = {
          first_name: firstName,
          middle_name: middleName,
          last_name: lastName,
          relative_name: relativeName,
          death_date: deathDate,
          email: email,
          contact_number: contactNumber,
          password: password
      };

      // Proceed with form submission logic here (e.g., send via AJAX)
      console.log(formData); // For debugging purposes


          // Client-side validation (skipping as you already implemented it)

          $.ajax({
              url: 'send-otp.php',
              method: 'POST',
              data: formData,
              dataType: 'json', // Expect a JSON response
              success: function (response) {
                  console.log('Success response:', response); // Log the response

                  if (response.success) {
                      window.location.href = 'OTP.php';
                  } else {
                      console.log('OTP sending failed:', response.message);
                      $('#alertBox').text(response.message || 'Failed to send OTP').show(); // Show error message
                  }
              },
              error: function (xhr, status, error) {
                  console.log('Error:', error); // Log error
                  console.log('Response:', xhr.responseText); // Log the response for debugging
                  $('#alertBox').text('Failed to send OTP. Please try again.').show(); // Handle error display
              }
          });
    }
  });
  </script>







  <style>
  /* Change input text color when out of focus */
  .form-control {
    color: black; /* Text color */
  }

  .form-label {
    color: black; /* Text color */
    text-shadow: none;
  }

  .form-control:focus {
    border-color: #50C878; /* Change border color on focus */
    box-shadow: none; /* Remove default shadow */
  }

  /* Override button colors */
  .btn-danger {
    background-color: #dc3545; /* Custom red color for Cancel button */
    color: white; /* Text color */
  }

  .btn-success {
    background-color: #28a745; /* Custom green color for Send OTP and Register buttons */
    color: white; /* Text color */
  }
  </style>


  <!-- Show/Hide Password Script -->
  <script>
      const togglePassword = document.querySelector('#togglePassword');
      const passwordField = document.querySelector('#form3Example4');

      togglePassword.addEventListener('click', function () {
        // Toggle the type attribute
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        // Toggle the icon
        this.classList.toggle('fa-eye-slash');
      });

      // Forgot Password Warning 
      document.getElementById('sendOtpBtn').addEventListener('click', function() {
        var emailInput = document.getElementById('emailInput').value;
        var emailWarning = document.getElementById('emailWarning');

        // Simple email validation (checks if not empty and has "@" symbol)
        if (emailInput === '' || !emailInput.includes('@')) {
          emailWarning.style.display = 'block';  // Show warning
        } else {
          emailWarning.style.display = 'none';   // Hide warning
          // Logic to send OTP (you can add your backend call here)
          alert('OTP sent to your email!');
        }
      });

    document.getElementById('toggleRegisterPassword').addEventListener('click', function () {
      const password = document.getElementById('registerPassword');
      if (password.type === 'password') {
        password.type = 'text';
        this.textContent = 'Hide';
      } else {
        password.type = 'password';
        this.textContent = 'Show';
      }
    });

    document.getElementById('toggleRegisterConfirmPassword').addEventListener('click', function () {
      const confirmPassword = document.getElementById('registerConfirmPassword');
      if (confirmPassword.type === 'password') {
        confirmPassword.type = 'text';
        this.textContent = 'Hide';
      } else {
        confirmPassword.type = 'password';
        this.textContent = 'Show';
      }
    });
  </script>

</body>