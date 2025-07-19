<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    echo "You are trying  to  without login access. Please login first";
} else {
    if(isset($_POST['action'])){ 
        $id= $_POST['id'];
        // SQL query to fetch the last enrollmentid
        $sql = "SELECT * FROM tblcandidate WHERE CandidateId = '$id' "; // Replace 'id' with the actual 
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
            //echo $payment_val;
        } else {
            echo "No payment record found for JobrollId: " . htmlspecialchars($jobid);
        }


        $last_id = $_POST['id'];

        $candidate_id = $last_id;
        $checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";
        $checkQuery = $dbh->prepare($checkSql);
        $checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
        $checkQuery->execute();
        
        // Fetch all rows associated with the candidate_id
        $results = $checkQuery->fetchAll(PDO::FETCH_ASSOC);

        $rowCount = count($results);

        if (!empty($results)) {
            // Candidate exists, show the data
            foreach ($results as $row) {
                $Discount_val = $row['discount'];
                $Paid_val = $row['paid'];
                $Balance_val = $row['balance'];
                $total_fee= $row['total_fee'];
                $status= $row['status'];
            }
        } else {
            $Discount_val = '0';
            $Paid_val = '0';
            $Balance_val = $result4['payment'];
            $total_fee= $result4['payment'];
            $status= 'Pending';
        }



        
        $enroll = $result['enrollmentid'];
        $candidatename = $result['candidatename'];
        $fathername = $result['fathername'];
        $village = $result['village'];

        echo "<table class='table'>";
        echo '<tr><th> Enrollment ID</th><td> '.$enroll.' </td></tr>';
        echo '<tr><th> Full Name </th><td> '.$candidatename.' </td></tr>';
        echo '<tr><th> Father Name </th><td> '.$fathername.' </td></tr>';
        echo '<tr><th> Village </th><td> '.$village.' </td></tr>';
        echo '<tr><th> Total Fee </th><td> '.$payment_val.' </td></tr>';
        echo '<tr><th> Discount </th><td> '.$Discount_val.' </td></tr>';
        echo '<tr><th> Paid </th><td> '.$Paid_val.' </td></tr>';
        echo '<tr><th> Balance </th><td> '.$Balance_val.' </td></tr>';
        echo '<tr><th> Status </th><td> '.$status.' </td></tr>';
        echo "</table>";
    }
}
?>