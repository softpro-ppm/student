<?php
session_start();
if($_SESSION['user_type'] != 1) {
    header("Location: index.php");
}
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

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/mystyle.css"> 
    <script src="js/modernizr/modernizr.min.js"></script>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">

    <!-- Bootstrap 5 CSS -->
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    
    
    <style>
        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .btn-action {
            padding: 5px 10px;
            margin: 0 2px;
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
                        <h1 class="h2">Manage Training Centers</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item">Training Center</li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Training Centers</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } else if ($error) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- Training Centers Table -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Training Center Information</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered" style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th>Address</th>
                                            <th>SPOC Name</th>
                                            <th>SPOC Contact</th>
                                            <th>SPOC Email</th>
                                            <th>User ID</th>
                                            <th>Password</th>
                                            <th>Created</th>
                                            <th>Modified</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = "SELECT * FROM tbltrainingcenter";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($result->trainingcentername); ?></td>
                                                    <td><?php echo htmlentities($result->tclocation); ?></td>
                                                    <td><?php echo htmlentities($result->tcaddress); ?></td>
                                                    <td><?php echo htmlentities($result->spocname); ?></td>
                                                    <td><?php echo htmlentities($result->spoccontact); ?></td>
                                                    <td><?php echo htmlentities($result->spocemailaddress); ?></td>
                                                    <td><?php echo htmlentities($result->tcuserid); ?></td>
                                                    <td>[Protected]</td> <!-- Hide actual password -->
                                                    <td><?php echo htmlentities($result->DateCreated); ?></td>
                                                    <td><?php echo htmlentities($result->DateModified); ?></td>
                                                    <td>
                                                        <a href="edit-trainingcenter.php?trainingcenterid=<?php echo htmlentities($result->TrainingcenterId); ?>" 
                                                           class="btn btn-sm btn-primary btn-action">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-danger btn-action delete" 
                                                                id="del_<?php echo htmlentities($result->TrainingcenterId); ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                        <?php $cnt++;
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

    <!-- Scripts -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="js/main.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#example').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[10, 20, 50, 100, 500], [10, 20, 50, 100, 500]],
            order: [[9, 'desc']], // Sort by Date Created descending
            dom:
              "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>"
        });


        // Delete functionality
        $('.delete').click(function() {
            var el = this;
            var id = this.id;
            var splitid = id.split("_");
            var deleteid = splitid[1];
            var action = "Delete trainingcenter";

            if(confirm("Are you sure you want to delete this training center?")) {
                $.ajax({
                    url: 'action.php',
                    type: 'POST',
                    data: {
                        id: deleteid,
                        action: action
                    },
                    success: function(response) {
                        if (response == 4) {
                            $(el).closest('tr').css('background', '#ffcccc');
                            $(el).closest('tr').fadeOut(800, function() {
                                $(this).remove();
                            });
                        } else {
                            alert('Error deleting training center.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the training center.');
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
<?php } ?>