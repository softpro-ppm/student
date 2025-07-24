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
                                            <table id="example"
                                                class="table table-stripped table-bordered table-hover table-full-width table-grey table-responsive-lg">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Enrollment ID</th>
                                                        <th>Candidate Name</th>
                                                        <th>Phone Number</th>
                                                        <th>Job Roll</th>
                                                        <th>Action</th>                                </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Enrollment ID</th>
                                                        <th>Candidate Name</th>
                                                        <th>Phone Number</th>
                                                        <th>Job Roll</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php $sql = "SELECT * from tblcandidate";
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
                                                    

                                                        <td>
                                                            <a class="badge badge-primary"
                                                                href="edit-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>"><i
                                                                    class="fa fa-edit" title="Edit Record"></i> </a>
                                                        
                                                            <a class="badge badge-danger delete"
                                                                id='del_<?php echo htmlentities($result->CandidateId); ?>'><i
                                                                    class="txt txt-danger fa fa-trash"
                                                                    title="delete Record"></i> </a>

                                                                    <button type="button" class="btn btn-info btn-xs" onClick='payment_status(<?php echo htmlentities($result->CandidateId); ?>)' data-toggle="modal" data-target="#myModal"><i
                                                                    class="txt txt-danger fa fa-inr"
                                                                    title="delete Record"></i></button>

                                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal_<?php echo htmlentities($result->CandidateId); ?>">
                                                                <i class="fa fa-picture-o" aria-hidden="true"></i>
                                                            </button>

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
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="js/DataTables/datatables.min.js"></script>

    <!-- <script src="https://adminlte.io/themes/v3/plugins/datatables/jquery.dataTables.min.js"></script> -->
    <script src="https://adminlte.io/themes/v3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script>
    // $(function($) {
    //     $('#example').DataTable();

    //     $('#example2').DataTable({
    //         "scrollY": "300px",
    //         "scrollCollapse": true,
    //         "paging": false
    //     });

    //     $('#example3').DataTable();
    // });
    </script>

    <script>
      $(function () {
        $("#example").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
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
$('#example tbody').on( 'click', '.delete', function () {
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
        }else{
            return false;
        }

    });

});

</script>