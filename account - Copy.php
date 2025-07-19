<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
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
  <style>
    body {
      background-color: #e9ecef;
    }
    /* Custom color theme */
    .bg-teal { background-color: #20c997 !important; }
    .bg-purple { background-color: #6f42c1 !important; }
    .bg-orange { background-color: #fd7e14 !important; }
    .bg-darkblue { background-color: #343a40 !important; }
    .bg-pink { background-color: #e83e8c !important; }
    
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
    /* Small Dashboard Card styling */
    .dashboard-card {
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
      color: #fff;
      transition: transform 0.3s ease;
      cursor: pointer;
      font-size: 0.9rem;
    }
    .dashboard-card:hover {
      transform: translateY(-3px);
    }
    .dashboard-card .icon {
      font-size: 1.8rem;
    }
    .dashboard-card h3 {
      margin: 0;
      font-size: 1.2rem;
    }
    .dashboard-card p {
      margin: 0;
    }
  </style>
</head>
<body>
  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">SOFTPRO Admin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item me-3">
            <a class="nav-link" href="#"><i class="fa-solid fa-user"></i></a>
          </li>
          <li class="nav-item me-3">
            <a class="nav-link" href="#"><i class="fa-solid fa-arrows-alt"></i></a>
          </li>

          <?php
                // Prepare the query to count the rows
                    $sql = "SELECT COUNT(*) AS count FROM emi_list WHERE added_type = 2";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();

                    // Fetch the result
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $count = $result['count'];

                    //print_r($_SESSION);

                   // echo "Total records with added_type 2: " . $count;
                ?>

          <li class="nav-item me-3">
            <a class="nav-link text-danger" href="pending_payment_approval.php">
              <i class="fa-solid fa-credit-card"></i> Pending Approval (<?=$count?>)
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php">
              <i class="fa-solid fa-sign-out-alt"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->

      <?php include('includes/left-sidebar-new.php'); ?>


      <!-- Main Content -->
      <main class="col-lg-10 col-md-9 p-4">
        <h2 class="mb-4">Softpro Account Dashboard</h2>
        <div class="row g-3">

          <!-- Regd Candidates Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-teal">
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
                  <p>Regd Candidates Current Year</p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>

          <!-- Trained Candidates Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-purple">
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
                  <p>Regd Candidates Current Month</p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>

          <div class="col-md-3">
		    <div class="dashboard-card bg-success">
		        <div class="d-flex justify-content-between align-items-center">
		            <div>
		                <?php
		                $currentYear = date("Y");
		                $sql = "SELECT SUM(total_fee) AS total_collection FROM payment WHERE YEAR(created_at) = :currentYear";
		                $query = $dbh->prepare($sql);
		                $query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
		                $query->execute();
		                $result = $query->fetch(PDO::FETCH_ASSOC);
		                $totalCollection = $result['total_collection'] ?? 0; // Default to 0 if no payments found
		                ?>
		                <h3><?php echo number_format($totalCollection, 2); ?></h3>
		                <p>Total Fees (<?php echo $currentYear; ?>)</p>
		            </div>
		            <div class="icon"><i class="fa-solid fa-coins"></i></div>
		        </div>
		    </div>
		</div>

		<div class="col-md-3">
		    <div class="dashboard-card bg-success">
		        <div class="d-flex justify-content-between align-items-center">
		            <div>
		                <?php
		                $currentYear = date("Y");
		                $currentMonth = date("m"); // Get current month as a number (01-12)

		                $sql = "SELECT SUM(total_fee) AS total_collection 
		                        FROM payment 
		                        WHERE YEAR(created_at) = :currentYear 
		                        AND MONTH(created_at) = :currentMonth";

		                $query = $dbh->prepare($sql);
		                $query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
		                $query->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
		                $query->execute();
		                $result = $query->fetch(PDO::FETCH_ASSOC);
		                $totalCollection = $result['total_collection'] ?? 0; // Default to 0 if no payments found
		                ?>
		                <h3><?php echo number_format($totalCollection, 2); ?></h3>
		                <p>Total Fees (<?php echo date("F Y"); ?>)</p> <!-- Displays Month & Year -->
		            </div>
		            <div class="icon"><i class="fa-solid fa-coins"></i></div>
		        </div>
		    </div>
		</div>















    <div class="col-md-3">
        <div class="dashboard-card bg-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <?php
                    $currentYear = date("Y");
                    $currentMonth = date("m"); // Get current month as a number (01-12)

                    $sql = "SELECT SUM(total_fee) AS total_collection 
                            FROM payment 
                            WHERE YEAR(created_at) = :currentYear 
                            AND MONTH(created_at) = :currentMonth";

                    $query = $dbh->prepare($sql);
                    $query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
                    $query->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalCollection = $result['total_collection'] ?? 0; // Default to 0 if no payments found
                    ?>
                    <h3><?php echo number_format($totalCollection, 2); ?></h3>
                    <p>Total Fees (<?php echo date("F Y"); ?>)</p> <!-- Displays Month & Year -->
                </div>
                <div class="icon"><i class="fa-solid fa-coins"></i></div>
            </div>
        </div>
    </div>


    <div class="col-md-3">
        <div class="dashboard-card bg-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <?php
                    $currentYear = date("Y");
                    $currentMonth = date("m"); // Get current month as a number (01-12)

                    $sql = "SELECT SUM(total_fee) AS total_collection 
                            FROM payment 
                            WHERE YEAR(created_at) = :currentYear 
                            AND MONTH(created_at) = :currentMonth";

                    $query = $dbh->prepare($sql);
                    $query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
                    $query->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalCollection = $result['total_collection'] ?? 0; // Default to 0 if no payments found
                    ?>
                    <h3><?php echo number_format($totalCollection, 2); ?></h3>
                    <p>Total Fees (<?php echo date("F Y"); ?>)</p> <!-- Displays Month & Year -->
                </div>
                <div class="icon"><i class="fa-solid fa-coins"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="dashboard-card bg-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <?php
                    $currentYear = date("Y");
                    $currentMonth = date("m"); // Get current month as a number (01-12)

                    $sql = "SELECT SUM(total_fee) AS total_collection 
                            FROM payment 
                            WHERE YEAR(created_at) = :currentYear 
                            AND MONTH(created_at) = :currentMonth";

                    $query = $dbh->prepare($sql);
                    $query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
                    $query->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalCollection = $result['total_collection'] ?? 0; // Default to 0 if no payments found
                    ?>
                    <h3><?php echo number_format($totalCollection, 2); ?></h3>
                    <p>Total Fees (<?php echo date("F Y"); ?>)</p> <!-- Displays Month & Year -->
                </div>
                <div class="icon"><i class="fa-solid fa-coins"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="dashboard-card bg-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <?php
                    $currentYear = date("Y");
                    $currentMonth = date("m"); // Get current month as a number (01-12)

                    $sql = "SELECT SUM(total_fee) AS total_collection 
                            FROM payment 
                            WHERE YEAR(created_at) = :currentYear 
                            AND MONTH(created_at) = :currentMonth";

                    $query = $dbh->prepare($sql);
                    $query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
                    $query->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalCollection = $result['total_collection'] ?? 0; // Default to 0 if no payments found
                    ?>
                    <h3><?php echo number_format($totalCollection, 2); ?></h3>
                    <p>Total Fees (<?php echo date("F Y"); ?>)</p> <!-- Displays Month & Year -->
                </div>
                <div class="icon"><i class="fa-solid fa-coins"></i></div>
            </div>
        </div>
    </div>





	    <div class="container-fluid mt-5">
	        <div class="row">
	            <div class="col-xl-12">
	                <!-- Bar Chart -->
	                <div class="card">
	                    <div class="card-body">
	                        <h4 class="card-title mb-4">Monthly Register Students Overview</h4>
	                        <canvas id="barChart" style="max-height: 300px; height: 100px;"></canvas>
	                        <!-- <div style="width: 100%; height: 450px; margin: auto;">
							    <canvas id="barChart"></canvas>
							</div> -->
	                    </div>
	                    

	                </div>
	            </div>
	        </div>

	        <div class="row mt-5">
	            <div class="col-xl-12">
	                <!-- Bar Chart -->
	                <div class="card">
	                    <div class="card-body">
	                        <h4 class="card-title mb-4">Monthly Fees Overview</h4>
	                        <canvas id="feesChart" style="max-height: 300px; height: 100px;"></canvas>
	                    </div>
	                    

	                </div>
	            </div>
	        </div>

	        
        
	        <div class="row mt-5">
	            <div class="col-lg-12">
	                <div class="card">
	                    <div class="card-body">
	                        <h4 class="card-title mb-4">Data List</h4>
	                        <div class="table-responsive">

	                            
	                            	<table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Enrollment ID</th>
                                                        <th>Candidate Name</th>
                                                        <th>Phone Number</th>
                                                        <th>Job Roll</th>
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
                                                        <th>Payment Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    if(isset($_GET['batch'])){
                                                        $batch_id = $_GET['batch'];
                                                        $sql = "SELECT * from tblcandidate WHERE batch='$batch_id' ORDER BY CandidateId DESC";
                                                    }else{
                                                        $sql = "SELECT * from tblcandidate ORDER BY CandidateId DESC";
                                                    }
                                                     //$sql = "SELECT * from tblcandidate ORDER BY CandidateId DESC";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {


                                                            $jobrollname ='';

                                                             // Payment table
                                                            $candidate_id = $result->CandidateId;
                                                            $p_checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";

                                                            $p_checkQuery = $dbh->prepare($p_checkSql);
                                                            $p_checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                                                            $p_checkQuery->execute();
                                                            $p_result = $p_checkQuery->fetchAll(PDO::FETCH_ASSOC);


                                                            // SQL query to fetch the last tbljobroll
                                                             $JobrollId = $result->job_roll;
                                                        $sql4 = "SELECT JobrollId, jobrollname FROM tbljobroll WHERE JobrollId = '$JobrollId' ORDER BY JobrollId DESC";
                                                        $query4 = $dbh->prepare($sql4);
                                                        $query4->execute();
                                                        $result4 = $query4->fetchAll(PDO::FETCH_ASSOC);
                                                        $jobrollname = $result4[0]['jobrollname'];


                                                        ?>

                                                        <?php if(count($p_result) ==0 OR $p_result[0]['paid'] != $p_result[0]['total_fee']){ ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-info btn-xs" onClick='all_data(<?php echo htmlentities($result->CandidateId); ?>)' data-toggle="modal" data-target="#c_myModal"><?php echo htmlentities($result->enrollmentid); ?></td></button>

                                                        <td><?php echo htmlentities($result->candidatename); ?></td>
                                                        <td><?php echo htmlentities($result->phonenumber); ?></td>
                                                        
                                
                                                        <td><?php echo $jobrollname; ?></td>
                                                    
                                                        

                                                        <?php
                                                        
                                                            $status='';
                                                            if(count($p_result) ==0){
                                                                $status = '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank"><button class="btn btn-danger btn-xs">Pending</button></a>';
                                                            }elseif($p_result[0]['paid'] != $p_result[0]['total_fee']){
                                                                $status = '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank"><button class="btn btn-warning btn-xs">Pending</button></a>';
                                                            }else{
                                                                $status = '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank"><button class="btn btn-success btn-xs">Paid</button></a>';
                                                            }
                                                        ?>

                                                        <td><?=$status ?></td>
                                                        
                                                        <td>
                                                            <a class="btn-info btn-sm" href="edit-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>" title="Edit Records"><i class="fa fa-edit"></i></a>
                                                           
                                                        </td>

                                                        
                                                    </tr>
                                                  <?php } ?>

                                                    <?php $cnt = $cnt + 1;
                                                            }
                                                        }else{ ?>
                                                          <tr>
                                                            <td colspan="7">Not record found</td>
                                                          </tr>
                                                        <?php } ?>


                                                </tbody>
                                            </table>

	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

    







        </div><!-- /.row -->
      </main>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->



  <?php
// Database connection
//require 'config.php'; // Ensure this connects to your database

// Get the current month and year
$currentMonth = date("m");
$currentYear = date("Y");

// Array to store data for the past 12 months
$monthlyData = [];
$monthLabels = [];

for ($i = 0; $i < 12; $i++) {
    // Calculate the month and year for each iteration
    $month = date("m", strtotime("-$i months"));
    $year = date("Y", strtotime("-$i months"));
    
    // Query to count registered candidates for each month
    $sql = "SELECT COUNT(CandidateId) AS total FROM tblcandidate WHERE YEAR(DateCreated) = :year AND MONTH(DateCreated) = :month";
    $query = $dbh->prepare($sql);
    $query->bindParam(':year', $year, PDO::PARAM_INT);
    $query->bindParam(':month', $month, PDO::PARAM_INT);
    $query->execute();
    
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $total = $result['total'] ?? 0; // If no data, default to 0
    
    // Store values in arrays
    $monthlyData[] = $total;
    $monthLabels[] = date("M Y", strtotime("-$i months")); // Month Name + Year (e.g., "Mar 2025")
}

// Reverse arrays to display oldest to newest month
$monthlyData = array_reverse($monthlyData);
$monthLabels = array_reverse($monthLabels);
?>



  <!-- jQuery (Required for DataTables and Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Bundle (JS + Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- <canvas id="barChart"></canvas> -->

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('barChart').getContext('2d');

    // ✅ Destroy existing chart instance if it exists
    if (window.myBarChart instanceof Chart) {
        window.myBarChart.destroy();
    }

    // ✅ Create a new chart instance
    window.myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($monthLabels); ?>, // PHP Array to JS
            datasets: [{
                label: 'Registered Candidates',
                backgroundColor: '#007bff',
                data: <?php echo json_encode($monthlyData); ?> // PHP Array to JS
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // ✅ Prevents infinite height growth
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>


<?php

// Get the current month and year
$currentMonth = date("m");
$currentYear = date("Y");

// Array to store data for the past 12 months
$monthlyFeesData = [];
$monthLabels = [];

for ($i = 0; $i < 12; $i++) {
    // Calculate the month and year for each iteration
    $month = date("m", strtotime("-$i months"));
    $year = date("Y", strtotime("-$i months"));

    // Query to sum total fees collected for each month
    $sql = "SELECT SUM(total_fee) AS total FROM payment WHERE YEAR(created_at) = :year AND MONTH(created_at) = :month";
    $query = $dbh->prepare($sql);
    $query->bindParam(':year', $year, PDO::PARAM_INT);
    $query->bindParam(':month', $month, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
    $total = $result['total'] ?? 0; // If no data, default to 0

    // Store values in arrays
    $monthlyFeesData[] = $total;
    $monthLabels[] = date("M Y", strtotime("-$i months")); // Month Name + Year (e.g., "Mar 2025")
}

// Reverse arrays to display oldest to newest month
$monthlyFeesData = array_reverse($monthlyFeesData);
$monthLabels = array_reverse($monthLabels);
?>


<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctxf = document.getElementById('feesChart').getContext('2d');

    // ✅ Destroy existing chart instance if it exists
    if (window.myFeesChart instanceof Chart) {
        window.myFeesChart.destroy();
    }

    // ✅ Create a new chart instance
    window.myFeesChart = new Chart(ctxf, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($monthLabels); ?>, // PHP Array to JS
            datasets: [{
                label: 'Monthly Fees Collected (₹)',
                backgroundColor: '#28a745', // Green color
                data: <?php echo json_encode($monthlyFeesData); ?> // PHP Array to JS
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // ✅ Allows custom height and width
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>




</body>
</html>
<?php } ?>
