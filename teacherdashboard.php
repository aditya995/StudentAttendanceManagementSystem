<?php
session_start();
require 'header.php';
if(isset($_SESSION['role']) && $_SESSION['role'] == 'Teacher'){}
else{
    header("Location:login.php");
}
?>

<h4 class="text-center  card my-4 p-1 text-white text-monospace text-uppercase" style="background-color:#30475E">teacher Dashboard</h4>
<a href="edit.php"><button type="button" class="btn " style="background-color:white">Edit presonal information</button></a>
<a href="attendanceEdit.php"><button type="button" class="btn " style="background-color:white">Search/Edit Attendance</button></a>
<a href="attendanceTake.php"><button type="button" class="btn btn-success">Take Attendance</button></a>

<?php
require 'allLists.php';

require 'footer.php';

?>
