<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $enrollmentid = $_POST['enrollmentid'];
        $candidatename = $_POST['candidatename'];
        $fathername = $_POST['fathername'];
        $aadharnumber = $_POST['aadharnumber'];
        $phonenumber = $_POST['phonenumber'];
        $email = $_POST['email'];
        $qualification = $_POST['qualification'];
        //$dateofbirth = $_POST['dateofbirth'];
        
       
        $dateInput = $_POST['dateofbirth']; // Example input date in DD-MM-YYYY format

        // Split the input date into parts using explode
        $dateParts = explode('-', $dateInput); // [21, 01, 2025]
        
        // Rearrange the parts to match YYYY-MM-DD format
        $dateofbirth = implode('-', array_reverse($dateParts)); // [2025, 01, 21]
        
        // Output the corrected date
        //echo "Corrected Date: " . $correctedDate; // Output: 2025-01-21
        
        //die;
        
        $gender = $_POST['gender'];
        $maritalstatus = $_POST['maritalstatus'];
        $religion = $_POST['religion'];
        $category = $_POST['category'];
        $village = $_POST['village'];
        $mandal = $_POST['mandal'];
        $district = $_POST['district'];
        $state = $_POST['state'];
        $pincode = $_POST['pincode'];
        $training_center = $_POST['training_center'];
        $scheme = $_POST['scheme'];
        $sector = $_POST['sector'];
        $job_roll = $_POST['job_roll'];
        $batch = $_POST['batch'];
        $tblbatch_id = $_POST['batch'];
        $qualification = $_POST['qualification'];

        $candidatephoto = ($_FILES['candidatephoto']['name']);
        $candidatephototarget = 'doc/' . basename($candidatephoto);

        $aadhaarphoto = ($_FILES['aadhaarphoto']['name']);
        $aadhaarphototarget = 'doc/' . basename($aadhaarphoto);

        $qualificationphoto = ($_FILES['qualificationphoto']['name']);
        $qualificationphototarget = 'doc/' . basename($qualificationphoto);

        $applicationphoto = ($_FILES['applicationphoto']['name']);
        $applicationphototarget = 'doc/' . basename($applicationphoto);
        



        $status = 1;

        //$count = "SELECT aadharnumber from  tblcandidate WHERE aadharnumber=:aadharnumber OR phonenumber=:phonenumber ";
        $count = "SELECT aadharnumber from  tblcandidate WHERE aadharnumber=:aadharnumber";
        $query = $dbh->prepare($count);
        $query->bindParam(':aadharnumber', $aadharnumber, PDO::PARAM_STR);
       // $query->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $totalcandidate = $query->rowCount();
        if ($totalcandidate < 10) {
            // $sql = "INSERT INTO tblcandidate (
            //     enrollmentid, candidatename, fathername, aadharnumber, phonenumber, email, dateofbirth, gender, maritalstatus, religion, category, village, 
            //     mandal, district, state, pincode, candidatephoto, aadhaarphoto, 
            //     qualificationphoto, applicationphoto, training_center, scheme, sector, 
            //     job_roll, batch,tblbatch_id
            // ) 
            // VALUES (
            //     :enrollmentid, :candidatename, :fathername, :aadharnumber, :phonenumber, :email, :dateofbirth, :gender, :maritalstatus, :religion, :category, :village, 
            //     :mandal, :district, :state, :pincode, :candidatephoto, :aadhaarphoto, 
            //     :qualificationphoto, :applicationphoto, :training_center, :scheme, :sector, 
            //     :job_roll, :batch,:tblbatch_id
            // )";

             $sql = "INSERT INTO tblcandidate (
                enrollmentid, candidatename, fathername, aadharnumber, phonenumber, email, dateofbirth, gender, maritalstatus, religion, category, village, 
                mandal, district, state, pincode, candidatephoto, aadhaarphoto, 
                qualificationphoto, applicationphoto,qualification
            ) 
            VALUES (
                :enrollmentid, :candidatename, :fathername, :aadharnumber, :phonenumber, :email, :dateofbirth, :gender, :maritalstatus, :religion, :category, :village, 
                :mandal, :district, :state, :pincode, :candidatephoto, :aadhaarphoto, 
                :qualificationphoto, :applicationphoto,:qualification
            )";

            $query = $dbh->prepare($sql);

            // Bind parameters
            $query->bindParam(':enrollmentid', $enrollmentid, PDO::PARAM_STR);
            $query->bindParam(':candidatename', $candidatename, PDO::PARAM_STR);
            $query->bindParam(':fathername', $fathername, PDO::PARAM_STR);
            $query->bindParam(':aadharnumber', $aadharnumber, PDO::PARAM_STR);
            $query->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            //$query->bindParam(':qualification', $qualification, PDO::PARAM_STR);
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
            $query->bindParam(':qualification', $qualification, PDO::PARAM_STR);
            // $query->bindParam(':training_center', $training_center, PDO::PARAM_INT);
            // $query->bindParam(':scheme', $scheme, PDO::PARAM_INT);
            // $query->bindParam(':sector', $sector, PDO::PARAM_INT);
            // $query->bindParam(':job_roll', $job_roll, PDO::PARAM_INT);
            // $query->bindParam(':batch', $batch, PDO::PARAM_INT);
            // $query->bindParam(':tblbatch_id', $tblbatch_id, PDO::PARAM_INT);

            $query->execute();
            move_uploaded_file($_FILES['candidatephoto']['tmp_name'], $candidatephototarget);
            move_uploaded_file($_FILES['aadhaarphoto']['tmp_name'], $aadhaarphototarget);
            move_uploaded_file($_FILES['qualificationphoto']['tmp_name'], $qualificationphototarget);
            move_uploaded_file($_FILES['applicationphoto']['tmp_name'], $applicationphototarget);

            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $msg = "Student info added successfully";
                echo  '<script> setTimeout(function() { window.location.href = "payment.php?last_id='.$lastInsertId.'"; }, 1000); </script>';
            } else {
                $error = "Something went wrong. Please try again";
            }
        } else {
            //$error = "Aadhaar or phone number already exist , Try again with different phone number";
            $error = "Aadhaar number already exist , Try again with different Adhar number";
        }
    }
    
    
    // SQL query to fetch the last enrollmentid
    $sql = "SELECT enrollmentid FROM tblcandidate ORDER BY CandidateId DESC LIMIT 1"; // Replace 'id' with the actual primary key or a unique column
    
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    // Check if a result was found
    if ($result) {
        $lastEnrollmentId = $result['enrollmentid'];
         // Extract the numeric part and increment it
        $prefix = preg_replace('/\d+$/', '', $lastEnrollmentId); // Remove numeric part
        $number = (int)preg_replace('/^\D+/', '', $lastEnrollmentId); // Extract numeric part
        $newNumber = $number + 1; // Increment

        // Construct the new enrollmentid
        $newEnrollmentId = $prefix . $newNumber;

        //echo "Last Enrollment ID: " . $lastEnrollmentId . "\n";
       // $enroll= $newEnrollmentId;
        
        $enroll= $newEnrollmentId;
    } else {
        $enroll = "SPHOA2501";
    }



    ///  last five column data for  select

    // SQL query to fetch the last tbltrainingcenter
    $sql1 = "SELECT TrainingcenterId, trainingcentername FROM tbltrainingcenter ORDER BY TrainingcenterId DESC";
    $query1 = $dbh->prepare($sql1);
    $query1->execute();
    $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);

    // SQL query to fetch the last tblscheme
    $sql2 = "SELECT SchemeId, SchemeName FROM tblscheme ORDER BY SchemeId DESC";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);

    // SQL query to fetch the last tblsector
    $sql3 = "SELECT SectorId, SectorName FROM tblsector ORDER BY SectorId DESC";
    $query3 = $dbh->prepare($sql3);
    $query3->execute();
    $result3 = $query3->fetchAll(PDO::FETCH_ASSOC);

    // SQL query to fetch the last tbljobroll
    $sql4 = "SELECT JobrollId, jobrollname FROM tbljobroll ORDER BY JobrollId DESC";
    $query4 = $dbh->prepare($sql4);
    $query4->execute();
    $result4 = $query4->fetchAll(PDO::FETCH_ASSOC);

    // SQL query to fetch the last tblbatch
    $sql5 = "SELECT id, batch_name FROM tblbatch ORDER BY id DESC";
    $query5 = $dbh->prepare($sql5);
    $query5->execute();
    $result5 = $query5->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN </title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/mystyle.css">
    <script src="js/modernizr/modernizr.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">

