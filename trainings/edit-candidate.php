<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['update'])) {

        $cid = ($_POST['candidateid']);
        $candidatename = $_POST['candidatename'];
        $fathername = $_POST['fathername'];
        $aadharnumber = $_POST['aadharnumber'];
        $phonenumber = $_POST['phonenumber'];
        $phonenumber2 = $_POST['phonenumber2'];
        $qualification = $_POST['qualification'];
        $dateofbirth = $_POST['dateofbirth'];
        $gender = $_POST['gender'];
        $maritalstatus = $_POST['maritalstatus'];
        $religion = $_POST['religion'];
        $category = $_POST['category'];
        $village = $_POST['village'];
        $mandal = $_POST['mandal'];
        $district = $_POST['district'];
        $state = $_POST['state'];
        $pincode = $_POST['pincode'];

        $status = 1;

        $sql = "update  tblcandidate set candidatename=:candidatename,fathername=:fathername,aadharnumber=:aadharnumber,phonenumber=:phonenumber,phonenumber2=:phonenumber2,qualification=:qualification,
        dateofbirth=:dateofbirth,gender=:gender,maritalstatus=:maritalstatus,religion=:religion,category=:category,village=:village,
        mandal=:mandal,district=:district,state=:state,pincode=:pincode
        where CandidateId=:cid ";
        $query = $dbh->prepare($sql);
        $query->bindParam(':candidatename', $candidatename, PDO::PARAM_STR);
        $query->bindParam(':fathername', $fathername, PDO::PARAM_STR);
        $query->bindParam(':aadharnumber', $aadharnumber, PDO::PARAM_STR);
        $query->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $query->bindParam(':phonenumber2', $phonenumber2, PDO::PARAM_STR);
        $query->bindParam(':qualification', $qualification, PDO::PARAM_STR);
        $query->bindParam(':dateofbirth', $dateofbirth, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':maritalstatus', $maritalstatus, PDO::PARAM_STR);
        $query->bindParam(':religion', $religion, PDO::PARAM_STR);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':village', $village, PDO::PARAM_STR);
        $query->bindParam(':mandal', $mandal, PDO::PARAM_STR);
        $query->bindParam(':district', $district, PDO::PARAM_STR);
        $query->bindParam(':state', $state, PDO::PARAM_STR);
        $query->bindParam(':pincode', $pincode, PDO::PARAM_STR);


        $query->bindParam(':cid', $cid, PDO::PARAM_STR);


        $query->execute();


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
                                <h2 class="title">Update Candidate Details </h2>
                            </div>

                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="#">Candidate</a></li>
                                    <li class="active">Update Candidate</li>
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
                                                <h5>Update Candidate info<?php echo $candidatephoto;
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
                                                    <input type="text" name="candidatename" class="form-control"
                                                        id="candidatename"
                                                        value="<?php echo htmlentities($result->candidatename); ?>">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="fathername">Father Name</label>
                                                    <input type="text" name="fathername" class="form-control"
                                                        id="fathername"
                                                        value="<?php echo htmlentities($result->fathername); ?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="aadharnumber">Aadhar Number</label>
                                                    <input type="number" name="aadharnumber"
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        maxlength="12" class="form-control" id="aadharnumber"
                                                        value="<?php echo htmlentities($result->aadharnumber); ?>">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="phonenumber">Phone Number</label>
                                                    <input type="number" name="phonenumber"
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        maxlength="10" class="form-control" id="phonenumber"
                                                        value="<?php echo htmlentities($result->phonenumber); ?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="phonenumber2">Phone Number 2</label>
                                                    <input type="number" name="phonenumber2"
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        maxlength="10" class="form-control" id="phonenumber2"
                                                        value="<?php echo htmlentities($result->phonenumber2); ?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="qualification">Qualification</label>
                                                    <select id="qualification" name="qualification" class="form-control"
                                                        value="<?php echo htmlentities($result->qualification); ?>">
                                                        <option selected>
                                                            <?php echo htmlentities($result->qualification); ?></option>
                                                        <option>SSC</option>
                                                        <option>Intermediate</option>
                                                        <option>Graduation</option>
                                                        <option>Master Degree</option>
                                                        <option>ITI</option>
                                                        <option>Diploma</option>
                                                        <option>B Tech</option>
                                                        <option>MBA</option>
                                                        <option>B Pharmacy</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="dateofbirth">Date of Birth</label>
                                                    <input type="date" name="dateofbirth" class="form-control"
                                                        id="dateofbirth"
                                                        value="<?php echo htmlentities($result->dateofbirth); ?>">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="gender">Gender</label>
                                                    <select id="gender" name="gender" class="form-control">
                                                        <option selected><?php echo htmlentities($result->gender); ?>
                                                        </option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                        <option>Other</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="maritalstatus">Marital Status</label>
                                                    <select id="maritalstatus" name="maritalstatus"
                                                        class="form-control">
                                                        <option selected>
                                                            <?php echo htmlentities($result->maritalstatus); ?></option>
                                                        <option>Married</option>
                                                        <option>Un Married</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <label for="religion">Religion</label>
                                                    <select id="religion" name="religion" class="form-control">
                                                        <option selected><?php echo htmlentities($result->religion); ?>
                                                        </option>
                                                        <option>Hindu</option>
                                                        <option>Muslim</option>
                                                        <option>Christian</option>
                                                        <option>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="category">Category</label>
                                                    <select id="category" name="category" class="form-control">
                                                        <option selected><?php echo htmlentities($result->category); ?>
                                                        </option>
                                                        <option>BC-A</option>
                                                        <option>BC-B</option>
                                                        <option>BC-C</option>
                                                        <option>BC-D</option>
                                                        <option>BC-E</option>
                                                        <option>EBC</option>
                                                        <option>Minorities</option>
                                                        <option>Other</option>
                                                        <option>OC</option>
                                                        <option>SC</option>
                                                        <option>ST</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="village">Village</label>
                                                    <input type="text" name="village" class="form-control" id="village"
                                                        value="<?php echo htmlentities($result->village); ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="mandal">Mandal</label>
                                                    <input type="text" name="mandal" class="form-control" id="mandal"
                                                        value="<?php echo htmlentities($result->mandal); ?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="district">District</label>
                                                    <select id="district" name="district" class="form-control">
                                                        <option selected><?php echo htmlentities($result->district); ?>
                                                        </option>
                                                        <option>Vizianagaram</option>
                                                        <option>Visakhapatnam</option>
                                                        <option>Srikakulam</option>
                                                        <option>East Godavari</option>
                                                        <option>West Godavari</option>
                                                        <option>Ongole</option>
                                                        <option>Nellore</option>
                                                        <option>Karnool</option>
                                                        <option>Prakasham</option>
                                                        <option>Krishna</option>
                                                        <option>YSR Kadapa</option>
                                                        <option>Guntur</option>
                                                        <option>Chittoor</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="state">State</label>
                                                    <select id="state" name="state" class="form-control">
                                                        <option selected><?php echo htmlentities($result->state); ?>
                                                        </option>
                                                        <option>Andhra Pradesh</option>
                                                        <option>Orissa</option>
                                                        <option>Telangana</option>
                                                        <option>Delhi</option>
                                                        <option>Jammu & Kashmir</option>
                                                        <option>Kerala</option>
                                                        <option>Arunachal Pradesh</option>
                                                        <option>Maharastra</option>
                                                        <option>Goa</option>
                                                        <option>Rajastan</option>
                                                        <option>Gujarat</option>
                                                        <option>Uttarakand</option>
                                                        <option>Uttar Pradesh</option>
                                                        <option>Assam</option>
                                                        <option>Tiruvanantapur</option>
                                                        <option>Meghalaya</option>
                                                        <option>Sikkim</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="pincode">Pin Code</label>
                                                    <input type="text" name="pincode" class="form-control" id="pincode"
                                                        value="<?php echo htmlentities($result->pincode); ?>">
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