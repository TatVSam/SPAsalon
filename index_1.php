<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA</title>
    <style>
     
      #zatemnenie {
        background: rgba(102, 102, 102, 0.5);
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        display: none;
      }
      #okno {
        width: 300px;
        height: 50px;
        text-align: center;
        padding: 15px;
        border: 3px solid #0000cc;
        border-radius: 10px;
        color: #0000cc;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: auto;
        background: #fff;
      }
      #zatemnenie:target {display: block;}
      .close {
        display: inline-block;
        border: 1px solid #0000cc;
        color: #0000cc;
        padding: 0 12px;
        margin: 10px;
        text-decoration: none;
        background: #f2f2f2;
        font-size: 14pt;
        cursor:pointer;
      }
      .close:hover {background: #e6e6ff;}
    
    </style>
</head>
<body>


<div id="zatemnenie">
      <div id="okno">
      <form method = "post" action="process.php">
           <input name="login" type="text" placeholder="Логин">
           <input name="password" type="password" placeholder="Пароль">
           <input class="close" name="submit" type="submit" value="Войти">
</form>
<?php
    session_start();
    if (isset($_SESSION["failed"])) echo "Неверный логин или пароль!";

?>
       
      </div>
    </div>
     
    <a href="#zatemnenie">Вызвать всплывающее окно</a>



   

</body>
</html>