<?php
    session_start();
    if(isset($_SESSION['email'])){
        
    }else{
        header("Location:login.php");
    }
	if($_SESSION['role'] == 'Teacher'){
        echo '<h4><a href="teacherdashboard.php">Go to dashboard</a></h4>';
        header("Location:teacherdashboard.php");
	}else if($_SESSION['role'] == 'Student'){
        echo '<h4><a href="studentdashboard.php">Go to dashboard</a></h4>';
        header("Location:studentdashboard.php");
    }else if($_SESSION['role'] == 'Admin'){
        echo '<h4><a href="admindashboard.php">Go to dashboard</a></h4>';
        header("Location:admindashboard.php");
    }

?>
