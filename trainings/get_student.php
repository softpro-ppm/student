<?php
include('includes/config.php');

if(!empty($_POST["classid"])) 
{
 $cid=intval($_POST['classid']);
 if(!is_numeric($cid)){
 
 	echo htmlentities("invalid Class");exit;
 }
 else{
 $stmt = $dbh->prepare("SELECT StudentName,StudentId FROM tblstudents WHERE ClassId= :id order by StudentName");
 $stmt->execute(array(':id' => $cid));
 ?><option value="">Select Category </option><?php
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 { 
  ?>
  <option value="<?php echo htmlentities($row['StudentId']); ?>"><?php echo htmlentities($row['StudentName']); ?></option>
  <?php
 }
}

}

if(!empty($_POST["trainingid"])) 
{
 $tid=intval($_POST['trainingid']);
 if(!is_numeric($tid)){
 
   echo htmlentities("invalid Class");
   exit;
 }
 else{
 $stmt = $dbh->prepare("SELECT DISTINCT tblscheme.SchemeName,tblassignscheme.scheme_id,tblassignscheme.trainingcenter_id FROM tblscheme INNER JOIN tblassignscheme ON tblscheme.SchemeId= tblassignscheme.scheme_id AND tblassignscheme.trainingcenter_id =:id");
 $stmt->execute(array(':id' => $tid));
 ?><option value="">Select Scheme </option><?php
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 { 
  ?>
  <option value="<?php echo htmlentities($row['scheme_id']); ?>"><?php echo htmlentities($row['SchemeName']); ?></option>
  <?php
 }
}

}

if(!empty($_POST["schemeid"])) 
{
 $sid=intval($_POST['schemeid']);
 if(!is_numeric($sid)){
 
   echo htmlentities("invalid Class");
   exit;
 }
 else{
 $stmt = $dbh->prepare("SELECT DISTINCT tblsector.SectorName,tblassignsector.sector_id,tblassignsector.scheme_id FROM tblsector INNER JOIN tblassignsector ON tblsector.SectorId = tblassignsector.sector_id AND tblassignsector.scheme_id =:id");
 $stmt->execute(array(':id' => $sid));
 ?><option value="">Select Sector </option><?php
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 { 
  ?>
  <option value="<?php echo htmlentities($row['sector_id']); ?>"><?php echo htmlentities($row['SectorName']); ?></option>
  <?php
 }
}

}

if(!empty($_POST["sectorid"])) 
{
 $jid=intval($_POST['sectorid']);
 if(!is_numeric($jid)){
 
   echo htmlentities("invalid Class");
   exit;
 }
 else{
 $stmt = $dbh->prepare("SELECT DISTINCT tbljobroll.jobrollname,tblassignjobroll.sector_id,tblassignjobroll.jobroll_id FROM tbljobroll INNER JOIN tblassignjobroll ON tbljobroll.JobrollId = tblassignjobroll.jobroll_id AND tblassignjobroll.sector_id =:id");
 $stmt->execute(array(':id' => $jid));
 ?><option value="">Select Sector </option><?php
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 { 
  ?>
  <option value="<?php echo htmlentities($row['jobroll_id']); ?>"><?php echo htmlentities($row['jobrollname']); ?></option>
  <?php
 }

 
}

}


if(!empty($_POST["jobroll_id"])) 
{
 $jid=intval($_POST['jobroll_id']);
 if(!is_numeric($jid)){
 
   echo htmlentities("invalid Class");
   exit;
 }
 else{
 $stmt = $dbh->prepare("SELECT tblbatch.* FROM tblbatch WHERE job_roll_id='$jid'");
 $stmt->execute(array(':id' => $jid));
 ?><option value="">Select batch </option><?php
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 { 
  ?>
  <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['batch_name']); ?></option>
  <?php
 }

 
}

}


