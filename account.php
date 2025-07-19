<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

  if($_SESSION['user_type'] != 1){
    header("Location: index.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SOFTPRO | ADMIN | Dashboard</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="screen"> -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
  <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
  <link rel="stylesheet" href="css/prism/prism.css" media="screen">
  <link rel="stylesheet" href="css/select2/select2.min.css">
  <link rel="stylesheet" href="css/main.css" media="screen">
  <link rel="stylesheet" href="css/mystyle.css"> 
  <script src="js/modernizr/modernizr.min.js"></script>

      <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">

  <!-- Include DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
  body {
    background-color: #e9ecef;
  }
  .bg-teal { background-color: #00a0a0 !important; }
  .bg-purple { background-color: #6f42c1 !important; }
  .bg-orange { background-color: #fd7e14 !important; }
  .bg-darkblue { background-color: #0d6efd !important; }
  .bg-pink { background-color: #d63384 !important; }
  .bg-indigo { background-color: #4263eb !important; }
  .bg-maroon { background-color: #dc3545 !important; }
  .bg-gold { background-color: #ffc107 !important; }

  .dashboard-card {
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    color: #fff;
    transition: transform 0.3s ease;
    cursor: pointer;
    font-size: 0.9rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  .dashboard-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
  }
  .dashboard-card .icon {
    font-size: 1.8rem;
  }
  .dashboard-card h3 {
    margin: 0;
    font-size: 1.2rem;
    color: white;
  }
  .dashboard-card p {
    margin: 0;
  }

   /* Sidebar styling */
    .sidebar {
      background-color: #343a40;
      min-height: 100vh;
    }
    .sidebar .nav-link {
      color: #adb5bd;
      padding: 0.75rem 1rem;
      font-size: 0.9rem;
    }
    .sidebar .nav-link:hover, .sidebar .nav-link.active {
      color: #fff;
      background-color: #495057;
      border-radius: 0.25rem;
    }
    .sidebar .sidebar-header {
      padding: 1.5rem;
      text-align: center;
      color: #fff;
    }

    .table-bordered th {
        text-align: center;
    }
        
/* Table Styling */
.table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    max-width: 100%;
    background-color: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
}

.table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    padding: 1rem;
    vertical-align: middle;
}

.table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
    color: #495057;
    font-size: 0.9rem;
}

.table tbody tr:last-child td {
    border-bottom: none;
}

/* Enrollment ID styling */
.enrollment-id {
    background-color: #00c1d4;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 500;
    display: inline-block;
    text-decoration: none;
}

.enrollment-id:hover {
    background-color: #00a5b5;
    color: white;
}

/* Status badges */
.badge-pending {
    background-color: #dc3545;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 500;
}

.badge-partial {
    background-color: #ffc107;
    color: #000;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 500;
}

.badge-paid {
    background-color: #28a745;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 500;
}

/* Action button */
.btn-edit {
    background-color: #00c1d4;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-edit:hover {
    background-color: #00a5b5;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* DataTables customization */
.dataTables_wrapper .dataTables_length select {
    padding: 0.375rem 2.25rem 0.375rem 0.75rem;
    border-radius: 6px;
    border: 1px solid #dee2e6;
    background-color: #fff;
}

.dataTables_wrapper .dataTables_filter input {
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    border: 1px solid #dee2e6;
    background-color: #fff;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    margin: 0 2px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #00c1d4 !important;
    border-color: #00c1d4 !important;
    color: white !important;
}

/* Numeric columns alignment */
.text-end {
    text-align: right !important;
}

/* Card styling */
.card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header {
    background-color: #fff;
    border-bottom: 1px solid #dee2e6;
    padding: 1.5rem;
}

.card-body {
    padding: 1.5rem;
}

/* Total amount display */
.total-amount {
    background-color: #f8f9fa;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.total-amount h5 {
    margin: 0;
    color: #495057;
}

.total-amount .amount {
    color: #dc3545;
    font-weight: 600;
}
</style>
</head>
<body>
  <!-- Top Navbar -->
  <?php include('includes/topbar-new.php'); ?>
  
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <?php include('includes/left-sidebar-new.php'); ?>
      <?php  include('includes/leftbar.php'); ?>

      <!-- Main Content -->
      <main class="col-lg-10 col-md-9 p-4">
        <h2 class="mb-4">Account Dashboard</h2>
        <div class="row g-3">

          <!-- Card 1: Regd Candidates Current Month -->
          <div class="col-md-4">
            <div class="dashboard-card bg-indigo">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $currentYear = date("Y");
                    $currentMonth = date("m");
                    $sql1 = "SELECT CandidateId FROM tblcandidate WHERE YEAR(DateCreated) = :currentYear AND MONTH(DateCreated) = :currentMonth";
                    $query1 = $dbh->prepare($sql1);
                    $query1->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
                    $query1->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
                    $query1->execute();
                    $totalstudentsMonth = $query1->rowCount();
                  ?>
                  <h3><?php echo $totalstudentsMonth; ?></h3>
                  <p>Regd Candidates (<?php echo date("F Y"); ?>)</p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>

          <!-- Card 2: Regd Candidates Current Year -->
          <div class="col-md-4">
            <div class="dashboard-card bg-darkblue">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $currentYear = date("Y");
                    $sql1 = "SELECT CandidateId FROM tblcandidate WHERE YEAR(DateCreated) = :currentYear";
                    $query1 = $dbh->prepare($sql1);
                    $query1->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
                    $query1->execute();
                    $totalstudents = $query1->rowCount();
                  ?>
                  <h3><?php echo $totalstudents; ?></h3>
                  <p>Regd Candidates (<?php echo $currentYear; ?>)</p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>


          <!-- Card 3: Total Registered Candidates -->
          <div class="col-md-4">
            <div class="dashboard-card bg-teal">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    // SQL query to count total registered candidates
                    $sql = "SELECT COUNT(*) AS total_candidates FROM tblcandidate";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalCandidates = $result['total_candidates'] ?? 0;
                  ?>
                  <h3><?php echo $totalCandidates; ?></h3>
                  <p>Total Registered Candidates</p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>

          <!-- Card 4: Total Fees Paid & Pending (All Time) -->
          <div class="col-md-4">
            <div class="dashboard-card bg-purple">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    // Fetch both total paid and total pending fees
                    $sql = "SELECT SUM(paid) AS total_paid, SUM(total_fee - paid) AS total_pending FROM payment WHERE total_fee > 0";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalPaid = $result['total_paid'] ?? 0;
                    $totalPending = $result['total_pending'] ?? 0;
                    $totalFees = $totalPaid + $totalPending;
                  ?>
                  <h3>₹ <?php echo number_format($totalFees, 2); ?></h3>
                  <p>Total Fees Summary (All Time)</p>
                </div>
                <div class="icon"><i class="fa-solid fa-scale-balanced"></i></div>
              </div>
            </div>
          </div>


          <!-- Card 5: Total Fees Paid (All Time) -->
          <div class="col-md-4">
            <div class="dashboard-card bg-pink">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    // SQL query to get total fees paid (no date filter)
                    $sql = "SELECT SUM(paid) AS total_fee FROM payment";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalFeePaidAllTime = $result['total_fee'] ?? 0;
                  ?>
                  <h3>₹ <?php echo number_format($totalFeePaidAllTime, 2); ?></h3>
                  <p>Total Fees Paid (All Time)</p>
                </div>
                <div class="icon"><i class="fa-solid fa-indian-rupee-sign"></i></div>
              </div>
            </div>
          </div>




          <!-- Card 6: Total Fees Pending (All Time) -->
          <div class="col-md-4">
            <div class="dashboard-card bg-maroon">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    // SQL query to sum all pending fees without time filter
                    $sql = "SELECT SUM(total_fee - paid) AS pending_amount FROM payment WHERE paid < total_fee";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalPendingFeesAllTime = $result['pending_amount'] ?? 0;
                  ?>
                  <h3>₹ <?php echo number_format($totalPendingFeesAllTime, 2); ?></h3>
                  <p>Total Fees Pending</p>
                </div>
                <div class="icon"><i class="fa-solid fa-wallet"></i></div>
              </div>
            </div>
          </div>



        </div><!-- /.row -->

        <!-- Charts and Data Table -->
        <!-- <div class="container-fluid mt-5">
          <div class="row">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-4">Monthly Register Students Overview</h4>
                  <canvas id="barChart" style="max-height: 300px; height: 100px;"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-5">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-4">Monthly Fees Overview</h4>
                  <canvas id="feesChart" style="max-height: 300px; height: 100px;"></canvas>
                </div>
              </div>
            </div>
          </div>  -->

          <div class="row mt-5 pt-5">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <!-- Fix the chart height here -->
                  <div style="position: relative; height: 400px; max-height: 400px;" class="mt-5">
                    <canvas id="combinedChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="row mt-5">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-4">Pending Payment List</h4>
                  <div class="table-responsive">
                    <table id="example" class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Enrollment ID</th>
                          <th>Candidate Name</th>
                          <th>Phone Number</th>
                          <th>Job Roll</th>
                          <th class="text-end">Pending Amount</th>
                          <th>Payment Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Enrollment ID</th>
                          <th>Candidate Name</th>
                          <th>Phone Number</th>
                          <th>Job Roll</th>
                          <th class="text-end">Pending Amount</th>
                          <th>Payment Status</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php
                          if(isset($_GET['batch'])){
                            $batch_id = $_GET['batch'];
                            $sql = "SELECT * FROM tblcandidate WHERE batch='$batch_id' ORDER BY CandidateId DESC";
                          } else {
                            $sql = "SELECT * FROM tblcandidate ORDER BY CandidateId DESC";
                          }
                          $query = $dbh->prepare($sql);
                          $query->execute();
                          $results = $query->fetchAll(PDO::FETCH_OBJ);
                          
                          if ($query->rowCount() > 0) {
                            $cnt = 1;
                            foreach ($results as $result) {
                              $jobrollname = '';
                              $candidate_id = $result->CandidateId;
                              $p_checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";
                              $p_checkQuery = $dbh->prepare($p_checkSql);
                              $p_checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                              $p_checkQuery->execute();
                              $p_result = $p_checkQuery->fetchAll(PDO::FETCH_ASSOC);

                              $JobrollId = $result->job_roll;
                              $sql4 = "SELECT JobrollId, jobrollname FROM tbljobroll WHERE JobrollId = '$JobrollId' ORDER BY JobrollId DESC";
                              $query4 = $dbh->prepare($sql4);
                              $query4->execute();
                              $result4 = $query4->fetchAll(PDO::FETCH_ASSOC);
                              $jobrollname = $result4[0]['jobrollname'] ?? '';

                              if (count($p_result) == 0 || $p_result[0]['paid'] != $p_result[0]['total_fee']) {


                                $payment_sql = "SELECT paid, total_fee FROM payment WHERE candidate_id = :cid";
                                $payment_query = $dbh->prepare($payment_sql);
                                $payment_query->bindParam(':cid', $result->CandidateId, PDO::PARAM_INT);
                                $payment_query->execute();
                                $payment = $payment_query->fetch(PDO::FETCH_ASSOC);
                                $status = $payment ? 
                                    ($payment['paid'] == $payment['total_fee'] ? 
                                        '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank" class="btn btn-success btn-sm">Paid</a>' : 
                                        '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank" class="btn btn-warning btn-sm">Pending</a>') : 
                                    '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank" class="btn btn-danger btn-sm">Unpaid</a>';

                        ?>


                        <?php
                          $p_checkSql = "SELECT total_fee, paid FROM payment WHERE candidate_id = :candidate_id";
                          $p_checkQuery = $dbh->prepare($p_checkSql);
                          $p_checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                          $p_checkQuery->execute();
                          $p_result = $p_checkQuery->fetchAll(PDO::FETCH_ASSOC);

                          $totalPendingAmount = 0;
                          foreach ($p_result as $row) {
                              $pending = ($row['total_fee'] ?? 0) - ($row['paid'] ?? 0);
                              if ($pending > 0) {
                                  $totalPendingAmount += $pending;
                              }
                          }
                          ?>


                        <tr> 
                          <td><?php echo $cnt++; ?></td>
                          <td>
                            <button type="button" class="enrollment-id" onClick='all_data(<?php echo htmlentities($result->CandidateId); ?>)' data-toggle="modal" data-target="#c_myModal">
                                <?php echo htmlentities($result->enrollmentid); ?>
                            </button>
                          </td>
                          <td><?php echo htmlentities($result->candidatename); ?></td>
                          <td><?php echo htmlentities($result->phonenumber); ?></td>
                          <td><?php echo $jobrollname; ?></td>
                          <td class="text-end"><?php echo number_format($totalPendingAmount, 2); ?></td>
                          <td>
                            <?php
                            /*
                              if (count($p_result) == 0) {
                                echo '<span class="badge-pending">Pending</span>';
                              } elseif ($p_result[0]['paid'] != $p_result[0]['total_fee']) {
                                echo '<span class="badge-partial">Pending</span>';
                              } else {
                                echo '<span class="badge-paid">Paid</span>';
                              }
                                */
                            ?>
                            <?=$status?>
                          </td>
                          <td>
                            <a href="edit-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>" 
                               class="btn-edit" title="Edit Records">
                                <i class="fas fa-edit"></i>
                            </a>
                          </td>
                        </tr>
                        <?php
                              }
                              //$cnt++;
                            }
                          } else {
                        ?>
                        <tr>
                          <td colspan="7">No record found</td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </main>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->

  <!-- Chart Data Preparation -->
  <?php
    $currentMonth = date("m");
    $currentYear = date("Y");
    $monthlyData = [];
    $monthLabels = [];
    for ($i = 0; $i < 12; $i++) {
      $month = date("m", strtotime("-$i months"));
      $year = date("Y", strtotime("-$i months"));
      $sql = "SELECT COUNT(CandidateId) AS total FROM tblcandidate WHERE YEAR(DateCreated) = :year AND MONTH(DateCreated) = :month";
      $query = $dbh->prepare($sql);
      $query->bindParam(':year', $year, PDO::PARAM_INT);
      $query->bindParam(':month', $month, PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      $total = $result['total'] ?? 0;
      $monthlyData[] = $total;
      $monthLabels[] = date("M Y", strtotime("-$i months"));
    }
    $monthlyData = array_reverse($monthlyData);
    $monthLabels = array_reverse($monthLabels);

    $monthlyFeesData = [];
    for ($i = 0; $i < 12; $i++) {
      $month = date("m", strtotime("-$i months"));
      $year = date("Y", strtotime("-$i months"));
      $sql = "SELECT SUM(total_fee) AS total FROM payment WHERE YEAR(created_at) = :year AND MONTH(created_at) = :month";
      $query = $dbh->prepare($sql);
      $query->bindParam(':year', $year, PDO::PARAM_INT);
      $query->bindParam(':month', $month, PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      $total = $result['total'] ?? 0;
      $monthlyFeesData[] = $total;
    }
    $monthlyFeesData = array_reverse($monthlyFeesData);
  ?>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
  <script src="js/select2/select2.min.js"></script>
  <script src="js/main.js"></script>


  <script>
    /*
  document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('barChart').getContext('2d');
    if (window.myBarChart instanceof Chart) {
      window.myBarChart.destroy();
    }
    window.myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($monthLabels); ?>,
        datasets: [{
          label: 'Registered Candidates',
          backgroundColor: '#007bff',
          data: <?php echo json_encode($monthlyData); ?>
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    var ctxf = document.getElementById('feesChart').getContext('2d');
    if (window.myFeesChart instanceof Chart) {
      window.myFeesChart.destroy();
    }
    window.myFeesChart = new Chart(ctxf, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($monthLabels); ?>,
        datasets: [{
          label: 'Monthly Fees Collected (₹)',
          backgroundColor: '#28a745',
          data: <?php echo json_encode($monthlyFeesData); ?>
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  });

  */
  </script>






<script>
  document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('combinedChart').getContext('2d');

    // Destroy existing instance if exists
    if (window.myCombinedChart instanceof Chart) {
      window.myCombinedChart.destroy();
    }

    window.myCombinedChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($monthLabels); ?>,
        datasets: [
          {
            label: 'Registered Candidates',
            data: <?php echo json_encode($monthlyData); ?>,
            backgroundColor: '#0d6efd',
            yAxisID: 'y1'
          },
          {
            label: 'Monthly Fees Collected (₹)',
            data: <?php echo json_encode($monthlyFeesData); ?>,
            backgroundColor: '#198754',
            yAxisID: 'y2'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          mode: 'index',
          intersect: false
        },
        stacked: false,
        scales: {
          y1: {
            type: 'linear',
            position: 'left',
            title: {
              display: true,
              text: 'Candidates'
            },
            beginAtZero: true
          },
          y2: {
            type: 'linear',
            position: 'right',
            title: {
              display: true,
              text: 'Fees Collected'
            },
            beginAtZero: true,
            grid: {
              drawOnChartArea: false
            }
          }
        }
      }
    });
  });
</script>

<!-- Add this script to initialize the DataTables -->
<script>
  $(document).ready(function() {
    $('#example').DataTable({
      "pageLength": 10,
      "responsive": true,
      "order": [[0, "asc"]],
      "columnDefs": [
          { className: "text-end", targets: [5] }
      ],
      "language": {
          "search": "Search:",
          "lengthMenu": "Show _MENU_ entries",
          "info": "Showing _START_ to _END_ of _TOTAL_ entries"
      }
    });
  });
</script>

</body>
</html>
<?php } ?>