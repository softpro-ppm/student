<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
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

        $candidatephoto = ($_FILES['candidatephoto']['name']);
        $candidatephototarget = 'doc/' . basename($candidatephoto);

        $aadhaarphoto = ($_FILES['aadhaarphoto']['name']);
        $aadhaarphototarget = 'doc/' . basename($aadhaarphoto);

        $qualificationphoto = ($_FILES['qualificationphoto']['name']);
        $qualificationphototarget = 'doc/' . basename($qualificationphoto);

        $applicationphoto = ($_FILES['applicationphoto']['name']);
        $applicationphototarget = 'doc/' . basename($applicationphoto);




        $status = 1;

        $count = "SELECT aadharnumber from  tblcandidate WHERE aadharnumber=:aadharnumber OR phonenumber=:phonenumber ";
        $query = $dbh->prepare($count);
        $query->bindParam(':aadharnumber', $aadharnumber, PDO::PARAM_STR);
        $query->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $totalcandidate = $query->rowCount();
        if ($totalcandidate == 0) {
            $sql = "INSERT INTO  tblcandidate(candidatename,fathername,aadharnumber,phonenumber,phonenumber2,qualification,dateofbirth,gender,maritalstatus,religion,category,village,mandal,district,state,pincode,candidatephoto,aadhaarphoto,qualificationphoto,applicationphoto) 
        VALUES(:candidatename,:fathername,:aadharnumber,:phonenumber,:phonenumber2,:qualification,:dateofbirth,:gender,:maritalstatus,:religion,:category,:village,:mandal,:district,:state,:pincode,:candidatephoto,:aadhaarphoto,:qualificationphoto,:applicationphoto)";
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

            $query->bindParam(':candidatephoto', $candidatephoto, PDO::PARAM_STR);
            $query->bindParam(':aadhaarphoto', $aadhaarphoto, PDO::PARAM_STR);
            $query->bindParam(':qualificationphoto', $qualificationphoto, PDO::PARAM_STR);
            $query->bindParam(':applicationphoto', $applicationphoto, PDO::PARAM_STR);

            $query->execute();
            move_uploaded_file($_FILES['candidatephoto']['tmp_name'], $candidatephototarget);
            move_uploaded_file($_FILES['aadhaarphoto']['tmp_name'], $aadhaarphototarget);
            move_uploaded_file($_FILES['qualificationphoto']['tmp_name'], $qualificationphototarget);
            move_uploaded_file($_FILES['applicationphoto']['tmp_name'], $applicationphototarget);

            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $msg = "Student info added successfully";
            } else {
                $error = "Something went wrong. Please try again";
            }
        } else {
            $error = "Aadhaar or phone number already exist , Try again with different phone number";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/mystyle.css">
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
                                <h2 class="title">Candidate Registration</h2>

                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>

                                    <li class="active">Candidate Registration</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Fill the Candidate info</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if ($msg) { ?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                        </div><?php } else if ($error) { ?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="candidatename">Full Name</label>
                                                    <input type="text" name="candidatename" class="form-control"
                                                        id="candidatename" required="required"
                                                        placeholder="Enter Full Name">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="fathername">Father Name</label>
                                                    <input type="text" name="fathername" required="required"
                                                        class="form-control" id="fathername"
                                                        placeholder="Enter Father Name">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="aadharnumber">Aadhar Number</label>
                                                    <input type="number" required="required" name="aadharnumber"
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        maxlength="12" class="form-control" id="aadharnumber"
                                                        placeholder="Enter Aadhar Number">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="phonenumber">Phone Number</label>
                                                    <input type="number" required="required" name="phonenumber"
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        maxlength="10" class="form-control" id="phonenumber"
                                                        placeholder="Phone Number">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="phonenumber2">Phone Number 2</label>
                                                    <input type="number" name="phonenumber2"
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        maxlength="10" class="form-control" id="phonenumber2"
                                                        placeholder="Phone Number 2">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="qualification">Qualification</label>
                                                    <select id="qualification" name="qualification"
                                                        class="form-control">
                                                        <option selected>Select</option>
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
                                                        id="dateofbirth">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="gender">Gender</label>
                                                    <select id="gender" name="gender" class="form-control">
                                                        <option selected>Select</option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                        <option>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="maritalstatus">Marital Status</label>
                                                    <select id="maritalstatus" name="maritalstatus"
                                                        class="form-control">
                                                        <option selected>Select</option>
                                                        <option>Married</option>
                                                        <option>Un Married</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <label for="religion">Religion</label>
                                                    <select id="religion" name="religion" class="form-control">
                                                        <option selected>Select</option>
                                                        <option>Hindu</option>
                                                        <option>Muslim</option>
                                                        <option>Christian</option>
                                                        <option>Other</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="category">Category</label>
                                                    <select id="category" name="category" class="form-control">
                                                        <option selected>Select</option>
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
                                                        placeholder="Village">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="mandal">Mandal</label>
                                                    <input type="text" name="mandal" class="form-control" id="mandal"
                                                        placeholder="Mandal">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="district">District</label>
                                                    <select id="district" name="district" class="form-control">
                                                        <option selected>Select</option>
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
                                                        <option selected>Select</option>
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
                                                        placeholder="Pin Code">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="candidatephoto">Upload Photo</label>
                                                    <input type="file" name="candidatephoto" class="form-control"
                                                        id="candidatephoto">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="aadharnumber">Upload Aadhaar</label>
                                                    <input type="file" name="aadhaarphoto" class="form-control"
                                                        id="aadhar" placeholder="Enter Aadhar Number">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="aadharnumber">Upload Education </label>
                                                    <input type="file" name="qualificationphoto" class="form-control"
                                                        id="qualificationphoto">
                                                </div>


                                                <div class="form-group col-md-3">
                                                    <label for="aadharnumber">Upload Application</label>
                                                    <input type="file" name="applicationphoto" class="form-control"
                                                        id="applicationphoto">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-2">

                                                    <button type="submit" name="submit" class="btn btn-primary">Register
                                                        Candidate</button>

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
<?PHP } ?>