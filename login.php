<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
include 'functions_db.php';

session_start();


if (getCurrentUser()) {
    header("Location: index.php"); 
    exit;
}

$_SESSION["index"] = false;
if (!empty($_SESSION["reg_success"])) {
    echo "Поздравляем! Вы зарегистрировались! Теперь введите логин и пароль.";
}
?>
<form method = "post" action="process.php">
           <input name="login" type="text" placeholder="Логин" required>
           <input name="password" type="password" placeholder="Пароль" required>
           <input name="submit" type="submit" value="Войти">
</form>
<?php
 
    if (!empty($_SESSION["isNull"])) {
        echo "Введите логин и пароль!";
    } elseif (!empty($_SESSION["failed"])) {
     echo "Неверный логин или пароль!";
    }

    $_SESSION["reg_success"] = false;
?>

</body>
</html>