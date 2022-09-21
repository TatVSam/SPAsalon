<?php

include 'functions_db.php';



$login = $_POST['login'] ?? null;
$password = sha1($_POST['password']) ?? null;
$password_repeat = sha1($_POST['password_repeat']) ?? null;

session_start();
$_SESSION['failed'] = false;

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