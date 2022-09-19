<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA</title>
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
    
    <style>
      
        <?php echo file_get_contents("style.css"); ?>
    </style>
    
</head>

<body>

    <?php 
        include 'functions.php';
    ?>

    <?php
        session_start();

        if (empty($_SESSION['auth'])) {
    ?>
   
        <button class="open-button" onclick="open_formLog()">Войдите</button>
        <button class="registration-button" onclick="open_formReg()">Зарегистрируйтесь</button>
       
    <?php
        }
    ?>



<div class="form-popup-invisible" id="formLog">
<form method = "post" action="process.php">
    <p>Залогиньтесь</p>
    <div class="form-group">
        <label for="login"><b>Логин</b></label>
        <input name="login" class="form-control" type="text" placeholder="Логин" required>
    </div>
    <div class="form-group">
        <label for="password"><b>Пароль</b></label>
        <input name="password" class="form-control" type="password" placeholder="Пароль" required>
    </div>
    
        <input name="submit" class = "btn btn-primary" type="submit" value="Войти">
   
    <button type="button" class="btn cancel btn-primary" onclick="close_formLog()">Закрыть</button>
    <?php
     
      $_SESSION["index"] = true;
    

?>
</form>
</div>

<?php
if (!empty($_SESSION["index"]) && (!empty($_SESSION["failed"]))) { 
?>
<div class="form-popup-visible" id="formLog">
<form method = "post" action="process.php">
    <h1>Залогиньтесь</h1>
    <label for="login"><b>Логин</b></label>
    <input name="login" type="text" placeholder="Логин" required>
    <label for="password"><b>Пароль</b></label>
    <input name="password" type="password" placeholder="Пароль" required>
    <input name="submit" class = "btn" type="submit" value="Войти">
    <button type="button" class="btn cancel" onclick="close_formLog()">Закрыть</button>
    <?php
  
    if (!empty($_SESSION["isNull"])) {
        echo "Введите логин и пароль!";
    } else {
     echo "Неверный логин или пароль!";
    }
      ?>
</form>
</div>

<?php
}
?>

<div class="form-popup-invisible" id="formReg">
<form method = "post" action="process_reg.php">
           <input name="login" type="text" placeholder="Логин" required>
           <input name="password" type="password" placeholder="Пароль" required>
           <input name="password_repeat" type="password" placeholder="Повторите пароль" required>
           <input name="submit" class = "btn" type="submit" value="Зарегистрироваться">
           <button type="button" class="btn cancel" onclick="close_formReg()">Закрыть</button>
           <?php     
                $_SESSION["index"] = true; 

            ?>
</form>
</div>

<?php
if (!empty($_SESSION["index"]) && (!empty($_SESSION["failed_reg"]))) { 
?>
<div class="form-popup-visible" id="formReg">
<form method = "post" action="process_reg.php">
           <input name="login" type="text" placeholder="Логин" required>
           <input name="password" type="password" placeholder="Пароль" required>
           <input name="password_repeat" type="password" placeholder="Повторите пароль" required>
           <input name="submit" class = "btn" type="submit" value="Зарегистрироваться">
           <button type="button" class="btn cancel" onclick="close_formReg()">Закрыть</button>
           <?php     
                $_SESSION["index"] = true;
                if (!empty($_SESSION["login_is_taken"])) {
                    echo "Логин занят!";
                  }
              
              
                  if (!empty($_SESSION["not_match"])) {
                      echo "Пароли не совпадают!";
                  } 

            ?>
</form>
</div>

<?php
}
?>

<?php     



if (!empty($_SESSION['auth'])) {

    

  $count = $_SESSION['count'] ?? 0;
  $count++;
  $_SESSION['count'] = $count;

  $name_login = "login_" . $_SESSION["login"];
  $entry_time = "entry_time_" . $_SESSION["login"];
  $entry_time_formatted = "entry_time_formatted_" . $_SESSION["login"];

  if (!empty($_COOKIE[$entry_time])) {
    if ($_COOKIE[$name_login] === $_SESSION["login"]) {
        $_SESSION["entry_time"] = $_COOKIE[$entry_time];
        $_SESSION["entry_time_formatted"] = $_COOKIE[$entry_time_formatted];
        $entry_time_set = true;
    }
}

  echo $_SESSION['count'] . nl2br("\n");

    
  if (empty ($entry_time_set)) {
  if ($_SESSION['count'] == 1 ) {
    $_SESSION["entry_time"] = time();
    $_SESSION["entry_time_formatted"] = date("H:i:s"); 
    setcookie(name: $entry_time, value: $_SESSION["entry_time"]);
    setcookie(name: $entry_time_formatted, value: $_SESSION["entry_time_formatted"]);
    setcookie(name: $name_login, value: $_SESSION["login"]);
    $entry_time_set = true;
  }
}
    echo "Привет, " . $_SESSION['login'] . nl2br("\n");
   
    echo "Время входа " . $_SESSION["entry_time_formatted"] . nl2br("\n");
   
   
    $difference = time() - $_SESSION["entry_time"];
 
  $all_seconds_left = 86400 - $difference;
  $seconds_left = $all_seconds_left % 60;
  $all_minutes_left = ($all_seconds_left - $seconds_left) / 60; 
  $minutes_left = $all_minutes_left % 60;
  $hours_left = ($all_minutes_left - $minutes_left) / 60;
  echo "Осталось " . $hours_left . " : " . $minutes_left . " : " . $seconds_left . nl2br("\n");
?>



<?php 

$birthday_login = "birthday_" . $_SESSION["login"];

if (!empty($_COOKIE[$birthday_login])) {
    if ($_COOKIE[$name_login] === $_SESSION["login"]) {
        $birthday = $_COOKIE[$birthday_login];
        $_SESSION["date_is_set"] = true;
    }
}

if ((($_SESSION['count'] - 1) % 5 == 0) && empty($_SESSION["date_is_set"])){ ?>


<div class="form-popup-visible" id="formLog">
<form method = "post" action="process_date.php">
    <h1>Какого числа вы родились?</h1>
    <label for="DOB"><b>Дата рождения</b></label>
    <input name="DOB" type="date" placeholder="Логин" required>

    <input name="submit" class = "btn" type="submit" value="Отправить">
    <button type="button" class="btn cancel" onclick="close_formLog()">Закрыть</button>
   


  </form>
</div>
<?php 
}

if (!empty($_SESSION["DOB"])) {
    $birthday = date('jS F', strtotime($_SESSION["DOB"]));
    
    setcookie(name: $birthday_login, value: $birthday);

}



if (isset($birthday)) {
    echo "Вы родились " . getRussianDate($birthday) . nl2br("\n");
    $d1=strtotime($birthday);
  

    $d2=ceil(($d1-time())/60/60/24);
   
    if ($d2 < 0) {
        $d2 = 365 + $d2;
    }

    if ($d2 == 0) {
        echo "Поздравляем";
    } else {
        echo "До вашего дня рождения " . $d2 . " " . dayEnding($d2);
    }
    

}
?>



    <br>
    <a href="logout.php">Выйти</a>
<?php
    }
?>

<script>

    function open_formLog() {
        document.querySelector("#formLog").style.display = "block"; 
    }

    function close_formLog() {
    let forms = document.querySelectorAll("#formLog");
    forms.forEach (elem => elem.style.display = "none");    
    }

    function open_formReg() {
        document.querySelector("#formReg").style.display = "block"; 
    }

    function close_formReg() {
        let forms = document.querySelectorAll("#formReg");
        forms.forEach (elem => elem.style.display = "none");
    }

</script>
   

</body>
</html>