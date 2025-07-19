<?php
include('includes/config.php');

if(isset($_POST['ids'])) {
    $ids = implode(",", $_POST['ids']); // Convert array to comma-separated string

    $sql = "DELETE FROM tblcandidate WHERE CandidateId IN ($ids)";
    $query = $dbh->prepare($sql);
    if ($query->execute()) {
        echo "success";
    } else {
        echo "error";
    }



        // Include database connection
        include 'includes/account.php'; // This provides the $acc connection

        // Make sure $ids is set
        if (!isset($ids) || empty($ids)) {
            echo "⚠️ No student ID provided for deletion.";
            exit;
        }

        $student_id = $ids;

        // Prepare DELETE query
        $stmt = $acc->prepare("DELETE FROM income WHERE student_id = ?");
        $stmt->bind_param("s", $student_id);

        // Execute
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "✅ Record with student ID $student_id deleted successfully.";
            } else {
                echo "⚠️ No record found with student ID $student_id.";
            }
        } else {
            echo "❌ Delete error: " . $stmt->error;
        }

        // Close
        $stmt->close();
        $acc->close();




} else {
    echo "no_ids";
}



?>
