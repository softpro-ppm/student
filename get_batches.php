<?php
include('includes/config.php');

if (isset($_POST['job_id'])) {
    $job_id = intval($_POST['job_id']);

    // Example Query: Adjust according to your actual database schema
    $sql = "SELECT id,job_roll_id, batch_name FROM tblbatch WHERE job_roll_id = :job_id ORDER BY id DESC";
    $query = $dbh->prepare($sql);
    $query->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $query->execute();

    $batches = $query->fetchAll(PDO::FETCH_ASSOC);

    //print_r($batches);

    echo json_encode($batches);
}


if (isset($_POST['training_center'])) {
    $training_center = intval($_POST['training_center']);

    $sql_s = "SELECT * FROM tblassignscheme WHERE trainingcenter_id = :training_center ORDER BY id DESC";
    $query_s = $dbh->prepare($sql_s);
    $query_s->bindParam(':training_center', $training_center, PDO::PARAM_INT);
    $query_s->execute();

    $sch_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

    $final_result = [];  
    $unique_names = []; // Track unique scheme names

    foreach ($sch_s as $row5) {
        $scheme_id = $row5['scheme_id'];

        $sql = "SELECT SchemeId, SchemeName FROM tblscheme WHERE SchemeId = :scheme_id ORDER BY SchemeId DESC";
        $query = $dbh->prepare($sql);
        $query->bindParam(':scheme_id', $scheme_id, PDO::PARAM_INT);
        $query->execute();

        $schemes = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($schemes as $scheme) {
            if (!in_array($scheme['SchemeName'], $unique_names)) { 
                $final_result[] = $scheme;
                $unique_names[] = $scheme['SchemeName']; 
            }
        }
    }

    echo json_encode($final_result);
    exit();
}




if (isset($_POST['scheme'])) {
    $scheme = intval($_POST['scheme']);

    $sql_s = "SELECT * FROM tblassignsector WHERE scheme_id = :scheme ORDER BY id DESC";
    $query_s = $dbh->prepare($sql_s);
    $query_s->bindParam(':scheme', $scheme, PDO::PARAM_INT);
    $query_s->execute();

    $sch_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

    $final_result = [];  
    $unique_names = []; // Track unique sector names

    foreach ($sch_s as $row5) {
        $sector_id = $row5['sector_id'];

        $sql = "SELECT * FROM tblsector WHERE SectorId = :sector_id ORDER BY SectorId DESC";
        $query = $dbh->prepare($sql);
        $query->bindParam(':sector_id', $sector_id, PDO::PARAM_INT);
        $query->execute();

        $training_center = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($training_center as $sector) {
            if (!in_array($sector['SectorName'], $unique_names)) { // Replace 'SectorName' with the actual column name
                $final_result[] = $sector;
                $unique_names[] = $sector['SectorName']; 
            }
        }
    }

    echo json_encode($final_result);
    exit();
}



if (isset($_POST['sector'])) {
    $sector = intval($_POST['sector']);

    $sql_s = "SELECT * FROM tblassignjobroll WHERE sector_id = :sector ORDER BY id DESC";
    $query_s = $dbh->prepare($sql_s);
    $query_s->bindParam(':sector', $sector, PDO::PARAM_INT);
    $query_s->execute();

    $sch_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

    $final_result = [];  
    $unique_names = []; // Track unique jobroll names

    foreach ($sch_s as $row5) {
        $sector_id = $row5['jobroll_id'];

        $sql = "SELECT JobrollId, jobrollname FROM tbljobroll WHERE JobrollId = :sector_id ORDER BY JobrollId DESC";
        $query = $dbh->prepare($sql);
        $query->bindParam(':sector_id', $sector_id, PDO::PARAM_INT); 
        $query->execute();

        $training_center = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($training_center as $scheme) {
            if (!in_array($scheme['jobrollname'], $unique_names)) {
                $final_result[] = $scheme;
                $unique_names[] = $scheme['jobrollname'];
            }
        }
    }

    echo json_encode($final_result);
    exit();
}


?>
