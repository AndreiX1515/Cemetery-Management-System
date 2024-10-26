<head>
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
        <form class="login-form" action="../Cemetery Management System/Admin Page/login-query.php" method="POST">

          <div class="d-flex flex-row align-items-center justify-content-center">
            <p class="lead fw-normal mb-4 me-3">Admin Login</p>
          </div>

          <!-- Username input -->
          <div class="form-outline mb-4">
            <input type="text" id="form3Example3" name="form3Example3" class="form-control form-control-lg"
              placeholder="Enter Admin Username" style="color: white;" required />
            <label class="form-label" for="form3Example3" id="loginfield">Username</label>
          </div>

          <!-- Password input with toggle icon -->
          <div class="form-outline mb-3">
            <input type="password" id="form3Example4" name="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" style="color: white;" required />
            <label class="form-label" for="form3Example4" id="loginfield">Password</label>
            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
          </div>

          <!-- Error Message Area -->
          <?php
          session_start(); 
          
          if (isset($_SESSION['error'])) {
              echo '<div class="text-danger d-flex flex-row align-items-center justify-content-center">' . $_SESSION['error'] . '</div>';
              unset($_SESSION['error']); // Clear the message after displaying
          }
          ?>

          <div class="text-center mt-2 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem; margin-bottom: 5px;">Login</button>
          </div>
        </form>
      </div>
      <a href="client-login.php" class="text-white-50 text-decoration-underline" style="position: absolute; bottom: 30px; right: 30px;">Client Login</a>
    </div>
  </section>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>

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

    document.querySelector("form").addEventListener("submit", function(e) {
      var user_name = document.getElementById("form3Example3").value;
      var password = document.getElementById("form3Example4").value;
      
      if (user_name === "" || password === "") {
          alert("Both fields are required.");
          e.preventDefault(); // Prevent form submission
      }
    });
  </script>
</body>