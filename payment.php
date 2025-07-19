<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else { 

    $msg ='';
    $error ='';

    $last_id = $_GET['last_id'];



    $candidate_id = $last_id;




    $checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";
    $checkQuery = $dbh->prepare($checkSql);
    $checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
    $checkQuery->execute();
    
    // Fetch all rows associated with the candidate_id
    $result = $checkQuery->fetchAll(PDO::FETCH_ASSOC);

    $Balance_val = $row['total_fee'];
    $total_fee= $row['total_fee'];

    if (!empty($result)) {
        // Candidate exists, show the data
        foreach ($result as $row) {
            $Discount_val = $row['discount'];
            $Paid_val = $row['paid'];
            $total_fee= $row['total_fee'];
            if($row['balance'] == ''){
                $Balance_val = $row['total_fee'];
            }else{
                $Balance_val = $row['balance'];
            }
            
            
        }
    } else {
        
        $Discount_val = '0';
        $Paid_val = '0';
        $total_fee = '0';
    }

    if (isset($_POST['submit'])) {



    $enrollmentid = $_POST['enrollmentid'];
    $candidate_id = $_POST['candidate_id'];
    $discount = $_POST['discount']+$Discount_val;
    $paid = $_POST['paid'];
    $balance = $_POST['balance'];
    $total_fee = $_POST['total_fee'];
    $payment_mode = $_POST['payment_mode'];
    $created_date = $_POST['created_at'];

    $name = $_POST['candidatename'];
    $fathername = $_POST['fathername'];
    $phone = $_POST['phone'];

    $date = DateTime::createFromFormat('d-m-Y', $created_date);
    $created_at = $date ? $date->format('Y-m-d') : null;
    $created = $date ? $date->format('Y-m-d') : null;

    //$created_at = date("Y-m-d H:i:s"); // Current timestamp


    try {
        // Check if record exists
        $checkSql = "SELECT COUNT(*) as count FROM payment WHERE enrollmentid = :enrollmentid AND candidate_id = :candidate_id";
        $checkQuery = $dbh->prepare($checkSql);
        $checkQuery->bindParam(':enrollmentid', $enrollmentid, PDO::PARAM_STR);
        $checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
        $checkQuery->execute();
        $recordExists = $checkQuery->fetch(PDO::FETCH_ASSOC)['count'] > 0;

        if ($recordExists) {


            $balance = $_POST['balance'];
            
            $paid = $_POST['total_fee'] - $_POST['balance'];

            if($total_fee == $paid){
                $status = "Paid";
            }else{
                $status = "Pending";
            }

             // Update existing record
            $updateSql = "UPDATE payment 
                          SET discount = :discount, paid = :paid, balance = :balance, created_at = :created_at,status=:status ,added_type=:added_type
                          WHERE candidate_id = :candidate_id";

            $updateQuery = $dbh->prepare($updateSql);

            // Bind parameters
            $updateQuery->bindParam(':discount', $discount, PDO::PARAM_STR); // Adjust type if needed
            $updateQuery->bindParam(':paid', $paid, PDO::PARAM_STR);
            $updateQuery->bindParam(':balance', $balance, PDO::PARAM_STR);
            $updateQuery->bindParam(':created_at', $created_at, PDO::PARAM_STR);
            $updateQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT); // Ensure candidate_id is bound
            $updateQuery->bindParam(':status', $status, PDO::PARAM_STR); // Ensure candidate_id is bound
            $updateQuery->bindParam(':added_type', $_SESSION['user_type'], PDO::PARAM_STR); // Ensure candidate_id is bound

            // Execute the query
            $updateQuery->execute();

            $paid = $_POST['discount'] + $_POST['paid'];
            $payment_mode = $_POST['payment_mode'];
            $insertSql = "INSERT INTO emi_list (candidate_id, paid, created,added_type,payment_mode ) VALUES ( :candidate_id, :paid, :created,:added_type,:payment_mode )";
            $insertQuery = $dbh->prepare($insertSql);
            $insertQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $insertQuery->bindParam(':paid', $paid, PDO::PARAM_STR);
            $insertQuery->bindParam(':created', $created, PDO::PARAM_STR);
            $insertQuery->bindParam(':added_type', $_SESSION['user_type'], PDO::PARAM_STR);
            $insertQuery->bindParam(':payment_mode', $payment_mode, PDO::PARAM_STR);
            $insertQuery->execute();


            

            // inserting data in account 
		
            	
            if($paid != 0){
                // Include your database connection
                include 'includes/account.php'; // $acc connection defined here
                
                // Sample or dynamic input values
                $date = date('Y-m-d');
                //$name = ''; // Fill from $_POST or leave blank if not used
                //$phone = ''; // Fill from $_POST or leave blank if not used
                $description = $name;
                $category = 'Student                  ';
                $subcategory = 'Student Fees';
                $amount = $paid;       // Example: 10000.00
                $received = $paid;     // Example: 10000.00
                $balance = 0;             // Can also calculate: $amount - $received
                $student_id = $candidate_id; // Must be defined before
                
                // Prepare the INSERT query
                $stmt = $acc->prepare("INSERT INTO income (
                    date, name, phone, description, category, subcategory,
                    amount, received, balance, created_at, updated_at, student_id
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)");
                
                // Bind parameters
                $stmt->bind_param(
                    "ssssssddds",
                    $date, $name, $phone, $description,
                    $category, $subcategory, $amount, $received, $balance, $student_id
                );
                
                // Execute
                if ($stmt->execute()) {
                  //  echo "✅ Income record inserted successfully!";
                } else {
                  //  echo "❌ Error inserting record: " . $stmt->error;
                }
                
                // Close
                $stmt->close();
                $acc->close();
            }

            // Check if any row was updated
            if ($updateQuery->rowCount() > 0) {
                //echo "Record updated successfully.";

                echo "<script>alert('Payment  updated')</script>";
                echo  '<script> setTimeout(function() { window.location.href = "manage-candidate.php"; }, 1000); </script>';
                //echo "<script>window.location.href = window.location.href;</script>";
            } else {
                echo "No record updated. Please check if candidate_id exists.";
            }


		
		
		// end account section

        } else {
            //$balance = $total_fee-($_POST['paid']);
            $balance = $_POST['balance'];
            //$paid = $Paid_val+$_POST['paid']+$_POST['discount'];
            $paid = $_POST['total_fee'] - $_POST['balance'];
            // Insert new record
            $insertSql = "INSERT INTO payment (
                enrollmentid, candidate_id, discount, paid, balance, total_fee, created_at,added_type
            ) VALUES (
                :enrollmentid, :candidate_id, :discount, :paid, :balance, :total_fee, :created_at,:added_type
            )";
            $insertQuery = $dbh->prepare($insertSql);
            $insertQuery->bindParam(':enrollmentid', $enrollmentid, PDO::PARAM_STR);
            $insertQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $insertQuery->bindParam(':discount', $discount, PDO::PARAM_STR);
            $insertQuery->bindParam(':paid', $paid, PDO::PARAM_STR);
            $insertQuery->bindParam(':balance', $balance, PDO::PARAM_STR);
            $insertQuery->bindParam(':total_fee', $total_fee, PDO::PARAM_STR);
            $insertQuery->bindParam(':created_at', $created_at, PDO::PARAM_STR);
            $insertQuery->bindParam(':added_type', $_SESSION['user_type'], PDO::PARAM_STR);
            $insertQuery->execute();

            $lastInsertId = $dbh->lastInsertId();

            $paid = $_POST['discount'] + $_POST['paid'];
            $payment_mode = $_POST['payment_mode'];

            $insertSql = "INSERT INTO emi_list (candidate_id, paid, created ,added_type,payment_mode) VALUES ( :candidate_id, :paid, :created ,:added_type,:payment_mode)";
            $insertQuery = $dbh->prepare($insertSql);
            $insertQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $insertQuery->bindParam(':paid', $paid, PDO::PARAM_STR);
            $insertQuery->bindParam(':created', $created, PDO::PARAM_STR);
            $insertQuery->bindParam(':added_type', $_SESSION['user_type'], PDO::PARAM_STR);
            $insertQuery->bindParam(':payment_mode', $payment_mode, PDO::PARAM_STR);
            $insertQuery->execute();

            echo "<script>alert('Record inserted successfully')</script>";
            //echo "<script>window.location.href = window.location.href;</script>";


           // echo "Record inserted successfully. Last Insert ID: " . $lastInsertId;


            // inserting data in account 
		
            	
            if($paid != 0){
                // Include your database connection
                include 'includes/account.php'; // $acc connection defined here
                
                // Sample or dynamic input values
                $date = date('Y-m-d');
                //$name = ''; // Fill from $_POST or leave blank if not used
                //$phone = ''; // Fill from $_POST or leave blank if not used
                $description = $name;
                $category = 'Student                  ';
                $subcategory = 'Student Fees';
                $amount = $paid;       // Example: 10000.00
                $received = $paid;     // Example: 10000.00
                $balance = 0;             // Can also calculate: $amount - $received
                $student_id = $candidate_id; // Must be defined before
                
                // Prepare the INSERT query
                $stmt = $acc->prepare("INSERT INTO income (
                    date, name, phone, description, category, subcategory,
                    amount, received, balance, created_at, updated_at, student_id
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)");
                
                // Bind parameters
                $stmt->bind_param(
                    "ssssssddds",
                    $date, $name, $phone, $description,
                    $category, $subcategory, $amount, $received, $balance, $student_id
                );
                
                // Execute
                if ($stmt->execute()) {
                  //  echo "✅ Income record inserted successfully!";
                } else {
                 //   echo "❌ Error inserting record: " . $stmt->error;
                }
                
                // Close
                $stmt->close();
                $acc->close();
            }

            echo  '<script> setTimeout(function() { window.location.href = "manage-candidate.php"; }, 1000); </script>';


		
		
		// end account section

        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
    
    // SQL query to fetch the last enrollmentid
    $sql = "SELECT * FROM tblcandidate WHERE CandidateId = '$last_id' "; // Replace 'id' with the actual primary key or a unique column
    
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);

    //print_r($results); die;
    
    // Check if a result was found
    if ($results) {
        $enroll = $results['enrollmentid'];
    } else {
        $enroll = "No records found.";
    }


    $last_id = $_GET['last_id'];
    // SQL query to fetch the last enrollmentid
    $sql1 = "SELECT CandidateId,jobid FROM tblcandidate WHERE CandidateId = '$last_id' "; // Replace 'id' with the 
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $jobid = $result['job_roll'];


    // SQL query to fetch the last tbljobroll
    $sql4 = "SELECT JobrollId, payment FROM tbljobroll WHERE JobrollId = :jobid";
    $query4 = $dbh->prepare($sql4);

    // Bind parameter to prevent SQL injection
    $query4->bindParam(':jobid', $jobid, PDO::PARAM_INT);

    // Execute the query
    $query4->execute();

    // Fetch the first row
    $result4 = $query4->fetch(PDO::FETCH_ASSOC);

    if ($result4 && isset($result4['payment'])) {
        $payment_val = $result4['payment'];
        if($total_fee =='0'){
            $Balance_val = $result4['payment'];
        }

    } else {
       // echo "No payment record found for JobrollId: " . htmlspecialchars($jobid);
    }


    $candidate_id = $last_id;
    $checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";
    $checkQuery = $dbh->prepare($checkSql);
    $checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
    $checkQuery->execute();
    
    // Fetch all rows associated with the candidate_id
    $result_new = $checkQuery->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result_new)) {
        // Candidate exists, show the data
        foreach ($result_new as $row) {
            $Discount_val = '0';//$row['discount'];
            $Paid_val = $row['paid'];
            $total_fee= $row['total_fee'];
            //if($row['balance'] == ''){
             //   $Balance_val = $row['total_fee'];
            //}else{
                $Balance_val = $row['balance'];
            //}
            
            
        }
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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/mystyle.css"> 
    <script src="js/modernizr/modernizr.min.js"></script>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">


    
    <style>
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 10px; }
        .table-responsive { border-radius: 10px; overflow: hidden; }
        .btn-action { padding: 5px 10px; margin: 0 2px; }
        .thead-dark { background: #212529; color: white; }
/*        .dt-buttons { margin-bottom: 15px; }*/
        .dt-button-collection {
            max-height: 300px; /* Adjust height as needed */
            overflow-y: auto !important;
        }

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
                        <h1 class="h2">Candidate Payment</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item">Candidate</li>
                            <li class="breadcrumb-item active" aria-current="page">Candidate Payment</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                    <div class="alert alert-success left-icon-alert" role="alert">
                        <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                    </div><?php } else if ($error) { ?>
                    <div class="alert alert-danger left-icon-alert" role="alert">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                    </div>
                    <?php } ?>

                    <!-- Candidates Table -->
                    <div class="card">
                        
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="candidate_id"  required="required" value="<?=$_GET['last_id']?>">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="enrollmentid">Enrollment ID</label>
                                            <input type="text" name="enrollmentid" class="form-control"
                                                id="enrollmentid" required="required"
                                                placeholder="Enrollment ID" value="<?=$enroll?>">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="created_at">Created Date</label>
                                            <input type="text" name="created_at" class="form-control"
                                                id="datepicker" required="required"
                                                placeholder="Created Date" value="<?=date('d-m-Y'); ?>">
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label for="candidatename">Full Name</label>
                                            <input type="text" name="candidatename" class="form-control"
                                                id="candidatename" required="required"
                                                placeholder="Enter Full Name" value="<?=$results['candidatename']; ?>">
                                        </div>

                                        <input type="hidden" name="phone" class="form-control"
                                                id="phone" required="required" value="<?=$results['phonenumber']; ?>">

                                        <div class="form-group col-md-6">
                                            <label for="fathername">Father Name</label>
                                            <input type="text" name="fathername" required="required"
                                                class="form-control" id="fathername"
                                                placeholder="Enter Father Name" value="<?=$results['fathername']; ?>">
                                        </div>
                                    </div>

                                
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="village">Village</label>
                                            <input type="text" name="village" class="form-control" id="village"
                                                placeholder="Village" value="<?=$results['village']; ?>">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="total_fee">Total Fee</label>
                                            <input type="text" name="total_fee" class="form-control" id="total_fee"
                                                placeholder="Total Fee" value="<?=$payment_val?>" readonly>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="discount">Discount</label>
                                            <input type="number" name="discount" class="form-control" id="discount"
                                                placeholder="Discount" value="0" <?php if($payment_val != $Balance_val) { echo 'readonly'; } ?> >
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="paid">Pay</label>
                                            <input type="number" name="paid" class="form-control" id="paid"
                                                placeholder="Paid" value="0">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="balance">Balance</label>
                                            <input type="text" name="balance" class="form-control" id="balance"
                                                placeholder="Balance" value="<?=$Balance_val?>">

                                                <input type="hidden" name="" class="form-control" id="balance_total"
                                                placeholder="Balance" value="<?=$Balance_val?>">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="payment_mode">Payment Mode</label>
                                            <select name="payment_mode" id="payment_mode" class="form-control" required>
                                                <option value="">Select Payment Mode</option>
                                                <option value="Online">Online</option>
                                                <option value="Cash">Cash</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12 error_message text-danger"></div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">

                                            <button type="submit" name="submit" class="btn btn-primary" id="submit_btn">Make Payment</button>
                                            <a href="manage-candidate.php" class="btn btn-danger">Skip</a>

                                            <button type="button" class="btn btn-success" onClick='p_all_data(<?php echo $last_id; ?>)' data-toggle="modal" data-target="#p_myModal">Print</td></button>

                                        </div>
                                    </div>

                                </form>


                                <?php
                                // candidate table
                                    $c_checkSql = "SELECT * FROM tblcandidate WHERE CandidateId = :candidate_id";

                                    $c_checkQuery = $dbh->prepare($c_checkSql);
                                    $c_checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                                    $c_checkQuery->execute();

                                    // Fetch all rows associated with the CandidateId
                                    $c_result = $c_checkQuery->fetchAll(PDO::FETCH_ASSOC);

                                    // Training Center table
                                    $TrainingcenterId = $c_result[0]['training_center'];
                                    $t_checkSql = "SELECT * FROM tbltrainingcenter WHERE TrainingcenterId = :TrainingcenterId";

                                    $t_checkQuery = $dbh->prepare($t_checkSql);
                                    $t_checkQuery->bindParam(':TrainingcenterId', $TrainingcenterId, PDO::PARAM_INT);
                                    $t_checkQuery->execute();

                                    // Fetch all rows associated with the TrainingcenterId
                                    $t_result = $t_checkQuery->fetchAll(PDO::FETCH_ASSOC);

                                    // Payment table
                                    $p_checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";

                                    $p_checkQuery = $dbh->prepare($p_checkSql);
                                    $p_checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                                    $p_checkQuery->execute();

                                    // Fetch all rows associated with the TrainingcenterId
                                    $p_result = $p_checkQuery->fetchAll(PDO::FETCH_ASSOC);

                                    // tblscheme table
                                    $SchemeId = $c_result[0]['scheme'];
                                    $scheme_checkSql = "SELECT * FROM tblscheme WHERE SchemeId = :SchemeId";

                                    $scheme_checkQuery = $dbh->prepare($scheme_checkSql);
                                    $scheme_checkQuery->bindParam(':SchemeId', $SchemeId, PDO::PARAM_INT);
                                    $scheme_checkQuery->execute();

                                    // Fetch all rows associated with the TrainingcenterId
                                    $scheme_result = $scheme_checkQuery->fetchAll(PDO::FETCH_ASSOC);

                                    // tblsector table
                                    $SectorId = $c_result[0]['sector'];
                                    $sector_checkSql = "SELECT * FROM tblsector WHERE SectorId = :SectorId";

                                    $sector_checkQuery = $dbh->prepare($sector_checkSql);
                                    $sector_checkQuery->bindParam(':SectorId', $SectorId, PDO::PARAM_INT);
                                    $sector_checkQuery->execute();

                                    // Fetch all rows associated with the TrainingcenterId
                                    $sector_result = $sector_checkQuery->fetchAll(PDO::FETCH_ASSOC);

                                    // tbljobroll table
                                    $JobrollId = $c_result[0]['job_roll'];
                                    $job_checkSql = "SELECT * FROM tbljobroll WHERE JobrollId = :JobrollId";

                                    $job_checkQuery = $dbh->prepare($job_checkSql);
                                    $job_checkQuery->bindParam(':JobrollId', $JobrollId, PDO::PARAM_INT);
                                    $job_checkQuery->execute();

                                    // Fetch all rows associated with the TrainingcenterId
                                    $job_result = $job_checkQuery->fetchAll(PDO::FETCH_ASSOC);

                                    // tbljobroll table
                                    $batch_id = $c_result[0]['batch'];
                                    $batch_checkSql = "SELECT * FROM tblbatch WHERE id = :batch_id";

                                    $batch_checkQuery = $dbh->prepare($batch_checkSql);
                                    $batch_checkQuery->bindParam(':batch_id', $batch_id, PDO::PARAM_INT);
                                    $batch_checkQuery->execute();

                                    // Fetch all rows associated with the TrainingcenterId
                                    $batch_result = $batch_checkQuery->fetchAll(PDO::FETCH_ASSOC);

                                    // emi table
                                    // Prepare and execute the query to fetch all records from the emi_list table
                                    $sql = "SELECT id, candidate_id, paid, created,added_type,payment_mode FROM emi_list where candidate_id = '$candidate_id'";
                                    $stmt = $dbh->prepare($sql);
                                    $stmt->execute();

                                    // Fetch all rows as an associative array
                                    $emi_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    $pending_list=1;
                                ?>


                                <!-- Modal for all Content-->
                                <div id="p_myModal" class="modal fade" role="dialog">
                                  <div class="modal-dialog">

                                    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
                                     <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
                                    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
                                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                                    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
                                    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
                                    <link rel="stylesheet" href="css/select2/select2.min.css">
                                    <link rel="stylesheet" href="css/main.css" media="screen">
                                    <link rel="stylesheet" href="css/mystyle.css">

                                    <style type="text/css">
                                        #p_myModal p, #p_myModal blockquote, #p_myModal pre, #p_myModal address, #p_myModal dl, #p_myModal ol, #p_myModal ul, #p_myModal table {
                                            margin-bottom: 0em;
                                        }
                                    </style>

                                    <?php // print_r($p_result)?>

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Payment Receipt</h4>
                                      </div>
                                      <div class="modal-body" id="p_myModals">



                                        <!DOCTYPE html>
                                        <html lang="en">
                                        <head>
                                            <meta charset="UTF-8">
                                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                            <title>Payment Receipt</title>
                                            <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
                                            <style>
                                                .receipt {
                                                    width: 100%;
                                                    max-width: 600px;
                                                    background: #fff;
                                                    padding: 15px;
                                                    border: 2px solid #000;
                                                    border-radius: 10px;
                                                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                                    margin: 30px auto;
                                                    height: auto;
                                                }
                                                .receipt-header {
                                                    text-align: center;
                                                    border-bottom: 2px solid #000;
                                                    padding-bottom: 5px;
                                                    margin-bottom: 5px;
                                                    vertical-align: middle !important;
                                                }
                                                .receipt-header img {
                                                    height: 50px;
                                                   /* position: absolute;
                                                    right: 27px;
                                                    top: 39px;
                                                    margin: 11px;*/
                                                }

                                                .receipt-header .table>tbody>tr>td {
                                                    padding: 0px;
                                                    line-height: 1.428571429;
                                                    vertical-align: top;
                                                    border: 0px solid #ffff;
                                                }
                                                .receipt-header .table tbody tr:nth-child(odd) {
                                                    background-color: #ffff;
                                                }

                                                .receipt-details {
                                                    display: flex;
                                                    justify-content: space-between;
                                                }
                                                .receipt-details .column {
                                                    width: 48%;
                                                }
                                                .receipt-details p {
                                                    margin: 5px 0;
                                                    font-size: 12px;
                                                    color: #000;
                                                    line-height: 12px;
                                                }
                                                .table th, .table td {
                                                    vertical-align: middle;
                                                    text-align: center;
                                                    border: 1px solid #000;
                                                }
                                                .table tbody tr:nth-child(odd) {
                                                    background-color: #f2f2f2;
                                                }
                                                .signature {
                                                    margin-top: 30px;
                                                    text-align: right;
                                                    font-size: 16px;
                                                    font-weight: bold;
                                                }
                                                .signature-line {
                                                    margin-top: 10px;
                                                    border-top: 2px solid #000;
                                                    width: 200px;
                                                    text-align: center;
                                                    margin-left: auto;
                                                }
                                                .contact-info {
                                                    text-align: center;
                                                    margin-top: 20px;
                                                    font-size: 14px;
                                                }

                                                .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                                                    padding: 0px;
                                                    font-size: 11px;
                                                }

                                                @media (min-width: 1140px) {
                                                    .receipt h4, .receipt .h4 {
                                                        font-size: 19.60708345px;
                                                        margin-top: 0;
                                                        line-height: 1;
                                                        margin-bottom: 0;
                                                    }
                                                    .receipt h5, .receipt .h5 {
                                                        font-size: 16.5680164262px;
                                                        margin-top: 5px;
                                                        line-height: 2;
                                                        margin-bottom: 0;
                                                    }
                                                }


                                                @media print {
                                                    body {
                                                        background: none;
                                                    }
                                                    .receipt {
                                                        width: 100%;
                                                        height: 50vh; 
                                                        page-break-after: always;
                                                        box-shadow: none;
                                                        margin: 0 auto;
                                                        border: 2px solid #000;
                                                    }
                                                }

                                                .table {
                                                    border-collapse: collapse;
                                                }

                                                .table-dark{
                                                    background: #212529;
                                                    color: white;
                                                }
                                                .table-dark th{
                                                    color: white;
                                                }
                                                .table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
                                                    border: 1px solid #212529;
                                                }
                                                .table-warning td{
                                                    background: #fff3cd;
                                                }

                                                @media print {
                                                    .receipt {
                                                        width: 100%;
                                                        max-width: 100%;
                        /*                                border: none;*/
                        /*                                box-shadow: none;*/
                        /*                                margin: 0 auto;*/
                                                        padding: 5mm; /* Ensures consistent padding */
                                                    }
                                                    .table {
                                                        width: 100%;
                                                        border-collapse: collapse; /* Prevents double borders */
                                                    }
                                                    .table th, .table td {
                                                        border: 1px solid #000;
                                                        padding: 1px;
                                                    }
                                                    @page {
                                                        margin: 5mm; /* Adjusts page margins for A4 */
                                                    }
                                                }



                                                @media print {
                                                    .receipt {
                                                        height: auto;
                                                        page-break-after: always; /* Ensures correct page breaks */
                                                    }
                                                }
                                            </style>
                                        </head>
                                        <body>
                                            <div class="receipt">
                                                <div class="receipt-header">
                                                    <table class="table">
                                                        <tr>
                                                            <td style="text-align: justify;"><h4 class="fw-bold"><span style="letter-spacing: 8px;font-size: 25px;font-weight: 700;">SOFTPRO</span> <br> PAYMENT RECEIPT</h4></td>
                                                            <td><img src="images/print_logo.jpg" alt="SoftPro Logo"></td>
                                                        </tr>
                                                    </table>
                                                    
                                                    
                                                </div>
                                                <div class="receipt-details">
                                                    <div class="column">
                                                        <p><strong>Enrollment. No:</strong> <?=$c_result[0]['enrollmentid']?></p>
                                                        <p><strong>Student:</strong> <?=$c_result[0]['candidatename']?></p>
                                                        <p><strong>Training Center:</strong> <?=$t_result[0]['trainingcentername']?></p>
                                                        <p><strong>Scheme:</strong> <?=$scheme_result[0]['SchemeName']?></p>
                                                        <p><strong>Sector:</strong> <?=$sector_result[0]['SectorName']?></p>
                                                    </div>
                                                    <div class="column">
                                                        <p><strong>Job Roll:</strong> <?=$job_result[0]['jobrollname']?></p>
                                                        <p><strong>Batch:</strong> <?=$batch_result[0]['batch_name']?></p>
                                                        <p><strong>Payment Date:</strong> <?=date("M d, Y", strtotime($p_result[0]['created_at']))?></p>
                                                        <p><strong>Paid Amount:</strong> <?=$p_result[0]['paid']?></p>
                                                        <p><strong>Payment Mode:</strong> Cash/Online</p>
                                                    </div>
                                                </div>
                                                <h5 class="fw-bold border-bottom pb-2 text-center">Payment Summary</h5>
                                                <table class="table table-bordered">
                                                    <thead class="table-dark" style="background: #212529;">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($emi_result)): ?>
                                                            <?php foreach ($emi_result as $row): ?>

                                                                <?php
                                                                if($row['added_type'] !=1 ){
                                                                    $pending_list = $row['added_type'];
                                                                }
                                                                 
                                                                 ?>

                                                            <?php if($row['paid'] !=0){ ?>
                                                            
                                                            <tr>
                                                                <td><b>Paid On :<?php echo htmlspecialchars($row['payment_mode']); ?> </b></td>
                                                                <td><b><?=date("M d, Y", strtotime($row['created']))?></b></td>
                                                                <td class="text-right"><b><?php echo htmlspecialchars($row['paid']); ?></b></td>
                                                            </tr>
                                                            <?php } ?>
                                                            <?php endforeach; ?>
                                                        <?php endif ?>
                                                        <tr>
                                                            <td><b></b></td>
                                                            <td><b>Total Payable Fee</b></td>
                                                            <td class="text-right"><b><?=$p_result[0]['total_fee']?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b></b></td>
                                                            <td><b>Total Paid</b></td>
                                                            <td class="text-right"><b><?=$p_result[0]['paid']?></b></td>
                                                        </tr>
                                                        <tr class="table-warning">
                                                            <td><b></b></td>
                                                            <td><b>Balance</b></td>
                                                            <td class="text-right"><b><?=$p_result[0]['balance']?></b></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="signature">
                                                    Authorised Signature
                                                </div>
                                                <div class="contact-info">
                                                    <p><strong>Address:</strong> 18-86 B, Main Road, Parvathipuram Manyam, Andhra Pradesh - 535501</p>
                                                    <p><strong>Ph:</strong> 7799773656</p>
                                                </div>
                                            </div>
                                        </body>
                                        </html>


                                        
                                        
                                     

                                        
                                    
                                      </div>
                                      <div class="modal-footer">
                                        <?php // print_r($_SESSION['user_type'])?>
                                        <?php if($pending_list == 1){ ?>
                                        <button type="button" class="btn btn-success" id="printButton" data-dismiss="modal">Print</button>
                                        <?php }else{ echo "Pending Approval"; } ?>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>

                                  </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

  

  

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>


           <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

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


        function p_all_data(id){
            $("#p_data").html('Loading...');
            $.ajax({
                url:'candidate_ajax.php',
                type:'post',
                data:{action:'action',id:id},
                success:function(res){
                   /// $("#p_data").html(res);
                }
            });
        }
        </script>

        <script>


        //$(document).ready(function () {
            $('#printButton').click(function (event) {
                event.preventDefault(); // Prevent default behavior

                var printContents = $('#p_myModals').html();
                var printWindow = window.open('', '', 'height=600,width=800');

                if (!printWindow) {
                    alert("Popup blocked! Please allow popups for this site.");
                    return;
                }

                var cssLink = '<link rel="stylesheet" href="https://student.softpromis.com/css/bootstrap.min.css" type="text/css" />';
                
                printWindow.document.open();
                printWindow.document.write('<html><head><title>Print</title>' + cssLink + '</head><body>');
                printWindow.document.write(printContents);
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                // Delay print to ensure content and styles are fully loaded
                setTimeout(function () {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            });
        //});




        $('#discount,#paid').on('input',function(){
            var total_fee = $('#balance_total').val();
            
            var discount = $('#discount').val();
            var paid = $('#paid').val();
            $('#balance').val(total_fee - discount - paid);

            var balance = (total_fee - discount - paid).toFixed(2);



            if(balance < 0){

                $('.error_message').html("Paying amount cannot be more than the balance amount!");
                $('#submit_btn').prop('disabled', true); // disable the button
            }else{
                $('.error_message').html("");
                $('#submit_btn').prop('disabled', false); // enable the button
            }
        });
    </script>


      <!-- jQuery and jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- jQuery Timepicker Addon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

<!-- Date & Time Picker Initialization -->
<script>
  $(function() {
    $("#datepicker").datepicker({
      dateFormat: "dd-mm-yy" // Date only in dd-mm-yy format
    });
  });
</script>
    
</body>
</html>



























<?PHP } ?>