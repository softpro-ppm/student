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
    <title>SOFTPRO | ADMIN</title>

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="screen"> -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/mystyle.css"> 
    <script src="js/modernizr/modernizr.min.js"></script>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">
    
    <style>
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 10px; }
        .table-responsive { border-radius: 10px; overflow: hidden; }
        .btn-action { padding: 5px 10px; margin: 0 2px; }
        .thead-dark { background: #212529; color: white; }
/*        .dt-buttons { margin-bottom: 15px; }*/
        .dt-button-collection {
            max-height: 300px; /* Adjust height as needed */
            overflow-y: auto !important;
        }

    </style>
</head>

<body class="bg-light">
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <?php include('includes/topbar-new.php'); ?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <?php include('includes/left-sidebar-new.php'); ?>
                <?php include('includes/leftbar.php'); ?>

                <!-- Main Content -->
                <main class="col-md-9 col-lg-10 px-md-4">
                    <!-- Page Title -->
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2">Manage placement</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item">placement</li>
                            <li class="breadcrumb-item active" aria-current="page">Manage placement</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                    <div class="alert alert-success left-icon-alert" role="alert">
                        <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                    </div><?php } else if ($error) { ?>
                    <div class="alert alert-danger left-icon-alert" role="alert">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                    </div>
                    <?php } ?>
                    
                    <!-- Candidates Table -->
                    <div class="card">
                        
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                
                                <table id="example" class="display table table-striped table-bordered"
                                                cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Candidate Name</th>
                                            <th>Father Name</th>
                                            <th>Aadhar Number</th>
                                            <th>Phone Number</th>
                                            <th>Date of Birth</th>
                                            <th>Org Name</th>
                                            <th>Salary</th>
                                            <th> Date of joining</th>
                                            <th>Location</th>
                                            <th>HR contact no</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Candidate Name</th>
                                            <th>Father Name</th>
                                            <th>Aadhar Number</th>
                                            <th>Phone Number</th>
                                            <th>Date of Birth</th>
                                            <th>Org Name</th>
                                            <th>Salary</th>
                                            <th> Date of joining</th>
                                            <th>Location</th>
                                            <th>HR contact no</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $sql = "SELECT tblcandidate.*,tblplacement.* from tblcandidate JOIN tblplacement ON tblcandidate.CandidateId = tblplacement.candidate_id";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {   ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt); ?></td>
                                            <td><?php echo htmlentities($result->candidatename); ?></td>
                                            <td><?php echo htmlentities($result->fathername); ?></td>
                                            <td><?php echo htmlentities($result->aadharnumber); ?></td>
                                            <td><?php echo htmlentities($result->phonenumber); ?></td>
                                            <td><?php echo htmlentities($result->dateofbirth); ?></td>
                                            <td><?php echo htmlentities($result->org_name); ?></td>
                                            <td><?php echo htmlentities($result->salary); ?></td>
                                            <td><?php echo htmlentities($result->doj); ?></td>
                                            <td><?php echo htmlentities($result->location); ?></td>
                                            <td><?php echo htmlentities($result->hr_contact_no); ?></td>

                                            <td>
                                                <a
                                                    href="edit-placement.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>"><i
                                                        class="fa fa-edit" title="Edit Record"></i> </a>

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
            </div>
        </div>
    </div>

  

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>

    <script>
    $(function($) {
        $('#example').DataTable({
            lengthMenu: [[10, 20, 50, 100, 500], [10, 20, 50, 100, 500]]
        });


        $('#example2').DataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false
        });

        $('#example3').DataTable();
    });
    </script>
    
</body>
</html>


<?php } ?>