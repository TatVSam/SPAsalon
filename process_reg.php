<?php
$users = [];
$logins = [];
$lines = file('data.txt');

foreach ($lines as $line_num => $line) {
    
    if (trim($line)) {
    $temp = explode(" ", $line);
    $users[$line_num] = ['login' => $temp[0], 'password' => trim($temp[1])];
    $logins[$line_num] = $temp[0];
    }
}

$login = $_POST['login'] ?? null;
$password = $_POST['password'] ?? null;
$password_repeat = $_POST['password_repeat'] ?? null;

session_start();

if (in_array($login, $logins)) {

    $_SESSION["login_is_taken"] = true;
    header("Location: reg.php"); 
    exit;
} else {
    $_SESSION["login_is_taken"] = false;
    //header("Location: reg.php");  
}

if (null == $password || null == $password_repeat) {

    $_SESSION["no_password"] = true;
    header("Location: reg.php");
    exit;
} else {
    $_SESSION["no_password"] = false;
    //header("Location: reg.php");  
}

if ($password !== $password_repeat) {

    $_SESSION["not_match"] = true;
    header("Location: reg.php");
    exit;
} else {
    $_SESSION["not_match"] = false;
    //header("Location: reg.php");  
}

$new_line = $login . " " . sha1($password) . "\n";
$fileopen = fopen('data.txt', 'a+');
fwrite($fileopen, $new_line);
fclose($fileopen);
header("Location: login.php"); 

?>