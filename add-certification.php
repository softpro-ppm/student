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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/mystyle.css"> 
    <script src="js/modernizr/modernizr.min.js"></script>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">

<script>
    function getStudent(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'trainingid=' + val,
            success: function(data) {
                $("#studentid").html(data);
            }
        });
    }

    function getsector(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'schemeid=' + val,
            success: function(data) {
                $("#sectorid").html(data);
            }
        });
    }

    function getjobroll(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'sectorid=' + val,
            success: function(data) {
                $("#jobrollid").html(data);
            }
        });
    }

    function getbatch(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'jobrollid_for_certificate=' + val,
            success: function(data) {
                $("#batchid").html(data);

            }
        });
    }
    </script>
    
    
    <style>
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 10px; }
        .form-control:focus, .select2-container--default .select2-selection--single:focus { 
            border-color: #007bff; 
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25); 
        }
        .select2-container { width: 100% !important; }
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
                        <h1 class="h2">Add certification to batch</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add certification to batch</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                    <div class="alert alert-success left-icon-alert" role="alert">
                        <strong>Well done!</strong>
                        <?php echo htmlentities($msg); ?>
                    </div>
                    <?php } else if ($error) { ?>
                    <div class="alert alert-danger left-icon-alert" role="alert">
                        <strong>Oh snap!</strong>
                        <?php echo htmlentities($error); ?>
                    </div>
                    <?php } ?>

                    <!-- Form -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Add New certification to batch</h5>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal mb-3" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="default" class="control-label">Training
                                                Center</label>
                                            <select name="trainingcenterid" class="form-control clid"
                                                id="classid" onChange="getStudent(this.value);"
                                                required="required">
                                                <option value="">Select Training Center Name</option>
                                                <?php $sql = "SELECT * from tbltrainingcenter";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $trainings = $query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($trainings as $training) {   ?>
                                                <option
                                                    value="<?php echo htmlentities($training->TrainingcenterId); ?>">
                                                    <?php echo htmlentities($training->trainingcentername); ?>&nbsp;
                                                </option>
                                                <?php }
                                                    } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date" class="control-label ">Scheme Name</label>
                                            <select name="schemeid" class="form-control stid" id="studentid"
                                                required="required" onChange="getsector(this.value);">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="default" class="control-label">Sector Name</label>
                                        <select name="sectorid" class="form-control stid" id="sectorid"
                                            required="required" onChange="getjobroll(this.value);">
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="default" class="control-label">Jobroll Name</label>
                                            <select name="jobrollid" class="form-control stid" id="jobrollid"
                                                required="required" onChange="getbatch(this.value);">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                
                            </form>

                            <table id="example" class="display table table-striped table-bordered"
                                            cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Batch Name</th>
                                        <th>Jobroll</th>
                                        <th>Sector</th>
                                        <th>Scheme</th>
                                        <th>Training Center</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Batch Name</th>
                                        <th>Jobroll</th>
                                        <th>Sector</th>
                                        <th>Scheme</th>
                                        <th>Training Center</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody id="batchid">

                                </tbody>
                            </table>

                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
  <script src="js/main.js"></script>

 <script>
    $(function($) {
        $(".js-states").select2();
        $(".js-states-limit").select2({
            maximumSelectionLength: 2
        });
        $(".js-states-hide").select2({
            minimumResultsForSearch: Infinity
        });
    });
    </script>
    
</body>
</html>

<?php } ?>