if(!empty($_POST["jobrollid"])) 
{
 $jobrollid=intval($_POST['jobrollid']);
 if(!is_numeric($jobrollid)){
 
   echo htmlentities("invalid Class");
   exit;
 }
 else{
   $sql = "SELECT tbltrainingcenter.trainingcentername,tblscheme.SchemeName,tblsector.SectorName,tbljobroll.jobrollname,tblbatch.* from tbltrainingcenter,tblscheme,tblsector,tbljobroll,tblbatch WHERE tblbatch.training_centre_id  = tbltrainingcenter.TrainingcenterId AND tblbatch.scheme_id = tblscheme.SchemeId AND tblbatch.sector_id = tblsector.SectorId AND tblbatch.job_roll_id = tbljobroll.JobrollId AND tblbatch.job_roll_id=:job_roll_id";
$query = $dbh->prepare($sql);
$query->bindParam(':job_roll_id',$jobrollid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
                                                <tr>
                                                    <td>
                                                        <?php echo htmlentities($cnt);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->batch_name);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->jobrollname);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->SectorName);?>
                                                    <td>
                                                        <?php echo htmlentities($result->SchemeName);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->trainingcentername);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->start_date);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->end_date);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->start_time);?>
                                                    <td>
                                                        <?php echo htmlentities($result->end_time);?>
                                                    </td>
                                                    <td>
                                                        <a href="add-candidate-to-particular-batch.php?batchid=<?php echo htmlentities($result->id);?>">
                                                        <span class="btn btn-primary">Add candidate</span> </a>
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="bulk-download.php?batchid=<?php echo htmlentities($result->id);?>">
                                                        <span class="btn btn-primary">export</span> </a>
                                                    </td>
                                                </tr>
                                                <?php $cnt=$cnt+1;}
  }else{
    echo "No Batch to show";
  } 



  
 }
}


if(!empty($_POST["jobrollid_for_result"])) 
{
 $jobrollid=intval($_POST['jobrollid_for_result']);
 if(!is_numeric($jobrollid)){
 
   echo htmlentities("invalid Class");
   exit;
 }
 else{
   $sql = "SELECT tbltrainingcenter.trainingcentername,tblscheme.SchemeName,tblsector.SectorName,tbljobroll.jobrollname,tblbatch.* from tbltrainingcenter,tblscheme,tblsector,tbljobroll,tblbatch WHERE tblbatch.training_centre_id  = tbltrainingcenter.TrainingcenterId AND tblbatch.scheme_id = tblscheme.SchemeId AND tblbatch.sector_id = tblsector.SectorId AND tblbatch.job_roll_id = tbljobroll.JobrollId AND tblbatch.job_roll_id=:job_roll_id";
$query = $dbh->prepare($sql);
$query->bindParam(':job_roll_id',$jobrollid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
                                                <tr>
                                                    <td>
                                                        <?php echo htmlentities($cnt);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->batch_name);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->jobrollname);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->SectorName);?>
                                                    <td>
                                                        <?php echo htmlentities($result->SchemeName);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->trainingcentername);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->start_date);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->end_date);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->start_time);?>
                                                    <td>
                                                        <?php echo htmlentities($result->end_time);?>
                                                    </td>
                                                    <td>
                                                        <a href="add-result-to-particular-batch.php?batchid=<?php echo htmlentities($result->id);?>">
                                                        <span class="btn btn-primary">Add result</span> </a>
                                                    </td>
                                                </tr>
                                                <?php $cnt=$cnt+1;}
  }else{
    echo "No Batch to show";
  } 



  
 }
}

if(!empty($_POST["jobrollid_for_certificate"])) 
{
 $jobrollid=intval($_POST['jobrollid_for_certificate']);
 if(!is_numeric($jobrollid)){
 
   echo htmlentities("invalid Class");
   exit;
 }
 else{
   $sql = "SELECT tbltrainingcenter.trainingcentername,tblscheme.SchemeName,tblsector.SectorName,tbljobroll.jobrollname,tblbatch.* from tbltrainingcenter,tblscheme,tblsector,tbljobroll,tblbatch WHERE tblbatch.training_centre_id  = tbltrainingcenter.TrainingcenterId AND tblbatch.scheme_id = tblscheme.SchemeId AND tblbatch.sector_id = tblsector.SectorId AND tblbatch.job_roll_id = tbljobroll.JobrollId AND tblbatch.job_roll_id=:job_roll_id";
$query = $dbh->prepare($sql);
$query->bindParam(':job_roll_id',$jobrollid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
                                                <tr>
                                                    <td>
                                                        <?php echo htmlentities($cnt);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->batch_name);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->jobrollname);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->SectorName);?>
                                                    <td>
                                                        <?php echo htmlentities($result->SchemeName);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->trainingcentername);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->start_date);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->end_date);?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($result->start_time);?>
                                                    <td>
                                                        <?php echo htmlentities($result->end_time);?>
                                                    </td>
                                                    <td>
                                                        <a href="add-certification-to-particular-batch.php?batchid=<?php echo htmlentities($result->id);?>">
                                                        <span class="btn btn-primary">Add certification</span> </a>
                                                    </td>
                                                </tr>
                                                <?php $cnt=$cnt+1;}
  }else{
    echo "No Batch to show";
  } 



  
 }
}
?>



