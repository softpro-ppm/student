<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['update'])) {
        $username = $_POST['username'];
        $userid = $_POST['userid'];
        $password = md5($_POST['password']);
        $user_type = $_POST['user_type'];
        $email = $_POST['email'];

        if($_POST['password'] != '') {
            $sql = "UPDATE admin SET UserName=:username, email=:email, Password=:password, user_type=:user_type WHERE id=:userid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':user_type', $user_type, PDO::PARAM_STR);
            $query->bindParam(':userid', $userid, PDO::PARAM_STR);
        } else {
            $sql = "UPDATE admin SET UserName=:username, email=:email, user_type=:user_type WHERE id=:userid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':user_type', $user_type, PDO::PARAM_STR);
            $query->bindParam(':userid', $userid, PDO::PARAM_STR);
        }
        
        $query->execute();
        $msg = "User data has been updated successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/mystyle.css"> 
    <script src="js/modernizr/modernizr.min.js"></script>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">
    
    <style>
        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .error {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
            display: none;
        }
    </style>
</head>

<body class="bg-light">
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <?php include('includes/topbar-new.php'); ?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <?php include('includes/left-sidebar-new.php'); ?>
                <?php include('includes/leftbar.php'); ?>

                <!-- Main Content -->
                <main class="col-md-9 col-lg-10 px-md-4">
                    <!-- Page Title -->
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2">Update User Details</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Admin Control</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update User</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } else if ($error) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- Update User Form -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Edit User Information</h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="post" id="myForm">
                                <?php
                                $sid = intval($_GET['userid']);
                                $sql = "SELECT * FROM admin WHERE id=:sid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                        <input type="hidden" name="userid" value="<?php echo $sid; ?>">

                                        <div class="mb-3">
                                            <label for="user_type" class="form-label">User Type</label>
                                            <select name="user_type" class="form-select" id="user_type" required>
                                                <option value="">Select User Type</option>
                                                <option value="1" <?php echo $result->user_type == 1 ? 'selected' : ''; ?>>Admin</option>
                                                <option value="2" <?php echo $result->user_type == 2 ? 'selected' : ''; ?>>MIS</option>
                                                <option value="3" <?php echo $result->user_type == 3 ? 'selected' : ''; ?>>Training Center</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="email" 
                                                   value="<?php echo htmlentities($result->email); ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" id="username" 
                                                   value="<?php echo htmlentities($result->UserName); ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password (Leave blank to keep current)</label>
                                            <div class="input-group">
                                                <input type="password" name="password" class="form-control password" id="password">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="error" id="passwordError">Password must be at least 8 characters and include uppercase, lowercase, number, and special character.</div>
                                        </div>
                                <?php }
                                } ?>

                                <div class="d-grid gap-2">
                                    <button type="submit" name="update" class="btn btn-primary">
                                        <i class="fas fa-check me-2"></i>Update User
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="js/jquery/jquery-2.2.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="js/bootstrap/bootstrap.min.js"></script>
  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
  <script src="js/select2/select2.min.js"></script>
  <script src="js/main.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('myForm');
        const passwordInput = document.querySelector('.password');
        const passwordError = document.getElementById('passwordError');
        const togglePassword = document.getElementById('togglePassword');

        form.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            if (password !== '') {
                const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                if (!passwordPattern.test(password)) {
                    e.preventDefault();
                    passwordError.style.display = 'block';
                } else {
                    passwordError.style.display = 'none';
                }
            }
        });

        // Toggle password visibility
        togglePassword.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    </script>
</body>
</html>
<?php } ?>