<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
?>
    <!-- Include Header -->
    <?php include('includes/header.php'); ?>

    <!-- Include Topbar -->
    <?php include('includes/topbar-new.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Include Sidebar -->
            <?php include('includes/sidebar-standard.php'); ?>

            <!-- Main Content -->
            <main class="col-lg-10 col-md-9 ms-sm-auto px-md-4 py-4">
                <h1 class="h2 mb-4">Trained Candidate</h1>

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Candidate</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Trained Candidate</li>
                    </ol>
                </nav>

                <!-- Your existing page content here -->
                <div class="card">
                    <div class="card-body">
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
                                                <?php $sql = "SELECT tblcandidate.*,tblbatch.* FROM  tblcandidate JOIN tblbatch ON tblcandidate.tblbatch_id = tblbatch.id AND end_date < CURRENT_DATE()";
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include('includes/footer.php'); ?>
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
        var action = "Delete candidate";
        if(confirm("Are you sure want to delete this?")){
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
}else{
    return false;
}

    });

});
</script>