</head>

<body class="top-navbar-fixed">

    <?php include('includes/topbar-new.php'); ?>

    <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->

      <?php include('includes/left-sidebar-new.php'); ?>
       <?php include('includes/leftbar.php'); ?>


      <!-- Main Content -->
      <main class="col-lg-10 col-md-9 p-4">
        <h2 class="mb-4">Candidate Registration</h2>
        <div class="row g-3">
          <!-- Regd Candidates Card -->

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
                                            <label for="candidatename">Enrollment ID</label>
                                            <input type="text" name="enrollmentid" class="form-control"
                                                id="enrollmentid" required="required"
                                                placeholder="Enrollment ID" value="<?=$enroll?>" readonly>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label for="candidatename">Full Name <span style="color:red">*</span></label>
                                            <input type="text" name="candidatename" class="form-control"
                                                id="candidatename" required="required"
                                                placeholder="Enter Full Name">
                                        </div>

                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-4">
                                            <label for="fathername">Father Name <span style="color:red">*</span></label>
                                            <input type="text" name="fathername" required="required"
                                                class="form-control" id="fathername"
                                                placeholder="Enter Father Name">
                                        </div>
                                    
                        

                                        <div class="form-group col-md-4">
                                            <label for="aadharnumber">Aadhar Number <span style="color:red">*</span></label>
                                            <input type="text" required name="aadharnumber" maxlength="12"
                                                class="form-control" id="aadharnumber" placeholder="Enter Aadhar Number"
                                                oninput="validateInput(this, 12)">
                                            <small id="aadharError" style="color:red; display:none;">Aadhar number must be exactly 12 digits.</small>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="qualification">Qualification <span style="color:red">*</span></label>
                                            <select name="qualification" id="qualification" class="form-control" required>
                                                <option value="">Select Qualification</option>
                                                <option value="Below SSC">Below SSC</option>
                                                <option value="SSC">SSC</option>
                                                <option value="Intermediate">Intermediate</option>
                                                <option value="Graduation">Graduation</option>
                                                <option value="Post Graduate">Post Graduate</option>
                                            </select>
                                        </div>

                                        


                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-4">
                                            <label for="phonenumber">Phone Number <span style="color:red">*</span></label>
                                            <input type="text" required name="phonenumber" maxlength="10"
                                                class="form-control" id="phonenumber" placeholder="Phone Number"
                                                oninput="validateInput(this, 10)">
                                            <small id="phoneError" style="color:red; display:none;">Phone number must be exactly 10 digits.</small>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="email">Email</label>
                                            <input type="email" name="email"
                                                class="form-control" id="email"
                                                placeholder="Email">
                                        </div>
                                    

                                        <div class="form-group col-md-4">
                                            <label for="dateofbirth">Date of Birth <span style="color:red">*</span></label>
                                            <input type="text" name="dateofbirth" class="form-control"
                                                id="dateofbirth" required>
                                        </div>

                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-4">
                                            <label for="gender">Gender <span style="color:red">*</span></label>
                                            <select id="gender" name="gender" class="form-control">
                                                <option selected>Select</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="maritalstatus">Marital Status <span style="color:red">*</span></label>
                                            <select id="maritalstatus" name="maritalstatus"
                                                class="form-control" required>
                                                <option selected>Select</option>
                                                <option>Married</option>
                                                <option>Un Married</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="religion">Religion <span style="color:red">*</span></label>
                                            <select id="religion" name="religion" class="form-control" required>
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
                                        <div class="form-group col-md-4">
                                            <label for="village">Village <span style="color:red">*</span></label>
                                            <input type="text" name="village" class="form-control" id="village"
                                                placeholder="Village" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="mandal">Mandal <span style="color:red">*</span></label>
                                            <input type="text" name="mandal" class="form-control" id="mandal"
                                                placeholder="Mandal" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="district">District <span style="color:red">*</span></label>
                                            <select id="district" name="district" class="form-control" required>
                                                <option selected>Select</option>
                                                <option>Alluri Sitharama Raju</option>
                                                <option>Anakapalli</option>
                                                <option>Anantapur</option>
                                                <option>Annamayya</option>
                                                <option>Bapatla</option>
                                                <option>Chittoor</option>
                                                <option>Dr. B. R. Ambedkar</option>
                                                <option>East Godavari</option>
                                                <option>Eluru</option>
                                                <option>Guntur</option>
                                                <option>Kakinada</option>
                                                <option>Krishna</option>
                                                <option>Kurnool</option>
                                                <option>Nandyal</option>
                                                <option>NTR</option>
                                                <option>Palnadu</option>
                                                <option>Parvathipuram Manyam</option>
                                                <option>Prakasam</option>
                                                <option>Sri Potti Sriramulu Nellore</option>
                                                <option>Sri Sathya Sai</option>
                                                <option>Srikakulam</option>
                                                <option>Tirupati</option>
                                                <option>Visakhapatnam</option>
                                                <option>Vizianagaram</option>
                                                <option>West Godavari</option>
                                                <option>YSR (Kadapa)</option>
                                            </select>

                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="state">State <span style="color:red">*</span></label>
                                            <select id="state" name="state" class="form-control" required>
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
                                            <label for="pincode">Pin Code <span style="color:red">*</span></label>
                                            <input type="number" name="pincode" class="form-control" id="pincode" placeholder="Pin Code" maxlength="6" oninput="this.value = this.value.slice(0, 6)" required>
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

                                    

                                    <?php /*
                                    <div class="form-row">

                                        <div class="form-group col-md-12"><hr></div>

                                        <div class="form-group col-md-12">
                                            <div class="panel-title">
                                                <h5>Job Information</h5>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="training_center">Training Center</label>
                                            <select id="training_center" name="training_center" class="form-control js-example-basic-single" required>
                                                <option selected>Select</option>
                                                <?php 
                                                foreach ($result1 as $row1) { ?>
                                                    <option value="<?=$row1['TrainingcenterId']; ?>"><?=$row1['trainingcentername']?></option>
                                                <?php } ?>
                                                
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="scheme">Scheme</label>
                                            <select id="scheme" name="scheme" class="form-control js-example-basic-single" required>
                                                <option selected>Select</option>
                                                <?php 
                                                foreach ($result2 as $row2) { ?>
                                                    <option value="<?=$row2['SchemeId']; ?>"><?=$row2['SchemeName']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="sector">Sector</label>
                                            <select id="sector" name="sector" class="form-control js-example-basic-single" required>
                                                <option selected>Select</option>
                                                <?php 
                                                foreach ($result3 as $row3) { ?>
                                                    <option value="<?=$row3['SectorId']; ?>"><?=$row3['SectorName']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="job_roll">Job Roll</label>
                                            <select id="job_roll" name="job_roll" class="form-control js-example-basic-single" required>
                                                <option selected>Select</option>
                                                <?php 
                                                foreach ($result4 as $row4) { ?>
                                                    <option value="<?=$row4['JobrollId']; ?>"><?=$row4['jobrollname']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="batch">Batch</label>
                                            <!-- <select id="batch" name="batch" class="form-control js-example-basic-single" required>
                                                <option selected>Select</option>
                                                 
                                            </select> -->
                                            <select id="batch" name="batch" class="form-control js-example-basic-single" required>
                                                <option selected disabled>Select Batch</option>
                                            </select>
                                        </div>


                                    </div>

                                    */ ?>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">

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

         
        </div><!-- /.row -->
      </main>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->


        <!-- ========== TOP NAVBAR ========== -->
        <?php // include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
       

        <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
        // $(function($) {
        //     $(".js-states").select2();
        //     $(".js-states-limit").select2({
        //         maximumSelectionLength: 2
        //     });
        //     $(".js-states-hide").select2({
        //         minimumResultsForSearch: Infinity
        //     });
        // });
        </script>
        
        <script>
        $(document).ready(function () {
          $('#candidatename,#fathername').on('keyup', function () {
            let inputValue = $(this).val();
            let capitalizedValue = inputValue
              .toLowerCase()
              .replace(/\b\w/g, char => char.toUpperCase());
            $(this).val(capitalizedValue);
          });
        });
      </script>
      
      <script>
        $(function () {
          $("#dateofbirth").datepicker({
            dateFormat: "dd-mm-yy", // Sets the format to DD-MM-YYYY
            changeMonth: true,      // Allows changing months
            changeYear: true,       // Allows changing years
            yearRange: "1900:2100", // Sets the year range
          });
        });
      </script>



      <script>
    function validateInput(input, length) {
        input.value = input.value.replace(/\D/g, ''); // Remove non-numeric characters

        let errorElement = document.getElementById(input.id + "Error");
        if (input.value.length === length) {
            errorElement.style.display = "none";
        } else {
            errorElement.style.display = "block";
        }
    }

    document.querySelector("form").addEventListener("submit", function (event) {
        let aadharInput = document.getElementById("aadharnumber");
        let phoneInput = document.getElementById("phonenumber");

        let valid = true;

        if (aadharInput.value.length !== 12) {
            document.getElementById("aadharError").style.display = "block";
            valid = false;
        }else{
            document.getElementById("aadharError").style.display = "none";
        }
        if (phoneInput.value.length !== 10) {
            document.getElementById("phoneError").style.display = "block";
            valid = false;
        }else{
            document.getElementById("phoneError").style.display = "none";
        }

        if (!valid) {
            event.preventDefault(); // Prevent form submission if validation fails
            alert("Oops! Some fields are missing or incorrect. Please double-check and try again. 🚀");
        }
    });
