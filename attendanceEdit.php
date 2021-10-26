<?php
session_start();
ob_start();
require 'header.php';
if(isset($_SESSION['role']) && ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Teacher')){
}else{
    header("Location:login.php");
}
if(isset($_POST['submit'])){
    $PcourseId = $_POST['cId'];
    $PsId = $_POST['sId'];
    $PstartDate = $_POST['dFrom'];
    $PendDate = $_POST['dTo'];
    
    $_SESSION['cId'] = $PcourseId;
    $_SESSION['sId'] = $PsId;
    $_SESSION['dFrom'] = $PstartDate;
    $_SESSION['dTo'] = $PendDate;
    header("Location:attendanceEdit.php");
}
?>
<style>
    .selectAll {
        cursor: -webkit-grab;
        cursor: grab;
        -webkit-user-select: all;
        /* Chrome all / Safari all */
        /********   user-select : all ****** for one click select!!!*/
        -moz-user-select: all;
        /* Firefox all */
        -ms-user-select: all;
        /* IE 10+ */
        user-select: all;
        /* Likely future */
    }

    .selectAll:hover {
        text-decoration: underline;
    }

    .edit,
    .delete,
    button {
        color: black;
        cursor: pointer;
    }

    ::selection {
        color: white;
        background: black;
    }
    .a{
        background-color: #222831;
    }
    .b{
        background-color: #30475E;
    }
    
</style>

<h4 class="text-center  card my-4 p-1 text-white text-monospace text-uppercase" style="background-color:#30475E">Edit attendance</h4>

