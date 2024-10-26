<!-- Header Section -->
<header id="header" class="header"  
  style="box-shadow: 0px 11px 17px 0px rgba(74,74,74,0.98);
  -webkit-box-shadow: 0px 11px 17px 0px rgba(74,74,74,0.98);
  -moz-box-shadow: 0px 11px 17px 0px rgba(74,74,74,0.98);">
  
  <!-- Top Bar for Contact Info and Social Media -->
  <div class="top-bar" style="color: #FFFAFA; padding: 0.1rem 0; font-family: var(--nav-font);">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between mb-3">

      <!-- Contact Info -->
      <div class="contact-info">
        <span><i class="bi bi-telephone-fill"></i> +(02) 8363 2343</span>
        <span class="ms-4"><i class="bi bi-envelope-fill"></i> info@stjosephcemetery.com</span>
      </div>

      <!-- Social Icons -->
      <div class="social-icons">
        <a href="#" class="me-2"><i class="bi bi-facebook"></i></a>
        <a href="#" class="me-2"><i class="bi bi-twitter"></i></a>
        <a href="#"><i class="bi bi-instagram"></i></a>
      </div>
    </div>
  </div>
  
  <!-- Navigation Bar with Links and Logo -->
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <!-- Logo -->
    <a href="index.php" class="logo d-flex align-items-center pe-lg-5 fw-bolder" style="color: #50C878">
      St. Joseph Catholic Cemetery
    </a>

    <!-- Navigation Menu -->
    <nav id="navmenu" class="navmenu">
      <ul class="fw-bolder">
        <li><a href="index.php" class="nav-link active">Home</a></li> <!-- Active on Home -->
        <li><a href="about.php" class="nav-link">About Us</a></li> <!-- About Us Link -->
        <li><a href="contact.php" class="nav-link">Contact</a></li> <!-- Contact Link -->
        <li>
          <button type="button" id="navbarLoginButton" class="btn btn-success ms-3">Login</button> <!-- Navbar Login Button -->
        </li>
      </ul>

      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i> <!-- Mobile Navigation Toggle -->
    </nav>
  </div>
</header>

<!-- CSS to set the active state color for the clicked link -->
<style>
  /* Active state for the navigation links */
  .nav-link.active {
    color: #50C878; /* Green color when active */
  }

  /* Sticky header styles */
  .sticky {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000; /* Ensure it stays on top of other elements */
    background-color: #000; /* Ensure background is visible */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Optional shadow */
  }
</style>

<!-- JavaScript to handle click events on nav links and toggle the active class -->
<script>
  // Function to handle active link state
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function() {
      // Remove the 'active' class from all navigation links
      document.querySelectorAll('.nav-link').forEach(item => item.classList.remove('active'));
      // Add the 'active' class to the clicked link
      this.classList.add('active');
    });
  });

  // Redirect to the login page when the login button is clicked
  document.getElementById("navbarLoginButton").onclick = function () {
    location.href = "client-login.php";
  };

  // Add scroll event listener to toggle sticky class
  window.onscroll = function() {
    const header = document.getElementById('header');
    if (window.scrollY > 0) {
      header.classList.add('sticky');
    } else {
      header.classList.remove('sticky');
    }
  };
</script>

<!-- Optional: Uncomment this modal section if you want a modal dialog to appear -->
<!--
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Find Grave</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        ...
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
-->
