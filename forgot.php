<?php
session_start();
error_reporting(0);
include('includes/config.php');
if ($_SESSION['alogin'] != '') {
    $_SESSION['alogin'] = '';
    $_SESSION['user_type'] ='';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];


    // Check if the email exists in the database
    $stmt = $dbh->prepare("SELECT id FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    print_r($_POST); die;

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50)); // Generate a secure token
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token expires in 1 hour

        // Store token in the database
        $stmt = $dbh->prepare("INSERT INTO reset_tokens (user_id, token, expires_at) VALUES (?, ?, ?) 
                               ON DUPLICATE KEY UPDATE token=?, expires_at=?");
        $stmt->bind_param("issss", $user['id'], $token, $expiry, $token, $expiry);
        $stmt->execute();

        // Send email
        $reset_link = "https://yourwebsite.com/reset_password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n\n" . $reset_link;
        $headers = "From: no-reply@softpromis.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "<script>alert('A password reset link has been sent to your email.');</script>";
        } else {
            echo "<script>alert('Failed to send email.');</script>";
        }
    } else {
        echo "<script>alert('This email is is not found. try  other');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Sofpro MIS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: url('/images/login1.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 5px 25px rgba(0, 0, 0, 0.3);
            width: 350px;
            text-align: center;
        }
        .login-container h4 {
            color: #333;
            margin-bottom: 25px;
        }
        .form-control {
            border-radius: 25px;
        }
        .btn-login {
            width: 100%;
            background: #007bff;
            color: white;
            border-radius: 25px;
            padding: 10px;
            font-size: 16px;
        }
        .btn-login:hover {
            background: #0056b3;
        }
        .footer-text {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h4><i class="fas fa-user-lock"></i> Forgot Password</h4>
        <form method="post">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
            </div>
            <button type="submit" name="forgot" class="btn btn-login">Sign In</button>
        </form>
        <p class="footer-text">&copy; 2025 Sofpro MIS. All Rights Reserved.</p>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



    <!-- /.main-wrapper -->

    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script>
    $(function() {

    });
    </script>

    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>

</html>