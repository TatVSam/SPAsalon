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
session_start();

if ($_SESSION) {
if ($_SESSION['auth']) {
    echo "Привет, " . $_SESSION['login'] . "!";
?>
    <br>
    <a href="logout.php">Выйти</a>
<?php
} else {
    echo "Залогиньтесь!";
}
} else {
?>    
    <a href = "login.php"> Залогиньтесь</a>
    <a href = "reg.php"> Зарегистрируйтесь</a>
<?php
}

?>
</body>
</html>