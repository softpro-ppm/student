<?php
// Include your database configuration/connection file
include('includes/config.php');

header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors in output, but log them

// Check if this is a bulk approval request
if(isset($_POST['bulk_approve']) && $_POST['bulk_approve'] == true) {
    if(!isset($_POST['items']) || empty($_POST['items'])) {
        echo json_encode(['status' => 'error', 'message' => 'No items provided for bulk approval.']);
        exit;
    }

    $items = $_POST['items'];
    $approved_count = 0;
    $failed_count = 0;
    $errors = [];

    try {
        // Begin transaction
        $dbh->beginTransaction();

        foreach($items as $item) {
            $candidate_id = isset($item['candidate_id']) ? $item['candidate_id'] : null;
            $id = isset($item['id']) ? $item['id'] : null;

            if(!$candidate_id || !$id) {
                $failed_count++;
                $errors[] = "Missing candidate_id or id in item";
                continue;
            }

            try {
                // Check if record exists in emi_list
                $sql_check = "SELECT * from emi_list where added_type = 2 and candidate_id = :candidate_id and id = :id";
                $query_check = $dbh->prepare($sql_check);
                $query_check->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                $query_check->bindParam(':id', $id, PDO::PARAM_INT);
                $query_check->execute();

                if ($query_check->rowCount() == 1) {
                    // Update payment table
                    $sql1 = "UPDATE payment SET added_type = 1 WHERE candidate_id = :candidate_id AND added_type = 2";
                    $stmt1 = $dbh->prepare($sql1);
                    $stmt1->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                    $stmt1->execute();

                    // Update emi_list table
                    $sql2 = "UPDATE emi_list SET added_type = 1 WHERE id = :id";
                    $stmt2 = $dbh->prepare($sql2);
                    $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt2->execute();

                    $approved_count++;
                } else {
                    $failed_count++;
                    $errors[] = "Record not found for candidate ID: $candidate_id, EMI ID: $id";
                }
            } catch(PDOException $e) {
                $failed_count++;
                $errors[] = "Error processing candidate ID $candidate_id: " . $e->getMessage();
            }
        }

        // Commit the transaction if there are approved records
        if($approved_count > 0) {
            $dbh->commit();
            if($failed_count == 0) {
                echo json_encode([
                    'status' => 'success', 
                    'approved_count' => $approved_count,
                    'message' => "Successfully approved $approved_count record(s)."
                ]);
            } else {
                echo json_encode([
                    'status' => 'partial_success', 
                    'approved_count' => $approved_count,
                    'failed_count' => $failed_count,
                    'message' => "Approved: $approved_count, Failed: $failed_count record(s).",
                    'errors' => $errors
                ]);
            }
        } else {
            $dbh->rollBack();
            echo json_encode([
                'status' => 'error', 
                'message' => "No records were approved. Failed: $failed_count",
                'errors' => $errors
            ]);
        }

    } catch(PDOException $e) {
        // Roll back the transaction if something failed
        $dbh->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    } catch(Exception $e) {
        // Handle any other exceptions
        echo json_encode(['status' => 'error', 'message' => 'General error: ' . $e->getMessage()]);
    }
    
    exit;
}

// Check if candidate_id is provided for single approval
if(isset($_POST['candidate_id'])) {
    $candidate_id = $_POST['candidate_id'];
    $id = $_POST['id'];

    try {
        // Begin transaction
        $dbh->beginTransaction();

        $sql = "SELECT * from emi_list where added_type= 2 and candidate_id='$candidate_id' ";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                        
        if ($query->rowCount() == 1) {
            // Update first table (full_texts)
            $sql1 = "UPDATE payment SET added_type = 1 WHERE candidate_id = :candidate_id";
            $stmt1 = $dbh->prepare($sql1);
            $stmt1->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $stmt1->execute();
        }

        

        // Update second table (second_table)
        $sql2 = "UPDATE emi_list SET added_type = 1 WHERE id = :id";
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt2->execute();

        // Commit the transaction if both updates are successful
        $dbh->commit();

        echo json_encode(['status' => 'success']);
    } catch(PDOException $e) {
        // Roll back the transaction if something failed
        $dbh->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Candidate ID not provided.']);
}
?>
