<?php
session_start();
require 'header.php';
if(isset($_SESSION['role']) && $_SESSION['role'] == 'Student'){
}else{
    header("Location:login.php");
}
if(isset($_POST['submit'])){
    $PcourseId = $_POST['cId'];
    $PsId = $_POST['sId'];
    $PstartDate = $_POST['dFrom'];
    $PendDate = $_POST['dTo'];
    
    $_SESSION['a'] = $PstartDate;
    $_SESSION['cId'] = $PcourseId;
    $_SESSION['sId'] = $PsId;
    $_SESSION['dFrom'] = $PstartDate;
    $_SESSION['dTo'] = $PendDate;
    header("Location:attendanceView.php");
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
    
    .selectAll:hover{
        text-decoration: underline;
    }
    
    ::selection {
        color: white;
        background: black;
    }
    .a{
        background-color: #222831;
    }
    .b{
        background-color: ##30475E;
    }
    
</style>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="p-1">
    <div class="row col-12 m-3">
        <!--***************************************Heading*************************************-->
        <div class="row col-12">
            <div name="Teacher" class="col-12 text-center text-white card" style="background-color:#30475E" onmouseover="openTab(event, 'Teacher')">
                <h4 class="font-weight-light">Attendance</h4>
            </div>
        </div>
        <!--***************************************Attendance*************************************-->
        <div id="Teacher" class="tab row col-xl-12 p-2">
            <div class="form-group col-6">
                <label for="dFrom">
                    <pre>From      :</pre>
                </label>
                <input type="date" id="dFrom" class="form-control" name="dFrom"value="<?php if(isset($_SESSION['dFrom'])){ echo $_SESSION['dFrom'];}?>" required>
            </div>
            <div class="form-group col-6">
                <label for="dTo">
                    <pre>To        :</pre>
                </label>
                <input type="date" id="dTo" class="form-control" name="dTo" value="<?php if(isset($_SESSION['dTo'])){ echo $_SESSION['dTo'];}?>" required>
            </div>
            <?php
            $sql = "SELECT DISTINCT course_id FROM attendance";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $Cdata = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="form-group col-6">
                <label for="cId">
                    <p>Course ID : </p>
                </label>
                <div class=" col-12 bg-muted">
                <div id="a" class="">
                    <select class="form-inline form-control" name="cId">
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
                    <p>StudentID : ( Use 0 to view all students.)</p>
                </label>
                <input type="number" class="form-control" id="sId" placeholder="Enter Student ID" name="sId" value="<?php /*if(isset($_SESSION['sId'])){ echo $_SESSION['sId'];}*/?>0" required>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="submit" type="submit" class="btn a text-white" name="submit">Show</button>
                </div>
            </div>
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
                <div class="col-2  text-center text-white a form-control">Presence:</div>
                <div class="col-2  text-center text-white a form-control">T_ID:</div>
                <div class="col-2  text-center text-white a form-control">C_ID:</div>
                <div class="col-2  text-center text-white a form-control">St.ID:</div>
                <div class="col-2  text-center text-white a form-control">St.Name:</div>
                <?php 
                $i = 0;
                $array = array();
                if($_SESSION['tl']==1){
                    sort($data);//echo '<h6 class="col-12">l cl'.$_SESSION['cl'].' </h6>';
                }
                foreach($data as $info) {
                    $array[$i++] = $info['id'];
                    $_SESSION['ti'] = $i-1;
                    $_SESSION['lIndexT'][$i-1] = $info['id'];
                    //echo '<h6 class="col-12"> $_SESSION[\'lIndexT\'][$i-1] = '.$_SESSION['lIndexT'][$i-1].' $_SESSION[\'ti\'] = '.$_SESSION['ti'].' </h6>';
                ?>
                <div class="col-2  selectAll text-center text-dark font-weight-normal b card"><?php echo ''.$info['date'].'';?></div>
                <div class="col-2  selectAll text-center text-dark font-weight-normal b card"><?php if($info['present'] == 1){ echo 'P';}else{ echo 'A';}?></div>
                <div class="col-2  selectAll text-center text-dark font-weight-normal b card"><?php echo $info['t_id'];?></div>
                <div class="col-2  selectAll text-center text-dark font-weight-normal b card"><?php echo $info['course_id'];?></div>
                <div class="col-2  selectAll text-center text-dark font-weight-normal b card"><?php echo $info['s_id'];?></div>
                <?php
                $ID = $info['s_id'];
                $sql = "SELECT * FROM students WHERE id = $ID";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="col-2  selectAll text-center text-dark font-weight-normal b card"><?php echo $data['name'];?></div>
                <?php }?>
            </div>
        </div>
</form>

<?php

require 'footer.php';

?>