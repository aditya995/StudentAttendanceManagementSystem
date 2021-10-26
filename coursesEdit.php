<?php
session_start();
ob_start( );
require 'header.php';
if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
}else{
    header("Location:login.php");
}

/*****************************************************Form***************************************************/

$rangeC = $_SESSION['rangeC'];

//Indices for query starting points

$indexC = $_SESSION['indexC'];

//Setting range values number of query each section

if(isset($_POST['rangeC'])){
    $_SESSION['rangeC'] = $_POST['rangeC'];
    $rangeC = $_SESSION['rangeC'];
}

//Navigation tabs' values
//coursesEdit
if(isset($_POST['Course'])){
    $_SESSION['tabRole'] = 'Course';
    header("Location:coursesEdit.php");
}

//Setting the left right navigation keys' values

if(isset($_POST['cl'])){
    $_SESSION['tabRole'] = 'Course';
    $_SESSION['cl'] = 1;
    $_SESSION['cr'] = 0;
    $indexFromLoop = $_SESSION['ci'];
    $sql = 'SELECT MIN(id) FROM courses';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $firstID = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($firstID[0]['MIN(id)'] == $_SESSION['lIndexC'][0]){
        $_SESSION['indexC'] = $_SESSION['lIndexC'][$indexFromLoop] + 1;
    }else if($firstID[0]['MIN(id)'] < $_SESSION['lIndexC'][0]){
        $_SESSION['indexC']=$_SESSION['lIndexC'][0];
    }
    header("Location:coursesEdit.php");
}else
if(isset($_POST['cr'])){
    $_SESSION['tabRole']='Course' ;
    $_SESSION['cr']=1; $_SESSION['cl']=0;
    $indexFromLoop=$_SESSION['ci'];
    $sql='SELECT MAX(id) FROM courses';
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $lastID = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($lastID[0]['MAX(id)'] > $_SESSION['lIndexC'][$indexFromLoop]){
        if($_SESSION['cl']==1){
            $_SESSION['indexC'] = $_SESSION['lIndexC'][0];
        }else{
            $_SESSION['indexC'] = $_SESSION['lIndexC'][$indexFromLoop];
        }
    }
    header("Location:coursesEdit.php");
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

    .edit,.delete,button {
        color: black;
        cursor: pointer;
    }
    
    .dropdown1 {
        display: inline-block;
        cursor: default;
        -webkit-user-select: none;
        /* Chrome all / Safari all */
        /********   user-select : all ****** for one click select!!!*/
        -moz-user-select: none;
        /* Firefox all */
        -ms-user-select: none;
        /* IE 10+ */
        user-select: none;
        /* Likely future */
    }

    .dropdown1:hover .dropdown-content1 {
        display: block;
    }


    .dropdown-content1 {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 5;
    }

    .dropdown-content1 span:hover {
        color: aliceblue;
        height: 25px;
        background-color: coral;
        padding: 0vw 2vw;
        margin: 0px 0px;
        cursor: pointer;
    }

    .dropdown-content1 span {
        margin: 0px 0px;
        padding: 0vw 2vw;
        height: 15px;
    }
    
    .img {
        height: 50px;
        width: auto;
        max-wi
        dth: 100px;
    }
    .a{
        background-color: white;
    }
    .bg-ac{
        background-color: #222831;
    }
    .b{
        background-color: #30475E;
    }
</style>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="p-1">
    <h4 class="text-center  card my-4 p-1 text-white text-monospace text-uppercase" style="background-color:#30475E">Courses lists:</h4>
    <?php  
        if($_SESSION['cl']==1){
            $_SESSION['cl'] = 1;
            $sql = "SELECT * FROM courses WHERE id < $indexC ORDER BY id DESC LIMIT $rangeC";
        }else if($_SESSION['cr']==1){
            $_SESSION['cr'] = 1;
            $sql = "SELECT * FROM courses WHERE id > $indexC LIMIT $rangeC";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="row col-12">
        <div class="col-2  text-center  form-control">ID_no:</div>
        <div class="col-4  text-center  form-control">Name:</div>
        <div class="col-6  text-center  form-control">Teacher:</div>
        <?php 
        $i = 0;
        $array = array();
        if($_SESSION['cl']==1){
            sort($data);//echo '<h6 class="col-12">l cl'.$_SESSION['cl'].' </h6>';
        }
        foreach($data as $info) {
            $array[$i++] = $info['id'];
            $_SESSION['ci'] = $i-1;
            $_SESSION['lIndexC'][$i-1] = $info['id'];
            //echo '<h6 class="col-12"> $_SESSION[\'lIndexC\'][$i-1] = '.$_SESSION['lIndexC'][$i-1].' $_SESSION[\'ci\'] = '.$_SESSION['ci'].' </h6>';
            $teacherId = $info['t_id'];//echo $teacherId;
            $sql = "SELECT * FROM teacher WHERE id = $teacherId";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $dataName = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="col-2  selectAll text-center text-dark font-weight-normal a card"><?php echo ''.$info['id'].'';?></div>
        <div class="col-4  selectAll text-center text-dark font-weight-normal a card"><?php echo $info['name'];?></div>
        <div class="col-3  selectAll text-center text-dark font-weight-normal a card" data-toggle="tooltip" data-placement="right" title="Teacher ID = <?php if($teacherId > 0){echo $dataName[0]['id'];}else{ echo 'N/A';}?>" ><?php if($teacherId > 0){echo $dataName[0]['name']."<br><center><img class=\"img bg-light rounded\" src='images/".$dataName[0]['image']."' > </center> <br>";}else{ echo 'N/A';}?>
        </div>
        <div class="col-1 text-center font-weight-bolder b form-control edit" type="button" data-toggle="modal" data-target="#myModal<?php echo $info['id']?>">
            <span>Edit</span>
        </div>
            <!-- Modal -->
        <div class="modal fade" id="myModal<?php echo $info['id']?>" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                     <h4 class="modal-title">Edit course information</h4>
                      <button type="button" class="close bg-secondary card" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <div id="">Course ID : <?php echo $info['id']?></div>
                      
                      <div class="form-group">
                          <label for="Cname">
                              <pre>Course name : <?php echo $info['name']?></pre>
                          </label>
                          
                          <input type="text" class="form-control" id="Cname" placeholder="Enter course name" name="name<?php echo $info['id']?>" value="<?php echo $info['name']?>">
                      </div>
                      <div class="form-group">
                          <label for="Tid">
                              <pre>Teacher ID  : <?php echo $info['t_id']?></pre>
                          </label>
                          <?php
                            $sql = "SELECT * FROM teacher";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $Tdata = $stmt->fetchAll(PDO::FETCH_ASSOC);?>
                          <div id="a" class="col-4 ">
                              <select class="form-control" name="TeacherId<?php echo $info['id']?>">
                                  <?php foreach($Tdata as $t_Data){?>
                                  <option <?php if($t_Data['id']==$info['t_id']){echo 'selected';}?>><?php echo $t_Data['id'];?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <button name="edit<?php echo $info['id']?>" class="btn btn-warning">Submit</button>
                      </div>
                      <div class="modal-footer">
                      <button type="button" class="btn btn-default bg-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $elementID = 'edit'.$info['id'];
            $name = "name".$info['id'];
            $t_id = "TeacherId".$info['id'];
            $idC = $info['id'];
            if(isset($_POST[$elementID])&&!empty($_POST[$name])&&!empty($_POST[$t_id])){
                $eName = $_POST[$name];
                $eTid = $_POST[$t_id];
                echo '<script type="text/JavaScript">  
                     alert("'.$_POST[$name].' '.$_POST[$t_id].' '.$idC.'"); 
                     </script>' 
                ;
                $sql = "UPDATE courses  SET t_id = :t_id, name = :name WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':name'=>$eName,':t_id'=>$eTid,':id'=>$idC]);
                ob_end_clean( );
                header("Location:coursesEdit.php");
                //exit();
            }
        ?>
        <div class="col-2 text-center font-weight-bolder form-control delete" style="background-color:#F05454" type="button" data-toggle="modal" data-target="#myModald<?php echo $info['id']?>">
            <span>Delete</span>
        </div>
            <!-- Modal -->
        <div class="modal fade" id="myModald<?php echo $info['id']?>" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                     <h4 class="modal-title">Delete course ?</h4>
                      <button type="button" class="close bg-secondary card" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <div id="">Course ID : <?php echo $info['id']?></div>
                      
                      <div class="form-group">
                          <label for="email">
                              <pre>Course name : <?php echo $info['name']?></pre>
                          </label>
                      </div>
                      <div class="form-group">
                          <label for="email">
                              <pre>Teacher ID  : <?php echo $info['t_id']?></pre>
                          </label>
                      </div>
                      
                      <button name="delete<?php echo $info['id']?>" class="btn btn-danger">Delete</button>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default bg-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $elementID = 'delete'.$info['id'];
            $idC = $info['id'];
            if(isset($_POST[$elementID])){
                $sql = 'DELETE FROM courses WHERE id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id'=>$idC]);
                ob_end_clean( );
                header("Location:coursesEdit.php");
                //exit();
            }
        ?>
        <?php }?>
        <div class="col-4 ">
            <button name="cl" class="col-12  form-control">&#x022D8;</button>
        </div>
        <div id="a" class="col-4 ">
            <button name="cr" class="col-12  form-control">&#x022D9;</button>
        </div>
        <div id="a" class="col-4 ">
            <select class="form-control" name="rangeC">
                <option <?php if(isset($_SESSION['rangeC'])&&$_SESSION['rangeC']==1){echo 'selected';}?>>1</option>
                <option <?php if(isset($_SESSION['rangeC'])&&$_SESSION['rangeC']==2){echo 'selected';}?>>2</option>
                <option <?php if(isset($_SESSION['rangeC'])&&$_SESSION['rangeC']==3){echo 'selected';}?>>3</option>
                <option <?php if(isset($_SESSION['rangeC'])&&$_SESSION['rangeC']==4){echo 'selected';}?>>4</option>
                <option <?php if(isset($_SESSION['rangeC'])&&$_SESSION['rangeC']==5){echo 'selected';}?>>5</option>
            </select>
        </div>
    </div>
</form>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="p-1">
    <div class="form-group">
        <label for="cid">
            <pre>Course ID     : </pre>
        </label>
        <input type="number" class="form-control" id="cid" placeholder="Enter Course ID" name="addCid" value="" required>
    </div>
    <div class="form-group">
        <label for="cname">
            <pre>Course name   : </pre>
        </label>
        <input type="text" class="form-control" id="cname" placeholder="Enter Course name" name="addCname" value="" required>
    </div>
    <div class="form-group">
        <label for="">
            <pre>Teacher ID    : </pre>
        </label>
        <input type="number" class="form-control" id="tid" placeholder="Enter Teacher ID" name="addTid" value="" required>
        
        <div id="" class="dropdown1" onclick="showOC1();">
            <h4 class="bg-primary p-3 row-of-icons">Teacher ID <small><pre>click me! for suggestions</pre></small></h4>
            <div id="dropdown-content1" class="dropdown-content1 bg-info">
                <?php /**************** Suggestion Box using Javascript php starts************/
                    $sql = 'SELECT * FROM teacher';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $i = 1;
                    foreach($userData as $data){
                        $i++;
                        $name = 'select'.$i.'a'.$i;
                        $email = $data['email'];
                        $Tname = $data['name'];
                        $Tid = $data['id'];
                        echo '<span onclick="'.$name.'()">ID = '.$Tid.', Name = '.$Tname.', Email = '.$email.'</span></br>';
                        echo'<script>
                            function '.$name.'() {
                                var x = document.getElementById("tid");
                                var id = '.$Tid.';
                                x.setAttribute("value", id);
                            }
                        </script>';
                    }
                    /**************** Suggestion Box using Javascript php ends************/
                ?>
            </div>
        </div>
        
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button id="submit" type="submit" class="btn btn-primary">Add course</button>
        </div>
    </div>
</form>


<?php

if(isset($_POST['addCid'])&&isset($_POST['addCname'])&&isset($_POST['addTid'])){
    $addCid = $_POST['addCid'];
    $addCname = $_POST['addCname'];
    $addTid = $_POST['addTid'];
    $sql = 'SELECT * FROM courses WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $addCid]);
    $data2 = $stmt->fetch(PDO::FETCH_ASSOC);
    if($data2['id'] == $addCid){
        echo '<script type="text/JavaScript">  
             alert("Course already Exist!"); 
             </script>' 
        ;
    }else{
        $sql = "INSERT INTO courses(id, t_id, name) VALUES ( ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$addCid,$addTid,$addCname]);
        ob_end_clean( );
        header("Location:coursesEdit.php");
    }
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    var x = document.getElementById('dropdown-content1');
    var tid = document.getElementById('tid');
    var submit = document.getElementById('submit');
    tid.addEventListener('mouseover',function enableInpute(e){
        console.log(e.target+'e');
        tid.disabled = true;
    });
    submit.addEventListener('mouseover',function enableInputs(e){
        console.log(e.target+'s');
        tid.disabled = false;
    });

    function showOC1() {
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
        tid.disabled = true;
    }

    </script>

<?php

require 'footer.php';

?>