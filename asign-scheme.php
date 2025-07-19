<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $schemeid = $_POST['schemeid'];
        $trainingcenterid = $_POST['trainingcenterid'];
        $date = date("m.d.y");
        $sql = "INSERT INTO tblassignscheme(scheme_id, trainingcenter_id) VALUES(:schemeid, :trainingcenterid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':schemeid', $schemeid, PDO::PARAM_STR);
        $query->bindParam(':trainingcenterid', $trainingcenterid, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "Scheme assigned successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"> -->
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
        .form-control:focus, .select2-container--default .select2-selection--single:focus { 
            border-color: #007bff; 
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25); 
        }
        .select2-container { width: 100% !important; }
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
                        <h1 class="h2">Assign Scheme</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Assign Scheme</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } else if ($error) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- Form -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Assign Scheme to Training Center</h5>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="schemeid" class="form-label">Scheme</label>
                                    <select name="schemeid" class="form-select" id="schemeid" required>
                                        <option value="">Select Scheme</option>
                                        <?php 
                                        $sql = "SELECT * FROM tblscheme";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $schemes = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($schemes as $scheme) { ?>
                                                <option value="<?php echo htmlentities($scheme->SchemeId); ?>">
                                                    <?php echo htmlentities($scheme->SchemeName); ?>
                                                </option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="trainingcenterid" class="form-label">Training Center</label>
                                    <select name="trainingcenterid" class="form-select" id="trainingcenterid" required>
                                        <option value="">Select Training Center</option>
                                        <?php 
                                        $sql = "SELECT * FROM tbltrainingcenter";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $trainings = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($trainings as $training) { ?>
                                                <option value="<?php echo htmlentities($training->TrainingcenterId); ?>">
                                                    <?php echo htmlentities($training->trainingcentername); ?>
                                                </option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i>Assign Scheme
                                </button>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->





    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="js/main.js"></script>

    <script>
    $(document).ready(function() {
        $('#schemeid, #trainingcenterid').select2({
            placeholder: $(this).find('option:first').text(),
            allowClear: true
        });
    });
    </script>
</body>
</html>