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

</head>
<body>
  <!-- Top Navbar -->
  <?php include('includes/topbar-new.php'); ?>
  
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->

      <?php include('includes/left-sidebar-new.php'); ?>
       <?php include('includes/leftbar.php'); ?>


      <!-- Main Content -->
      <main class="col-lg-10 col-md-9 p-4">
        <h2 class="mb-4">
          <i class="fas fa-tachometer-alt me-3 text-primary"></i>
          Softpro Dashboard
        </h2>
        <div class="row g-4">
            <!-- Regd Candidates Card -->
            <div class="col-md-3">
                <div class="dashboard-card bg-primary text-white" onclick="location.href='manage-candidate.php';" data-count="<?php echo $totalstudents; ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php
                            $sql1 = "SELECT CandidateId FROM tblcandidate";
                            $query1 = $dbh->prepare($sql1);
                            $query1->execute();
                            $totalstudents = $query1->rowCount();
                            ?>
                            <h3 class="counter-value"><?php echo $totalstudents; ?></h3>
                            <p>Regd Candidates</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-users"></i></div>
                    </div>
                </div>
            </div>
            <!-- Trained Candidates Card -->
            <div class="col-md-3">
                <div class="dashboard-card bg-success text-white" onclick="location.href='trained-candidate.php';" data-count="<?php echo htmlentities($totalTrained); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php
                            $sql = "SELECT CandidateId FROM tblcandidate 
                                    JOIN tblbatch ON tblcandidate.tblbatch_id = tblbatch.id 
                                    AND tblbatch.end_date < CURRENT_DATE()";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $totalTrained = $query->rowCount();
                            ?>
                            <h3 class="counter-value"><?php echo htmlentities($totalTrained); ?></h3>
                            <p>Trained Candidates</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    </div>
                </div>
            </div>
            <!-- Ongoing Candidates Card -->
            <div class="col-md-3">
                <div class="dashboard-card bg-warning text-dark" onclick="location.href='ongoing-candidate.php';">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php
                            $sql2 = "SELECT CandidateId FROM tblcandidate 
                                     JOIN tblbatch ON tblcandidate.tblbatch_id = tblbatch.id 
                                     AND tblbatch.end_date > CURRENT_DATE()";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $ongoingCandidates = $query2->rowCount();
                            ?>
                            <h3><?php echo htmlentities($ongoingCandidates); ?></h3>
                            <p>Ongoing Candidates</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-spinner"></i></div>
                    </div>
                </div>
            </div>
            <!-- Passed Candidates Card -->
            <div class="col-md-3">
                <div class="dashboard-card bg-info text-white" onclick="location.href='passed-candidate.php';">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php
                            $sql3 = "SELECT tblcandidate.CandidateId, tblcandidateresults.* FROM tblcandidate 
                                     INNER JOIN tblcandidateresults ON tblcandidate.CandidateId = tblcandidateresults.candidate_id 
                                     AND tblcandidateresults.result = 'Pass'";
                            $query3 = $dbh->prepare($sql3);
                            $query3->execute();
                            $totalPassed = $query3->rowCount();
                            ?>
                            <h3><?php echo htmlentities($totalPassed); ?></h3>
                            <p>Passed Candidates</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-check"></i></div>
                    </div>
                </div>
            </div>
            <!-- Total Batches Card -->
            <div class="col-md-3">
                <div class="dashboard-card bg-danger text-white" onclick="location.href='manage-batch.php';">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php
                            $sqlBatch = "SELECT DISTINCT batch_name FROM tblbatch";
                            $queryBatch = $dbh->prepare($sqlBatch);
                            $queryBatch->execute();
                            $totalBatches = $queryBatch->rowCount();
                            ?>
                            <h3><?php echo htmlentities($totalBatches); ?></h3>
                            <p>Total Batches</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-layer-group"></i></div>
                    </div>
                </div>
            </div>
            <!-- Ongoing Batches Card -->
            <div class="col-md-3">
                <div class="dashboard-card bg-teal text-white" onclick="location.href='ongoing-batches.php';">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php
                            $sqlOngoingBatch = "SELECT id FROM tblbatch WHERE end_date > CURRENT_DATE()";
                            $queryOngoingBatch = $dbh->prepare($sqlOngoingBatch);
                            $queryOngoingBatch->execute();
                            $ongoingBatches = $queryOngoingBatch->rowCount();
                            ?>
                            <h3><?php echo htmlentities($ongoingBatches); ?></h3>
                            <p>Ongoing Batches</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-spinner"></i></div>
                    </div>
                </div>
            </div>
            <!-- Assed Batches Card -->
            <div class="col-md-3">
                <div class="dashboard-card bg-purple text-white" onclick="location.href='assed-batches.php';">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php
                            $sqlAssed = "SELECT id FROM tblbatch WHERE end_date < CURRENT_DATE()";
                            $queryAssed = $dbh->prepare($sqlAssed);
                            $queryAssed->execute();
                            $assedBatches = $queryAssed->rowCount();
                            ?>
                            <h3><?php echo htmlentities($assedBatches); ?></h3>
                            <p>Assed Batches</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
            <!-- Batch Results Card -->
            <div class="col-md-3">
                <div class="dashboard-card bg-orange text-white" onclick="location.href='manage-subjects.php';">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php
                            $sqlResults = "SELECT DISTINCT tblcandidate.CandidateId, tblcandidateresults.batch_id 
                                           FROM tblcandidate 
                                           INNER JOIN tblcandidateresults ON tblcandidate.CandidateId = tblcandidateresults.candidate_id";
                            $queryResults = $dbh->prepare($sqlResults);
                            $queryResults->execute();
                            $totalResults = $queryResults->rowCount();
                            ?>
                            <h3><?php echo htmlentities($totalResults); ?></h3>
                            <p>Batch Results</p>
                        </div>
                        <div class="icon"><i class="fa-solid fa-chart-line"></i></div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
