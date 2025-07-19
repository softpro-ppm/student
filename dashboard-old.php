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
    <title>SOFTPRO | ADMIN | Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
    <link rel="stylesheet" href="css/icheck/skins/line/blue.css">
    <link rel="stylesheet" href="css/icheck/skins/line/red.css">
    <link rel="stylesheet" href="css/icheck/skins/line/green.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">

                <?php include('includes/leftbar.php'); ?>

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-sm-6">
                                <h2 class="title">Softpro Dashboard</h2>

                            </div>
                            <!-- /.col-sm-6 -->
                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.container-fluid -->

                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat bg-primary" href="manage-candidate.php">
                                        <?php
                                            $sql1 = "SELECT CandidateId from tblcandidate";
                                            $query1 = $dbh->prepare($sql1);
                                            $query1->execute();
                                            $totalstudents = $query1->rowCount();
                                            ?>

                                        <span class="number "><?php echo $totalstudents ; ?></span>
                                        <span class="name">Regd Candidates</span>
                                        <span class="bg-icon"><i class="fa fa-users"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <?php
                                        $sql = "SELECT CandidateId from  tblcandidate JOIN tblbatch ON tblcandidate.tblbatch_id = tblbatch.id AND tblbatch.end_date < CURRENT_DATE() ";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $totalclasses = $query->rowCount();
                                        ?>
                                    <a class="dashboard-stat bg-danger" href="trained-candidate.php">

                                        <span class="number"><?php echo htmlentities($totalclasses); ?></span>
                                        <span class="name">Trained Candidates</span>
                                        <span class="bg-icon"><i class="fa fa-ticket"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat bg-warning" href="ongoing-candidate.php">
                                        <?php
                                            $sql2 = "SELECT CandidateId from  tblcandidate JOIN tblbatch ON tblcandidate.tblbatch_id = tblbatch.id AND end_date > CURRENT_DATE() ";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            $totalsubjects = $query2->rowCount();
                                            ?>
                                        <span class="number"><?php echo htmlentities($totalsubjects); ?></span>
                                        <span class="name">Ongoing Candidates</span>
                                        <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat bg-success" href="passed-candidate.php">
                                        <?php
                                            $sql3 = "SELECT tblcandidate.CandidateId,tblcandidateresults.* from  tblcandidate INNER JOIN tblcandidateresults ON tblcandidate.CandidateId = tblcandidateresults.candidate_id AND tblcandidateresults.result='Pass' ";
                                            $query3 = $dbh->prepare($sql3);
                                            $query3->execute();
                                            $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                                            $totalresults = $query3->rowCount();
                                            ?>

                                        <span class="number"><?php echo htmlentities($totalresults); ?></span>
                                        <span class="name">Passed Candidates</span>
                                        <span class="bg-icon"><i class="fa fa-file-text"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <br>
                                    <a class="dashboard-stat bg-warning" href="manage-batch.php">
                                        <?php
                                            $sql3 = "SELECT DISTINCT batch_name from  tblbatch  ";
                                            $query3 = $dbh->prepare($sql3);
                                            $query3->execute();
                                            $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                                            $totalresults = $query3->rowCount();
                                            ?>

                                        <span class="number"><?php echo htmlentities($totalresults); ?></span>
                                        <span class="name">Total Batches</span>
                                        <span class="bg-icon"><i class="fa fa-file-text"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <br>
                                    <a class="dashboard-stat bg-success" href="ongoing-batches.php">
                                        <?php
                                            $sql2 = "SELECT id from  tblbatch WHERE end_date > CURRENT_DATE()";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            $totalsubjects = $query2->rowCount();
                                            ?>
                                        <span class="number"><?php echo htmlentities($totalsubjects); ?></span>
                                        <span class="name">Ongoing Batches</span>
                                        <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <br>
                                    <a class="dashboard-stat bg-primary" href="assed-batches.php">
                                        <?php
                                            $sql2 = "SELECT id from  tblbatch WHERE end_date < CURRENT_DATE()";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            $totalongoingbatches = $query2->rowCount();
                                            ?>
                                        <span
                                            class="number"><?php echo htmlentities($totalongoingbatches); ?></span>
                                        <span class="name">Assed Batches</span>
                                        <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <br>
                                    <a class="dashboard-stat bg-danger" href="manage-subjects.php">
                                        <?php
                                            $sql2 = "SELECT DISTINCT tblcandidate.CandidateId,tblcandidateresults.batch_id from tblcandidate INNER JOIN tblcandidateresults ON tblcandidate.CandidateId = tblcandidateresults.candidate_id ";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            $totalsubjects = $query2->rowCount();
                                            ?>
                                        <span class="number"><?php echo htmlentities($totalsubjects); ?></span>
                                        <span class="name">Batch Results</span>
                                        <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <br>
                                    <a class="dashboard-stat bg-success" href="manage-trainingcenter.php">
                                        <?php
                                            $sql2 = "SELECT TrainingcenterId from  tbltrainingcenter ";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            $totalsubjects = $query2->rowCount();
                                            ?>
                                        <span class="number"><?php echo htmlentities($totalsubjects); ?></span>
                                        <span class="name">Training Centers</span>
                                        <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <br>
                                    <a class="dashboard-stat bg-warning" href="manage-scheme.php">
                                        <?php
                                            $sql2 = "SELECT Schemeid from  tblscheme";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            $totalsubjects = $query2->rowCount();
                                            ?>
                                        <span class="number"><?php echo htmlentities($totalsubjects); ?></span>
                                        <span class="name">Schems</span>
                                        <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <br>
                                    <a class="dashboard-stat bg-danger" href="manage-sector.php">
                                        <?php
                                            $sql2 = "SELECT SectorId from  tblsector ";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            $totalsubjects = $query2->rowCount();
                                            ?>
                                        <span class="number counter"><?php echo htmlentities($totalsubjects); ?></span>
                                        <span class="name">Sectors</span>
                                        <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <br>
                                    <a class="dashboard-stat bg-primary" href="manage-jobroll.php">
                                        <?php
                                            $sql2 = "SELECT JobrollId from  tbljobroll";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            $totalsubjects = $query2->rowCount();
                                            ?>
                                        <span class="number"><?php echo htmlentities($totalsubjects); ?></span>
                                        <span class="name">Job Rolls</span>
                                        <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->



                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->
                    </section>
                    <!-- /.section -->

                </div>
                <!-- /.main-page -->


            </div>
            <!-- /.content-container -->
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /.main-wrapper -->

    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="js/waypoint/waypoints.min.js"></script>
    <script src="js/counterUp/jquery.counterup.min.js"></script>
    <script src="js/amcharts/amcharts.js"></script>
    <script src="js/amcharts/serial.js"></script>
    <script src="js/amcharts/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="js/amcharts/plugins/export/export.css" type="text/css" media="all" />
    <script src="js/amcharts/themes/light.js"></script>
    <script src="js/toastr/toastr.min.js"></script>
    <script src="js/icheck/icheck.min.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script src="js/production-chart.js"></script>
    <script src="js/traffic-chart.js"></script>
    <script src="js/task-list.js"></script>
    <script>
    $(function() {

        // Counter for dashboard stats
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });

        // Welcome notification
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr["success"]("Welcome to SOFTPRO MIS!");

    });
    </script>
</body>

</html>
<?php } ?>