<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $invoiceid = $_POST['invoiceid'];
        $invoiceno = $_POST['invoice_no'];
        $invoicedate = $_POST['invoice_date'];
        $manualbatchid = $_POST['manual_batch_id'];
        $trainingcenterid = $_POST['trainingcenterid'];
        $schemeid = $_POST['schemeid'];
        $sectorid = $_POST['sectorid'];
        $jobrollid = $_POST['jobroll_id'];
        $batchid = $_POST['batchid'];
        $tranche = $_POST['tranche'];
        $amount = $_POST['amount'];


        $sql = "UPDATE tblinvoice SET invoiceNo=:invoiceno, invoiceDate=:invoicedate,manualbatchID=:manualbatchid,trainingcenterID=:trainingcenterid,schemeID=:schemeid,sectorID=:sectorid,jobrollID=:jobrollid,batchID=:batchid,tranche=:tranche,invoiceAmount=:amount WHERE invoiceID ='$invoiceid'";
        $query = $dbh->prepare($sql);
        $query->bindParam(':invoiceno', $invoiceno, PDO::PARAM_STR);
        $query->bindParam(':invoicedate', $invoicedate, PDO::PARAM_STR);
        $query->bindParam(':manualbatchid', $manualbatchid, PDO::PARAM_STR);
        $query->bindParam(':trainingcenterid', $trainingcenterid, PDO::PARAM_STR);
        $query->bindParam(':schemeid', $schemeid, PDO::PARAM_STR);
        $query->bindParam(':sectorid', $sectorid, PDO::PARAM_STR);
        $query->bindParam(':jobrollid', $jobrollid, PDO::PARAM_STR);
        $query->bindParam(':batchid', $batchid, PDO::PARAM_STR);
        $query->bindParam(':tranche', $tranche, PDO::PARAM_STR);
        $query->bindParam(':amount', $amount, PDO::PARAM_STR);

        $query->execute();
        if ($query->execute()) {
            $msg = "invoice info updated successfully";
        } else {
            $error = "something wrong";
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

    function getjobroll(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'sectorid=' + val,
            success: function(data) {
                $("#jobroll_id").html(data);

            }
        });
    }

    function getbatch(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'jobroll_id=' + val,
            success: function(data) {
                $("#batchid").html(data);

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
                                <h2 class="title">Add Invoice</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Add Invoice</li>
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
                                        <form class="form-horizontal" method="post">
                                            <?php
                                            $invoiceid = intval($_GET['invoiceid']);
                                            $sql = "SELECT tblinvoice.*,tbltrainingcenter.trainingcentername,tbltrainingcenter.TrainingcenterId,tblscheme.SchemeName,tblscheme.SchemeId,tblsector.SectorName,tblsector.SectorId,tbljobroll.jobrollname,tbljobroll.JobrollId,tblbatch.batch_name,tblbatch.id from tblinvoice JOIN tbltrainingcenter JOIN tblscheme JOIN tblsector JOIN tbljobroll JOIN tblbatch ON tblinvoice.trainingcenterID = tbltrainingcenter.TrainingcenterId AND tblinvoice.schemeID = tblscheme.SchemeId AND tblinvoice.sectorID = tblsector.SectorId AND tblinvoice.jobrollID = tbljobroll.JobrollId AND tblinvoice.batchID = tblbatch.id AND tblinvoice.invoiceID='$invoiceid'";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':invoiceid', $invoiceid, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {   ?>
                                            <input type="hidden" name="invoiceid" value="<?php echo $invoiceid; ?>">
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Invoice no</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="invoice_no" class="form-control"
                                                        id="invoice_no" required="required"
                                                        value="<?php echo htmlentities($result->invoiceNo); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Invoice date</label>
                                                <div class="col-sm-10">
                                                    <input type="date" name="invoice_date" class="form-control"
                                                        id="invoice_date" required="required"
                                                        value="<?php echo htmlentities($result->invoiceDate); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Batch ID</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="manual_batch_id" class="form-control"
                                                        id="manual_batch_id" required="required"
                                                        value="<?php echo htmlentities($result->manualbatchID); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Training
                                                    Center</label>
                                                <div class="col-sm-10">
                                                    <select name="trainingcenterid" class="form-control clid"
                                                        id="classid" onChange="getStudent(this.value);">
                                                        <option
                                                            value="<?php echo htmlentities($result->TrainingcenterId); ?>">
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
                                                        onChange="getsector(this.value);">
                                                        <option value="<?php echo htmlentities($result->scheme_id); ?>">
                                                            <?php echo htmlentities($result->SchemeName); ?></option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Sector Name</label>
                                                <div class="col-sm-10">
                                                    <select name="sectorid" class="form-control stid" id="sectorid"
                                                        onChange="getjobroll(this.value);">
                                                        <option value="<?php echo htmlentities($result->sector_id); ?>">
                                                            <?php echo htmlentities($result->SectorName); ?></option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Jobroll Name</label>
                                                <div class="col-sm-10">
                                                    <select name="jobroll_id" class="form-control stid" id="jobroll_id"
                                                        onChange="getbatch(this.value);">
                                                        <option
                                                            value="<?php echo htmlentities($result->job_roll_id); ?>">
                                                            <?php echo htmlentities($result->jobrollname); ?></option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Batch Name</label>
                                                <div class="col-sm-10">
                                                    <select name="batchid" class="form-control stid" id="batchid">
                                                        <option
                                                            value="<?php echo htmlentities($result->job_roll_id); ?>">
                                                            <?php echo htmlentities($result->batch_name); ?></option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Tranche</label>
                                                <div class="col-sm-10">
                                                    <select name="tranche" class="form-control">
                                                        <option value="<?php echo $result->tranche; ?>">
                                                            <?php echo $result->tranche; ?></option>

                                                        <option value="1ST">1ST</option>
                                                        <option value="2ND">2ND</option>
                                                        <option value="3RD">3RD</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Invoice
                                                    amount</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="amount" class="form-control stid"
                                                        id="amount" required="required"
                                                        value="<?php echo $result->invoiceAmount; ?>">
                                                </div>
                                            </div>
                                            <?php }
                                            } ?>


                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" id="submit"
                                                        class="btn btn-primary">Add
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