<<<<<<< HEAD

        <!-- Dashboard Extra Sections -->
        <div class="row mb-4">
          <!-- Notifications -->
          <div class="col-lg-4">
            <div class="dashboard-section">
              <h5><i class="fa-solid fa-bell me-2 text-warning"></i>Notifications</h5>
              <ul class="notifications-list">
                <li><span class="badge bg-warning me-2">New</span> 3 candidates registered today</li>
                <li><span class="badge bg-info me-2">Info</span> Batch 2025A assessment scheduled</li>
                <li><span class="badge bg-success me-2">Success</span> All payments processed</li>
              </ul>
            </div>
          </div>
          <!-- Recent Activity -->
          <div class="col-lg-4">
            <div class="dashboard-section">
              <h5><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Recent Activity</h5>
              <ul class="recent-activity-list">
                <li>Candidate <b>John Doe</b> added to Batch 2025A</li>
                <li>Result uploaded for Batch 2024B</li>
                <li>Invoice #1234 generated</li>
              </ul>
            </div>
          </div>
          <!-- Quick Links -->
          <div class="col-lg-4">
            <div class="dashboard-section quick-links">
              <h5><i class="fa-solid fa-link me-2 text-success"></i>Quick Links</h5>
              <a href="add-candidate.php" class="btn btn-outline-primary btn-sm mb-2"><i class="fa fa-user-plus me-1"></i> Add Candidate</a>
              <a href="add-batch.php" class="btn btn-outline-success btn-sm mb-2"><i class="fa fa-layer-group me-1"></i> Add Batch</a>
              <a href="manage-results.php" class="btn btn-outline-info btn-sm mb-2"><i class="fa fa-chart-line me-1"></i> Manage Results</a>
              <a href="manage-invoice.php" class="btn btn-outline-warning btn-sm mb-2"><i class="fa fa-file-invoice me-1"></i> Invoices</a>
            </div>
          </div>
        </div>

        <!-- Dashboard Chart -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="dashboard-section">
              <h5><i class="fa-solid fa-chart-line me-2 text-primary"></i>Student Registrations - Last 6 Months</h5>
              <canvas id="registrationChart" height="80"></canvas>
            </div>
          </div>
        </div>
=======
>>>>>>> parent of a241dd1 (a)
    </main>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="js/jquery/jquery-2.2.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="js/bootstrap/bootstrap.min.js"></script>
  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
  <script src="js/select2/select2.min.js"></script>
  <script src="js/main.js"></script>
<<<<<<< HEAD
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Dashboard Chart Example
    document.addEventListener('DOMContentLoaded', function() {
      // Simplified counter animation to prevent blinking
      function animateCounters() {
        const counters = document.querySelectorAll('.counter-value');
        counters.forEach(counter => {
          const target = parseInt(counter.textContent);
          if (target > 0) {
            const increment = Math.max(1, target / 30);
            let current = 0;
            
            const updateCounter = () => {
              if (current < target) {
                current += increment;
                counter.textContent = Math.floor(current);
                setTimeout(updateCounter, 50);
              } else {
                counter.textContent = target;
              }
            };
            
            updateCounter();
          }
        });
      }
      
      // Initialize counter animation
      setTimeout(animateCounters, 200);
      
      // Get 6 months registration data
      <?php
      // Get data for last 6 months
      $months = [];
      $registrations = [];
      
      for ($i = 5; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-$i months"));
        $monthName = date('M Y', strtotime("-$i months"));
        
        $sql = "SELECT COUNT(*) as count FROM tblcandidate WHERE DATE_FORMAT(CreationDate, '%Y-%m') = '$month'";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $months[] = $monthName;
        $registrations[] = (int)$result['count'];
      }
      ?>
      
      // Registration Chart
      var ctx = document.getElementById('registrationChart').getContext('2d');
      var registrationChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: <?php echo json_encode($months); ?>,
          datasets: [{
            label: 'Student Registrations',
            data: <?php echo json_encode($registrations); ?>,
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#667eea',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { 
              display: true,
              position: 'top',
              labels: {
                padding: 20,
                font: {
                  size: 12,
                  weight: '600'
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: 'rgba(0,0,0,0.1)'
              },
              ticks: {
                stepSize: 1
              }
            },
            x: {
              grid: {
                color: 'rgba(0,0,0,0.1)'
              }
            }
          },
          elements: {
            point: {
              hoverBackgroundColor: '#764ba2'
            }
          },
          animation: {
            duration: 1500,
            easing: 'easeInOutQuart'
          }
        }
      });
      
      // Simplified click effects to prevent blinking
      const dashboardCards = document.querySelectorAll('.dashboard-card');
      dashboardCards.forEach(card => {
        card.addEventListener('click', function(e) {
          // Simple scale effect instead of ripple
          card.style.transform = 'scale(0.98)';
          setTimeout(() => {
            card.style.transform = '';
          }, 150);
        });
      });
    });
  </script>
=======
>>>>>>> parent of a241dd1 (a)
</body>
</html>
<?php } ?>
