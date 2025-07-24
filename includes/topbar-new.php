<?php
$pending_payments = 0;
if (isset($dbh)) {
    $sql = "SELECT COUNT(*) AS count FROM emi_list WHERE added_type = 2";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $pending_payments = $result['count'];
}
?>
<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid px-4">
        <!-- Sidebar Toggle (Mobile) -->
        <button type="button" class="btn btn-link d-lg-none me-2 mobile-nav-toggle sidebar-nav-old">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
            <img src="images/logo.jpg" alt="Softpro" class="me-2" style="height: 32px; width: auto;">
            <span class="d-none d-sm-inline">SOFTPRO <?= ($_SESSION['user_type'] == 1) ? 'Admin' : (($_SESSION['user_type'] == 2) ? 'MIS' : 'Training') ?></span>
        </a>

        <!-- Mobile Menu Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <i class="fas fa-ellipsis-v"></i>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Search -->
                <li class="nav-item me-3 d-none d-md-block">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="search" class="form-control border-0 bg-light" placeholder="Search..." style="min-width: 200px">
                            <button class="btn btn-light border-0" type="submit">
                                <i class="fas fa-search text-muted"></i>
                            </button>
                        </div>
                    </form>
                </li>

                <!-- Pending Approvals -->
                <?php if ($pending_payments > 0): ?>
                <li class="nav-item me-3">
                    <a class="nav-link d-flex align-items-center" href="pending_payment_approval.php">
                        <span class="position-relative">
                            <i class="fas fa-credit-card me-1"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?=$pending_payments?>
                            </span>
                        </span>
                        <span class="d-none d-sm-inline ms-1">Pending Approvals</span>
                    </a>
                </li>
                <?php endif; ?>

                <!-- User Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <img src="images/user-avatar.png" alt="User" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                        <span class="d-none d-sm-inline"><?=$_SESSION['alogin']?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>