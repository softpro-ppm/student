<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->

    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />

    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .succWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
    .rotated i{
      transform: rotate(90deg);
      color: #5bc0de;
      font-size: 29px;
      padding-left: 20px;
      padding-right: 20px;
    }

    thead,tfoot {
        background: black;
    }

    thead th,tfoot th{
        color: white;
    }
    </style>

    <style>
      /*.custom-bordered {
        border: 2px solid #007bff; /* Blue border */
      }*/
      .custom-bordered td, 
      .custom-bordered th {
        border: 1px solid #007bff; /* Inner borders */
      }
    </style>


</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Manage Candidate</h2>

                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Candidate</li>
                                    <li class="active">Manage Candidate</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->

                    <section class="section">
                        <div class="container-fluid">



                            <div class="row">
                                <div class="col-md-12">

                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>View Candidate Info</h5>
                                            </div>
                                        </div>
                                        <?php if ($msg) { ?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                        </div><?php } else if ($error) { ?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <div style="overflow: auto;">
                                            <table id="example" class="table table-stripped table-bordered table-hover table-full-width table-grey table-responsive-lg table custom-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Enrollment ID</th>
                                                        <th>Candidate Name</th>
                                                        <th>Phone Number</th>
                                                        <th>Job Roll</th>
                                                        <th>CandidateId</th>
                                                        <th>Father name</th>
                                                        <th>Aadhar number</th>
                                                        <th>Qqualification</th>
                                                        <th>Date of birth</th>
                                                        <th>Gender</th>
                                                        <th>Marital status</th>
                                                        <th>Religion</th>
                                                        <th>Category</th>
                                                        <th>Village</th>
                                                        <th>Mandal</th>
                                                        <th>District</th>
                                                        <th>State</th>
                                                        <th>Pincode</th>
                                                        <th>Date Created</th>
                                                        <th>Date Modified</th>
                                                        <th>Batch id</th>
                                                        <th>Training center</th>
                                                        <th>Scheme</th>
                                                        <th>Sector</th>
                                                        <th>Batch</th>
                                                        <th>Payment Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Enrollment ID</th>
                                                        <th>Candidate Name</th>
                                                        <th>Phone Number</th>
                                                        <th>Job Roll</th>
                                                        <th>CandidateId</th>
                                                        <th>Father name</th>
                                                        <th>Aadhar number</th>
                                                        <th>Qualification</th>
                                                        <th>Date of birth</th>
                                                        <th>Gender</th>
                                                        <th>Marital status</th>
                                                        <th>Religion</th>
                                                        <th>Category</th>
                                                        <th>Village</th>
                                                        <th>Mandal</th>
                                                        <th>District</th>
                                                        <th>State</th>
                                                        <th>Pincode</th>
                                                        <th>Date Created</th>
                                                        <th>Date Modified</th>
                                                        <th>Batch id</th>
                                                        <th>Training center</th>
                                                        <th>Scheme</th>
                                                        <th>Sector</th>
                                                        <th>Batch</th>
                                                        <th>Payment Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php $sql = "SELECT * from tblcandidate ORDER BY CandidateId DESC";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {

                                                            $jobrollname ='';

                                                            // SQL query to fetch the last tbljobroll
                                                             $JobrollId = $result->job_roll;
                                                        $sql4 = "SELECT JobrollId, jobrollname FROM tbljobroll WHERE JobrollId = '$JobrollId' ORDER BY JobrollId DESC";
                                                        $query4 = $dbh->prepare($sql4);
                                                        $query4->execute();
                                                        $result4 = $query4->fetchAll(PDO::FETCH_ASSOC);
                                                        $jobrollname = $result4[0]['jobrollname'];


                                                        ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-info btn-xs" onClick='all_data(<?php echo htmlentities($result->CandidateId); ?>)' data-toggle="modal" data-target="#c_myModal"><?php echo htmlentities($result->enrollmentid); ?></td></button>

                                                        <td><?php echo htmlentities($result->candidatename); ?></td>
                                                        <td><?php echo htmlentities($result->phonenumber); ?></td>
                                                        
                                
                                                        <td><?php echo $jobrollname; ?></td>
                                                    
                                                        <td><?php echo htmlentities($result->CandidateId); ?></td>
                                                        <td><?php echo htmlentities($result->fathername); ?></td>
                                                        <td><?php echo htmlentities($result->aadharnumber); ?></td>
                                                        <td><?php echo htmlentities($result->qualification); ?></td>
                                                        <td><?php echo htmlentities($result->dateofbirth); ?></td>
                                                        <td><?php echo htmlentities($result->gender); ?></td>
                                                        <td><?php echo htmlentities($result->maritalstatus); ?></td>
                                                        <td><?php echo htmlentities($result->religion); ?></td>
                                                        <td><?php echo htmlentities($result->category); ?></td>
                                                        <td><?php echo htmlentities($result->village); ?></td>
                                                        <td><?php echo htmlentities($result->mandal); ?></td>
                                                        <td><?php echo htmlentities($result->district); ?></td>
                                                        <td><?php echo htmlentities($result->state); ?></td>
                                                        <td><?php echo htmlentities($result->pincode); ?></td>
                                                        <td><?php echo htmlentities($result->DateCreated); ?></td>
                                                        <td><?php echo htmlentities($result->DateModified); ?></td>
                                                        <td><?php echo htmlentities($result->tblbatch_id); ?></td>
                                                        <td><?php echo htmlentities($result->training_center); ?></td>
                                                        <td><?php echo htmlentities($result->scheme); ?></td>
                                                        <td><?php echo htmlentities($result->sector); ?></td>
                                                        <td><?php echo htmlentities($result->batch); ?></td>

                                                        <?php
                                                         // Payment table
                                                            $candidate_id = $result->CandidateId;
                                                            $p_checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";

                                                            $p_checkQuery = $dbh->prepare($p_checkSql);
                                                            $p_checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                                                            $p_checkQuery->execute();
                                                            $p_result = $p_checkQuery->fetchAll(PDO::FETCH_ASSOC);
                                                            $status='';
                                                            if(count($p_result) ==0){
                                                                $status = '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank"><button class="btn btn-danger btn-xs">Unpaid</abutton></a>';
                                                            }elseif($p_result[0]['paid'] != $p_result[0]['total_fee']){
                                                                $status = '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank"><button class="btn btn-warning btn-xs">Pending</button></a>';
                                                            }else{
                                                                $status = '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank"><button class="btn btn-success btn-xs">Paid</button></a>';
                                                            }
                                                        ?>

                                                        <td><?=$status ?></td>
                                                        
                                                        <td>
                                                            <a class="btn-info btn-xs" href="edit-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>" ><i class="fa fa-edit"></i></a>
                                                            <a class="btn-warning btn-xs" href="#" type="button" onClick='payment_status(<?php echo htmlentities($result->CandidateId); ?>)' data-toggle="modal" data-target="#myModal"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                            <a class="btn-success btn-xs" href="#" type="button" data-toggle="modal" data-target="#myModal_<?php echo htmlentities($result->CandidateId); ?>"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
                                                            <a href="#" class="delete btn-danger btn-xs" id='del_<?php echo htmlentities($result->CandidateId); ?>'><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            
                                                            
                                                            <?php /*
                                                            <div class="dropdown">
                                                                <a class="rotated  dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                                                  <i class="fa fa-ellipsis-v"></i> <!-- 3 dots icon -->
                                                                </a>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                                  <li><a href="edit-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>" >Edit</a></li>
                                                                  <li><a href="#" class="delete" id='del_<?php echo htmlentities($result->CandidateId); ?>'>delete</a></li>
                                                                  <li><a href="#" type="button" onClick='payment_status(<?php echo htmlentities($result->CandidateId); ?>)' data-toggle="modal" data-target="#myModal">Status</a></li>
                                                                  <li><a href="#" type="button" data-toggle="modal" data-target="#myModal_<?php echo htmlentities($result->CandidateId); ?>">
                                                                        Images
                                                                    </a></li>
                                                                </ul>
                                                              </div>
                                                              */ ?>
                                                              
                                                            
                                                                    

                                                        </td>

                                                       
                                                            
                                                            
                                                            
                                                            
                                                            <!-- Button to Open the Modal -->
                                                            
                                                    
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="myModal_<?php echo htmlentities($result->CandidateId); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <!-- Modal Header -->
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel"><?php echo htmlentities($result->candidatename); ?></h4>
                                                                        </div>
                                                                        <!-- Modal Body -->
                                                                        <div class="modal-body">
                                                                            <p>Photo</p>
                                                                            <?php 
                                                                                $doc = $result->candidatephoto;
                                                                                if($doc == ""){
                                                                                    ?>
                                                                                    <i style="font-size:20px;" class="fa fa-upload"></i>
                                                                                <?php
                                                                                }else{
                                                                                ?><a target="_blank"
                                                                                        href="doc/<?php echo htmlentities($result->candidatephoto); ?>">
                                                                                    <img
                                                                                            style="width: 76px;height: 44px;"
                                                                                            src="doc/<?php echo htmlentities($result->candidatephoto); ?>"></a>
                                                                                <?php } ?>
                                                                            <hr><hr>
                                                                            <p>Aadhaar</p>
                                                                            <?php
                                                                                $doc = $result->aadhaarphoto;
                                                                                if($doc == ""){
                                                                                    ?>
                                                                                    <i style="font-size:20px;" class="fa fa-upload"></i>
                                                                                <?php
                                                                                }else{
                                                                                ?><a target="_blank"
                                                                                        href="doc/<?php echo htmlentities($result->aadhaarphoto); ?>">
                                                                                    <img
                                                                                            style="width: 76px;height: 44px;"
                                                                                            src="doc/<?php echo htmlentities($result->aadhaarphoto); ?>"></a>
                                                                                <?php } ?>
                                                                            <hr><hr>
                                                                            <p>Qualification</p>
                                                                            <?php
                                                                                $doc = $result->qualificationphoto;
                                                                                if($doc == ""){
                                                                                    ?>
                                                                                    <i style="font-size:20px;" class="fa fa-upload"></i>
                                                                                <?php
                                                                                }else{
                                                                                ?><a target="_blank"
                                                                                        href="doc/<?php echo htmlentities($result->qualificationphoto); ?>">
                                                                                    <img style="width: 76px;height: 44px;" src="doc/<?php echo htmlentities($result->qualificationphoto); ?>"></a>
                                                                                <?php } ?>
                                                                            <hr><hr>
                                                                            <p>Aplication</p>
                                                                            <?php 
                                                                                $doc = $result->applicationphoto;
                                                                                if($doc == ""){
                                                                                    ?>
                                                                                    <i style="font-size:20px;" class="fa fa-upload"></i>
                                                                                <?php
                                                                                }else{
                                                                                ?><a target="_blank"
                                                                                        href="doc/<?php echo htmlentities($result->applicationphoto); ?>">
                                                                                    <img style="width: 76px;height: 44px;" src="doc/<?php echo htmlentities($result->applicationphoto); ?>"></a>
                                                                            <?php } ?>
                                                                        </div>

                                                                        <a class="btn btn-success m-5"
                                                            href="upload-candidate-file.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>">upload </a>
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                        
                                                    </tr>
                                                    <?php $cnt = $cnt + 1;
                                                            }
                                                        } ?>


                                                </tbody>
                                            </table>


                                            <!-- /.col-md-12 -->
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-md-6 -->


                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-md-6 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.section -->

    </div>
    <!-- /.main-page -->


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Payment Status</h4>
      </div>
      <div class="modal-body">
        <div id="c_id">Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- Modal for all Content-->
