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
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SOFTPRO | ADMIN</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/main.css" media="screen">
  <style>
    /* Moderate Design Customizations */
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    /* Navbar adjustments */
    .navbar {
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    /* Sidebar styling */
    .sidebar {
      background-color: #343a40;
      min-height: 100vh;
    }
    .sidebar .nav-link {
      color: #c2c7d0;
      padding: 0.75rem 1rem;
      font-size: 0.95rem;
    }
    .sidebar .nav-link.active, .sidebar .nav-link:hover {
      color: #fff;
      background-color: #4b545c;
      border-radius: 0.25rem;
    }
    /* Panel styling */
    .panel {
      background-color: #fff;
      border: 1px solid #dee2e6;
      border-radius: 0.25rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      margin-bottom: 1rem;
    }
    .panel-heading {
      padding: 1rem 1.25rem;
      border-bottom: 1px solid #dee2e6;
      background-color: #fff;
    }
    .panel-title h5 {
      margin: 0;
      font-weight: 600;
      color: #333;
    }
    /* DataTable header */
    table.dataTable thead th {
      background-color: #e9ecef;
      color: #333;
    }
    table.dataTable tbody tr:hover {
      background-color: #f1f1f1;
    }
    /* Alert Styling */
    .alert {
      border-radius: 0.25rem;
      font-size: 0.95rem;
    }
    /* Modal styling adjustments */
    .modal-header {
      background-color: #f8f9fa;
      border-bottom: 1px solid #dee2e6;
    }
    .modal-title {
      font-weight: 600;
    }
  </style>
  <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body class="top-navbar-fixed">
  <div class="main-wrapper">
    <!-- Top Navbar -->
    <?php include('includes/topbar.php'); ?>
    <!-- Sidebar and Content Wrapper -->
    <div class="content-wrapper">
      <div class="content-container">
        <?php include('includes/leftbar.php'); ?>

        <div class="main-page">
          <div class="container-fluid">
            <div class="row page-title-div">
              <div class="col-md-6">
                <h2 class="title">Manage Candidate</h2>
              </div>
            </div>
            <div class="row breadcrumb-div">
              <div class="col-md-6">
                <ul class="breadcrumb">
                  <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                  <li>Candidate</li>
                  <li class="active">Manage Candidate</li>
                </ul>
              </div>
            </div>
          </div><!-- /.container-fluid -->

          <section class="section">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <div class="panel-title">
                        <h5>View Candidate Info</h5>
                      </div>
                    </div>
                    <?php if ($msg) { ?>
                      <div class="alert alert-success" role="alert">
                        <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                      </div>
                    <?php } else if ($error) { ?>
                      <div class="alert alert-danger" role="alert">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                      </div>
                    <?php } ?>
                    <div class="p-3 table-responsive">
                      <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Enrollment ID</th>
                            <th>Candidate Name</th>
                            <th>Phone Number</th>
                            <th>Job Roll</th>
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
                            <th>Action</th>
                          </tr>
                        </tfoot>
                        <tbody>
                          <?php 
                          $sql = "SELECT * FROM tblcandidate";
                          $query = $dbh->prepare($sql);
                          $query->execute();
                          $results = $query->fetchAll(PDO::FETCH_OBJ);
                          $cnt = 1;
                          if ($query->rowCount() > 0) {
                              foreach ($results as $result) {
                                  $jobrollname = '';
                                  // Query to fetch job roll name
                                  $JobrollId = $result->job_roll;
                                  $sql4 = "SELECT JobrollId, jobrollname FROM tbljobroll WHERE JobrollId = :jobrollid ORDER BY JobrollId DESC";
                                  $query4 = $dbh->prepare($sql4);
                                  $query4->bindParam(':jobrollid', $JobrollId, PDO::PARAM_STR);
                                  $query4->execute();
                                  $result4 = $query4->fetchAll(PDO::FETCH_ASSOC);
                                  if(!empty($result4)){
                                      $jobrollname = $result4[0]['jobrollname'];
                                  }
                          ?>
                          <tr>
                            <td><?php echo htmlentities($cnt); ?></td>
                            <td>
                              <button type="button" class="btn btn-info btn-sm" onClick='all_data(<?php echo htmlentities($result->CandidateId); ?>)' data-bs-toggle="modal" data-bs-target="#c_myModal">
                                <?php echo htmlentities($result->enrollmentid); ?>
                              </button>
                            </td>
                            <td><?php echo htmlentities($result->candidatename); ?></td>
                            <td><?php echo htmlentities($result->phonenumber); ?></td>
                            <td><?php echo $jobrollname; ?></td>
                            <td>
                              <a class="badge bg-primary text-white" href="edit-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>"><i class="fa-solid fa-edit" title="Edit Record"></i></a>
                              <a class="badge bg-danger text-white delete" id='del_<?php echo htmlentities($result->CandidateId); ?>'><i class="fa-solid fa-trash" title="Delete Record"></i></a>
                              <button type="button" class="btn btn-info btn-sm" onClick='payment_status(<?php echo htmlentities($result->CandidateId); ?>)' data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-indian-rupee-sign" title="Payment Status"></i></button>
                              <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal_<?php echo htmlentities($result->CandidateId); ?>">
                                <i class="fa-solid fa-image"></i>
                              </button>
                            </td>
                          </tr>
                          <!-- Modal for Candidate Documents -->
                          <div class="modal fade" id="myModal_<?php echo htmlentities($result->CandidateId); ?>" tabindex="-1" aria-labelledby="myModalLabel_<?php echo htmlentities($result->CandidateId); ?>" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="myModalLabel_<?php echo htmlentities($result->CandidateId); ?>"><?php echo htmlentities($result->candidatename); ?></h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <p>Photo</p>
                                  <?php 
                                  $doc = $result->candidatephoto;
                                  if($doc == ""){
                                      echo '<i class="fa-solid fa-upload fs-4"></i>';
                                  } else {
                                      echo '<a target="_blank" href="doc/' . htmlentities($result->candidatephoto) . '">
                                              <img style="width:76px; height:44px;" src="doc/' . htmlentities($result->candidatephoto) . '">
                                            </a>';
                                  }
                                  ?>
                                  <hr>
                                  <p>Aadhaar</p>
                                  <?php 
                                  $doc = $result->aadhaarphoto;
                                  if($doc == ""){
                                      echo '<i class="fa-solid fa-upload fs-4"></i>';
                                  } else {
                                      echo '<a target="_blank" href="doc/' . htmlentities($result->aadhaarphoto) . '">
                                              <img style="width:76px; height:44px;" src="doc/' . htmlentities($result->aadhaarphoto) . '">
                                            </a>';
                                  }
                                  ?>
                                  <hr>
                                  <p>Qualification</p>
                                  <?php 
                                  $doc = $result->qualificationphoto;
                                  if($doc == ""){
                                      echo '<i class="fa-solid fa-upload fs-4"></i>';
                                  } else {
                                      echo '<a target="_blank" href="doc/' . htmlentities($result->qualificationphoto) . '">
                                              <img style="width:76px; height:44px;" src="doc/' . htmlentities($result->qualificationphoto) . '">
                                            </a>';
                                  }
                                  ?>
                                  <hr>
                                  <p>Application</p>
                                  <?php 
                                  $doc = $result->applicationphoto;
                                  if($doc == ""){
                                      echo '<i class="fa-solid fa-upload fs-4"></i>';
                                  } else {
                                      echo '<a target="_blank" href="doc/' . htmlentities($result->applicationphoto) . '">
                                              <img style="width:76px; height:44px;" src="doc/' . htmlentities($result->applicationphoto) . '">
                                            </a>';
                                  }
                                  ?>
                                </div>
                                <div class="modal-footer">
                                  <a class="btn btn-success" href="upload-candidate-file.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>">Upload</a>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php 
                              $cnt++;
                              }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div><!-- ./table-responsive -->
                  </div><!-- /.panel -->
                </div><!-- /.col-md-12 -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>
        </div><!-- /.main-page -->

        <!-- Payment Status Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="c_id">Loading...</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal for All Candidate Data -->
        <div class="modal fade" id="c_myModal" tabindex="-1" aria-labelledby="allDataModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="allDataModalLabel">Candidate Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="c_data">Loading...</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.content-container -->
    </div><!-- /.content-wrapper -->
  </div><!-- /.main-wrapper -->

  <!-- jQuery and Bootstrap Bundle (with Popper) -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
  <script src="js/main.js"></script>
  <script>
    // Payment status AJAX function
    function payment_status(id) {
      $("#c_id").html('Loading...');
      $.ajax({
        url: 'payment_status.php',
        type: 'post',
        data: { action: 'action', id: id },
        success: function(res) {
          $("#c_id").html(res);
        }
      });
    }
    // All candidate data AJAX function
    function all_data(id) {
      $("#c_data").html('Loading...');
      $.ajax({
        url: 'candidate_ajax.php',
        type: 'post',
        data: { action: 'action', id: id },
        success: function(res) {
          $("#c_data").html(res);
        }
      });
    }
    // Initialize DataTable and delete functionality
    $(document).ready(function() {
      var table = $('#example').DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false
      });
      // Delete candidate record
      $('#example tbody').on('click', '.delete', function () {
        var el = this;
        var id = this.id.split("_")[1];
        var action = "Delete candidate";
        if(confirm("Are you sure want to delete this?")){
          $.ajax({
            url: 'action.php',
            type: 'POST',
            data: { id: id, action: action },
            success: function(response) {
              if (response == 4) {
                $(el).closest('tr').css('background', 'tomato');
                $(el).closest('tr').fadeOut(800, function(){
                  $(this).remove();
                });
              } else {
                alert('Invalid ID.');
              }
            }
          });
        } else {
          return false;
        }
      });
    });
  </script>
</body>
</html>
<?php } ?>
