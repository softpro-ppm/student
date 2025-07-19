<?php
session_start();
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_GET['batchid'])) {
    $batchid = $_GET['batchid'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SOFTPRO | ADMIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="export/css/bootstrap.min_1.css" />
    <link rel="stylesheet" type="text/css" href="export/css/tableexport.min.css" />
</head>
<div class="container">
    <table id="result" class="table table-bordered" style="font-size:12px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Candidate Name</th>
                <th>Father Name</th>
                <th>Aadhar Number</th>
                <th>Phone Number</th>
                <th>Qualification</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Marital Status</th>
                <th>Religion</th>
                <th>Category</th>
                <th>Village</th>
                <th>Mandal</th>
                <th>District</th>
                <th>State</th>
                <th>Pin Code</th>
                <th>Date Created</th>
                <th> Batch name</th>
                <th>Training centre</th>
                <th>Scheme</th>
                <th>Sector</th>
                <th>Jobroll</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $row_counter = 1;
            $sql = "SELECT tblcandidate.*,tblbatch.*,tbltrainingcenter.*,tblscheme.*,tblsector.*,tbljobroll.* FROM tblcandidate JOIN tblbatch JOIN tbltrainingcenter JOIN tblscheme JOIN tblsector JOIN tbljobroll ON tblcandidate.tblbatch_id = tblbatch.id AND tblbatch.training_centre_id = tbltrainingcenter.TrainingcenterId AND tblbatch.scheme_id = tblscheme.SchemeId AND tblbatch.sector_id = tblsector.SectorId AND tblbatch.job_roll_id = tbljobroll.JobrollId AND tblcandidate.tblbatch_id = '$batchid'";
            $query = $dbh->prepare($sql);
            $query->execute();
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>"
                    . "<td> $row_counter </td> "
                    . "<td> {$row['candidatename']} </td>"
                    . "<td> {$row['fathername']} </td>"
                    . "<td> {$row['aadharnumber']} </td>"
                    . "<td> {$row['phonenumber']} </td>"
                    . "<td> {$row['qualification']} </td>"
                    . "<td> {$row['dateofbirth']} </td>"
                    . "<td> {$row['gender']} </td>"
                    . "<td> {$row['maritalstatus']} </td>"
                    . "<td> {$row['religion']} </td>"
                    . "<td> {$row['category']} </td>"
                    . "<td> {$row['village']} </td>"
                    . "<td> {$row['mandal']} </td>"
                    . "<td> {$row['district']} </td>"
                    . "<td> {$row['state']} </td>"
                    . "<td> {$row['pincode']} </td>"
                    . "<td> {$row['DateCreated']} </td>"
                    . "<td> {$row['batch_name']} </td>"

                    . "<td> {$row['trainingcentername']} </td>"
                    . "<td> {$row['SchemeName']} </td>"
                    . "<td> {$row['SectorName']} </td>"
                    . "<td> {$row['jobrollname']} </td>"

                    . "</tr>";
                $row_counter++;
            }
            ?>
        </tbody>

    </table>

</div>
<script src="export/js/bootstrap.min_1.js" type="text/javascript"></script>
<script src="export/js/FileSaver.min.js" type="text/javascript"></script>

<script src="export/js/jquery-3.1.1.min.js" type="text/javascript"></script>

<script src="export/js/tableexport.min.js" type="text/javascript"></script>

<script>
$('#result').tableExport();
</script>

<body>

</body>

</html>