<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $trainingcentername = $_POST['trainingcentername'];
        $tclocation = $_POST['tclocation'];
        $tcaddress = $_POST['tcaddress'];
        $spocname = $_POST['spocname'];
        $spoccontact = $_POST['spoccontact'];
        $spocemailaddress = $_POST['spocemailaddress'];
        $tcuserid = $_POST['tcuserid'];
        $tcpassword = $_POST['tcpassword'];
        $status = 1;

        $count = "SELECT trainingcentername from  tbltrainingcenter WHERE trainingcentername=:trainingcentername";
        $query = $dbh->prepare($count);
        $query->bindParam(':trainingcentername', $trainingcentername, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $totalTC = $query->rowCount();
        if ($totalTC == 0) {
            $sql = "INSERT INTO  tbltrainingcenter(trainingcentername,tclocation,tcaddress,spocname,spoccontact,spocemailaddress,tcuserid,tcpassword) VALUES(:trainingcentername,:tclocation,:tcaddress,:spocname,:spoccontact,:spocemailaddress,:tcuserid,:tcpassword)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':trainingcentername', $trainingcentername, PDO::PARAM_STR);
            $query->bindParam(':tclocation', $tclocation, PDO::PARAM_STR);
            $query->bindParam(':tcaddress', $tcaddress, PDO::PARAM_STR);
            $query->bindParam(':spocname', $spocname, PDO::PARAM_STR);
            $query->bindParam(':spoccontact', $spoccontact, PDO::PARAM_STR);
            $query->bindParam(':spocemailaddress', $spocemailaddress, PDO::PARAM_STR);
            $query->bindParam(':tcuserid', $tcuserid, PDO::PARAM_STR);
            $query->bindParam(':tcpassword', $tcpassword, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();


            if ($lastInsertId) {
                $msg = "Training Center Created successfully";
            } else {
                $error = "Something went wrong. Please try again";
            }
        } else {
            $error = "Training center already exist";
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
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
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
                                <h2 class="title">Create Training Center</h2>
                            </div>

                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="#">Training Center</a></li>
                                    <li class="active">Create Training Centerh</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->

                    <section class="section">
                        <div class="container-fluid">





                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Create Training Center</h5>
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

                                        <div class="panel-body">

                                            <form action="create-trainingcenter.php" method="post">
                                                <div class="form-group has-success">
                                                    <label for="trainingcentername" class="control-label">Training
                                                        Center
                                                        Name</label>
                                                    <div class="">
                                                        <input type="text" name="trainingcentername"
                                                            class="form-control" required="required"
                                                            placeholder="Enter Training Center Name"
                                                            id="trainingcentername">

                                                    </div>
                                                </div>


                                                <div class="form-group has-success">
                                                    <label for="tclocation" class="control-label">TC Location</label>
                                                    <div class="">
                                                        <input type="text" name="tclocation" required="required"
                                                            class="form-control"
                                                            placeholder="Enter Training Center Location"
                                                            id="tclocation">

                                                    </div>
                                                </div>



                                                <div class="form-group has-success">
                                                    <label for="tcaddress" class="control-label">TC Address</label>
                                                    <div class="">
                                                        <input type="text" name="tcaddress" class="form-control"
                                                            required="required"
                                                            placeholder="Enter Training Center Address" id="tcaddress">

                                                    </div>
                                                </div>

                                                <div class="form-group has-success">
                                                    <label for="spocname" class="control-label">SPOC Name</label>
                                                    <div class="">
                                                        <input type="text" name="spocname" class="form-control"
                                                            required="required" placeholder="Enter SPOC Name"
                                                            id="spocname">

                                                    </div>
                                                    <div class="form-group has-success">
                                                        <label for="spoccontact" class="control-label">SPOC Contact
                                                            Number</label>
                                                        <div class="">
                                                            <input type="number" name="spoccontact" class="form-control"
                                                                required="required"
                                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                maxlength="10" placeholder="Enter SPOC Contact Number"
                                                                id="spoccontact">

                                                        </div>

                                                        <div class="form-group has-success">
                                                            <label for="spocemailaddress" class="control-label">SPCO
                                                                Email Adress
                                                            </label>
                                                            <div class="">
                                                                <input type="email" name="spocemailaddress"
                                                                    class="form-control" required="required"
                                                                    placeholder="Enter SPOC Email Address"
                                                                    id="spocemailaddress">

                                                            </div>
                                                            <div class="form-group has-success">
                                                                <label for="tcuserid" class="control-label">TC USER
                                                                    ID</label>
                                                                <div class="">
                                                                    <input type="text" name="tcuserid"
                                                                        class="form-control" required="required"
                                                                        placeholder="Enter TC User ID" id="tcuserid">

                                                                </div>

                                                                <div class="form-group has-success">
                                                                    <label for="tcpassword" class="control-label">TC
                                                                        PASSWORD</label>
                                                                    <div class="">
                                                                        <input type="text" name="tcpassword"
                                                                            class="form-control" required="required"
                                                                            placeholder="Enter TC Password"
                                                                            id="tcpassword">

                                                                    </div>
                                                                    <div class="form-group has-success">

                                                                        <div class="">
                                                                            <button type="submit" name="submit"
                                                                                class="btn btn-success btn-labeled">Submit<span
                                                                                    class="btn-label btn-label-right"><i
                                                                                        class="fa fa-check"></i></span></button>
                                                                        </div>

                                                                    </div>
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