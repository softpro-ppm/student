<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    $uploadedStatus = 0;
}
?>
<?php

try {
    // Create PDO instance with UTF-8 support
    $dbh = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
    );
    // Set error mode to exceptions
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['submit'])) {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, "r");

        if ($handle !== FALSE) {
            // Skip the header row
            fgetcsv($handle);

            // Prepare the SQL statement once outside the loop
            $sql = "INSERT INTO tblcandidate 
                    (enrollmentid,candidatename, fathername, aadharnumber, phonenumber, email, dateofbirth, gender, maritalstatus, religion, category, village, mandal, district, state, pincode, training_center, scheme, sector, job_roll, batch)
                    VALUES (:enrollmentid,:candidatename, :fathername, :aadharnumber, :phonenumber, :email, :dateofbirth, :gender, :maritalstatus, :religion, :category, :village, :mandal, :district, :state, :pincode, :training_center, :scheme, :sector, :job_roll, :batch)";
            $stmt = $dbh->prepare($sql);

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Map CSV columns to named placeholders

                // newEnrollmentId  start

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
                        $enroll = "No records found.";
                    }

                    // newEnrollmentId end


                $params = array(
                    ':enrollmentid'    => $newEnrollmentId,
                    ':candidatename'    => $data[0],
                    ':fathername'        => $data[1],
                    ':aadharnumber'      => $data[2],
                    ':phonenumber'       => $data[3],
                    ':email'             => $data[4],
                    ':dateofbirth'       => $data[5],
                    ':gender'            => $data[6],
                    ':maritalstatus'     => $data[7],
                    ':religion'          => $data[8],
                    ':category'          => $data[9],
                    ':village'           => $data[10],
                    ':mandal'            => $data[11],
                    ':district'          => $data[12],
                    ':state'             => $data[13],
                    ':pincode'           => $data[14],
                    ':training_center'   => $data[15],
                    ':scheme'            => $data[16],
                    ':sector'            => $data[17],
                    ':job_roll'          => $data[18],
                    ':batch'             => $data[19]
                );

                try {
                    $stmt->execute($params);
                } catch (PDOException $e) {
                    echo "Error inserting row: " . $e->getMessage() . "<br>";
                }
            }
            
            fclose($handle);
            echo "Bulk upload successful!";
        } else {
            echo "Error opening the file.";
        }
    } else {
        echo "Please upload a valid CSV file.";
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

      <!-- Bootstrap 5 CSS -->
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
        <h2 class="mb-4">Bulk upload</h2>
        <div class="row g-3">
          
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
                                Demo csv file <a href="csv/sample_bulk_upload.csv" download target="_blank">Click here</a>
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


        <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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