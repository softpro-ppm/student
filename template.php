<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
?>
    <?php include('includes/header.php'); ?>
    <?php include('includes/topbar-new.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <?php include('includes/sidebar-standard.php'); ?>

            <main class="col-lg-10 col-md-9 ms-sm-auto px-md-4 py-4">
                <!-- Page title -->
                <h1 class="h2 mb-4">Your Page Title</h1>

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Current Page</li>
                    </ol>
                </nav>

                <!-- Your page content here -->
                <div class="card">
                    <div class="card-body">
                        <!-- Your existing content -->
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
<?php } ?> 