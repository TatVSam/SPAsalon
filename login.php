<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   
   <style>
     
     <?php echo file_get_contents("style.css"); ?>
   </style>
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
<div class="form-popup-visible">
<form method = "post" action="process.php">
<div class="form-group">
           <input name="login" class="form-control" type="text" placeholder="Логин" required>
</div>
<div class="form-group">
           <input name="password" class="form-control" type="password" placeholder="Пароль" required>
</div>
           <input name="submit" class ="btn btn-primary" type="submit" value="Войти">

<?php
 
    if (!empty($_SESSION["isNull"])) {
?>
<small class="form-text text-danger">Введите логин и пароль!</small>
      
<?php
    } elseif (!empty($_SESSION["failed"])) {
?>
<small class="form-text text-danger">Неверный логин или пароль!</small>
    
<?php
    }

    $_SESSION["reg_success"] = false;
?>
</form>
</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>