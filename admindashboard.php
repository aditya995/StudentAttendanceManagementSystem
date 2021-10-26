<?php
session_start();
require 'header.php';
if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
}else{
    header("Location:login.php");
}

?>
<?php 
    if(isset($_SESSION['status'])){
        echo '<h5 class="text-center text-white bg-success m-3 ">'.$_SESSION['status'].'</h5>';
        unset ($_SESSION['status']);
    }
?>

<h4 class="text-center card my-4 p-1 text-white text-monospace text-uppercase" style="background-color:#30475E">Admin Dashboard</h4>
<a href="edit.php"><button type="button" class="btn " style="background-color:white">Edit presonal information</button></a><br><br>
<a href="register.php"><button type="button" class="btn text-white" style="background-color:#30475E">Register New User</button></a>
<a href="usersEdit.php"><button type="button" class="btn text-white" style="background-color:#F05454">Delete existing users</button></a>
<a href="coursesEdit.php"><button type="button" class="btn " style="background-color:white">Add/Delete/Edit courses</button></a>
<a href="attendanceEdit.php"><button type="button" class="btn " style="background-color:white">Search/Edit Attendance</button></a>
<?php
require 'allLists.php';

require 'footer.php';

?>
