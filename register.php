<?php
error_reporting(0); //Error reporting off
session_start();
require 'header.php';
if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
    if(isset($_POST['uname']) && isset($_POST['id']) && isset($_POST['submit']) && isset($_POST['email']) && isset($_POST['pswd1']) && isset($_POST['pswd2'])&&($_POST['pswd1']==$_POST['pswd2'])){
        $email = $_POST['email'];
        $name = $_POST['uname'];
        $emailCheck = $_POST["email"];
        // check if e-mail address is well-formed
        $emailErr = 0;
        if (!filter_var($emailCheck, FILTER_VALIDATE_EMAIL)) {
          $emailErr = 1;
            echo '<script type="text/JavaScript">  
                     alert("Invalid Email!"); 
                     </script>' 
                ;
        }if($emailErr == 0){
            $pass = $_POST['pswd1'];
            $role = $_POST['role'];
            $id = $_POST['id'];
            $passHash = md5($pass);
            $sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if($role == 'Admin'){
                $sql = 'SELECT * FROM admin WHERE id = :id';
            }else if($role == 'Teacher'){
                $sql = 'SELECT * FROM teacher WHERE id = :id';
            }else if($role == 'Student'){
                $sql = 'SELECT * FROM students WHERE id = :id';
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $data2 = $stmt->fetch(PDO::FETCH_ASSOC);
            if($data['email'] == $email){
                echo '<script type="text/JavaScript">  
                     alert("Email already Registered!"); 
                     </script>' 
                ; 
            }else if($data2['id'] == $id){
                echo '<script type="text/JavaScript">  
                     alert("ID already Registered!"); 
                     </script>' 
                ; 
            }else{
                $sql = 'INSERT INTO users(email, role, pass, passHash) VALUES (:email, :role, :pass, :passHash)';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['email' => $email, 
                                'role' => $role, 
                                'pass' => $pass,
                                'passHash' => $passHash]);
                if($role == 'Admin'){
                    $sql = 'INSERT INTO admin(email, id, name, image) VALUES (:email, :id, :name, "default.jpg" )';
                }else if($role == 'Teacher'){
                    $sql = 'INSERT INTO teacher(email, id, name, image) VALUES (:email, :id, :name, "default.jpg" )';
                }else if($role == 'Student'){
                    $sql = 'INSERT INTO students(email, id, name, image) VALUES (:email, :id, :name, "default.jpg" )';
                }
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['email' => $email,
                               'id' => $id,
                               'name'=>$name]);
                $sql = 'SELECT * FROM users WHERE email = :email';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['email' => $email]);
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['status'] = 'Registration Successful!';
                echo '<script type="text/JavaScript">  
                     alert("Registration Successful!"); 
                     </script>' 
                ; 
            }
        }
    }
}else{
    header("Location:index.php");
}

?>

<h4 class="text-center  card my-4 p-1 text-white text-monospace text-uppercase" style="background-color:#30475E">Registration Page</h4>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="was-validated  card card-body">
    <div class="form-inline">
        <label for="uname">
            <pre>Give username   : </pre>
        </label>
        <input type="text" class="form-control" id="uname" placeholder="Enter Username" name="uname" required>
        <div class="valid-feedback">Not empty.</div>
        <div class="invalid-feedback">Give a Username.</div>
    </div>
    <div class="form-inline">
        <label for="email">
            <pre>Give email      : </pre>
        </label>
        <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required>
        <div class="valid-feedback">Not empty.</div>
        <div class="invalid-feedback">Give a valid email address.</div>
    </div>
    <div class="form-inline">
        <label for="id">
            <pre>Give ID number  : </pre>
        </label>
        <input type="number" class="form-control" id="id" placeholder="Enter ID number" name="id" required>
        <div class="valid-feedback">Not empty.</div>
        <div class="invalid-feedback">Give a valid ID number.</div>
    </div>
    <div class="form-inline">
        <label for="role">
            <pre>Applying as     : </pre>
        </label>
        <select class="form-control" id="role" name="role">
            <option>Student</option>
            <option>Teacher</option>
            <option>Admin</option>
        </select>
    </div><br>
    <div class="form-inline">
        <label for="pwd1">
            <pre>Enter password  : </pre>
        </label>
        <input type="password" class="form-control pin" id="pwd1" placeholder="Enter password" name="pswd1" required>
        <div id="inpass1" class="valid-feedback">Matching in progress...</div>
        <div class="invalid-feedback">Give approprieate password.</div>
    </div>
    <div class="form-inline">
        <label for="pwd2">
            <pre>Retype password : </pre>
        </label>
        <input type="password" class="form-control pin" id="pwd2" placeholder="Enter password" name="pswd2" required>
        <div id="inpass2" class="valid-feedback">Matching in progress...</div>
        <div class="invalid-feedback">Retype same password.</div>
    </div>
    <input type="checkbox" onclick="myFunction()">Show Password
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" type="submit" class="btn btn-light">Submit</button>
        </div>
    </div>
</form>
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
    var input1 = document.getElementById('pwd1');
    var input2 = document.getElementById('pwd2');
    input1.addEventListener('keyup', runEvent1);
    input2.addEventListener('keyup', runEvent2);
    var p1 = document.getElementById('inpass1');
    var p2 = document.getElementById('inpass2');

    function matched() {
        p1.innerHTML = 'Mached!!';
        p2.innerHTML = 'Mached!!';
        var in1 = $("#inpass1");
        var in2 = $("#inpass2");
        in1.css("color", "green");
        in2.css("color", "green");
    }

    function notMatched() {
        p1.innerHTML = 'Not Mached!!';
        p2.innerHTML = 'Not Mached!!';
        var in1 = $("#inpass1");
        var in2 = $("#inpass2");
        in1.css("color", "red");
        in2.css("color", "red");
    }

    function runEvent1(e) {
        if (input2.value === e.target.value) {
            matched();
        } else {
            notMatched();
        }
    }

    function runEvent2(e) {
        if (input1.value === e.target.value) {
            matched();
        } else {
            notMatched();
        }
    }

</script>

<?php require 'footer.php'; ?>
