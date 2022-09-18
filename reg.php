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

    <?php
        include 'functions_db.php';
        session_start();
        
        if (getCurrentUser()) {
            header("Location: index.php"); 
            exit;
        }
        $_SESSION["index"] = false;
    ?>

    <form method = "post" action="process_reg.php">
           <input name="login" type="text" placeholder="Логин" required>
           <input name="password" type="password" placeholder="Пароль" required>
           <input name="password_repeat" type="password" placeholder="Повторите пароль" required>
           <input name="submit" type="submit" value="Зарегистрироваться">
    </form>

    <?php
    

    if (!empty($_SESSION["login_is_taken"])) {
      echo "Логин занят!";
    }


    if (!empty($_SESSION["not_match"])) {
        echo "Пароли не совпадают!";
    }
    
   

    ?>


   

    

</body>
</html>