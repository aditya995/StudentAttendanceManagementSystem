<?php
session_start();
require 'header.php';
$email = $_SESSION['email'];
if($_SESSION['role'] == 'Admin'){
    $sql = 'SELECT * FROM admin WHERE email = :email';
}else if($_SESSION['role'] == 'Teacher'){
    $sql = 'SELECT * FROM teacher WHERE email = :email';
} else if($_SESSION['role'] == 'Student'){
    $sql = 'SELECT * FROM students WHERE email = :email';
}else{
    header("Location:index.php");
}
$stmt = $pdo->prepare($sql);
$stmt->execute(['email'=>$email]);
$dataT = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['name'] = $dataT['name'];
$sql = 'SELECT * FROM users WHERE email = :email';
$stmt = $pdo->prepare($sql);
$stmt->execute(['email'=>$email]);
$dataU = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['pass'] = $dataU['pass'];
if(isset($_SESSION['role'])){
    if(isset($_POST['submit']) && isset($_POST['name']) && isset($_POST['pswd'])){
        $name = $_POST['name'];
        $email = $_SESSION['email'];
        $pass = $_POST['pswd'];
        $passHash = md5($pass);
        // Get image name
        $image = $_FILES['image']['name'];
        if(strlen($image) < 1){
            $image = $dataT['image'];
        }else{
            $imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));
            $str = $dataT['image'];
            $st1 = strrchr($str,".");
            $str1 = rtrim($str,$st1);
            $st2 = strrchr($str1,".");
            $str2 = rtrim($str1,$st2);
            if($dataT['image'] == 'default.jpg'){
                $image = $dataT['email'].'.'.time().'.'.$imageFileType;
            }else{
                $delImg = "images/".$dataT['image'];
                unlink($delImg);
                $str2 = $str2.'.'.time().$st1;
                $image = $str2;
            }
        }
        if(strlen($pass) < 1){
            $pass = $dataU['pass'];
            $passHash = $dataU['passHash'];
        }
        // image file directory
        $target = "images/".basename($image);
        //Update data name in their own table
        if($_SESSION['role'] == 'Admin'){
            $sql = 'UPDATE admin SET name = :name, image = :image WHERE email = :email';
        }else if($_SESSION['role'] == 'Teacher'){
            $sql = 'UPDATE teacher SET name = :name, image = :image WHERE email = :email';
        } else if($_SESSION['role'] == 'Student'){
            $sql = 'UPDATE students SET name = :name, image = :image WHERE email = :email';
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name'=>$name, 'image'=>$image, 'email'=>$email]);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
            /*****************************************Resize*********************************************/
            function load_image($filename, $type) {
                if( $type == IMAGETYPE_JPEG ) {
                    $image = imagecreatefromjpeg($filename);
                }
                elseif( $type == IMAGETYPE_PNG ) {
                    $image = imagecreatefrompng($filename);
                }
                elseif( $type == IMAGETYPE_GIF ) {
                    $image = imagecreatefromgif($filename);
                }
                return $image;
            }
            function resize_image($new_width, $new_height, $image, $width, $height) {
                $new_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                return $new_image;
            }
            function resize_image_to_width($new_width, $image, $width, $height) {
                $ratio = $new_width / $width;
                $new_height = $height * $ratio;
                return resize_image($new_width, $new_height, $image, $width, $height);
            }
            function resize_image_to_height($new_height, $image, $width, $height) {
                $ratio = $new_height / $height;
                $new_width = $width * $ratio;
                return resize_image($new_width, $new_height, $image, $width, $height);
            }
            function scale_image($scale, $image, $width, $height) {
                $new_width = $width * $scale;
                $new_height = $height * $scale;
                return resize_image($new_width, $new_height, $image, $width, $height);
            }
            function save_image($new_image, $new_filename, $new_type='jpeg', $quality=80) {
                if( $new_type == 'jpeg' ) {
                    imagejpeg($new_image, $new_filename, $quality);
                 }
                 elseif( $new_type == 'png' ) {
                    imagepng($new_image, $new_filename);
                 }
                 elseif( $new_type == 'gif' ) {
                    imagegif($new_image, $new_filename);
                 }
            }
            /* Testing the above code */

            $filename = $target;
            list($width, $height, $type) = getimagesize($filename);
            $old_image = load_image($filename, $type);

            //$new_image = resize_image(280, 180, $old_image, $width, $height);
            //$image_width_fixed = resize_image_to_width(560, $old_image, $width, $height);
            $image_height_fixed = resize_image_to_height(100, $old_image, $width, $height);
            //$image_scaled = scale_image(0.8, $old_image, $width, $height);

            //save_image($new_image, 'wallpapers/resized-'.basename($filename), 'jpeg', 75);
            //save_image($image_width_fixed, 'wallpapers/fixed-width-'.basename($filename), 'jpeg', 75);
            save_image($image_height_fixed, "images/".basename($filename), 'jpeg', 95);
            //save_image($image_scaled, 'wallpapers/scaled-'.basename($filename), 'jpeg', 75);
            /*****************************************Resize*********************************************/
        }else{
            $msg = "Failed to upload image";
        }
        // Update data pass and passHash in users table
        $sql = 'UPDATE users SET pass = :pass, passHash = :passHash WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['pass'=>$pass,
                        'passHash'=>$passHash,
                        'email'=>$email]);
        $_SESSION['name'] = $name;
        $_SESSION['pass'] = $pass;
        
        header("Location:edit.php");
    }

}else{
    header("Location:index.php");
}

?>
<style>
    .img {
        height: 100px;
        width: auto;
    }
</style>
<h4 class="text-center card my-4 p-1 text-white text-monospace text-uppercase" style="background-color:#30475E">Edit your <?php echo $_SESSION['role'];?> profile info</h4>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" class="was-validated " enctype="multipart/form-data">
    <div class="form-inline">
        <label for="name">
            <pre>Name     : </pre>
        </label>
        <input type="text" class="form-control" id="name" placeholder="Place new name" name="name" value="<?php echo $_SESSION['name'];?>" required>
        <div class="invalid-feedback">Give new name! <br>Current name is : <span style="font-size:24px"><?php echo $_SESSION['name'];?></span></div>
        <div class="valid-feedback">Give new name! <br>Current name is : <span style="font-size:24px"><?php echo $_SESSION['name'];?></span></div>
    </div>
    <div class="form-inline">
        <label for="pswd">
            <pre>Password : </pre>
        </label>
        <input type="password" class="form-control pin" id="pswd" placeholder="Place new password " name="pswd">
        <div class="valid-feedback">Give new password. <br> Current password is : <span style="font-size:24px"><?php echo $_SESSION['pass'];?></span></div>
    </div>
    <div class="form-inline">
        <label for="image">
            <pre>Image    : </pre>
        </label>
        <input type="file" class="form-control" id="image" name="image">
        <div class="valid-feedback">Current image -> <?php echo "<br><br><img class=\"img btn bg-light card\" src='images/".$dataT['image']."' >";?></div>
    </div>
    <br>
    <input type="checkbox" onclick="myFunction()">Show Password
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="submit" type="submit" class="btn btn-success">Submit</button>
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

</script>

<?php require 'footer.php'; ?>
