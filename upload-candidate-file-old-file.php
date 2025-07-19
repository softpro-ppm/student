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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>

      <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="screen"> -->
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

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">

    
    <style>
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 10px; }
        .form-control:focus { border-color: #007bff; box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25); }
        .help-block { font-size: 0.875rem; color: #6c757d; }
    </style>
</head>

<body class="bg-light">
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <?php include('includes/topbar-new.php'); ?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <?php include('includes/left-sidebar-new.php'); ?>
                <?php include('includes/leftbar.php'); ?>

                <!-- Main Content -->
                <main class="col-md-9 col-lg-10 px-md-4">
                    <!-- Page Title -->
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2">Create Scheme</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Scheme</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Scheme</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
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

                    <!-- Form -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Update Candidate Document</h5>
                        </div>
                        <div class="card-body">
                        
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

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="candidatename">Full Name</label> : <?php echo htmlentities($result->candidatename); ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fathername">Father Name</label> : <?php echo htmlentities($result->fathername); ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="aadharnumber">Aadhar Number</label> : <?php echo htmlentities($result->aadharnumber); ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="aadharnumber">Phone Number</label> : <?php echo htmlentities($result->phonenumber); ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="candidatephoto">Upload Photo</label>
                                        <input type="file" name="candidatephoto" class="form-control" value="<?php echo htmlentities($result->candidatephoto); ?>"
                                                id="candidatephoto">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="aadharnumber">Upload Aadhaar </label>
                                        <input type="file" name="aadhaarphoto" class="form-control"
                                                id="aadhar">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="aadharnumber">Upload Education</label>
                                        <input type="file" name="qualificationphoto"
                                                class="form-control" id="qualificationphoto">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="aadharnumber">Upload Application</label>
                                        <input type="file" name="applicationphoto"
                                                    class="form-control" id="applicationphoto">
                                    </div>
                                    
                                    
                                </div>
                                
                                
                                    
                                </div>


                                <?php }
                                    } ?>
                                <div class="form-row">
                                    <div class="form-group col-md-2 m-3">
                                        <button type="submit" name="update"
                                            class="btn btn-success btn-labeled">Update<span
                                                class="btn-label btn-label-right"><i
                                                    class="fa fa-check"></i></span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

  <script src="js/jquery/jquery-2.2.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/bootstrap/bootstrap.min.js"></script>
  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
  <script src="js/select2/select2.min.js"></script>
  <script src="js/main.js"></script>

</body>
</html>
<?php } ?>