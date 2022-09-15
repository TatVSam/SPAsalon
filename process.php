<?php

$users = [];


$lines = file('data.txt');

foreach ($lines as $line_num => $line) {
    
    if (trim($line)) {
    $temp = explode(" ", $line);
    $users[$line_num] = ['login' => $temp[0], 'password' => trim($temp[1])];
  
    }
}


print_r($users);

/*
$login = 'Jim';
$password = 'secret';
$str = $login . " " . $password . "\n";
echo $str;
$fileopen = fopen('data.txt', 'a+');
fwrite($fileopen, $str);
fclose($fileopen);

$index = 0;

$lines = file('data.txt');
foreach ($lines as $line) {
    
    $temp = explode(" ", $line);
    $users[$index] = ['login' => $temp[0], 'password' => $temp[1]];
    $index++;

}

print_r($users);*/

$login = $_POST['login'] ?? null;
$password = sha1($_POST['password']) ?? null;



//echo 'Привет, пользователь ' . $_POST['login'] . '!';
//echo nl2br ("\n");
//var_dump ($_POST);

//header("Location: index.php"); /* Перенаправление браузера */

/* Убедиться, что код ниже не выполнится после перенаправления .
exit;*/

session_start(); 

if (null !== $login || null !== $password) {

    foreach ($users as $user_num => $user) {
    // Если пароль из базы совпадает с паролем из формы
    if  (($login === $users[$user_num]['login']) && ($password === $users[$user_num]['password'])) {
    
         // Стартуем сессию:
       
        
   	 // Пишем в сессию информацию о том, что мы авторизовались:
        $_SESSION['auth'] = true; 
        
        // Пишем в сессию логин и id пользователя
        $_SESSION['id'] = $user_num; 
        $_SESSION['login'] = $login; 
        header("Location: index.php");
        exit;

    }

} 
} else {
    echo "Введите логин и пароль!";
}



    $_SESSION["auth"] = false;
    $_SESSION["failed"] = true;
    header("Location: login.php"); 


if ($_SESSION["failed"]) {
    header("Location: login.php");  
}

?>

