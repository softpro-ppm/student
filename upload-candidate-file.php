<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    $maxFileSize = 1048576; // 1 MB in bytes
    $allowedFileTypes = ['image/jpeg', 'image/png', 'application/pdf']; // Allowed file types

    // Handle Candidate Photo Upload
    if (isset($_POST['updatePhoto'])) {
        if (!empty($_FILES['candidatephoto']['name'])) {
            $candidatephoto = $_FILES['candidatephoto']['name'];
            $candidatephototarget = 'doc/' . basename($candidatephoto);
            $fileType = $_FILES['candidatephoto']['type'];
            $fileSize = $_FILES['candidatephoto']['size'];

            if ($fileSize > $maxFileSize) {
                $error = "Candidate photo must be less than 1 MB.";
            } elseif (!in_array($fileType, $allowedFileTypes)) {
                $error = "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
            } else {
                if (move_uploaded_file($_FILES['candidatephoto']['tmp_name'], $candidatephototarget)) {
                    $sql = "UPDATE tblcandidate SET candidatephoto=:candidatephoto WHERE CandidateId=:cid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':candidatephoto', $candidatephoto, PDO::PARAM_STR);
                    $query->bindParam(':cid', $_POST['candidateid'], PDO::PARAM_STR);
                    $query->execute();
                    $msg = "Candidate photo updated successfully.";
                } else {
                    $error = "Failed to upload candidate photo. Check directory permissions.";
                }
            }
        } else {
            $error = "No file selected for upload.";
        }
    }

    // Handle Aadhaar Photo Upload
    if (isset($_POST['updateAadhaar'])) {
        if (!empty($_FILES['aadhaarphoto']['name'])) {
            $aadhaarphoto = $_FILES['aadhaarphoto']['name'];
            $aadhaarphototarget = 'doc/' . basename($aadhaarphoto);
            $fileType = $_FILES['aadhaarphoto']['type'];
            $fileSize = $_FILES['aadhaarphoto']['size'];

            if ($fileSize > $maxFileSize) {
                $error = "Aadhaar photo must be less than 1 MB.";
            } elseif (!in_array($fileType, $allowedFileTypes)) {
                $error = "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
            } else {
                if (move_uploaded_file($_FILES['aadhaarphoto']['tmp_name'], $aadhaarphototarget)) {
                    $sql = "UPDATE tblcandidate SET aadhaarphoto=:aadhaarphoto WHERE CandidateId=:cid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':aadhaarphoto', $aadhaarphoto, PDO::PARAM_STR);
                    $query->bindParam(':cid', $_POST['candidateid'], PDO::PARAM_STR);
                    $query->execute();
                    $msg = "Aadhaar photo updated successfully.";
                } else {
                    $error = "Failed to upload Aadhaar photo. Check directory permissions.";
                }
            }
        } else {
            $error = "No file selected for upload.";
        }
    }

    // Handle Qualification Photo Upload
    if (isset($_POST['updateQualification'])) {
        if (!empty($_FILES['qualificationphoto']['name'])) {
            $qualificationphoto = $_FILES['qualificationphoto']['name'];
            $qualificationphototarget = 'doc/' . basename($qualificationphoto);
            $fileType = $_FILES['qualificationphoto']['type'];
            $fileSize = $_FILES['qualificationphoto']['size'];

            if ($fileSize > $maxFileSize) {
                $error = "Qualification photo must be less than 1 MB.";
            } elseif (!in_array($fileType, $allowedFileTypes)) {
                $error = "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
            } else {
                if (move_uploaded_file($_FILES['qualificationphoto']['tmp_name'], $qualificationphototarget)) {
                    $sql = "UPDATE tblcandidate SET qualificationphoto=:qualificationphoto WHERE CandidateId=:cid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':qualificationphoto', $qualificationphoto, PDO::PARAM_STR);
                    $query->bindParam(':cid', $_POST['candidateid'], PDO::PARAM_STR);
                    $query->execute();
                    $msg = "Qualification photo updated successfully.";
                } else {
                    $error = "Failed to upload qualification photo. Check directory permissions.";
                }
            }
        } else {
            $error = "No file selected for upload.";
        }
    }

    // Handle Application Photo Upload
    if (isset($_POST['updateApplication'])) {
        if (!empty($_FILES['applicationphoto']['name'])) {
            $applicationphoto = $_FILES['applicationphoto']['name'];
            $applicationphototarget = 'doc/' . basename($applicationphoto);
            $fileType = $_FILES['applicationphoto']['type'];
            $fileSize = $_FILES['applicationphoto']['size'];

            if ($fileSize > $maxFileSize) {
                $error = "Application photo must be less than 1 MB.";
            } elseif (!in_array($fileType, $allowedFileTypes)) {
                $error = "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
            } else {
                if (move_uploaded_file($_FILES['applicationphoto']['tmp_name'], $applicationphototarget)) {
                    $sql = "UPDATE tblcandidate SET applicationphoto=:applicationphoto WHERE CandidateId=:cid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':applicationphoto', $applicationphoto, PDO::PARAM_STR);
                    $query->bindParam(':cid', $_POST['candidateid'], PDO::PARAM_STR);
                    $query->execute();
                    $msg = "Application photo updated successfully.";
                } else {
                    $error = "Failed to upload application photo. Check directory permissions.";
                }
            }
        } else {
            $error = "No file selected for upload.";
        }
    }

    // Handle Candidate Photo Deletion
    if (isset($_POST['deletePhoto'])) {
        $cid = $_POST['candidateid'];
        $sql = "SELECT candidatephoto FROM tblcandidate WHERE CandidateId=:cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($result->candidatephoto) && file_exists('doc/' . $result->candidatephoto)) {
            unlink('doc/' . $result->candidatephoto); // Delete the file from the server
        }

        $sql = "UPDATE tblcandidate SET candidatephoto=NULL WHERE CandidateId=:cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Candidate photo deleted successfully.";
    }

    // Handle Aadhaar Photo Deletion
    if (isset($_POST['deleteAadhaar'])) {
        $cid = $_POST['candidateid'];
        $sql = "SELECT aadhaarphoto FROM tblcandidate WHERE CandidateId=:cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($result->aadhaarphoto) && file_exists('doc/' . $result->aadhaarphoto)) {
            unlink('doc/' . $result->aadhaarphoto); // Delete the file from the server
        }

        $sql = "UPDATE tblcandidate SET aadhaarphoto=NULL WHERE CandidateId=:cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Aadhaar photo deleted successfully.";
    }

    // Handle Qualification Photo Deletion
    if (isset($_POST['deleteQualification'])) {
        $cid = $_POST['candidateid'];
        $sql = "SELECT qualificationphoto FROM tblcandidate WHERE CandidateId=:cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($result->qualificationphoto) && file_exists('doc/' . $result->qualificationphoto)) {
            unlink('doc/' . $result->qualificationphoto); // Delete the file from the server
        }

        $sql = "UPDATE tblcandidate SET qualificationphoto=NULL WHERE CandidateId=:cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Qualification photo deleted successfully.";
    }

    // Handle Application Photo Deletion
    if (isset($_POST['deleteApplication'])) {
        $cid = $_POST['candidateid'];
        $sql = "SELECT applicationphoto FROM tblcandidate WHERE CandidateId=:cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($result->applicationphoto) && file_exists('doc/' . $result->applicationphoto)) {
            unlink('doc/' . $result->applicationphoto); // Delete the file from the server
        }

        $sql = "UPDATE tblcandidate SET applicationphoto=NULL WHERE CandidateId=:cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Application photo deleted successfully.";
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
                            
                            <?php
                            $cid = intval($_GET['candidateid']);
                            $sql = "SELECT * FROM tblcandidate WHERE CandidateId=:cid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':cid', $cid, PDO::PARAM_STR);
                            $query->execute();
                            $result = $query->fetch(PDO::FETCH_OBJ);
                            
                            //print_r($result);
                            ?>

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

                            

                            </div>

                            

                            <?php

                            if ($query->rowCount() > 0) { ?>
                                <!-- Candidate Photo -->
                                <div class="card m-3 p-3">
                                    <form method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="candidateid" value="<?php echo $cid; ?>">
                                        <div class="form-group">
                                            <label for="candidatephoto">Upload Candidate Photo</label>
                                            <input type="file" name="candidatephoto" class="form-control">
                                            <?php if (!empty($result->candidatephoto)) { ?>
                                                <p>Current File: <a href="doc/<?php echo htmlentities($result->candidatephoto); ?>" target="_blank"><?php echo htmlentities($result->candidatephoto); ?></a></p>
                                                <button type="submit" name="deletePhoto" class="btn btn-danger">Delete Photo</button>
                                            <?php } ?>
                                            <button type="submit" name="updatePhoto" class="btn btn-primary">Upload Photo</button>
                                        </div>
                                        
                                        
                                    </form>
                                </div>
                                
                                <hr>

                                <!-- Aadhaar Photo -->
                                <div class="card m-3 p-3">
                                    <form method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="candidateid" value="<?php echo $cid; ?>">
                                        <div class="form-group">
                                            <label for="aadhaarphoto">Upload Aadhaar Photo</label>
                                            <input type="file" name="aadhaarphoto" class="form-control">
                                            <?php if (!empty($result->aadhaarphoto)) { ?>
                                                <p>Current File: <a href="doc/<?php echo htmlentities($result->aadhaarphoto); ?>" target="_blank"><?php echo htmlentities($result->aadhaarphoto); ?></a></p>
                                                <button type="submit" name="deleteAadhaar" class="btn btn-danger">Delete Aadhaar</button>
                                            <?php } ?>
                                            <button type="submit" name="updateAadhaar" class="btn btn-primary">Upload Aadhaar</button>
                                        </div>
                                        
                                        
                                    </form>
                                </div>
                                <hr>

                                <!-- Qualification Photo -->
                                <div class="card m-3 p-3">
                                    <form method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="candidateid" value="<?php echo $cid; ?>">
                                        <div class="form-group">
                                            <label for="qualificationphoto">Upload Qualification Photo</label>
                                            <input type="file" name="qualificationphoto" class="form-control">
                                            <?php if (!empty($result->qualificationphoto)) { ?>
                                                <p>Current File: <a href="doc/<?php echo htmlentities($result->qualificationphoto); ?>" target="_blank"><?php echo htmlentities($result->qualificationphoto); ?></a></p>
                                                <button type="submit" name="deleteQualification" class="btn btn-danger">Delete Qualification</button>
                                            <?php } ?>
                                            <button type="submit" name="updateQualification" class="btn btn-primary">Upload Qualification</button>
                                        </div>
                                        
                                        
                                    </form>
                                </div>
                                <hr>

                                <!-- Application Photo -->
                                <div class="card m-3 p-3">
                                    <form method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="candidateid" value="<?php echo $cid; ?>">
                                        <div class="form-group">
                                            <label for="applicationphoto">Upload Application Photo</label>
                                            <input type="file" name="applicationphoto" class="form-control">
                                            <?php if (!empty($result->applicationphoto)) { ?>
                                                <p>Current File: <a href="doc/<?php echo htmlentities($result->applicationphoto); ?>" target="_blank"><?php echo htmlentities($result->applicationphoto); ?></a></p>
                                                <button type="submit" name="deleteApplication" class="btn btn-danger">Delete Application</button>
                                            <?php } ?>
                                            <button type="submit" name="updateApplication" class="btn btn-primary">Upload Application</button>
                                        </div>
                                        
                                        
                                    </form>
                                </div>
                            <?php } ?>
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