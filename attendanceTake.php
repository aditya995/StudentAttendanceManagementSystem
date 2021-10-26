<?php
    session_start();
    ob_start();
    require 'header.php';
    if(isset($_SESSION['role']) && $_SESSION['role'] == 'Teacher'){
    }else{
        header("Location:login.php");
    }
$rec = array(0,0);
    $sql = "SELECT * FROM students";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $tId = $_SESSION['id'];
    $sql = "SELECT * FROM courses WHERE t_id = $tId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $Cdata = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(isset($_SESSION['status'])){
        echo '<h5 class="text-center text-white bg-success m-3 ">'.$_SESSION['status'].'</h5>';
        //unset ($_SESSION['status']);
    }
?>
<style>
    .a{
        background-color: white;
    }
</style>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="form-group">
    <pre>Insert date of attendance : </pre>
    <div class=" col-6 bg-muted">
        <div id="a" class=" ">
            <input class="form-control col-12" type="date" name="date" required>
        </div>
    </div>
    <pre>Insert course ID          : </pre>
    <div class=" col-6 bg-muted">
        <div id="a" class="">
            <select class="form-inline form-control" name="courseID">
               <?php foreach($Cdata as $c_Data){?>
                <option ><?php echo $c_Data['id'];?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-12 card container m-1">
        <div class="row">
            <div class="card col-6  text-center">
                Name:
            </div>
            <div class="card col-3  text-center">
                ID:
            </div>
            <div class="card col-3  text-center">
                present:
            </div>
        </div>
        <?php
        $inc = 0;
            foreach($data as $info){
        ?>
        <div class="row">
            <div class="card col-6 a text-center text-dark font-weight-normal">
                <?php echo $info['name'];?>
            </div>
            <div class="card col-3 a text-dark text-center font-weight-normal">
                <?php echo $info['id'];?>
            </div>
            <div class="card col-3 a text-center font-weight-light">
                <div id="a" class="col-12 ">
                    <select class="form-inline" name="present<?php echo $info['id']?>">
                        <option >0</option>
                        <option >1</option>
                    </select>
                </div>
            </div>
        </div>
        <?php
                if(isset($_POST['submit'])){
                    $cID = $_POST['courseID'];
                    $date = $_POST['date'];
                    $sql = "SELECT COUNT(s_id) FROM attendance WHERE date = '$date' AND course_id = $cID";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $duplicateSearch = $stmt->fetch(PDO::FETCH_ASSOC);
                    $i = $duplicateSearch['COUNT(s_id)'];
                    $rec[$inc++] = $i;
                    if($rec[0] > 0){
                        echo $rec[0];
                        $_SESSION['status'] = 'Date : (yyyy-mm-dd) '.$date.', CourseID : '.$cID.', <br><span class="text-danger">Possible Duplicate Entry!!</span>';
                    }else{
                        $sID = $info['id'];
                        $pre = "present".$info['id'];
                        $present = $_POST[$pre];
                        $tID = $_SESSION['id'];
                        $sql = "INSERT INTO `attendance`(`course_id`, `date`, `s_id`, `present`, `t_id`) VALUES ($cID, '$date', $sID, $present, $tID)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $_SESSION['status'] = 'Date : (yyyy-mm-dd) '.$date.', CourseID : '.$cID.', <br><span class="text-dark">Attendance successfully submitted!!</span>';
                    }
                }
            }
        ?>
    </div>
    <div id="" class="col-4 ">
        <button name="submit" class="col-12 bg-success form-control">Submit</button>
    </div>
</form>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="form-group">
    <div class="col-12 text-center font-weight-bolder  card delete" style="background-color: #F05454" type="button" data-toggle="modal" data-target="#myModald">
        <span class="text-light btn">Double check before taking attendance, if necessary delete all records in a particular <span class="text-light spinner-grow bg-dark rounded">date</span> from a <span class="text-warning bg-dark rounded">"course"</span>?!!</span>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModald" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bg-danger a font-weight-light card p-3"><small class="text-light">Warning:</small>You are about to delete a lot of records,<br>Delete the records ?!!</h5>
                    <button type="button" class="close bg-secondary card" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                   <?php
                            $t_ID = $_SESSION['id'];
                            $sql = "SELECT DISTINCT course_id FROM attendance WHERE t_id = $t_ID";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $cidData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($cidData as $LoopcidData){
                        ?>
                    <div class="form-group">
                          <label for="delCid">
                              <pre>Course ID  : <?php echo $LoopcidData['course_id'];?></pre>
                          </label>
                    </div>
                    <div class="form-group">
                          <label for="delDate">
                              <pre>Date of Attendance  : </pre>
                          </label>
                          <?php
                            $CIDdata = $LoopcidData['course_id'];
                            $sql = "SELECT DISTINCT date FROM attendance WHERE course_id = $CIDdata AND t_id = $t_ID";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $dateData = $stmt->fetchAll(PDO::FETCH_ASSOC);?>
                          <div id="a" class="col-4 ">
                              <select class="form-control" name="delDate<?php echo $LoopcidData['course_id'];?>" id="delDate">
                                  <?php foreach($dateData as $t_Data){?>
                                  <option><?php echo $t_Data['date'];?></option>
                                  <?php } ?>
                              </select>
                          </div>
                    </div>
                    <button name="delete<?php echo $LoopcidData['course_id'];?>" class="btn btn-danger">Confirm</button>
                    <?php
                    $elementID = 'delete'.$LoopcidData['course_id'];
                    if(isset($_POST[$elementID])){
                        $Dcid = $LoopcidData['course_id'];
                        $delDate = "delDate".$LoopcidData['course_id'];
                        $Ddate = $_POST[$delDate];
                        $sql = "DELETE FROM attendance WHERE course_id = $Dcid AND date = '$Ddate'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        ob_end_clean( );
                        $_SESSION['status'] = "All records of date (yyyy-mm-dd) ".$Ddate.", with CourseID ".$Dcid." has been deleted!!";
                        header("Location:attendanceTake.php");
                        //exit();
                    } 
                } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default bg-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
if(isset($_POST['submit'])){
    ob_end_clean( );
    header("Location:attendanceTake.php");
}
?>

<?php include 'footer.php';?>