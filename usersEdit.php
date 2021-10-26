<?php
session_start();
ob_start( );
require 'header.php';
if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
}else{
    header("Location:login.php");
}


$rangeT = $_SESSION['rangeT'];
$rangeS = $_SESSION['rangeS'];
$rangeA = $_SESSION['rangeA'];

//Indices for query starting points

$indexT = $_SESSION['indexT'];
$indexS = $_SESSION['indexS'];
$indexA = $_SESSION['indexA'];

//Setting range values number of query each section

if(isset($_POST['rangeT'])){
    $_SESSION['rangeT'] = $_POST['rangeT'];
    $rangeT = $_SESSION['rangeT'];
}
if(isset($_POST['rangeS'])){
    $_SESSION['rangeS'] = $_POST['rangeS'];
    $rangeS = $_SESSION['rangeS'];
}
if(isset($_POST['rangeA'])){
    $_SESSION['rangeA'] = $_POST['rangeA'];
    $rangeA = $_SESSION['rangeA'];
}

//Navigation tabs' values

if(isset($_POST['Teacher'])){
    $_SESSION['tabRole'] = 'Teacher';
    header("Location:usersEdit.php");
}
if(isset($_POST['Student'])){
    $_SESSION['tabRole'] = 'Student';
    header("Location:usersEdit.php");
}
if(isset($_POST['Admin'])){
    $_SESSION['tabRole'] = 'Admin';
    header("Location:usersEdit.php");
}
if($_SESSION['tabRole'] == 'Course'){
    $_SESSION['tabRole'] = 'Admin';
    header("Location:usersEdit.php");
}

//Setting the left right navigation keys' values

