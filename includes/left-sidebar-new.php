<?php
// Get current file name without query string
$currentPage = basename($_SERVER['PHP_SELF']);

// Helper function to check if a menu item should be active
function isActive($pages) {
    global $currentPage;
    return in_array($currentPage, $pages) ? 'active' : '';
}

// Helper function to check if a submenu should be shown
function isSubmenuShown($pages) {
    global $currentPage;
    return in_array($currentPage, $pages) ? 'show' : '';
}
?>

<nav class="col-lg-2 col-md-3 d-none d-md-block sidebar p-0 sidebar-nav sidebarnew">
    <div class="sidebar-header">
        <img src="images/logo.jpg" alt="Profile" class="rounded-circle mb-2" width="80">
        <h6><?=$_SESSION['alogin']?></h6>
        <small>Softpro <?= ($_SESSION['user_type'] == 1) ? 'Admin' : (($_SESSION['user_type'] == 2) ? 'MIS' : 'Training') ?></small>
    </div>
    <div class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?=isActive(['dashboard.php'])?>" href="dashboard.php">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php if($_SESSION['user_type'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link <?=isActive(['account.php'])?>" href="account.php">
                    <i class="fas fa-server me-2"></i>
                    <span>Account</span>
                </a>
            </li>
            <?php } ?>
            
            <li class="nav-item">
                <a class="nav-link <?=isActive(['edit-candidate.php', 'add-candidate.php', 'candidate-bulk-upload.php', 'manage-candidate.php'])?>" 
                   data-bs-toggle="collapse" 
                   href="#candidateSubmenu">
                    <i class="fas fa-users me-2"></i>
                    <span>Candidate</span>
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse <?=isSubmenuShown(['edit-candidate.php', 'add-candidate.php', 'candidate-bulk-upload.php', 'manage-candidate.php'])?>" 
                     id="candidateSubmenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['add-candidate.php'])?>" href="add-candidate.php">
                                <i class="fas fa-user-plus me-2"></i>
                                <span>Register Candidate</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['candidate-bulk-upload.php'])?>" href="candidate-bulk-upload.php">
                                <i class="fas fa-upload me-2"></i>
                                <span>Bulk Upload</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['manage-candidate.php'])?>" href="manage-candidate.php">
                                <i class="fas fa-tasks me-2"></i>
                                <span>Manage Candidates</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <?php if($_SESSION['user_type'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link <?=isActive(['create-trainingcenter.php', 'manage-trainingcenter.php', 'edit-trainingcenter.php'])?>"
                       data-bs-toggle="collapse" 
                       href="#trainingCenterSubmenu">
                        <i class="fas fa-building me-2"></i>
                        <span>Training Center</span>
                        <i class="fas fa-chevron-down float-end"></i>
                    </a>
                    <div class="collapse <?=isSubmenuShown(['create-trainingcenter.php', 'manage-trainingcenter.php', 'edit-trainingcenter.php'])?>"
                         id="trainingCenterSubmenu">
                        <ul class="nav flex-column ps-3">
                            <li class="nav-item">
                                <a class="nav-link <?=isActive(['create-trainingcenter.php'])?>" href="create-trainingcenter.php">
                                    <i class="fas fa-plus me-2"></i>
                                    <span>Create Center</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=isActive(['manage-trainingcenter.php'])?>" href="manage-trainingcenter.php">
                                    <i class="fas fa-cogs me-2"></i>
                                    <span>Manage Centers</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php } ?>

            <?php if($_SESSION['user_type']==1){ ?>
            <!-- Scheme Sub-menu -->
            <li class="nav-item">
                <a class="nav-link <?=isActive(['asign-scheme.php', 'manage-scheme.php', 'create-scheme.php', 'edit-scheme.php'])?>"
                   data-bs-toggle="collapse" 
                   href="#schemeSubmenu">
                    <i class="fas fa-project-diagram me-2"></i>
                    <span>Scheme</span>
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse <?=isSubmenuShown(['asign-scheme.php', 'manage-scheme.php', 'create-scheme.php', 'edit-scheme.php'])?>"
                     id="schemeSubmenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['create-scheme.php'])?>" href="create-scheme.php">
                                <i class="fas fa-plus me-2"></i>
                                <span>Create Scheme</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['manage-scheme.php'])?>" href="manage-scheme.php">
                                <i class="fas fa-cogs me-2"></i>
                                <span>Manage Schemes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['asign-scheme.php'])?>" href="asign-scheme.php">
                                <i class="fas fa-handshake me-2"></i>
                                <span>Assign Scheme</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Sector Sub-menu -->
            <li class="nav-item">
                <a class="nav-link <?=isActive(['assign-sector.php', 'manage-sector.php', 'create-sector.php', 'edit-sector.php'])?>"
                   data-bs-toggle="collapse" 
                   href="#sectorSubmenu">
                    <i class="fas fa-industry me-2"></i>
                    <span>Sector</span>
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse <?=isSubmenuShown(['assign-sector.php', 'manage-sector.php', 'create-sector.php', 'edit-sector.php'])?>"
                     id="sectorSubmenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['create-sector.php'])?>" href="create-sector.php">
                                <i class="fas fa-plus me-2"></i>
                                <span>Create Sector</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['manage-sector.php'])?>" href="manage-sector.php">
                                <i class="fas fa-cogs me-2"></i>
                                <span>Manage Sectors</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['assign-sector.php'])?>" href="assign-sector.php">
                                <i class="fas fa-check-circle me-2"></i>
                                <span>Assign Sector</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Job Roll Sub-menu -->
            <li class="nav-item">
                <a class="nav-link <?=isActive(['assign-jobroll.php', 'manage-jobroll.php', 'create-jobroll.php', 'edit-jobroll.php'])?>"
                   data-bs-toggle="collapse" 
                   href="#jobRollSubmenu">
                    <i class="fas fa-briefcase me-2"></i>
                    <span>Job Roll</span>
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse <?=isSubmenuShown(['assign-jobroll.php', 'manage-jobroll.php', 'create-jobroll.php', 'edit-jobroll.php'])?>"
                     id="jobRollSubmenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['create-jobroll.php'])?>" href="create-jobroll.php">
                                <i class="fas fa-plus me-2"></i>
                                <span>Create Job Roll</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['manage-jobroll.php'])?>" href="manage-jobroll.php">
                                <i class="fas fa-cogs me-2"></i>
                                <span>Manage Job Rolls</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['assign-jobroll.php'])?>" href="assign-jobroll.php">
                                <i class="fas fa-check-circle me-2"></i>
                                <span>Assign Job Roll</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php } ?>  

            <!-- Batch Sub-menu -->
            <li class="nav-item">
                <a class="nav-link <?=isActive(['add-candidate-to-batch.php', 'manage-batch.php', 'add-batch.php', 'edit-batch.php', 'add-candidate-to-particular-batch.php'])?>"
                   data-bs-toggle="collapse" 
                   href="#batchSubmenu">
                    <i class="fas fa-layer-group me-2"></i>
                    <span>Batch</span>
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse <?=isSubmenuShown(['add-candidate-to-batch.php', 'manage-batch.php', 'add-batch.php', 'edit-batch.php', 'add-candidate-to-particular-batch.php'])?>"
                     id="batchSubmenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['add-batch.php'])?>" href="add-batch.php">
                                <i class="fas fa-plus me-2"></i>
                                <span>Add Batch</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['manage-batch.php'])?>" href="manage-batch.php">
                                <i class="fas fa-cogs me-2"></i>
                                <span>Manage Batches</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['add-candidate-to-batch.php'])?>" href="add-candidate-to-batch.php">
                                <i class="fas fa-user-plus me-2"></i>
                                <span>Add to Batch</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Result Sub-menu -->
            <li class="nav-item">
                <a class="nav-link <?=isActive(['manage-results.php', 'add-result.php'])?>"
                   data-bs-toggle="collapse" 
                   href="#resultSubmenu">
                    <i class="fas fa-chart-bar me-2"></i>
                    <span>Results</span>
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse <?=isSubmenuShown(['manage-results.php', 'add-result.php'])?>"
                     id="resultSubmenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['add-result.php'])?>" href="add-result.php">
                                <i class="fas fa-plus me-2"></i>
                                <span>Add Result</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['manage-results.php'])?>" href="manage-results.php">
                                <i class="fas fa-cogs me-2"></i>
                                <span>Manage Results</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Placement Sub-menu -->
            <li class="nav-item">
                <a class="nav-link <?=isActive(['manage-placement.php'])?>" href="manage-placement.php">
                    <i class="fas fa-handshake me-2"></i>
                    <span>Placement</span>
                </a>
            </li>

            <!-- Certification Sub-menu -->
            <li class="nav-item">
                <a class="nav-link <?=isActive(['manage-certification.php', 'add-certification.php', 'add-certification-document.php'])?>"
                   data-bs-toggle="collapse" 
                   href="#certificationSubmenu">
                    <i class="fas fa-certificate me-2"></i>
                    <span>Certification</span>
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse <?=isSubmenuShown(['manage-certification.php', 'add-certification.php', 'add-certification-document.php'])?>"
                     id="certificationSubmenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['add-certification.php'])?>" href="add-certification.php">
                                <i class="fas fa-plus me-2"></i>
                                <span>Add Certificate</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['manage-certification.php'])?>" href="manage-certification.php">
                                <i class="fas fa-cogs me-2"></i>
                                <span>Manage Certificates</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Invoice Sub-menu -->
            <li class="nav-item">
                <a class="nav-link <?=isActive(['manage-invoice.php', 'add-invoice.php', 'edit-invoice.php'])?>"
                   data-bs-toggle="collapse" 
                   href="#invoiceSubmenu">
                    <i class="fas fa-file-invoice me-2"></i>
                    <span>Invoice</span>
                    <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse <?=isSubmenuShown(['manage-invoice.php', 'add-invoice.php', 'edit-invoice.php'])?>"
                     id="invoiceSubmenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['add-invoice.php'])?>" href="add-invoice.php">
                                <i class="fas fa-plus me-2"></i>
                                <span>Add Invoice</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=isActive(['manage-invoice.php'])?>" href="manage-invoice.php">
                                <i class="fas fa-cogs me-2"></i>
                                <span>Manage Invoices</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <?php if($_SESSION['user_type']==1){ ?>
                <!-- Admin Control Sub-menu -->
                <li class="nav-item">
                    <a class="nav-link <?php if ($currentPage == 'manage-user.php' OR $currentPage == 'create-user.php' OR $currentPage == 'edit-user.php') echo 'active mt-1 mb-1'; ?>" data-bs-toggle="collapse" href="#adminSubmenu" role="button" aria-expanded="false" aria-controls="adminSubmenu">
                        <i class="fa fa-lock me-2"></i>Admin Control <i class="fa-solid fa-chevron-down float-end"></i>
                    </a>
                    <div class="collapse <?php if ($currentPage == 'manage-user.php' OR $currentPage == 'create-user.php' OR $currentPage == 'edit-user.php') echo 'show'; ?>" id="adminSubmenu">
                        <ul class="nav flex-column ps-3">
                            <li class="nav-item">
                                <a class="nav-link <?php if ($currentPage == 'create-user.php') echo 'active mt-1 mb-1'; ?>" href="create-user.php"><i class="fa fa-user-plus me-2"></i>Create User</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($currentPage == 'manage-user.php') echo 'active mt-1 mb-1'; ?>" href="manage-user.php"><i class="fa fa-cogs me-2"></i>Manage User</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>