<div id="c_myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Payment Status</h4>
      </div>
      <div class="modal-body">
        <div id="c_data">Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>




    </div>
    <!-- /.content-container -->
    </div>
    <!-- /.content-wrapper -->

    </div>
    <!-- /.main-wrapper -->


<!-- ========== COMMON JS FILES ========== -->

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/pace/pace.min.js"></script>
<script src="js/lobipanel/lobipanel.min.js"></script>
<script src="js/iscroll/iscroll.js"></script>

<!-- ========== PAGE JS FILES ========== -->
<script src="js/prism/prism.js"></script>
<script src="js/DataTables/datatables.min.js"></script>


 <script src="https://adminlte.io/themes/v3/plugins/datatables/jquery.dataTables.min.js"></script> 
<script src="https://adminlte.io/themes/v3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>




<!-- ========== THEME JS ========== -->
<script src="js/main.js"></script>

<script>
//   $(function () {
      
      
//     $("#example").DataTable({
//       "responsive": true, "lengthChange": false, "autoWidth": false,
//       "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
//       //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis" { extend: 'colvis', columns: [0, 2, 3, 4], text: 'Select Columns' }]
//     }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
    
//   });

</script>

<script>
/*
  $(function () {
    $("#example").DataTable({
      "responsive": true,
      "lengthChange": true, // Enable length change dropdown
      "autoWidth": false,
      "pageLength": 10, // Default number of records per page
      "lengthMenu": [[10, 20, 30, 100, 500], [10, 20, 30, 100, 500]], // Dropdown options for records per page
      "buttons": [
        "copy",
        "csv",
        "excel",
        "pdf",
        "print",
        {
          extend: 'colvis', // Column visibility button
          columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27], // Allow toggling these columns
          text: 'Select Columns' // Button label
        }
      ],
      "columnDefs": [
        { "targets": [0,1,2,3,4,26,27], "visible": true }, // Show specific columns
        { "targets": "_all", "visible": false } // Hide all other columns
      ]
    }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
  });
  */
