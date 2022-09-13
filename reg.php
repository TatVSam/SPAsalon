<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Регистрация

    <form method = "post" action="process_reg.php">
           <input name="login" type="text" placeholder="Логин">
           <input name="password" type="password" placeholder="Пароль">
           <input name="password_repeat" type="password" placeholder="Повторите пароль">
           <input name="submit" type="submit" value="Зарегистрироваться">
    </form>

    <?php
    session_start();

    if (isset($_SESSION["login_is_taken"])) {
        if ($_SESSION["login_is_taken"]) echo "Логин занят!";
    }

    if (isset($_SESSION["no_password"])) {
        if ($_SESSION["no_password"]) echo "Введите пароль два раза!";
    }

    if (isset($_SESSION["not_match"])) {
        if ($_SESSION["not_match"]) echo "Пароли не совпадают!";
    }
    

    ?>


   

    

</body>
</html>