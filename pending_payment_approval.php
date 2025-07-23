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



    
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />

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
  <link rel="stylesheet" href="css/custom-styles.css">
  <style type="text/css">
      select.input-sm {
            height: 30px;
            line-height: 20px;
        }
  </style>
  <style>
    .text-end {
        text-align: right !important;
    }
  </style>
  <style>
    .rounded-circle {
        border: 1px solid #ddd;
        background-color: #f8f9fa;
    }
  </style>
  <style>
    .sidebar {
        background-color: #343a40 !important;
    }
    .sidebar .nav-link {
        color: #adb5bd;
    }
    .sidebar .nav-link:hover, 
    .sidebar .nav-link.active {
        color: #fff;
        background-color: #495057;
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


      <!-- Main Content -->
      <main class="col-lg-10 col-md-9 p-4">
        <h2 class="mb-4">Pending Approval </h2>
      

      <div class="card">
        <div class="card-body">
            <div class="panel-heading mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <?php
                    // Calculate total pending amount from all pending payments
                    $sql_total = "SELECT 
                        SUM(e.paid) as total_pending 
                        FROM emi_list e 
                        INNER JOIN payment p ON e.candidate_id = p.candidate_id 
                        WHERE e.added_type = 2";
                    $query_total = $dbh->prepare($sql_total);
                    $query_total->execute();
                    $total_result = $query_total->fetch(PDO::FETCH_OBJ);
                    $total_pending = $total_result->total_pending ?? 0;
                    ?>
                    <h5 class="mb-0">
                        Total Pending Amount: <span class="text-danger fw-bold">₹<?= number_format($total_pending, 2) ?></span>
                    </h5>
                </div>
            </div>

            <?php if ($msg) { ?>
                <div class="alert alert-success left-icon-alert" role="alert">
                    <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                </div>
            <?php } else if ($error) { ?>
                <div class="alert alert-danger left-icon-alert" role="alert">
                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                </div>
            <?php } ?>

            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Enrollment ID</th>
                            <th>Name</th>
                            <th>Job Roll</th>
                            <th class="text-end">Total Fee</th>
                            <th class="text-end">Paid</th>
                            <th class="text-end">Balance</th>
                            <th class="text-end">Last Paid</th>
                            <th>Updated On</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $sql = "SELECT * from emi_list where added_type= 2";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;



                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) { 
                                    $candidate_id = $result->candidate_id;

                                    $sql_p = "SELECT * from payment where candidate_id = :candidate_id AND added_type = 2 ORDER BY id DESC LIMIT 1";
                                    $query_p = $dbh->prepare($sql_p);
                                    $query_p->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                                    $query_p->execute();
                                    $results_p = $query_p->fetch(PDO::FETCH_OBJ);

                                    $sql_c = "SELECT * from tblcandidate where CandidateId= '$candidate_id'";
                                    $query_c = $dbh->prepare($sql_c);
                                    $query_c->execute();
                                    $results_c = $query_c->fetchAll(PDO::FETCH_OBJ);

                                    // Fetch job roll name
                                    $jobroll_id = $results_c[0]->job_roll;
                                    $jobroll_name = '';
                                    if ($jobroll_id) {
                                        $sql_j = "SELECT jobrollname FROM tbljobroll WHERE JobrollId = :jobroll_id";
                                        $query_j = $dbh->prepare($sql_j);
                                        $query_j->bindParam(':jobroll_id', $jobroll_id, PDO::PARAM_INT);
                                        $query_j->execute();
                                        $result_j = $query_j->fetch(PDO::FETCH_OBJ);
                                        $jobroll_name = $result_j ? $result_j->jobrollname : '';
                                    }

                        ?>
                    <tr>
                        <td><?php echo htmlentities($cnt); ?></td>
                        <td><?php echo htmlentities($results_c[0]->enrollmentid); ?></td>
                        <td><?php echo htmlentities($results_c[0]->candidatename); ?></td>
                        <td><?php echo htmlentities($jobroll_name); ?></td>
                        <td class="text-end"><?php echo number_format($results_p->total_fee, 2); ?></td>
                        <td class="text-end"><?php echo number_format($results_p->paid, 2); ?></td>
                        <td class="text-end"><?php echo number_format($results_p->balance, 2); ?></td>
                        <td class="text-end" style="background-color: #fffbe6; font-weight: bold;"><?php echo number_format($result->paid, 2); ?></td>
                        <td><?php echo date("d-m-Y", strtotime($result->created)); ?></td>
                        <td class="text-center">
                            <?php if($_SESSION['user_type']!=1) { ?>
                                <span class="badge bg-warning">Pending Approval</span>
                            <?php } else { ?>
                                <button class="btn btn-info btn-sm" onclick="updateStatus(<?php echo htmlentities($result->candidate_id); ?>, <?php echo htmlentities($result->id); ?>)">
                                    Approve
                                </button>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $cnt = $cnt + 1;
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>
</div><!-- /.row -->
</div><!-- /.container-fluid -->

<!-- Bootstrap Bundle with Popper -->
  

<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/pace/pace.min.js"></script>
<script src="js/lobipanel/lobipanel.min.js"></script>
<script src="js/iscroll/iscroll.js"></script>
<script src="js/prism/prism.js"></script>
<script src="js/select2/select2.min.js"></script>
<script src="js/DataTables/datatables.min.js"></script>
<script src="js/main.js"></script>

    


<script>
$(document).ready(function() {
    $('#example').DataTable({
        "order": [[0, "asc"]],
        "pageLength": 10,
        "responsive": true,
        "columnDefs": [
            { className: "text-end", targets: [3,4,5,6] },
            { className: "text-center", targets: [8] }
        ],
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
});
</script>
</body>
</html>
<?php } ?>


<script>

function updateStatus(candidateId,id) {
    // Ask for confirmation
    if (confirm("Are you sure you want to update the status?")) {
        $.ajax({
            url: 'appve_ajax.php',  // Path to the PHP backend file
            type: 'POST',
            data: { candidate_id: candidateId,id:id },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success'){
                    alert('Status updated successfully!');
                     window.location.reload();
                    // Optionally, update the UI here (e.g., change a label or reload a section)
                } else {
                    alert('Update failed: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('An error occurred while updating the status.');
            }
        });
    }
}


</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all dropdowns
    var dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(function(dropdown) {
        new bootstrap.Dropdown(dropdown);
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<style>
.table {
    font-size: 0.9rem;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: white;
}

.btn-info:hover {
    background-color: #138496;
    border-color: #117a8b;
    color: white;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.text-end {
    text-align: right !important;
}

.text-center {
    text-align: center !important;
}

/* DataTables customization */
.dataTables_wrapper .dataTables_length select {
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    border-radius: 0.25rem;
}

.dataTables_wrapper .dataTables_filter input {
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    border: 1px solid #ced4da;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    margin: 0 0.125rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #17a2b8;
    border-color: #17a2b8;
    color: white !important;
}
</style>

<style>
/* Table Styling */
.custom-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    max-width: 100%;
    background-color: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
}

.custom-table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    padding: 1rem;
    vertical-align: middle;
}

.custom-table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
    color: #495057;
    font-size: 0.9rem;
}

.custom-table tbody tr:last-child td {
    border-bottom: none;
}

/* Button Styles */
.btn-custom {
    background-color: #00c1d4;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-custom:hover {
    background-color: #00a5b5;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    color: white;
}

/* Status Badges */
.badge-custom {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 500;
}

.badge-pending {
    background-color: #dc3545;
    color: white;
}

.badge-partial {
    background-color: #ffc107;
    color: #000;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

/* Card Styling */
.custom-card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.custom-card .card-header {
    background-color: #fff;
    border-bottom: 1px solid #dee2e6;
    padding: 1.5rem;
}

.custom-card .card-body {
    padding: 1.5rem;
}

/* DataTables Custom Styling */
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

/* Utility Classes */
.text-end {
    text-align: right !important;
}

.text-center {
    text-align: center !important;
}

/* Amount Display */
.amount-display {
    background-color: #f8f9fa;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.amount-display .amount {
    color: #dc3545;
    font-weight: 600;
}
</style>

<style>
/* Profile Dropdown Styles */
.profile-dropdown {
    position: relative;
    display: inline-block;
}
.profile-dropdown-toggle {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    display: flex;
    align-items: center;
    transition: background 0.2s;
}
.profile-dropdown-toggle:hover,
.profile-dropdown-toggle:focus {
    background: #f0f0f0;
}
.profile-dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 120%;
    min-width: 180px;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    z-index: 1000;
    padding: 0.5rem 0;
}
.profile-dropdown.open .profile-dropdown-menu {
    display: block;
}
.profile-dropdown-menu a {
    display: block;
    padding: 0.5rem 1.5rem;
    color: #333;
    text-decoration: none;
    transition: background 0.2s;
}
.profile-dropdown-menu a:hover {
    background: #f8f9fa;
    color: #007bff;
}
</style>
