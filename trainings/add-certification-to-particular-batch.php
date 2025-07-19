<?php
session_start();
error_reporting(0);
$batchid = $_GET['batchid'];
include('includes/config.php');
$sql = "SELECT * from tblcandidate WHERE tblbatch_id='$batchid'";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$candidatecount = $query->rowCount();
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {


    if (isset($_POST['submit'])) {
        $date  = mysqli_real_escape_string($dbh, $_POST['date']);
        $candidateid     = $_POST['candidateid'];
        $batchid = $_POST['batchid'];
        $candidatecertification = $_POST['certification'];
        $candidatecertificationphoto = ($_FILES['certificatefile']['name']);
        $candidatecertificationtarget = 'doc/' . basename($candidatecertificationphoto);

        //INSERT
        for ($i = 0; $i < $candidatecount; $i++) {
            $sql = "SELECT * FROM tblcandidatecertification WHERE candidate_id=:candidateid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':candidateid', $candidateid[$i], PDO::PARAM_STR);
            $query->execute();
            $duplicateresultcount = $query->rowCount();
            if ($duplicateresultcount > 0) {

                $sql = "UPDATE tblcandidatecertification SET certification=:certification,certificatedoc=:certificatefile WHERE candidate_id=:candidateid ";
                $query = $dbh->prepare($sql);
                $query->bindParam(':certification', $candidatecertification[$i], PDO::PARAM_STR);
                $query->bindParam(':certificatefile', $candidatecertificationphoto[$i], PDO::PARAM_STR);

                $query->bindParam(':candidateid', $candidateid[$i], PDO::PARAM_STR);
                $query->execute();
                move_uploaded_file($_FILES['certificatefile']['tmp_name'], $candidatecertificationtarget);
                $info = "update";
            } else {
                # code...
                $sql = "INSERT INTO tblcandidatecertification(candidate_id,batch_id,certification,certificatedoc)VALUE(:candidateid,:batchid,:certification,:certificatefile)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':certification', $candidatecertification[$i], PDO::PARAM_STR);
                $query->bindParam(':certificatefile', $candidatecertificationphoto[$i], PDO::PARAM_STR);
                $query->bindParam(':batchid', $batchid, PDO::PARAM_STR);
                $query->bindParam(':candidateid', $candidateid[$i], PDO::PARAM_STR);
                $query->execute();
                move_uploaded_file($_FILES['certificatefile']['tmp_name'], $candidatecertificationtarget);
                $info = "execute";
                // echo $result;
            }
        }
        if (($info == "execute")) {
            $msg = "student certification added successfully";
        } elseif ($info == "update") {
            $msg = "student certification updated successfully";
        } else {
            $error = "student certification failed to add";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .succWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
    </style>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Add certification to particular batch</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Training Center</li>
                                    <li class="active">Add certification to particular batch</li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Add certification to particular batch</h5>
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
                                        <div style="overflow: auto;">
                                            <div class="panel-body p-20">
                                                <form method="post" enctype="multipart/form-data">
                                                    <table id="example"
                                                        class="display table table-striped table-bordered"
                                                        cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Candidate Name</th>
                                                                <th>Father Name</th>
                                                                <th>Aadhar Number</th>
                                                                <th>Phone Number</th>
                                                                <th>Qualification</th>
                                                                <th>Date of Birth</th>
                                                                <th>Gender</th>
                                                                <th>certification</th>

                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Candidate Name</th>
                                                                <th>Father Name</th>
                                                                <th>Aadhar Number</th>
                                                                <th>Phone Number</th>
                                                                <th>Qualification</th>
                                                                <th>Date of Birth</th>
                                                                <th>Gender</th>
                                                                <th>certification</th>

                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <?php $batch = "";
                                                                $cnt = 1;
                                                                if ($candidatecount > 0) {
                                                                    foreach ($results as $result) {   ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo htmlentities($cnt); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->candidatename); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->fathername); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->aadharnumber); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->phonenumber); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->qualification); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->dateofbirth); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->gender); ?>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="candidateid[]"
                                                                        value="<?php echo ($result->CandidateId); ?>">
                                                                    <input type="hidden" name="batchid"
                                                                        value="<?php echo $batchid; ?>">
                                                                    <input type="text" name="certification[]" required>
                                                                </td>
                                                                <!---- <td>
                                                            <input type="file" name="certificatefile[]"  required>                                                                                                                        

                                                                </td> --->
                                                            </tr>
                                                            <?php $cnt = $cnt + 1;
                                                                    }
                                                                } ?>
                                                        </tbody>
                                                    </table>
                                                    <input class="btn btn-success" type="submit" name="submit"
                                                        value="submit">
                                                </form>
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-6 -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                        </div>
                        <!-- /.panel -->
                </div>
                <!-- /.col-md-6 -->
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
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="js/DataTables/datatables.min.js"></script>
    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script>
    $(function($) {
        $('#example').DataTable();
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