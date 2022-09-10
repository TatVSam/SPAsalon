<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form method = "post" action="process.php">
           <input name="login" type="text" placeholder="Логин">
           <input name="password" type="password" placeholder="Пароль">
           <input name="submit" type="submit" value="Войти">
</form>
<?php
    session_start();
    if (isset($_SESSION["failed"])) echo "Неверный логин или пароль!";

?>

</body>
</html>