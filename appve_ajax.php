<?php
// Include your database configuration/connection file
include('includes/config.php');

header('Content-Type: application/json');

// Check if candidate_id is provided
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
