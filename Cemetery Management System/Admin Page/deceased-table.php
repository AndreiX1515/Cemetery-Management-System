<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login-query.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <?php include('head.php'); ?>
  <!-- Custom styles for this page -->
  <link href="..\vendor\datatablesdataTables.bootstrap4.min.css" rel="stylesheet">

  <link rel="stylesheet" href="../Admin Page/css/cards.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../Admin Page/css/tables.css?v=<?php echo time(); ?>">
</head>

<body id="page-top">
  <div id="wrapper">

    <?php include('..\Admin Page\includes-ap\sidebar.php'); ?>

    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <?php include('..\Admin Page\includes-ap\topbar.php'); ?>

        <div class="container-fluid py-4 px-5">
          <div class="main-header w-100 mb-5">
              <h3 class="font-weight-bold">Deceased Records</h3>
          </div>

          <div class="main-body">
            <div class="table-container ">
                <div class="table-header mb-4">
                    <!-- Search and Sort Controls -->
                    <div class="table-header mb-4">
                        <!-- Search and Sort Controls -->
                        <div class="row d-flex align-items-center justify-content-between">
                            <!-- Search Bar with Icon aligned to the left -->
                            <div class="col-md-4 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="searchInput" placeholder="Search for records...">
                                </div>
                            </div>

                            <div class="col-md-7 d-flex justify-content-end">
                                <!-- Sort Column Dropdown -->
                                <div class="col-md-4 mb-2">
                                    <select class="form-control" id="sortColumn">
                                        <option value="Name">Sort by Name</option>
                                        <option value="Position">Sort by Position</option>
                                        <option value="Office">Sort by Office</option>
                                        <option value="Age">Sort by Age</option>
                                        <option value="Start date">Sort by Start Date</option>
                                        <option value="Salary">Sort by Salary</option>
                                    </select>
                                </div>

                                <!-- Sort Order Dropdown -->
                                <div class="col-md-4 mb-2">
                                    <select class="form-control" id="sortOrder">
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Table with checkboxes and pagination -->
                <div class="table-container-body">
                    <table class="table table-striped table-hover table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Death Date</th>
                                <th>Death Age</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                        <tr>
                            <td>George Dela Cruz</td>
                            <td>Sept. 12, 2024</td>
                            <td>61</td>
                            <td>A1 L1 R1 R2</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td> 
                                <div class="dropdown text-center">
                                    <div class="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer; font-size: 16px;">
                                        <i class="fas fa-ellipsis-v" style="color: black;"></i> 
                                    </div>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#" 
                                        data-toggle="modal" 
                                        data-target="#payment_history_modal_">View Full Records</a>
                                        
                                        <a class="dropdown-item" href="#" 
                                        data-toggle="modal" 
                                        data-target="#payment_history_modal_">Update Records</a>
                                        
                                        <a class="dropdown-item" href="#" 
                                        data-toggle="modal" 
                                        data-target="#payment_history_modal_">Delete</a>
                                    </div>
                                </div>

                            </td>
                        </tr>


                        </tbody>
                    </table>

                    <!-- Pagination controls -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end mt-4">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>



              <!-- Optional JavaScript -->
              <script>
                  // Check all checkboxes functionality
                  document.getElementById('checkAll').addEventListener('click', function() {
                      const checkboxes = document.querySelectorAll('.rowCheckbox');
                      checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                  });

                  // Search functionality
                  document.getElementById('searchInput').addEventListener('keyup', function() {
                      const filter = this.value.toLowerCase();
                      const rows = document.querySelectorAll('#tableBody tr');
                      rows.forEach(row => {
                          const cells = row.querySelectorAll('td');
                          const match = Array.from(cells).some(cell => cell.innerText.toLowerCase().includes(filter));
                          row.style.display = match ? '' : 'none';
                      });
                  });

                  // Placeholder for sorting (implement this based on the data you're using)
                  document.getElementById('sortColumn').addEventListener('change', function() {
                      // Implement sorting logic based on selected column and order
                  });
                  document.getElementById('sortOrder').addEventListener('change', function() {
                      // Implement sorting logic based on ascending/descending order
                  });
              </script>
              </div>





              
          </div>
        </div>
      </div>
    </div>

  </div>

                  

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <?php include('smooth-sidebar-transition.php'); ?>

  <?php include('..\Admin Page\includes-ap\scripts.php') ?>
  <!-- Page level custom scripts -->
  <script src="..\js\demo\datatables-demo.js"></script>

</body>

</html>
