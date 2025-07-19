<?php
include('includes/config.php');
// Delete assign work and set status in user_project table
if ($_POST["action"] == "Delete candidate") {
    $id = $_POST['id'];
    if ($id > 0) {
        // Delete record
        $sql = "DELETE FROM tblcandidate WHERE CandidateId=" . $id;
        $query = $dbh->prepare($sql);
        $query->execute();
        echo 4;
        exit;
    }
    echo 0;
    exit;
}


// Delete assign work and set status in user_project table
if ($_POST["action"] == "Delete trainingcenter") {
    $id = $_POST['id'];
    if ($id > 0) {
        // Delete record
        $sql = "DELETE FROM tbltrainingcenter WHERE TrainingcenterId=" . $id;
        $query = $dbh->prepare($sql);
        $query->execute();
        echo 4;
        exit;
    }
    echo 0;
    exit;
}

if ($_POST["action"] == "Delete scheme") {
    $id = $_POST['id'];
    if ($id > 0) {
        // Delete record
        $sql = "DELETE FROM tblscheme WHERE SchemeId=" . $id;
        $query = $dbh->prepare($sql);
        $query->execute();
        echo 4;
        exit;
    }
    echo 0;
    exit;
}

if ($_POST["action"] == "Delete sector") {
    $id = $_POST['id'];
    if ($id > 0) {
        // Delete record
        $sql = "DELETE FROM tblsector WHERE SectorId=" . $id;
        $query = $dbh->prepare($sql);
        $query->execute();
        echo 4;
        exit;
    }
    echo 0;
    exit;
}
if ($_POST["action"] == "Delete jobroll") {
    $id = $_POST['id'];
    if ($id > 0) {
        // Delete record
        $sql = "DELETE FROM tbljobroll WHERE JobrollId=" . $id;
        $query = $dbh->prepare($sql);
        $query->execute();
        echo 4;
        exit;
    }
    echo 0;
    exit;
}

if ($_POST["action"] == "Delete batch") {
    $id = $_POST['id'];
    if ($id > 0) {
        // Delete record
        $sql = "DELETE FROM tblbatch WHERE id=" . $id;
        $query = $dbh->prepare($sql);
        $query->execute();
        echo 4;
        exit;
    }
    echo 0;
    exit;
}


if ($_POST["action"] == "Delete user") {
    $id = $_POST['id'];
    if ($id > 0) {
        // Delete record
        $sql = "DELETE FROM admin WHERE id=" . $id;
        $query = $dbh->prepare($sql);
        $query->execute();
        echo 4;
        exit;
    }
    echo 0;
    exit;
}

if ($_POST["action"] == "Delete invoice") {
    $id = $_POST['id'];
    if ($id > 0) {
        // Delete record
        $sql = "DELETE FROM tblinvoice WHERE invoiceID=" . $id;
        $query = $dbh->prepare($sql);
        $query->execute();
        echo 4;
        exit;
    }
    echo 0;
    exit;
}
