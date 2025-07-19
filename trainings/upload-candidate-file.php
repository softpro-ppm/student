<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['update'])) {

        $cid = ($_POST['candidateid']);

        $candidatephoto = ($_FILES['candidatephoto']['name']);
        $candidatephototarget = 'doc/' . basename($candidatephoto);

        $aadhaarphoto = ($_FILES['aadhaarphoto']['name']);
        $aadhaarphototarget = 'doc/' . basename($aadhaarphoto);

        $qualificationphoto = ($_FILES['qualificationphoto']['name']);
        $qualificationphototarget = 'doc/' . basename($qualificationphoto);

        $applicationphoto = ($_FILES['applicationphoto']['name']);
        $applicationphototarget = 'doc/' . basename($applicationphoto);
        $status = 1;

        $sql = "update  tblcandidate set candidatephoto=:candidatephoto,aadhaarphoto=:aadhaarphoto,qualificationphoto=:qualificationphoto,applicationphoto=:applicationphoto
        where CandidateId=:cid ";
        $query = $dbh->prepare($sql);
        $query->bindParam(':candidatephoto', $candidatephoto, PDO::PARAM_STR);
        $query->bindParam(':aadhaarphoto', $aadhaarphoto, PDO::PARAM_STR);
        $query->bindParam(':qualificationphoto', $qualificationphoto, PDO::PARAM_STR);
        $query->bindParam(':applicationphoto', $applicationphoto, PDO::PARAM_STR);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);


        $query->execute();
        move_uploaded_file($_FILES['candidatephoto']['tmp_name'], $candidatephototarget);
        move_uploaded_file($_FILES['aadhaarphoto']['tmp_name'], $aadhaarphototarget);
        move_uploaded_file($_FILES['qualificationphoto']['tmp_name'], $qualificationphototarget);
        move_uploaded_file($_FILES['applicationphoto']['tmp_name'], $applicationphototarget);

        $msg = "Data has been updated successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-----End Top bar>
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
                                <h2 class="title">Update Candidate Document </h2>
                            </div>

                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="#">Candidate</a></li>
                                    <li class="active">Update Candidate Document</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12" style="background-color: white;">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Update Candidate Document<?php echo $candidatephoto;
                                                                                ?></h5>
                                            </div>
                                        </div>
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
                                        <form method="post" enctype="multipart/form-data">
                                            <?php
                                                $cid = intval($_GET['candidateid']);
                                                $sql = "SELECT * from tblcandidate where CandidateId=:cid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':cid', $cid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {   ?>
                                            <input type="hidden" name="candidateid" value="<?php echo $cid; ?>">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="candidatename">Full Name</label>
                                                    <?php echo htmlentities($result->candidatename); ?>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="fathername">Father Name</label>
                                                    <?php echo htmlentities($result->fathername); ?>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="aadharnumber">Aadhar Number</label>
                                                    <?php echo htmlentities($result->aadharnumber); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="aadharnumber">Phone Number</label>
                                                    <?php echo htmlentities($result->phonenumber); ?>
                                                </div>
                                            </div>
                                                
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="candidatephoto">Upload Photo</label>
                                                        <input type="file" name="candidatephoto" class="form-control" value="<?php echo htmlentities($result->candidatephoto); ?>"
                                                            id="candidatephoto">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="aadharnumber">Upload Aadhaar </label>
                                                        <input type="file" name="aadhaarphoto" class="form-control"
                                                            id="aadhar">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="aadharnumber">Upload Education</label>
                                                        <input type="file" name="qualificationphoto"
                                                            class="form-control" id="qualificationphoto">
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="aadharnumber">Upload Application</label>
                                                            <input type="file" name="applicationphoto"
                                                                class="form-control" id="applicationphoto">
                                                        </div>
                                                        
                                                    </div>


                                                </div>
                                            </div>


                                            <?php }
                                                } ?>
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <button type="submit" name="update"
                                                        class="btn btn-success btn-labeled">Update<span
                                                            class="btn-label btn-label-right"><i
                                                                class="fa fa-check"></i></span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-8 col-md-offset-2 -->
                        </div>
                        <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
                </section>
                <!-- /.section -->
            </div>
            <!-- /.main-page -->
            <!-- /.right-sidebar -->
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

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>

</html>
<?php  } ?>