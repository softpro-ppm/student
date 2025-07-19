
<?php  
//export.php  
session_start();

$connect = mysqli_connect("localhost", "root", "root", "srms");
$output = '';

 $query = "SELECT * FROM tblcandidate";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
   <tr>  
   <th>Name</th>  
                       <th>fathername</th>  
                       <th>aadhaar</th>
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
    <td>'.$row["candidatename"].'</td>  
    <td>'.$row["fathername"].'</td>  
    <td>'.$row["aadharnumber"].'</td>
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
 
}
?>