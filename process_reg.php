<?php

include 'functions_db.php';

/*$users = [];
$logins = [];
$lines = file('data.txt');

foreach ($lines as $line_num => $line) {
    
    if (trim($line)) {
    $temp = explode(" ", $line);
    $users[$line_num] = ['login' => $temp[0], 'password' => trim($temp[1])];
    $logins[$line_num] = $temp[0];
    }
}*/

$login = $_POST['login'] ?? null;
$password = sha1($_POST['password']) ?? null;
$password_repeat = sha1($_POST['password_repeat']) ?? null;

session_start();

if (existsUser($login)) {

    $_SESSION["login_is_taken"] = true;
   
} else {
    $_SESSION["login_is_taken"] = false;
  
}


if ($password !== $password_repeat) {

    $_SESSION["not_match"] = true;
    
} else {
    $_SESSION["not_match"] = false;
     
}

if (!empty($_SESSION["login_is_taken"]) || !empty($_SESSION["not_match"])) {
    $_SESSION["failed_reg"] = true;
    if (!empty($_SESSION["index"])) {
        header("Location: index.php");
    } else {
        header("Location: reg.php");  
    } 
}
if (!$_SESSION["login_is_taken"] && !$_SESSION["not_match"]) {
    $new_line = $login . " " . $password . "\n";
    $_SESSION["failed_reg"] = false;
    $fileopen = fopen('data.txt', 'a+');
    fwrite($fileopen, $new_line);
    fclose($fileopen);
    $_SESSION["reg_success"] = true;
    header("Location: login.php");
}  
?>