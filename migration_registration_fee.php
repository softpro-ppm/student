<?php
/*
 * MIGRATION SCRIPT: Add Registration Fee for Existing Candidates
 * 
 * This script should be run once to add registration fee payments 
 * for all existing candidates who don't have one.
 * 
 * WARNING: Only run this script once!
 */

session_start();
error_reporting(0);
include('includes/config.php');

// Check if user is admin
if (strlen($_SESSION['alogin']) == "" || $_SESSION['user_type'] != 1) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['run_migration'])) {
    try {
        $dbh->beginTransaction();
        
        // Get all candidates who don't have registration fee payment
        $sql = "SELECT DISTINCT c.CandidateId, c.enrollmentid, c.candidatename 
                FROM tblcandidate c 
                LEFT JOIN emi_list e ON c.CandidateId = e.candidate_id AND e.payment_mode = 'Registration Fee'
                WHERE e.id IS NULL";
        
        $query = $dbh->prepare($sql);
        $query->execute();
        $candidates = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $updated_count = 0;
        $registration_fee = 100;
        $created_date = date('Y-m-d');
        
        foreach ($candidates as $candidate) {
            // Insert registration fee payment
            $insertSql = "INSERT INTO emi_list (candidate_id, paid, created, added_type, payment_mode) 
                         VALUES (:candidate_id, :paid, :created, :added_type, :payment_mode)";
            $insertQuery = $dbh->prepare($insertSql);
            $insertQuery->bindParam(':candidate_id', $candidate['CandidateId'], PDO::PARAM_INT);
            $insertQuery->bindParam(':paid', $registration_fee, PDO::PARAM_STR);
            $insertQuery->bindParam(':created', $created_date, PDO::PARAM_STR);
            $insertQuery->bindValue(':added_type', '1', PDO::PARAM_STR); // Auto-approved
            $insertQuery->bindValue(':payment_mode', 'Registration Fee', PDO::PARAM_STR);
            $insertQuery->execute();
            
            // Update payment table if exists
            $checkPaymentSql = "SELECT candidate_id FROM payment WHERE candidate_id = :candidate_id";
            $checkPaymentQuery = $dbh->prepare($checkPaymentSql);
            $checkPaymentQuery->bindParam(':candidate_id', $candidate['CandidateId'], PDO::PARAM_INT);
            $checkPaymentQuery->execute();
            
            if ($checkPaymentQuery->rowCount() > 0) {
                // Update existing payment record to include registration fee
                $updatePaymentSql = "UPDATE payment 
                                    SET paid = paid + :reg_fee, 
                                        balance = balance - :reg_fee,
                                        total_fee = total_fee + :reg_fee 
                                    WHERE candidate_id = :candidate_id";
                $updatePaymentQuery = $dbh->prepare($updatePaymentSql);
                $updatePaymentQuery->bindParam(':reg_fee', $registration_fee, PDO::PARAM_STR);
                $updatePaymentQuery->bindParam(':candidate_id', $candidate['CandidateId'], PDO::PARAM_INT);
                $updatePaymentQuery->execute();
            }
            
            $updated_count++;
        }
        
        $dbh->commit();
        $success_msg = "Successfully updated $updated_count candidates with registration fee.";
        
    } catch (Exception $e) {
        $dbh->rollBack();
        $error_msg = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Fee Migration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">⚠️ Registration Fee Migration</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success_msg)): ?>
                        <div class="alert alert-success">
                            <strong>Success!</strong> <?php echo $success_msg; ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (isset($error_msg)): ?>
                        <div class="alert alert-danger">
                            <strong>Error!</strong> <?php echo $error_msg; ?>
                        </div>
                        <?php endif; ?>
                        
                        <p><strong>This migration script will:</strong></p>
                        <ul>
                            <li>Add ₹100 registration fee payment for all existing candidates</li>
                            <li>Update payment records to include registration fee in total calculations</li>
                            <li>Mark registration fee payments as auto-approved</li>
                        </ul>
                        
                        <div class="alert alert-warning">
                            <strong>⚠️ Warning:</strong> This should only be run once! Running it multiple times will duplicate registration fee payments.
                        </div>
                        
                        <?php if (!isset($success_msg)): ?>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to run this migration? This cannot be undone!')">
                            <button type="submit" name="run_migration" class="btn btn-warning btn-lg">
                                🚀 Run Migration
                            </button>
                        </form>
                        <?php else: ?>
                        <a href="manage-candidate.php" class="btn btn-success">
                            ✅ Back to Candidates
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
