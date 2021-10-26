<?php 
session_start();
if(isset($_SESSION['email'])){
    header("Location:index.php");
}
require 'config.php';
if(isset($_POST['email'])&&isset($_POST['pswd'])){
    $email = $_POST['email'];
    $pass = $_POST['pswd'];
    $passHash = md5($pass);
//# PREPARED STATEMENTS (prepare & execute)
    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user['email'] == $email){
        if($user['passHash'] == $passHash){
            require 'sessionVariables.php';
            header("Location:index.php");
        }else{
            $_SESSION['status'] = 'Incorrect password';
        }
    }else{
        $_SESSION['status'] = 'Email is not resigtered';
    }
}

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
    <style>
        .row-of-icons {
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

        .dropdown1 {
            display: inline-block;
            cursor: default;
        }

        .dropdown2 {
            display: inline-block;
            cursor: default;
        }

        .dropdown1:hover .dropdown-content1 {
            display: block;
        }

        .dropdown2:hover .dropdown-content2 {
            display: block;
        }

        .dropdown-content1 {
            display: none;
            position: absolute;
            background-color: #DDDDDD;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 5;
        }

        .dropdown-content2 {
            display: none;
            position: absolute;
            background-color: #DDDDDD;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content1 span:hover {
            color: aliceblue;
            height: 25px;
            background-color: #DDDDDD;
            padding: 0vw 2vw;
            margin: 0px 0px;
            cursor: pointer;
        }

        .dropdown-content2 span:hover {
            color: aliceblue;
            height: 25px;
            background-color: #DDDDDD;
            padding: 0vw 2vw;
            margin: 0px 0px;
            cursor: pointer;
        }

        .dropdown-content1 span {
            margin: 0px 0px;
            padding: 0vw 2vw;
            height: 15px;
        }

        .dropdown-content2 span {
            margin: 0px 0px;
            padding: 0vw 2vw;
            height: 15px;
        }
        .a{
            background-color: #DDDDDD;
        }
        .b{
            background-color: #30475E;
        }
        .c{
            background-color: black;
        }
        input:checked{
            color: green;
        }

    </style>
</head>

<body>
    <div class="container main a col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        <?php 
        if(isset($_SESSION['status'])){
            echo '<h5 class="text-center text-danger bg-info m-3 ">'.$_SESSION['status'].'</h5>';
        }
        ?>
        <h3 class="text-center font-weight-light">Attendance management system</h3><br>
        <h4 class="text-center font-weight-light">Login Page:</h4><br>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="was-validated">
            <div class="form-group">
                <label for="">
                    <pre>Email     : </pre>
                </label>
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" value="" required>
<!--
                <div class="valid-feedback">Not empty.</div>
                <div class="invalid-feedback">Enter your registered email.</div>
-->
                <!-- ************************ Suggestion Box using Javascript html starts*******************-->
                <div id="" class="dropdown1" onclick="showOC1();">
                    <h4 class="b p-3 row-of-icons text-white">emails <small><pre>click me! for suggestions</pre></small></h4>
                    <div id="dropdown-content1" class="dropdown-content1 ">
                        <?php /**************** Suggestion Box using Javascript php starts************/
                            $sql = 'SELECT * FROM users';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $i = 1;
                            foreach($userData as $data){
                                $i++;
                                $name = 'select'.$i.'a'.$i;
                                $email = $data['email'];
                                $role = $data['role'];
                                echo '<span onclick="'.$name.'()"data-toggle="tooltip" data-placement="right" title="'.$role.'">'.$email.'</span></br>';
                                echo'<script>
                                    function '.$name.'() {
                                        var x = document.getElementById("email");
                                        var email = "'.$email.'";
                                        x.setAttribute("value", email);
                                    }
                                </script>';
                            }
                            /**************** Suggestion Box using Javascript php ends************/
                        ?>
                    </div>
                </div>
                <!-- ************************ Suggestion Box using Javascript html ends*******************-->
            </div>
            <div class="form-group">
                <label for="">
                    <pre>Password  : </pre>
                </label>
                <input type="text" class="form-control pin" id="pwd" placeholder="Enter password" value="" name="pswd" required>
<!--
                <div class="valid-feedback">Not empty.</div>
                <div class="invalid-feedback">Enter your password.</div>
-->
                <!-- ************************ Suggestion Box using Javascript html starts*******************-->
                <div id="" class="dropdown2" onclick="showOC2();">
                    <h4 class="b p-3 row-of-icons text-white">Passwords<small><pre>click me! for suggestions</pre></small></h4>
                    <div id="dropdown-content2" class="dropdown-content2 ">
                        <?php /**************** Suggestion Box using Javascript php starts************/
                            $sql = 'SELECT * FROM users';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $userDatap = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $i = 1;
                            foreach($userDatap as $data){
                                $i++;
                                $name = 'select'.$i;
                                $email = $data['email'];
                                if($data['role'] == 'Admin'){
                                    $sql = 'SELECT * FROM admin WHERE email = :email';
                                }else if($data['role'] == 'Teacher'){
                                    $sql = 'SELECT * FROM teacher WHERE email = :email';
                                } else if($data['role'] == 'Student'){
                                    $sql = 'SELECT * FROM students WHERE email = :email';
                                }
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute(['email'=>$email]);
                                $uData = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo '<span onclick="'.$name.'()"data-toggle="tooltip" data-placement="right" title="'.$data['role'].'Name ->[ '.$uData['name' ].']">'.$data['email'].'--> '.$uData['id'].' </span></br>';
                                echo'<script>
                                    function '.$name.'() {
                                        var x = document.getElementById("pwd");
                                        var pass = "'.$data['pass'].'";
                                        x.setAttribute("value", pass);
                                    }
                                    </script>';
                            }
                            /**************** Suggestion Box using Javascript php ends************/
                        ?>
                    </div>
                </div>
                <!-- ************************ Suggestion Box using Javascript html ends*******************-->
            </div>
            <input checked type="checkbox" onclick="myFunction()">Show Password
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="submit" type="submit" class="btn c text-white">Submit</button>
                </div>
            </div>
        </form>
        <br>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
	-->
    <script>
        function myFunction() {
            var x = document.getElementsByClassName("pin");
            for (i = 0; i < x.length; i++) {
                if (x[i].type === "password") {
                    x[i].type = "text";
                } else {
                    x[i].type = "password";
                }
            }

        }
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        var x = document.getElementById('dropdown-content1');
        var y = document.getElementById('dropdown-content2');
        var inEmail = document.getElementById('email');
        var inPwd = document.getElementById('pwd');
        var submit = document.getElementById('submit');
        inEmail.addEventListener('mouseover',function enableInpute(e){
            console.log(e.target+'e');
            inEmail.disabled = true;
        });
        inPwd.addEventListener('mouseover',function enableInputp(e){
            console.log(e.target+'p');
            inPwd.disabled = true;
        });
        submit.addEventListener('mouseover',function enableInputs(e){
            console.log(e.target+'s');
            inEmail.disabled = false;
            inPwd.disabled = false;
//            inPwd.setAttribute("disabled","none");
        });
        
        function showOC1() {
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
            inEmail.disabled = true;
            //console.log("showOC1");
        }

        function showOC2() {
            if (y.style.display === "none") {
                y.style.display = "block";
            } else {
                y.style.display = "none";
            }
            inPwd.setAttribute("disabled","disabled");
            //console.log("showOC2");
        }
        /*
        function showOMO1() {
            x.style.display = "block";
            //console.log("showOMO1");
        }

        function showOMO2() {
            y.style.display = "block";
            //console.log("showOMO2");
        }
        
        function hideOMO1() {
            x.style.display = "none";
            //console.log("hideOMO1");
        }

        function hideOMO2() {
            y.style.display = "none";
            //console.log("hideOMO2");
        }
        */
        

    </script>
</body>

</html>