if(isset($_POST['tl'])){
    $_SESSION['tabRole'] = 'Teacher';
    $_SESSION['tl'] = 1;
    $_SESSION['tr'] = 0;
    $indexFromLoop = $_SESSION['ti'];
    $sql = 'SELECT MIN(id) FROM teacher';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $firstID = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($firstID[0]['MIN(id)'] == $_SESSION['lIndexT'][0]){
        $_SESSION['indexT'] = $_SESSION['lIndexT'][$indexFromLoop] + 1;
    }else if($firstID[0]['MIN(id)'] < $_SESSION['lIndexT'][0]){
        $_SESSION['indexT']=$_SESSION['lIndexT'][0];
    }
    header("Location:usersEdit.php");
}else
if(isset($_POST['tr'])){
    $_SESSION['tabRole']='Teacher' ;
    $_SESSION['tr']=1;
    $_SESSION['tl']=0; 
    $indexFromLoop=$_SESSION['ti']; 
    $sql='SELECT MAX(id) FROM teacher' ; 
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $lastID = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($lastID[0]['MAX(id)'] > $_SESSION['lIndexT'][$indexFromLoop]){
        if($_SESSION['tl']==1){
            $_SESSION['indexT'] = $_SESSION['lIndexT'][0];
        }else{
            $_SESSION['indexT'] = $_SESSION['lIndexT'][$indexFromLoop];
        }
    }
    header("Location:usersEdit.php");
}else
if(isset($_POST['sl'])){
    $_SESSION['tabRole'] = 'Student';
    $_SESSION['sl'] = 1;
    $_SESSION['sr'] = 0;
    $indexFromLoop = $_SESSION['si'];
    $sql = 'SELECT MIN(id) FROM students';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $firstID = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($firstID[0]['MIN(id)'] == $_SESSION['lIndexS'][0]){
        $_SESSION['indexS'] = $_SESSION['lIndexS'][$indexFromLoop] + 1;
    }else if($firstID[0]['MIN(id)'] < $_SESSION['lIndexS'][0]){
        $_SESSION['indexS']=$_SESSION['lIndexS'][0];
    }
    header("Location:usersEdit.php");
}else
if(isset($_POST['sr'])){
    $_SESSION['tabRole']='Student' ;
    $_SESSION['sr']=1;
    $_SESSION['sl']=0;
    $indexFromLoop=$_SESSION['si']; 
    $sql='SELECT MAX(id) FROM students' ; 
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $lastID = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($lastID[0]['MAX(id)'] > $_SESSION['lIndexS'][$indexFromLoop]){
        if($_SESSION['sl']==1){
            $_SESSION['indexS'] = $_SESSION['lIndexS'][0];
        }else{
            $_SESSION['indexS'] = $_SESSION['lIndexS'][$indexFromLoop];
        }
    }
    header("Location:usersEdit.php");
}else
if(isset($_POST['al'])){
    $_SESSION['tabRole'] = 'Admin';
    $_SESSION['al'] = 1;
    $_SESSION['ar'] = 0;
    $indexFromLoop = $_SESSION['ai'];
    $sql = 'SELECT MIN(id) FROM admin';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $firstID = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($firstID[0]['MIN(id)'] == $_SESSION['lIndexA'][0]){
        $_SESSION['indexA'] = $_SESSION['lIndexA'][$indexFromLoop] + 1;
    }else if($firstID[0]['MIN(id)'] < $_SESSION['lIndexA'][0]){
        $_SESSION['indexA']=$_SESSION['lIndexA'][0]; 
    } 
    header("Location:usersEdit.php");
}else
if(isset($_POST['ar'])){
    $_SESSION['ar']=1;
    $_SESSION['al']=0;
    $_SESSION['tabRole']='Admin' ;
    $indexFromLoop=$_SESSION['ai'];
    $sql='SELECT MAX(id) FROM admin' ;
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $lastID = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($lastID[0]['MAX(id)'] > $_SESSION['lIndexA'][$indexFromLoop]){
        if($_SESSION['al']==1){
            $_SESSION['indexA'] = $_SESSION['lIndexA'][0];
        }else{
            $_SESSION['indexA'] = $_SESSION['lIndexA'][$indexFromLoop];
        }
    }
    header("Location:usersEdit.php");
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

    .active {
        background-color:#848484;
        color: aliceblue;
    }

    .hide {
        display: none;
    }

    /* Style the tab */
    
    /* Style the buttons inside the tab */
    .tab button {
        outline: none;
        cursor: pointer;
        transition: 0.3s;
    }

    /* Change background color of buttons on hover */
    

    .tablinks {
        height: 40px;
        margin: 0;
        padding: 0;
    }
    .edit,.delete,button {
        color: black;
        cursor: pointer;
    }
    .img {
        height: 50px;
        width: auto;
        max-width: 100px;
    }
    .a{
        background-color: white;
    }
    .bg-ac{
        background-color: #222831;
    }

</style>
<h4 class="text-center  card my-4 p-1 text-white text-monospace text-uppercase" style="background-color:#30475E">Delete Users</h4>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="p-1">
    <div class="row col-12 m-3">
        <!--***************************************Heading*************************************-->
        <div class="tabhead row col-12">
            <button name="Teacher" class="tablinks <?php if($_SESSION['tabRole'] == 'Teacher'){echo 'active bg-ac';}?> col-4 text-center" onmouseover="openTab(event, 'Teacher')">
                <h4 class="font-weight-light">Teacher</h4>
            </button>
            <button name="Student" class="tablinks <?php if($_SESSION['tabRole'] == 'Student'){echo 'active bg-ac';}?> col-4 text-center" onmouseover="openTab(event, 'Student')">
                <h4 class="font-weight-light">Student</h4>
            </button>
            <button name="Admin" class="tablinks <?php if($_SESSION['tabRole'] == 'Admin'){echo 'active bg-ac';}?> col-4 text-center" onmouseover="openTab(event, 'Admin')">
                <h4 class="font-weight-light">Admin</h4>
            </button>
        </div>
        
        <!--***************************************Teacher*************************************-->
        <div id="Teacher" class="tab <?php if($_SESSION['tabRole'] != 'Teacher'){echo 'hide';}?> tabcontent row col-xl-12 p-2">

            <h3 class="text-center col-12 font-weight-light"> Teachers lists:</h3>
            <?php  
                if($_SESSION['tl']==1){
                    $_SESSION['tl'] = 1;
                    $sql = "SELECT * FROM teacher WHERE id < $indexT ORDER BY id DESC LIMIT $rangeT";
                }else if($_SESSION['tr']==1){
                    $_SESSION['tr'] = 1;
                    $sql = "SELECT * FROM teacher WHERE id > $indexT LIMIT $rangeT";
                }
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="row col-12">
                <div class="col-2  text-center  form-control">ID_no:</div>
                <div class="col-5  text-center  form-control">Name:</div>
                <div class="col-5  text-center  form-control">Email:</div>
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
                <div class="col-2  selectAll text-center text-dark font-weight-normal a card"><?php echo ''.$info['id'].'';?></div>
                <div class="col-4  selectAll text-center text-dark font-weight-normal a card"><?php echo $info['name']."<br><center><img class=\"img bg-light rounded\" src='images/".$info['image']."' > </center> <br>";?></div>
                <div class="col-4  selectAll text-center text-dark font-weight-normal a card"><?php echo $info['email'];?></div>
                <div class="col-2 text-center font-weight-bolder bg-danger form-control delete" type="button" data-toggle="modal" data-target="#myModaldT<?php echo $info['id']?>">
                    <span>Delete</span>
                </div>
                    <!-- Modal -->
                <div class="modal fade" id="myModaldT<?php echo $info['id']?>" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                             <h4 class="modal-title">Delete Teacher ?</h4>
                              <button type="button" class="close bg-secondary card" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                              <div id="">Teacher ID : <?php echo $info['id']?></div>

                              <div class="form-group">
                                  <label for="email">
                                      <pre>Teacher name : <?php echo $info['name']?></pre>
                                  </label>
                              </div>
                              <div class="form-group">
                                  <label for="email">
                                      <pre>Email address : <?php echo $info['email']?></pre>
                                  </label>
                              </div>

                              <button name="deleteT<?php echo $info['id']?>" class="btn btn-danger">Delete</button>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default bg-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $elementID = 'deleteT'.$info['id'];
                    $emailD = $info['email'];
                    $t_ID = $info['id'];
                    if(isset($_POST[$elementID])){
                        $sql = 'DELETE FROM users WHERE email = :email';
                        if($info['image'] != 'default.jpg'){
                            $strT = "images/".$info['image'];
                            unlink($strT);
                        }
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':email'=>$emailD]);
                        
                        $sql = 'DELETE FROM teacher WHERE email = :email';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':email'=>$emailD]);
                        
                        $sql = 'UPDATE `courses` SET `t_id`= -1 WHERE t_id = :t_id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':t_id'=>$t_ID]);
                        ob_end_clean( );
                        header("Location:usersEdit.php");
                        //exit();
                    }
                ?>
                <?php }?>
                <div class="col-4  text-center">
                    <button name="tl" class="col-12  form-control">&#x022D8;</button>
                </div>
                <div class="col-4  text-center">
                    <button name="tr" class="col-12  form-control">&#x022D9;</button>
                </div>
                <div class="col-4 ">
                    <select class="form-control" name="rangeT">
                        <option <?php if(isset($_SESSION['rangeT'])&&$_SESSION['rangeT']==1){echo 'selected';}?>>1</option>
                        <option <?php if(isset($_SESSION['rangeT'])&&$_SESSION['rangeT']==2){echo 'selected';}?>>2</option>
                        <option <?php if(isset($_SESSION['rangeT'])&&$_SESSION['rangeT']==3){echo 'selected';}?>>3</option>
                        <option <?php if(isset($_SESSION['rangeT'])&&$_SESSION['rangeT']==4){echo 'selected';}?>>4</option>
                        <option <?php if(isset($_SESSION['rangeT'])&&$_SESSION['rangeT']==5){echo 'selected';}?>>5</option>
                    </select>
                </div>
            </div>
        </div>
        <!--***************************************Student*************************************-->
        <div id="Student" class="tab <?php if($_SESSION['tabRole'] != 'Student'){echo 'hide';}?> tabcontent row col-xl-12 p-2">

            <h3 class="text-center col-12 font-weight-light"> Students lists</h3>
            <?php
                if($_SESSION['sl']==1){
                    $_SESSION['sl'] = 1;
                    $sql = "SELECT * FROM students WHERE id < $indexS ORDER BY id DESC LIMIT $rangeS";
                }else if($_SESSION['sr']==1){
                    $_SESSION['sr'] = 1;
                    $sql = "SELECT * FROM students WHERE id > $indexS LIMIT $rangeS";
                }
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="row col-12">
                <div class="col-2  text-center  form-control">ID_no:</div>
                <div class="col-5  text-center  form-control">Name:</div>
                <div class="col-5  text-center  form-control">Email:</div>
                <?php 
                $i = 0;
                $array = array();
                if($_SESSION['sl']==1){
                    sort($data);//echo '<h6 class="col-12">l cl'.$_SESSION['sl'].' </h6>';
                }
                foreach($data as $info) {
                    $array[$i++] = $info['id'];
                    $_SESSION['si'] = $i-1;
                    $_SESSION['lIndexS'][$i-1] = $info['id'];
                    //echo '<h6 class="col-12"> $_SESSION[\'lIndexS\'][$i-1] = '.$_SESSION['lIndexS'][$i-1].' $_SESSION[\'si\'] = '.$_SESSION['si'].' </h6>';
                ?>
                <div class="col-2  selectAll text-center text-dark font-weight-normal a card"><?php echo ''.$info['id'].'';?></div>
                <div class="col-4  selectAll text-center text-dark font-weight-normal a card"><?php echo $info['name']."<br><center><img class=\"img bg-light rounded\" src='images/".$info['image']."' > </center> <br>";?></div>
                <div class="col-4  selectAll text-center text-dark font-weight-normal a card"><?php echo $info['email'];?></div>
                <div class="col-2 text-center font-weight-bolder bg-danger form-control delete" type="button" data-toggle="modal" data-target="#myModaldS<?php echo $info['id']?>">
                    <span>Delete</span>
                </div>
                    <!-- Modal -->
                <div class="modal fade" id="myModaldS<?php echo $info['id']?>" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                             <h4 class="modal-title">Delete Student ?</h4>
                              <button type="button" class="close bg-secondary card" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                              <div id="">Student ID : <?php echo $info['id']?></div>

                              <div class="form-group">
                                  <label for="email">
                                      <pre>Student name : <?php echo $info['name']?></pre>
                                  </label>
                              </div>
                              <div class="form-group">
                                  <label for="email">
                                      <pre>Email address : <?php echo $info['email']?></pre>
                                  </label>
                              </div>

                              <button name="deleteS<?php echo $info['id']?>" class="btn btn-danger">Delete</button>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default bg-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $elementID = 'deleteS'.$info['id'];
                    $emailD = $info['email'];
                    $S_ID = $info['id'];
                    if(isset($_POST[$elementID])){
                        $sql = 'DELETE FROM users WHERE email = :email';
                        if($info['image'] != 'default.jpg'){
                            $strS = "images/".$info['image'];
                            unlink($strS);
                        }
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':email'=>$emailD]);
                        
                        $sql = 'DELETE FROM students WHERE email = :email';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':email'=>$emailD]);
                        
                        $sql = 'DELETE FROM attendance WHERE s_id = :s_id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':s_id'=>$S_ID]);
                        
                        ob_end_clean( );
                        header("Location:usersEdit.php");
                        //exit();
                    }
                ?>
                <?php }?>
                <div class="col-4  text-center">
                    <input type="submit" name="sl" value="&#x022D8;" class="col-12  form-control"></input>
                </div>
                <div class="col-4  text-center">
                    <input type="submit" name="sr" value="&#x022D9;" class="col-12  form-control"></input>
                </div>
                <div class="col-4 ">
                    <select class="form-control" name="rangeS">
                        <option <?php if(isset($_SESSION['rangeS'])&&$_SESSION['rangeS']==1){echo 'selected';}?>>1</option>
                        <option <?php if(isset($_SESSION['rangeS'])&&$_SESSION['rangeS']==2){echo 'selected';}?>>2</option>
                        <option <?php if(isset($_SESSION['rangeS'])&&$_SESSION['rangeS']==3){echo 'selected';}?>>3</option>
                        <option <?php if(isset($_SESSION['rangeS'])&&$_SESSION['rangeS']==4){echo 'selected';}?>>4</option>
                        <option <?php if(isset($_SESSION['rangeS'])&&$_SESSION['rangeS']==5){echo 'selected';}?>>5</option>
                    </select>
                </div>
            </div>
        </div>
        <!--***************************************Admin*************************************-->
        <div id="Admin" class="tab <?php if($_SESSION['tabRole'] != 'Admin'){echo 'hide';}?> tabcontent row col-xl-12 p-2">


            <h3 class="text-center col-12 font-weight-light"> Admins lists</h3>
            <?php
                if($_SESSION['al']==1){
                    $_SESSION['al'] = 1;
                    $sql = "SELECT * FROM admin WHERE id < $indexA ORDER BY id DESC LIMIT $rangeA";
                }else if($_SESSION['ar']==1){
                    $_SESSION['ar'] = 1;
                    $sql = "SELECT * FROM admin WHERE id > $indexA LIMIT $rangeA";
                }
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="row col-12">
                <div class="col-2  text-center  form-control">ID_no:</div>
                <div class="col-5  text-center  form-control">Name:</div>
                <div class="col-5  text-center  form-control">Email:</div>
                <?php 
                $i = 0;
                $array = array();
                if($_SESSION['al']==1){
                    sort($data);//echo '<h6 class="col-12">l cl'.$_SESSION['sl'].' </h6>';
                }
                foreach($data as $info) {
                    $array[$i++] = $info['id'];
                    $_SESSION['ai'] = $i-1;
                    $_SESSION['lIndexA'][$i-1] = $info['id'];
                    //echo '<h6 class="col-12"> $_SESSION[\'lIndexA\'][$i-1] = '.$_SESSION['lIndexA'][$i-1].' $_SESSION[\'ai\'] = '.$_SESSION['ai'].' </h6>';
                ?>
                <div class="col-2  selectAll text-center text-dark font-weight-normal a card"><?php echo ''.$info['id'].'';?></div>
                <div class="col-4  selectAll text-center text-dark font-weight-normal a card"><?php echo $info['name']."<br><center><img class=\"img bg-light rounded\" src='images/".$info['image']."' > </center> <br>";?></div>
                <div class="col-4  selectAll text-center text-dark font-weight-normal a card"><?php echo $info['email'];?></div>
                <div class="col-2 text-center font-weight-bolder form-control delete" style="background-color:#F05454" type="button" data-toggle="modal" data-target="#myModaldA<?php echo $info['id']?>">
                    <span>Delete</span>
                </div>
                    <!-- Modal -->
                <div class="modal fade" id="myModaldA<?php echo $info['id']?>" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                             <h4 class="modal-title">Delete Admin ?</h4>
                              <button type="button" class="close bg-secondary card" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                              <div id="">Admin ID : <?php echo $info['id']?></div>

                              <div class="form-group">
                                  <label for="email">
                                      <pre>Admin name : <?php echo $info['name']?></pre>
                                  </label>
                              </div>
                              <div class="form-group">
                                  <label for="email">
                                      <pre>Email address : <?php echo $info['email']?></pre>
                                  </label>
                              </div>

                              <button name="deleteA<?php echo $info['id']?>" class="btn" style="background-color:#F05454">Delete</button>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default bg-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $elementID = 'deleteA'.$info['id'];
                    $emailD = $info['email'];
                    if(isset($_POST[$elementID])){
                        $sql = 'DELETE FROM users WHERE email = :email';
                        if($info['image'] != 'default.jpg'){
                            $strA = "images/".$info['image'];
                            unlink($strA);
                        }
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':email'=>$emailD]);
                        
                        $sql = 'DELETE FROM admin WHERE email = :email';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':email'=>$emailD]);
                        
                        ob_end_clean( );
                        header("Location:usersEdit.php");
                    }
                ?>
                <?php }?>
                <div class="col-4  text-center">
                    <button name="al" class="col-12  form-control">&#x022D8;</button>
                </div>
                <div class="col-4  text-center">
                    <button name="ar" class="col-12  form-control">&#x022D9;</button>
                </div>
                <div class="col-4 ">
                    <select class="form-control" name="rangeA">
                        <option <?php if(isset($_SESSION['rangeA'])&&$_SESSION['rangeA']==1){echo 'selected';}?>>1</option>
                        <option <?php if(isset($_SESSION['rangeA'])&&$_SESSION['rangeA']==2){echo 'selected';}?>>2</option>
                        <option <?php if(isset($_SESSION['rangeA'])&&$_SESSION['rangeA']==3){echo 'selected';}?>>3</option>
                        <option <?php if(isset($_SESSION['rangeA'])&&$_SESSION['rangeA']==4){echo 'selected';}?>>4</option>
                        <option <?php if(isset($_SESSION['rangeA'])&&$_SESSION['rangeA']==5){echo 'selected';}?>>5</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>

<script>/*
    function openTab(evt, role) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(role).style.display = "block";
        evt.currentTarget.className += " active";
    }
    /*
    // executes after every 1 second;
    var myVar = setInterval(myFunction, 1000);
    //Toggle func
    function myFunction() {
        var x = document.getElementById("a");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
    var myVar = setTimeout(myFunction, 1000);

    function myFunction() {
        var i, tabcontent;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length - 1; i++) {
            tabcontent[i].className += " hide";
        }
    }*/

</script>

<?php

require 'footer.php';

?>