<?php

include 'functions_db.php';

/*$users = [];


$lines = file('data.txt');

foreach ($lines as $line_num => $line) {
    
    if (trim($line)) {
    $temp = explode(" ", $line);
    $users[$line_num] = ['login' => $temp[0], 'password' => trim($temp[1])];
  
    }
}*/

$users = getUsersList(); 




$login = $_POST['login'] ?? null;
$password = sha1($_POST['password']) ?? null;




session_start(); 
$_SESSION['failed_reg'] = false;

if (null != $login || null != $_POST['password']) {

   /* foreach ($users as $user_num => $user) {
    // Если пароль из базы совпадает с паролем из формы
    if  (($login === $users[$user_num]['login']) && ($password === $users[$user_num]['password'])) {
    
         // Стартуем сессию:
       
        
   	 // Пишем в сессию информацию о том, что мы авторизовались:
        $_SESSION['auth'] = true;
        $_SESSION['failed'] = false;  
        
        // Пишем в сессию логин и id пользователя
        $_SESSION['id'] = $user_num; 
        $_SESSION['login'] = $login; 
        header("Location: index.php");
        exit;

    }

} */

    if (checkPassword($login, $password)) {
        $_SESSION['auth'] = true;
        $_SESSION['failed'] = false;  
        
        // Пишем в сессию логин и id пользователя
        $_SESSION['id'] = $user_num; 
        $_SESSION['login'] = $login; 
        header("Location: index.php");
        exit;
    }
} else {
    $_SESSION["isNull"] = true;
    if (!empty($_SESSION["index"])) {
        header("Location: index.php");
        exit;  
    } else {
        header("Location: login.php"); 
    }

    exit;
}


    $_SESSION["isNull"] = false;
    $_SESSION["auth"] = false;
    $_SESSION["failed"] = true;

    if (!empty($_SESSION["index"])) {
        header("Location: index.php");
        exit;  
    } else {
        header("Location: login.php"); 
    }



  


?>

