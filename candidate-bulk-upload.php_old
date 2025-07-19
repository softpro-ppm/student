<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    $uploadedStatus = 0;
    if (isset($_POST["submit"])) {
        if (isset($_FILES["file"])) {
            //if there was an error uploading the file
            if ($_FILES["file"]["error"] > 0) {
                $error =  "Return Code: " . $_FILES["file"]["error"] . "<br />";
            } else {
                if (file_exists($_FILES["file"]["name"])) {
                    unlink($_FILES["file"]["name"]);
                }
                $storagename = "images/bulkfile.xlsx";
                move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
                $uploadedStatus = 1;

                set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
                include 'PHPExcel/IOFactory.php';

                // This is the file path to be uploaded.
                $inputFileName = 'images/bulkfile.xlsx';

                try {
                    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }

                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

                for ($i = 2; $i <= $arrayCount; $i++) {

                    $name = trim($allDataInSheet[$i]["A"]);
                    $fathername = trim($allDataInSheet[$i]["B"]);
                    $aadharnumber = trim($allDataInSheet[$i]["C"]);
                    $phone = trim($allDataInSheet[$i]["D"]);
                    $qualification = trim($allDataInSheet[$i]["E"]);
                    $dob = trim($allDataInSheet[$i]["F"]);
                    $gender = trim($allDataInSheet[$i]["G"]);
                    $marital = trim($allDataInSheet[$i]["H"]);
                    $religion = trim($allDataInSheet[$i]["I"]);
                    $category = trim($allDataInSheet[$i]["J"]);
                    $village = trim($allDataInSheet[$i]["K"]);
                    $mandal = trim($allDataInSheet[$i]["L"]);
                    $district = trim($allDataInSheet[$i]["M"]);
                    $state = trim($allDataInSheet[$i]["N"]);
                    $pincode = trim($allDataInSheet[$i]["O"]);




                    $sql = "SELECT candidatename FROM tblcandidate WHERE aadharnumber = '$aadharnumber' AND phonenumber = '$phone'";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $candidatecount = $query->rowCount();
                    if ($candidatecount == 0) {
                        $insertTable = "INSERT INTO tblcandidate (candidatename,fathername,aadharnumber,phonenumber,qualification,dateofbirth,gender,maritalstatus,religion,category,village,mandal,district,state,pincode)
                                    VALUE ('$name','$fathername','$aadharnumber','$phone','$qualification','$dob','$gender','$marital','$religion','$category','$village','$mandal','$district','$state','$pincode')";
                        $query = $dbh->prepare($insertTable);
                        $query->execute();
                        $msg = "file uploaded successfully";
                    } else {
                        $error = 'Record already exist.';
                    }
                }
            }
        } else {
            $error = "No file selected <br />";
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
                                <h2 class="title">Bulk upload</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Bulk upload</li>
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
                                        <form class="form-horizontal" action="candidate-bulk-upload.php" method="post"
                                            enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">upload file</label>
                                                <div class="col-sm-4">
                                                    <input type="file" name="file" class="form-control-file" id="file"
                                                        required="required">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
                                                        <button type="submit" name="submit" id="submit"
                                                            class="btn btn-primary">Bulk
                                                            upload</button>
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