<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    echo "You are trying  to  without login access. Please login first";
} else {
    echo "Hello";
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



        // Job roll fetching

        $JobrollId = $result['job_roll'];

        // SQL query to fetch the last tbljobroll
        $sql4 = "SELECT JobrollId, jobrollname FROM tbljobroll WHERE JobrollId = '$JobrollId' ORDER BY JobrollId DESC";
        $query4 = $dbh->prepare($sql4);
        $query4->execute();
        $result4 = $query4->fetchAll(PDO::FETCH_ASSOC);
        $jobrollname = $result4[0]['jobrollname'];



        
        $enroll = $result['enrollmentid'];
        $candidatename = $result['candidatename'];
        $fathername = $result['fathername'];
        $aadharnumber = $result['aadharnumber'];
        $phonenumber = $result['phonenumber'];
        $qualification = $result['qualification'];
        $dateofbirth = date_format(date_create($result['dateofbirth']),'d M Y');
        $gender = $result['gender'];
        $maritalstatus = $result['maritalstatus'];
        $religion = $result['religion'];
        $category = $result['category'];
        $village = $result['village'];
        $mandal = $result['mandal'];
        $district = $result['district'];
        $state = $result['state'];
        $pincode = $result['pincode'];




            

        echo "<table class='table'>";
        echo '<tr><th> Enrollment ID</th><td> '.$enroll.' </td></tr>';
        echo '<tr><th> Full Name </th><td> '.$candidatename.' </td></tr>';
        echo '<tr><th> Father Name </th><td> '.$fathername.' </td></tr>';
        echo '<tr><th> Aadhar Number </th><td> '.$aadharnumber.' </td></tr>';
        echo '<tr><th> Phone Number </th><td> '.$phonenumber.' </td></tr>';
        echo '<tr><th> Job roll </th><td> '.$jobrollname.' </td></tr>';
        echo '<tr><th> Date of Birth </th><td>'.$dateofbirth.' </td></tr>';
        echo '<tr><th> Gender </th><td> '.$gender.' </td></tr>';
        echo '<tr><th> Marital Status </th><td> '.$maritalstatus.' </td></tr>';
        echo '<tr><th> Religion </th><td> '.$religion.' </td></tr>';
        echo '<tr><th> Category </th><td> '.$category.' </td></tr>';
        echo '<tr><th> Village </th><td> '.$village.' </td></tr>';
        echo '<tr><th> Mandal </th><td> '.$mandal.' </td></tr>';
        echo '<tr><th> District </th><td> '.$district.' </td></tr>';
        echo '<tr><th> State </th><td> '.$state.' </td></tr>';
        echo '<tr><th> Pin Code </th><td> '.$pincode.' </td></tr>';

        echo '<tr><th> Total Fee </th><td> '.$payment_val.' </td></tr>';
        echo '<tr><th> Discount </th><td> '.$Discount_val.' </td></tr>';
        echo '<tr><th> Paid </th><td> '.$Paid_val.' </td></tr>';
        echo '<tr><th> Balance </th><td> '.$Balance_val.' </td></tr>';
        echo '<tr><th> Status </th><td> '.$status.' </td></tr>';
        echo "</table>";

        //print_r($result);
    }
}
?>