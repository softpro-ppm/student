<div class="sidebar" style="background-color: #1e2124 !important;">
    <div class="sidebar-header text-center py-4">
        <img src="images/softpro-logo.png" alt="SoftPro" class="rounded-circle mb-2" style="width: 80px;">
        <h5 class="text-white mb-0">admin</h5>
        <p class="text-white-50 small">Softpro Admin</p>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'account.php') ? 'active' : ''; ?>" href="account.php">
                <i class="fas fa-user-circle me-2"></i> Account
            </a>
        </li>
        <!-- Add all other menu items following the same pattern -->
    </ul>
</div>

<style>
.sidebar {
    background-color: #1e2124 !important;
    min-height: 100vh;
    width: 250px;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 100;
}

.sidebar .nav-link {
    color: #adb5bd;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active {
    color: #fff;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 0.25rem;
}

.main-content {
    margin-left: 250px;
}

/* Ensure consistent icons */
.sidebar .nav-link i {
    width: 20px;
    text-align: center;
    margin-right: 8px;
}
</style> 