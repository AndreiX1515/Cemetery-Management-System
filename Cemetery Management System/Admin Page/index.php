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

  <link rel="stylesheet" href="../Admin Page/includes-ap/cards.css">
</head>

<body id="page-top">
  <div id="wrapper">

    <?php include('..\Admin Page\includes-ap\sidebar.php'); ?>

    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <?php include('..\Admin Page\includes-ap\topbar.php'); ?>

        <div class="container-fluid py-4 px-5">
          <div class="row mb-4">
            <div class="col">
              <h1 class="h3 mb-0 text-gray-700 font-weight-bold">Dashboard</h1>
            </div>
          </div>

          <div class="row">
            <!-- Card 1 -->
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-2 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="h6 card-title text-uppercase text-muted mb-2">Total </h5>
                      <span class="h2 font-weight-bold mb-0">100</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape text-white rounded-circle shadow">
                        <!-- <i class="fas fa-chart-bar"></i> -->
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Since last month</span>
                  </p>
                </div>
              </div>
            </div>

            <!-- Card 2 -->
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-2 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                  <div class="col">
                      <h5 class="h6 card-title text-uppercase text-muted mb-2">Monthly</h5>
                      <span class="h2 font-weight-bold mb-0">100</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape text-white rounded-circle shadow">
                        <!-- <i class="fas fa-chart-pie"></i> -->
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
                    <span class="text-nowrap">Since last week</span>
                  </p>
                </div>
              </div>
            </div>

            <!-- Card 3 -->
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-2 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                  <div class="col">
                      <h5 class="h6 card-title text-uppercase text-muted mb-2">To Expired</h5>
                      <span class="h2 font-weight-bold mb-0">100</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape text-white rounded-circle shadow">
                        <!-- <i class="fas fa-skull"></i> -->
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                    <span class="text-nowrap">Since yesterday</span>
                  </p>
                </div>
              </div>
            </div>

            <!-- Card 4 -->
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-2 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="h6 card-title text-uppercase text-muted mb-2">Active Client Account </h5>
                      <span class="h2 font-weight-bold mb-0">100</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape text-white rounded-circle shadow">
                      <!-- <i class="fas fa-users"></i> -->
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                    <span class="text-nowrap">Since last month</span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-4">

            <!-- Table Accounts -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Active Client Accounts <span class="text-muted">(as of Oct. 20, 2024)</span></h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <div class="card-body-header">
                
                    </div>

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Office</th>
                          <th>Age</th>
                          <th>Start date</th>
                          <th>Salary</th>
                        </tr>
                      </thead>
                      <!-- <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Office</th>
                          <th>Age</th>
                          <th>Start date</th>
                          <th>Salary</th>
                        </tr>
                      </tfoot> -->
                      <tbody>
                        <tr>
                          <td>Tiger Nixon</td>
                          <td>System Architect</td>
                          <td>Edinburgh</td>
                          <td>61</td>
                          <td>2011/04/25</td>
                          <td>$320,800</td>
                        </tr>
                        <tr>
                          <td>Garrett Winters</td>
                          <td>Accountant</td>
                          <td>Tokyo</td>
                          <td>63</td>
                          <td>2011/07/25</td>
                          <td>$170,750</td>
                        </tr>
                        <tr>
                          <td>Ashton Cox</td>
                          <td>Junior Technical Author</td>
                          <td>San Francisco</td>
                          <td>66</td>
                          <td>2009/01/12</td>
                          <td>$86,000</td>
                        </tr>
                        <tr>
                          <td>Cedric Kelly</td>
                          <td>Senior Javascript Developer</td>
                          <td>Edinburgh</td>
                          <td>22</td>
                          <td>2012/03/29</td>
                          <td>$433,060</td>
                        </tr>
                       
                      
                      </tbody>
                    </table>
                  </div>
                </div>


              </div>
            </div>

            <!-- Total/To be Expired/Paid -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Active Accounts</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Total
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-danger"></i> To be Expired
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Paid
                    </span>
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

  <?php include('smooth-sidebar-transition.php'); ?>

  <?php include('..\Admin Page\includes-ap\scripts.php') ?>
  <!-- Page level custom scripts -->
  <script src="..\js\demo\datatables-demo.js"></script>

</body>

</html>
