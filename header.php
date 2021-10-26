<?php

if(isset($_SESSION['role'])){
    require 'config.php';
}else{
    header("Location:login.php");
}
if($_SESSION['role'] == 'Admin'){
    $sql = 'SELECT * FROM admin WHERE email = :email';
}else if($_SESSION['role'] == 'Teacher'){
    $sql = 'SELECT * FROM teacher WHERE email = :email';
} else if($_SESSION['role'] == 'Student'){
    $sql = 'SELECT * FROM students WHERE email = :email';
}
$email = $_SESSION['email'];
$stmt = $pdo->prepare($sql);
$stmt->execute(['email'=>$email]);
$dataT = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['name'] = $dataT['name'];
$_SESSION['id'] = $dataT['id'];
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Attendance management system</title>
</head>

<body>
    <div class="container main " style="background-color: #DDDDDD"><br>
        <h2 class="text-center font-weight-normal">Attendance management system</h2><br>
        <img src="images/<?php echo $dataT['image'];?>" alt="" class="rounded-circle">
        <h6 class="font-weight-light">Username : <?php echo $_SESSION['name'].'<br>ID no : '.$_SESSION['id'];?> <br>logged in as : <?php echo $_SESSION['role'];?> <br> Email => <?php echo $_SESSION['email'];?></h6>
        <a href="index.php" class="badge btn-light text-dark"><h6>Home</h6></a>
        <a href="logout.php"><button type="button" class="btn font-weight-bolder font-italic float-right" style="background-color:#F05454">Logout</button></a>
        <br>
        <br>