</script>


<script>
  $(function () {
    $("#example").DataTable({
      "responsive": true,
      "lengthChange": true, // Enable length change dropdown
      "autoWidth": false,
      "pageLength": 10, // Default display will show 10 rows
      "lengthMenu": [[10, 20, 30, 100, 500], [10, 20, 30, 100, 500]], // Dropdown options
      "buttons": [
        "copy",
        {
          extend: "csv",
          text: "CSV",
          exportOptions: {
            columns: ":visible:not(:last-child)" // Exclude the last column (Action)
          }
        },
        {
          extend: "excel",
          text: "Excel",
          exportOptions: {
            columns: ":visible:not(:last-child)" // Exclude the last column (Action)
          }
        },
        {
          extend: "pdf",
          text: "PDF",
          exportOptions: {
            columns: ":visible:not(:last-child)" // Exclude the last column (Action)
          }
        },
        {
          extend: "print",
          text: "Print",
          exportOptions: {
            columns: ":visible:not(:last-child)" // Exclude the last column (Action)
          }
        },
        {
          extend: 'colvis', // Column visibility button
          columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27], // Allow toggling these columns
          text: 'Select Columns' // Button label
        }
      ],
      "columnDefs": [
        { "targets": [0,1,2,3,4,26,27], "visible": true }, // Show specific columns
        { "targets": -1, "orderable": false, "searchable": false }, // Disable sorting & searching for Action column
        { "targets": "_all", "visible": false } // Hide all other columns by default
      ]
    }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
  });
