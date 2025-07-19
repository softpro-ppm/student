<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $batchid = $_POST['batchid'];
        $trainingcenterid = $_POST['trainingcenterid'];
        $schemeid = $_POST['schemeid'];
        $sectorid = $_POST['sectorid'];
        $jobrollid = $_POST['jobrollid'];
        $batchname = $_POST['batchname'];
        $sdate = $_POST['start_date'];
        $edate = $_POST['end_date'];
        $stime = $_POST['start_time'];
        $etime = $_POST['end_time'];
        $sql = "UPDATE tblbatch SET training_centre_id=:trainingcenter_id, scheme_id=:scheme_id, sector_id=:sector_id, job_roll_id=:job_roll_id, batch_name=:batch_name, start_date=:sdate, end_date=:edate, start_time=:stime, end_time=:etime WHERE id=:batchid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':batchid', $batchid, PDO::PARAM_STR);
        $query->bindParam(':trainingcenter_id', $trainingcenterid, PDO::PARAM_STR);
        $query->bindParam(':scheme_id', $schemeid, PDO::PARAM_STR);
        $query->bindParam(':sector_id', $sectorid, PDO::PARAM_STR);
        $query->bindParam(':job_roll_id', $jobrollid, PDO::PARAM_STR);
        $query->bindParam(':batch_name', $batchname, PDO::PARAM_STR);
        $query->bindParam(':sdate', $sdate, PDO::PARAM_STR);
        $query->bindParam(':edate', $edate, PDO::PARAM_STR);
        $query->bindParam(':stime', $stime, PDO::PARAM_STR);
        $query->bindParam(':etime', $etime, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() > 0) {
            $msg = "Batch info updated successfully";
        } else {
            $error = "Something went wrong or no changes were made. Please try again";
        }
    }
}
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
                        <h1 class="h2">Edit Batch</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Batch</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } else if ($error) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- Form -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Modify Batch Details</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $batchid = intval($_GET['batchid']);
                            $sql = "SELECT tbltrainingcenter.trainingcentername, tblscheme.SchemeName, tblsector.SectorName, tbljobroll.jobrollname, tblbatch.* 
                                    FROM tbltrainingcenter, tblscheme, tblsector, tbljobroll, tblbatch 
                                    WHERE tblbatch.training_centre_id = tbltrainingcenter.TrainingcenterId 
                                    AND tblbatch.scheme_id = tblscheme.SchemeId 
                                    AND tblbatch.sector_id = tblsector.SectorId 
                                    AND tblbatch.job_roll_id = tbljobroll.JobrollId 
                                    AND tblbatch.id = :batchid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':batchid', $batchid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) { ?>
                                    <form method="post" action="edit-batch.php">
                                        <input type="hidden" name="batchid" value="<?php echo $batchid; ?>">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="trainingcenterid" class="form-label">Training Center</label>
                                                    <select name="trainingcenterid" class="form-select" id="trainingcenterid" required>
                                                        <option value="<?php echo htmlentities($result->training_centre_id); ?>">
                                                            <?php echo htmlentities($result->trainingcentername); ?>
                                                        </option>
                                                        <?php 
                                                        $sql = "SELECT * FROM tbltrainingcenter";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $trainings = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($trainings as $training) { ?>
                                                                <option value="<?php echo htmlentities($training->TrainingcenterId); ?>">
                                                                    <?php echo htmlentities($training->trainingcentername); ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="schemeid" class="form-label">Scheme</label>
                                                    <select name="schemeid" class="form-select" id="schemeid" required>
                                                        <option value="<?php echo htmlentities($result->scheme_id); ?>">
                                                            <?php echo htmlentities($result->SchemeName); ?>
                                                        </option>
                                                        <?php 
                                                        $sql = "SELECT * FROM tblscheme";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $schemes = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($schemes as $scheme) { ?>
                                                                <option value="<?php echo htmlentities($scheme->SchemeId); ?>">
                                                                    <?php echo htmlentities($scheme->SchemeName); ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="sectorid" class="form-label">Sector</label>
                                                    <select name="sectorid" class="form-select" id="sectorid" required>
                                                        <option value="<?php echo htmlentities($result->sector_id); ?>">
                                                            <?php echo htmlentities($result->SectorName); ?>
                                                        </option>
                                                        <?php 
                                                        $sql = "SELECT * FROM tblsector";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $sectors = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($sectors as $sector) { ?>
                                                                <option value="<?php echo htmlentities($sector->SectorId); ?>">
                                                                    <?php echo htmlentities($sector->SectorName); ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="jobrollid" class="form-label">Job Roll</label>
                                                    <select name="jobrollid" class="form-select" id="jobrollid" required>
                                                        <option value="<?php echo htmlentities($result->job_roll_id); ?>">
                                                            <?php echo htmlentities($result->jobrollname); ?>
                                                        </option>
                                                        <?php 
                                                        $sql = "SELECT * FROM tbljobroll";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $jobrolls = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($jobrolls as $jobroll) { ?>
                                                                <option value="<?php echo htmlentities($jobroll->JobrollId); ?>">
                                                                    <?php echo htmlentities($jobroll->jobrollname); ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="batchname" class="form-label">Batch Name</label>
                                                    <input type="text" name="batchname" class="form-control" id="batchname" 
                                                           value="<?php echo htmlentities($result->batch_name); ?>" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="start_date" class="form-label">Start Date</label>
                                                <input type="date" name="start_date" class="form-control" id="start_date" 
                                                       value="<?php echo htmlentities($result->start_date); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="end_date" class="form-label">End Date</label>
                                                <input type="date" name="end_date" class="form-control" id="end_date" 
                                                       value="<?php echo htmlentities($result->end_date); ?>" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="start_time" class="form-label">Start Time</label>
                                                <input type="time" name="start_time" class="form-control" id="start_time" 
                                                       value="<?php echo htmlentities($result->start_time); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="end_time" class="form-label">End Time</label>
                                                <input type="time" name="end_time" class="form-control" id="end_time" 
                                                       value="<?php echo htmlentities($result->end_time); ?>" required>
                                            </div>
                                        </div>

                                        <button type="submit" name="submit" class="btn btn-primary">
                                            <i class="fas fa-check me-2"></i>Modify Batch
                                        </button>
                                    </form>
                            <?php }
                            } else { ?>
                                <div class="alert alert-warning" role="alert">
                                    No batch found with the provided ID.
                                </div>
                            <?php } ?>
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
    $(document).ready(function() {
        $('#trainingcenterid, #schemeid, #sectorid, #jobrollid').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        // Dynamic loading functions (requires backend implementation in get_student.php)
        $('#trainingcenterid').on('change', function() {
            var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "get_student.php",
                data: 'trainingid=' + val,
                success: function(data) {
                    $("#schemeid").html(data);
                }
            });
        });

        $('#schemeid').on('change', function() {
            var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "get_student.php",
                data: 'schemeid=' + val,
                success: function(data) {
                    $("#sectorid").html(data);
                }
            });
        });

        $('#sectorid').on('change', function() {
            var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "get_student.php",
                data: 'sectorid=' + val,
                success: function(data) {
                    $("#jobrollid").html(data);
                }
            });
        });
    });
    </script>
</body>
</html>