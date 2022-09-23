<?php

include 'functions_db.php';



$login = $_POST['login'] ?? null;
$password = $_POST['password'] ?? null;
$password_repeat = $_POST['password_repeat'] ?? null;

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

if ($password !== $password_repeat) {

    $_SESSION["not_match"] = true;
    
} else {
    $_SESSION["not_match"] = false;
     
}

if (mb_strlen($password) < 5) {
    $_SESSION["password_too_short"] = true;
} else {
    $_SESSION["password_too_short"] = false;
     
}

if (!empty($_SESSION["login_is_taken"]) || !empty($_SESSION["not_match"]) || !empty($_SESSION["password_too_short"])) {
    $_SESSION["failed_reg"] = true;
    if (!empty($_SESSION["index"])) {
        header("Location: index.php");
    } else {
        header("Location: reg.php");  
    } 
}

if (!$_SESSION["login_is_taken"] && !$_SESSION["not_match"] && !$_SESSION["password_too_short"]) {
    $new_line = $login . " " . sha1($password) . "\n";
    $_SESSION["failed_reg"] = false;
    $fileopen = fopen('data.txt', 'a+');
    fwrite($fileopen, $new_line);
    fclose($fileopen);
    $_SESSION["reg_success"] = true;
    header("Location: login.php");
}  
?>