</script>





</body>
</html>

<?php } ?>

<script>
function payment_status(id){
  $("#c_id").html('Loading...');
  $.ajax({
    url:'payment_status.php',
    type:'post',
    data:{action:'action',id:id},
    success:function(res){
      $("#c_id").html(res);
    }
  });
}

function all_data(id){
  $("#c_data").html('Loading...');
  $.ajax({
    url:'candidate_ajax.php',
    type:'post',
    data:{action:'action',id:id},
    success:function(res){
      $("#c_data").html(res);
    }
  });
}

$(document).ready(function() {
  var table = $('#example').DataTable();
  
  // Delete 
  $('#example tbody').on('click', '.delete', function () {
    var el = this;
    var id = this.id;
    var splitid = id.split("_");

    // Delete id
    var deleteid = splitid[1];
    var action = "Delete candidate";
    console.log(deleteid);

    // AJAX Request
    if(confirm("Are you sure want to delete this?")){
      $.ajax({
        url: 'action.php',
        type: 'POST',
        data: {
          id: deleteid,
          action: action
        },
        success: function(response) {
          if (response == 4) {
            // Remove row from HTML Table
            $(el).closest('tr').css('background', 'tomato');
            $(el).closest('tr').fadeOut(800, function() {
              $(this).remove();
            });
          } else {
            alert('Invalid ID.');
          }
        }
      });
    } else {
      return false;
    }
  });
});
</script>