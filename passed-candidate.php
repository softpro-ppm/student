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
                                <h2 class="title">Passed Candidate</h2>

                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Candidate</li>
                                    <li class="active">Passed Candidate</li>
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

                                                        <th>candidate</th>
                                                        <th>aadhaar</th>
                                                        <th>qualification</th>
                                                        <th>aplication</th>

                                                        <th>Date Created</th>
                                                        <th>Date Modified</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
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
                                                        <th>Result</th>


                                                        <th>candidate</th>
                                                        <th>aadhaar</th>
                                                        <th>qualification</th>
                                                        <th>aplication</th>
                                                        <th>Date Created</th>
                                                        <th>Date Modified</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php $sql = "SELECT tblcandidate.*, tblcandidateresults.* from tblcandidate JOIN tblcandidateresults ON tblcandidate.CandidateId = tblcandidateresults.candidate_id AND result='Pass'";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($result->candidatename); ?></td>
                                                        <td><?php echo htmlentities($result->fathername); ?></td>
                                                        <td><?php echo htmlentities($result->aadharnumber); ?></td>
                                                        <td><?php echo htmlentities($result->phonenumber); ?></td>
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
                                                        <td><?php echo htmlentities($result->result); ?></td>


                                                        <td><a target="_blank"
                                                                href="doc/<?php echo htmlentities($result->candidatephoto); ?>"><img
                                                                    style="width: 76px;height: 44px;"
                                                                    src="doc/<?php echo htmlentities($result->candidatephoto); ?>"></a>
                                                        </td>
                                                        <td><a target="_blank"
                                                                href="doc/<?php echo htmlentities($result->aadhaarphoto); ?>"><img
                                                                    style="width: 76px;height: 44px;"
                                                                    src="doc/<?php echo htmlentities($result->aadhaarphoto); ?>"></a>
                                                        </td>
                                                        <td><a target="_blank"
                                                                href="doc/<?php echo htmlentities($result->qualificationphoto); ?>"><img
                                                                    style="width: 76px;height: 44px;"
                                                                    src="doc/<?php echo htmlentities($result->qualificationphoto); ?>"></a>
                                                        </td>
                                                        <td><a target="_blank"
                                                                href="doc/<?php echo htmlentities($result->applicationphoto); ?>"><img
                                                                    style="width: 76px;height: 44px;"
                                                                    src="doc/<?php echo htmlentities($result->applicationphoto); ?>"></a>
                                                        </td>

                                                        <td><?php echo htmlentities($result->DateCreated); ?></td>
                                                        <td><?php echo htmlentities($result->DateModified); ?></td>
                                                        <td>
                                                            <a class="badge badge-primary"
                                                                href="edit-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>"><i
                                                                    class="fa fa-edit" title="Edit Record"></i> </a>
                                                            <a class="badge badge-danger delete"
                                                                id='del_<?php echo htmlentities($result->CandidateId); ?>'><i
                                                                    class="txt txt-danger fa fa-trash"
                                                                    title="delete Record"></i> </a>

                                                        </td>
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

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script>
    $(function($) {
        $('#example').DataTable();

        $('#example2').DataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false
        });

        $('#example3').DataTable();
    });
    </script>
</body>

</html>
<?php } ?>

<script>
$(document).ready(function() {

    // Delete 
    $('.delete').click(function() {
        var el = this;
        var id = this.id;
        var splitid = id.split("_");

        // Delete id
        var deleteid = splitid[1];
        var action = "Delete candidate"

        // AJAX Request
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

    });

});
</script>