<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $batchid = ($_POST['batchid']);
        $trainingcenterid = $_POST['trainingcenterid'];
        $schemeid = $_POST['schemeid'];
        $sectorid = $_POST['sectorid'];
        $jobrollid = $_POST['jobrollid'];
        $batchname = $_POST['batchname'];
        $sdate = $_POST['start_date'];
        $edate = $_POST['end_date'];
        $stime = $_POST['start_time'];
        $etime = $_POST['end_time'];
        $sql = "update  tblbatch set training_centre_id=:trainingcenter_id,scheme_id=:scheme_id,sector_id=:sector_id,job_roll_id=:job_roll_id,batch_name=:batch_name,
        start_date=:sdate,end_date=:edate,start_time=:stime,end_time=:etime
        where id=:batchid ";
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

        if ($query->execute()) {
            $msg = "Batch info updated successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN </title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
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

    function getbatch(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'sectorid=' + val,
            success: function(data) {
                $("#jobrollid").html(data);

            }
        });
    }
    </script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <!-- ========== LEFT SIDEBAR ========== -->
                <?php include('includes/leftbar.php'); ?>
                <!-- /.left-sidebar -->
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Edit Batch</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Edit Batch</li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-body">
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
                                        <form class="form-horizontal" action="edit-batch.php" method="post">
                                            <?php
                                            $batchid = intval($_GET['batchid']);
                                            $sql = "SELECT tbltrainingcenter.trainingcentername,tblscheme.SchemeName,tblsector.SectorName,tbljobroll.jobrollname,tblbatch.* from tbltrainingcenter,tblscheme,tblsector,tbljobroll,tblbatch WHERE tblbatch.training_centre_id  = tbltrainingcenter.TrainingcenterId AND tblbatch.scheme_id = tblscheme.SchemeId AND tblbatch.sector_id = tblsector.SectorId AND tblbatch.job_roll_id = tbljobroll.JobrollId AND tblbatch.id=:batchid";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':batchid', $batchid, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {   ?>
                                            <input type="hidden" name="batchid" value="<?php echo $batchid; ?>">
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Training
                                                    Center</label>
                                                <div class="col-sm-10">
                                                    <select name="trainingcenterid" class="form-control clid"
                                                        id="classid" onChange="getStudent(this.value);"
                                                        required="required">
                                                        <option
                                                            value="<?php echo htmlentities($result->training_centre_id); ?>">
                                                            <?php echo htmlentities($result->trainingcentername); ?>
                                                        </option>
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
                                            <div class="form-group">
                                                <label for="date" class="col-sm-2 control-label ">Scheme Name</label>
                                                <div class="col-sm-10">
                                                    <select name="schemeid" class="form-control stid" id="studentid"
                                                        required="required" onChange="getsector(this.value);">
                                                        <option value="<?php echo htmlentities($result->scheme_id); ?>">
                                                            <?php echo htmlentities($result->SchemeName); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Sector Name</label>
                                                <div class="col-sm-10">
                                                    <select name="sectorid" class="form-control stid" id="sectorid"
                                                        required="required" onChange="getbatch(this.value);">
                                                        <option value="<?php echo htmlentities($result->sector_id); ?>">
                                                            <?php echo htmlentities($result->SectorName); ?></option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Jobroll Name</label>
                                                <div class="col-sm-10">
                                                    <select name="jobrollid" class="form-control stid" id="jobrollid"
                                                        required="required">
                                                        <option
                                                            value="<?php echo htmlentities($result->job_roll_id); ?>">
                                                            <?php echo htmlentities($result->jobrollname); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Batch Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="batchname" class="form-control stid"
                                                        id="batchid" required="required"
                                                        value="<?php echo htmlentities($result->batch_name); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Start Date</label>
                                                <div class="col-sm-4">
                                                    <input type="date" name="start_date" class="form-control stid"
                                                        id="start_date" required="required"
                                                        value="<?php echo htmlentities($result->start_date); ?>">

                                                </div>
                                                <label for="default" class="col-sm-2 control-label">End Date</label>
                                                <div class="col-sm-4">
                                                    <input type="date" name="end_date" class="form-control stid"
                                                        id="end_date" required="required"
                                                        value="<?php echo htmlentities($result->end_date); ?>">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Start Time</label>
                                                <div class="col-sm-4">
                                                    <input type="time" name="start_time" class="form-control stid"
                                                        id="start_time" required="required"
                                                        value="<?php echo htmlentities($result->start_time); ?>">

                                                </div>
                                                <label for="default" class="col-sm-2 control-label">End Time</label>
                                                <div class="col-sm-4">
                                                    <input type="time" name="end_time" class="form-control stid"
                                                        id="end_time" required="required"
                                                        value="<?php echo htmlentities($result->end_time); ?>">

                                                </div>
                                            </div>
                                            <?php }
                                            } ?>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" id="submit"
                                                        class="btn btn-primary">Modify
                                                        Batch</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
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