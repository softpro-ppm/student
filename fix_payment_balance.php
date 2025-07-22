<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    
    // This script fixes payment balance issues after approvals
    
    if(isset($_GET['fix_all'])) {
        try {
            $dbh->beginTransaction();
            
            // Get all candidates who have payments
            $sql = "SELECT DISTINCT candidate_id FROM payment";
            $query = $dbh->prepare($sql);
            $query->execute();
            $candidates = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $fixed_count = 0;
            
            foreach($candidates as $candidate) {
                $candidate_id = $candidate['candidate_id'];
                
                // Calculate total approved payments for this candidate
                $sql_approved = "SELECT SUM(paid) as total_approved FROM emi_list WHERE candidate_id = :candidate_id AND added_type = 1";
                $query_approved = $dbh->prepare($sql_approved);
                $query_approved->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                $query_approved->execute();
                $approved_result = $query_approved->fetch(PDO::FETCH_ASSOC);
                $total_approved = $approved_result['total_approved'] ?? 0;
                
                // Get total fee for this candidate
                $sql_fee = "SELECT total_fee FROM payment WHERE candidate_id = :candidate_id";
                $query_fee = $dbh->prepare($sql_fee);
                $query_fee->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                $query_fee->execute();
                $fee_result = $query_fee->fetch(PDO::FETCH_ASSOC);
                $total_fee = $fee_result['total_fee'] ?? 0;
                
                // Calculate correct balance
                $correct_balance = $total_fee - $total_approved;
                $correct_balance = max(0, $correct_balance); // Don't allow negative balance
                
                // Update payment table with correct values
                $sql_update = "UPDATE payment SET paid = :paid, balance = :balance WHERE candidate_id = :candidate_id";
                $query_update = $dbh->prepare($sql_update);
                $query_update->bindParam(':paid', $total_approved, PDO::PARAM_STR);
                $query_update->bindParam(':balance', $correct_balance, PDO::PARAM_STR);
                $query_update->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                $query_update->execute();
                
                if($query_update->rowCount() > 0) {
                    $fixed_count++;
                }
            }
            
            $dbh->commit();
            $msg = "Successfully fixed payment balances for $fixed_count candidates.";
            
        } catch(Exception $e) {
            $dbh->rollBack();
            $error = "Error fixing balances: " . $e->getMessage();
        }
    }
    
    // Debug information
    if(isset($_GET['debug'])) {
        $candidate_id = $_GET['candidate_id'] ?? 0;
        
        if($candidate_id > 0) {
            echo "<h3>Debug Info for Candidate ID: $candidate_id</h3>";
            
            // Current payment record
            $sql_payment = "SELECT * FROM payment WHERE candidate_id = :candidate_id";
            $query_payment = $dbh->prepare($sql_payment);
            $query_payment->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $query_payment->execute();
            $payment = $query_payment->fetch(PDO::FETCH_ASSOC);
            
            echo "<h4>Current Payment Record:</h4>";
            echo "<pre>" . print_r($payment, true) . "</pre>";
            
            // All EMI records
            $sql_emi = "SELECT * FROM emi_list WHERE candidate_id = :candidate_id ORDER BY created DESC";
            $query_emi = $dbh->prepare($sql_emi);
            $query_emi->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $query_emi->execute();
            $emi_records = $query_emi->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<h4>EMI Records:</h4>";
            echo "<pre>" . print_r($emi_records, true) . "</pre>";
            
            // Calculate totals
            $total_approved = 0;
            $total_pending = 0;
            
            foreach($emi_records as $emi) {
                if($emi['added_type'] == 1) {
                    $total_approved += $emi['paid'];
                } else {
                    $total_pending += $emi['paid'];
                }
            }
            
            echo "<h4>Calculated Totals:</h4>";
            echo "Total Fee: " . ($payment['total_fee'] ?? 0) . "<br>";
            echo "Total Approved Payments: $total_approved<br>";
            echo "Total Pending Payments: $total_pending<br>";
            echo "Current Balance in DB: " . ($payment['balance'] ?? 0) . "<br>";
            echo "Calculated Balance: " . (($payment['total_fee'] ?? 0) - $total_approved) . "<br>";
            
            exit;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fix Payment Balance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Payment Balance Fix Utility</h2>
        
        <?php if(isset($msg)) { ?>
            <div class="alert alert-success"><?php echo $msg; ?></div>
        <?php } ?>
        
        <?php if(isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fix All Payment Balances</h5>
                        <p class="card-text">This will recalculate and fix payment balances for all candidates based on their approved payments.</p>
                        <a href="?fix_all=1" class="btn btn-warning" onclick="return confirm('Are you sure you want to fix all payment balances?')">Fix All Balances</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Debug Candidate Payment</h5>
                        <p class="card-text">Enter a candidate ID to see detailed payment information.</p>
                        <form method="get">
                            <div class="input-group">
                                <input type="number" name="candidate_id" class="form-control" placeholder="Candidate ID" required>
                                <input type="hidden" name="debug" value="1">
                                <button class="btn btn-info" type="submit">Debug</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="manage-candidate.php" class="btn btn-secondary">Back to Candidates</a>
            <a href="pending_payment_approval.php" class="btn btn-primary">Pending Approvals</a>
        </div>
    </div>
</body>
</html>

<?php } ?>