<div class="row col-12 m-2 p-2">
    <!--***************************************Heading*************************************-->
    <div class="row col-12">
        <div name="Teacher" class="col-12 text-center card" onmouseover="openTab(event, 'Teacher')">
            <h4 class="font-weight-light">Attendance</h4>
        </div>
    </div>
    <!--***************************************Attendance*************************************-->
    <div id="Teacher" class="tab row col-12">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="form-inline ">
            <div class="form-group col-6">
                <label for="dFrom">
                    <pre>From      : </pre><input type="date" id="dFrom" class="form-control" name="dFrom"value="<?php if(isset($_SESSION['dFrom'])){ echo $_SESSION['dFrom'];}?>" required>
                </label>
            </div>
            <div class="form-group col-6">
                <label for="dTo">
                    <pre>To        : </pre><input type="date" id="dTo" class="form-control" name="dTo" value="<?php if(isset($_SESSION['dTo'])){ echo $_SESSION['dTo'];}?>" required>
                </label>
            </div>
            <?php
            $sql = "SELECT DISTINCT course_id FROM attendance";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $Cdata = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="form-group col-6">
                <label for="cId">
                    <pre>Course ID : </pre>
                </label>
                <div class=" col-12 bg-muted">
                <div id="a" class="">
                    <select class="form-control" name="cId">
                        <option value="0">All Courses</option>
                       <?php foreach($Cdata as $c_Data){?>
                        <option <?php if(isset($_SESSION['cId']) && $_SESSION['cId'] == $c_Data['course_id']){ echo 'selected';}?>><?php echo $c_Data['course_id'];?></option>
                        <?php } ?>
                    </select>
                </div>
                </div>
            </div>
            
            
            <div class="form-group col-6">
                <label for="sId">
                    <pre>StudentID : </pre><input type="number" class="form-control" id="sId" placeholder="Enter Student ID" name="sId" value="<?php /*if(isset($_SESSION['sId'])){ echo $_SESSION['sId'];} else{ echo '0';}*/ echo '0'; ?>" required>
                </label>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="submit" type="submit" class="btn text-white" style="background-color: black" name="submit">Show</button>
                </div>
            </div>
        </form>
        <?php
                if(isset($_SESSION['sId'])){
                    $courseId = $_SESSION['cId'];
                    $sId = $_SESSION['sId'];
                    $startDate = $_SESSION['dFrom'];
                    $endDate = $_SESSION['dTo'];
                }else{
                    $courseId = 0;
                    $sId = 0;
                    $startDate = '';
                    $endDate = '';
                }
                if($courseId == 0 && $sId != 0){
                    $sql = "SELECT * FROM attendance WHERE date BETWEEN '$startDate' and '$endDate' and s_id = $sId  ORDER BY date ";
                }else if($courseId != 0 && $sId == 0){
                    $sql = "SELECT * FROM attendance WHERE date BETWEEN '$startDate' and '$endDate' and course_id = $courseId ORDER BY id";
                }else if($courseId == 0 && $sId == 0){
                    $sql = "SELECT * FROM attendance WHERE date BETWEEN '$startDate' and '$endDate' ORDER BY id ";
                }
                else{
                    $sql = "SELECT * FROM attendance WHERE date BETWEEN '$startDate' and '$endDate' and s_id = $sId and course_id = $courseId ORDER BY date ";
                }
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
        <div class="row col-12">
            <h3 class="text-center col-12"> Attendance list:</h3>
            <h5 class="col-12  card"><?php echo 'StudentID = '.$sId.', CourseID = '.$courseId;?></h5>
            <h6 class="col-12  card"><?php echo 'Date From : (yyyy-mm-dd) = '.$startDate.', To : '.$endDate;?></h6>
            <div class="col-2  text-center text-white a form-control">Date:</div>
            <div class="col-2  text-center text-white a form-control">T_ID:</div>
            <div class="col-2  text-center text-white a form-control">Presence:</div>
            <div class="col-2  text-center text-white a form-control">C_ID:</div>
            <div class="col-2  text-center text-white a form-control">St.ID:</div>
            <div class="col-2  text-center text-white a form-control">Edit:</div>
            <?php 
                foreach($data as $info) {
                ?>
                <div class="col-2  selectAll text-center text-dark font-weight-normal  card"><?php echo ''.$info['date'].'';?></div>
                <div class="col-2  selectAll text-center text-dark font-weight-normal  card"><?php echo ''.$info['t_id'].'';?></div>
                <div class="col-2  selectAll text-center text-dark font-weight-normal  card"><?php if($info['present'] == 1){ echo 'P';}else{ echo 'A';}?></div>
                <div class="col-2  selectAll text-center text-dark font-weight-normal  card"><?php echo $info['course_id'];?></div>
                <div class="col-2  selectAll text-center text-dark font-weight-normal  card"><?php echo $info['s_id'];?></div>
                <div class="col-2 text-center font-weight-normal b form-control edit" type="button" data-toggle="modal" data-target="#myModalE<?php echo $info['id']?>">
                    <span>Edit</span>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="myModalE<?php echo $info['id']?>" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit presence information</h4>
                                <button type="button" class="close bg-secondary card" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12 bg-info" id="">Date (yyyy-mm-dd) : <?php echo $info['date']?></div><br>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="form-group">
                                <div id="a" class="col-12 ">
                                   <h5>1 for present. <br> 0 for absent.</h5>
                                    <select class="form-control" name="present<?php echo $info['id']?>">
                                        <option <?php if($info['present'] == 1){echo 'selected';}?>>1</option>
                                        <option <?php if($info['present'] == 0){echo 'selected';}?>>0</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button id="edit<?php echo $info['id']?>" type="submit" class="btn btn-warning" name="edit<?php echo $info['id']?>">Submit</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default bg-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $elementID = 'edit'.$info['id'];
                    $pID = 'present'.$info['id'];
                    if(isset($_POST[$elementID])){
                        $p = $_POST[$pID];echo $p;
                        $id = $info['id'];
                        $sql = "UPDATE attendance SET present = :p WHERE id = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':p'=>$p,':id'=>$id]);
                        ob_end_clean( );
                        header("Location:attendanceEdit.php");
                    }
                ?>
            <?php }?>
        </div>
    </div>
</div>
<?php
require 'footer.php';
?>