</script>

<script>
    document.getElementById("dateofbirth").setAttribute("max", new Date().toISOString().split("T")[0]);

    document.querySelector("form").addEventListener("submit", function (event) {
        let dobInput = document.getElementById("dateofbirth");
        let dobError = document.getElementById("dobError");
        let selectedDate = new Date(dobInput.value);
        let today = new Date();

        if (selectedDate > today) {
            dobError.style.display = "block";
            event.preventDefault(); // Prevent form submission
        } else {
            dobError.style.display = "none";
        }
    });
</script>

<script>
$(document).ready(function(){
    $('#village,#mandal').on('keyup', function(){
        var value = $(this).val().toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
        $(this).val(value);
    });
});

// In your Javascript (external .js resource or <script> tag)
// $(document).ready(function() {
//     $('.js-example-basic-single').select2();
// });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        // Job 
        $('#job_roll').change(function() {
            var job_id = $(this).val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: {job_id: job_id},
                dataType: 'json',
                success: function(response) {
                    $('#batch').empty().append('<option selected disabled>Select Batch</option>');
                    if (response.length > 0) {
                        $.each(response, function(index, batch) {
                            $('#batch').append('<option value="' + batch.id + '">' + batch.batch_name + '</option>');
                        });
                    } else {
                        $('#batch').append('<option disabled>No batches available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading batches: " + error);
                }
            });
        });

        $('#training_center').change(function() {
            var training_center = $(this).val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: {training_center: training_center},
                dataType: 'json',
                success: function(response) {
                    $('#scheme').empty().append('<option selected disabled>Select Scheme</option>');
                    if (response.length > 0) {
                        $.each(response, function(index, scheme) {
                            $('#scheme').append('<option value="' + scheme.SchemeId + '">' + scheme.SchemeName + '</option>');
                        });
                    } else {
                        $('#scheme').append('<option disabled>No Scheme available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading batches: " + error);
                }
            });
        });

        $('#scheme').change(function() {
            var scheme = $(this).val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: {scheme: scheme},
                dataType: 'json',
                success: function(response) {
                    $('#sector').empty().append('<option selected disabled>Select Sector</option>');
                    if (response.length > 0) {
                        $.each(response, function(index, sector) {
                            $('#sector').append('<option value="' + sector.SectorId + '">' + sector.SectorName + '</option>');
                        });
                    } else {
                        $('#sector').append('<option disabled>No Sector available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading batches: " + error);
                }
            });
        });

        $('#sector').change(function() {
            var sector = $(this).val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: {sector: sector},
                dataType: 'json',
                success: function(response) {
                    $('#job_roll').empty().append('<option selected disabled>Select job roll</option>');
                    if (response.length > 0) {
                        $.each(response, function(index, job_roll) {
                            $('#job_roll').append('<option value="' + job_roll.JobrollId + '">' + job_roll.jobrollname + '</option>');
                        });
                    } else {
                        $('#job_roll').append('<option disabled>No job roll available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading batches: " + error);
                }
            });
        });
    });
</script>



  
</body>

</html>
<?PHP } ?>