<?php
session_start();
error_reporting(0);
include('includes/config.php');

$databasetable = "tblcandidate";

/************************ YOUR DATABASE CONNECTION END HERE  ****************************/


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
$inputFileName = 'bulkfile.xlsx';

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch (Exception $e) {
	die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
}

$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

for ($i = 2; $i <= $arrayCount; $i++) {
	$userName = trim($allDataInSheet[$i]["A"]);
	$fathername = trim($allDataInSheet[$i]["B"]);

	$sql = "SELECT name FROM tblcandidate WHERE candidatename = '" . $userName . "' and fathername = '" . $fathername . "'";
	$query = $dbh->prepare($sql);
	$sql = mysql_query($query);
	$recResult = mysql_fetch_array($sql);
	$existName = $recResult["candidatename"];
	if ($existName == "") {
		$insertTable = mysql_query("insert into tblcandidate (candidatename, fathername) values('" . $userName . "', '" . $fathername . "');");

		$msg = 'Record has been added. <div style="Padding:20px 0 0 0;"><a href="https://discussdesk.com//import-excel-file-data-in-mysql-database-using-PHP.htm" target="_blank">Go Back to tutorial</a></div>';
	} else {
		$msg = 'Record already exist. <div style="Padding:20px 0 0 0;"><a href="https://discussdesk.com//import-excel-file-data-in-mysql-database-using-PHP.htm" target="_blank">Go Back to tutorial</a></div>';
	}
}
echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>" . $msg . "</div>";