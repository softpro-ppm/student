<?php
// Quick test script to check payment balance calculation
// Usage: test_payment_balance.php?candidate_id=1767

session_start();
include('includes/config.php');

if(isset($_GET['candidate_id'])) {
    $candidate_id = $_GET['candidate_id'];
    
    echo "<h3>Payment Balance Test for Candidate ID: $candidate_id</h3>";
    
    // Get candidate info
    $sql = "SELECT * FROM tblcandidate WHERE CandidateId = :candidate_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
    $query->execute();
    $candidate = $query->fetch(PDO::FETCH_ASSOC);
    
    if($candidate) {
        echo "<p><strong>Candidate:</strong> {$candidate['candidatename']}</p>";
        echo "<p><strong>Job Roll ID:</strong> {$candidate['job_roll']}</p>";
        
        // Get job roll payment
        $sql = "SELECT payment FROM tbljobroll WHERE JobrollId = :jobid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':jobid', $candidate['job_roll'], PDO::PARAM_INT);
        $query->execute();
        $jobroll = $query->fetch(PDO::FETCH_ASSOC);
        
        $payment_val = $jobroll['payment'] ?? 100;
        echo "<p><strong>Job Roll Fee:</strong> ₹{$payment_val}</p>";
        
        // Get payment record
        $sql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
        $query->execute();
        $payment = $query->fetch(PDO::FETCH_ASSOC);
        
        if($payment) {
            echo "<p><strong>Payment Record Found:</strong></p>";
            echo "<ul>";
            echo "<li>Total Fee: ₹{$payment['total_fee']}</li>";
            echo "<li>Paid: ₹{$payment['paid']}</li>";
            echo "<li>Stored Balance: ₹{$payment['balance']}</li>";
            echo "<li>Calculated Balance: ₹" . ($payment['total_fee'] - $payment['paid']) . "</li>";
            echo "</ul>";
            
            if($payment['balance'] != ($payment['total_fee'] - $payment['paid'])) {
                echo "<p style='color:red;'><strong>⚠️ Balance Mismatch Detected!</strong></p>";
                echo "<p><a href='fix_payment_balance.php?candidate_id=$candidate_id'>Click here to fix</a></p>";
            } else {
                echo "<p style='color:green;'><strong>✅ Balance is correct!</strong></p>";
            }
        } else {
            echo "<p><strong>No Payment Record Found</strong> - This would create a new one with:</p>";
            echo "<ul>";
            echo "<li>Total Fee: ₹{$payment_val}</li>";
            echo "<li>Paid: ₹0</li>";
            echo "<li>Balance: ₹{$payment_val}</li>";
            echo "</ul>";
        }
        
        // Get EMI payments
        $sql = "SELECT * FROM emi_list WHERE candidate_id = :candidate_id ORDER BY created DESC";
        $query = $dbh->prepare($sql);
        $query->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
        $query->execute();
        $emi_payments = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if($emi_payments) {
            echo "<h4>EMI Payment History:</h4>";
            echo "<table border='1' style='border-collapse:collapse;'>";
            echo "<tr><th>Date</th><th>Amount</th><th>Status</th><th>Mode</th></tr>";
            foreach($emi_payments as $emi) {
                $status = ($emi['added_type'] == 1) ? 'Approved' : 'Pending';
                echo "<tr>";
                echo "<td>{$emi['created']}</td>";
                echo "<td>₹{$emi['paid']}</td>";
                echo "<td>$status</td>";
                echo "<td>{$emi['payment_mode']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "<p><strong>Candidate not found!</strong></p>";
    }
} else {
    echo "<p>Please provide a candidate_id parameter</p>";
    echo "<p>Example: test_payment_balance.php?candidate_id=1767</p>";
}
?>
