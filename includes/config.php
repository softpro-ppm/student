<?php 
date_default_timezone_set("Asia/Kolkata"); // Set to IST (Indian Standard Time)
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','u820431346_smis');
define('DB_PASS','Metx@123');
define('DB_NAME','u820431346_smis');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}