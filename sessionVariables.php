
/* Called in login.php file after logged in successfully*/

   <?php
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $user['role'];
    $_SESSION['tabRole'] = $user['role'];
    $_SESSION['rangeC'] = 5;
    $_SESSION['rangeT'] = 5;
    $_SESSION['rangeS'] = 5;
    $_SESSION['rangeA'] = 5;
    $_SESSION['indexC'] = 0;
    $_SESSION['indexT'] = 0;
    $_SESSION['indexS'] = 0;
    $_SESSION['indexA'] = 0;
    $_SESSION['lIndexC'] = array(0,0);
    $_SESSION['lIndexT'] = array(0,0);
    $_SESSION['lIndexS'] = array(0,0);
    $_SESSION['lIndexA'] = array(0,0);
    $_SESSION['cl'] = 0;
    $_SESSION['cr'] = 1;
    $_SESSION['sl'] = 0;
    $_SESSION['tr'] = 1;
    $_SESSION['tl'] = 0;
    $_SESSION['sr'] = 1;
    $_SESSION['al'] = 0;
    $_SESSION['ar'] = 1;
?>
in --->> register.php
$_SESSION['status']
in --->> allLists.php
$_SESSION['ci'];
$_SESSION['ti'];
$_SESSION['si'];
$_SESSION['ai'];
