<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login-query.php");
    exit();
}

include '../conn.php';
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
              <h3 class="font-weight-bold">Client Records</h3>
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
                    <?php
                        // Fetch records from the clients table
                        $sql = "
                        SELECT 
                            client_id, first_name, middle_name, last_name, password, email, contact_number, relative_name, death_date, confirmation_status, 
                            created_at
                        FROM clients
                        ";
                        $result = $conn->query($sql);
                        ?>

                        <table class="table table-striped table-hover table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Relative Name</th>
                                    <th>Death Date</th>
                                    <th>Death Age</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody id="tableBody">
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $fullName = htmlspecialchars($row["first_name"] . ' ' . $row["middle_name"] . ' ' . $row["last_name"]);
                                        $email = htmlspecialchars($row["email"]);
                                        $contactNumber = htmlspecialchars($row["contact_number"]);
                                        $relativeName = htmlspecialchars($row["relative_name"]);
                                        $deathDate = date("M d, Y", strtotime($row["death_date"]));
                                        $deathAge = htmlspecialchars(date_diff(date_create($row["death_date"]), date_create('now'))->y);


                                        // Concat Variables
                                        $confirmationStatus = htmlspecialchars($row["confirmation_status"]);

                                        $statusBadgeClass = ($row["confirmation_status"] === "Pending") ? "badge-warning" : 
                                                            (($row["confirmation_status"] === "Confirmed") ? "badge-success" : "badge-danger");

                                        echo "<tr>";
                                        echo "<td>$fullName</td>";
                                        echo "<td>$email</td>";
                                        echo "<td>$contactNumber</td>";
                                        echo "<td>$relativeName</td>";
                                        echo "<td>$deathDate</td>";
                                        echo "<td>$deathAge</td>";
                                        echo "<td> <span class='badge $statusBadgeClass'> $confirmationStatus </span></td>";
                                        echo "<td>
                                                <div class='dropdown text-center'>
                                                    <div id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='cursor: pointer; font-size: 16px;'>
                                                        <i class='fas fa-ellipsis-v' style='color: black;'></i>
                                                    </div>
                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                        <a class='dropdown-item' href='#'  
                                                        data-toggle='modal' 
                                                        data-target='#acceptModal_" . htmlspecialchars($row['client_id']) . "'>Accept</a>

                                                        <a class='dropdown-item' href='#' 
                                                        data-toggle='modal' 
                                                        data-target='#rejectModal_" . htmlspecialchars($row['client_id']) . "'>Reject</a>

                                                        <a class='dropdown-item' href='#' 
                                                        data-toggle='modal' 
                                                        data-target='#noticeModal_" . htmlspecialchars($row['client_id']) . "'>Notice Concern</a>
                                                    </div>
                                                </div>
                                            </td>";
                                        echo "</tr>";

                                        // Accept Modal
                                        echo "<div class='modal fade' id='acceptModal_" . htmlspecialchars($row['client_id']) . "' tabindex='-1' role='dialog' aria-labelledby='acceptModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='acceptModalLabel'>Accept Record Confirmation</h5>
                                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                <span aria-hidden='true'>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <p>Are you sure you want to accept this record with ID: " . htmlspecialchars($row['client_id']) . "?</p>
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                            <button type='button' class='btn btn-success confirm-client' data-client-id='" . 
                                                            htmlspecialchars($row['client_id']) . "'>Confirm</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";

                                        // Reject Modal
                                        echo "<div class='modal fade' id='rejectModal_" . htmlspecialchars($row['client_id']) . "' tabindex='-1' role='dialog' aria-labelledby='rejectModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='rejectModalLabel'>Reject Record Confirmation</h5>
                                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                <span aria-hidden='true'>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <p>Are you sure you want to reject this record with ID: " . htmlspecialchars($row['client_id']) . "?</p>
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                            <button type='button' class='btn btn-danger' id='accept-client'>Confirm</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";

                                        // Notice Concern Modal
                                        echo "<div class='modal fade' id='noticeModal_" . htmlspecialchars($row['client_id']) . "' tabindex='-1' role='dialog' aria-labelledby='noticeModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='noticeModalLabel'>Send Notice of Concern</h5>
                                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                <span aria-hidden='true'>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <form id='noticeConcernForm'>
                                                                <div class='form-group'>
                                                                    <label for='subject'>Subject</label>
                                                                    <select class='form-control' id='subject' required>
                                                                        <option value='' disabled selected>Select Subject</option>
                                                                        <option value='Inquiry'>Inquiry</option>
                                                                        <option value='Feedback'>Feedback</option>
                                                                        <option value='Complaint'>Complaint</option>
                                                                    </select>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label for='body'>Message Body</label>
                                                                    <textarea class='form-control' id='body' rows='3' required></textarea>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                            <button type='button' class='btn btn-primary' id='sendNotice'>Send Notice</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>No records found</td></tr>";
                                }

                                // https://getbootstrap.com/docs/5.3/components/toasts/ Toast from success in deletion
                                ?>
                            </tbody>
                        </table>

                        <?php
                        // Close the database connection
                        $conn->close();
                        ?>
                           
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <script>
    $(document).on('click', '.confirm-client', function() {
        const clientId = $(this).data('client-id');
        
        $.ajax({
            type: 'POST',
            url: 'process_accept.php', // Replace with your PHP processing file
            data: { client_id: clientId },
            success: function(response) {
                // Handle success
                alert('Record accepted successfully!');
                $('#acceptModal_' + clientId).modal('hide'); // Hide the modal on success
                // Optionally, refresh or update the UI here
            },
            error: function(xhr, status, error) {
                // Handle error
                alert('An error occurred: ' + error);
            }
        });
    });
  </script>




  <?php include('smooth-sidebar-transition.php'); ?>

  <?php include('..\Admin Page\includes-ap\scripts.php') ?>
  <!-- Page level custom scripts -->
  <script src="..\js\demo\datatables-demo.js"></script>

</body>

</html>
