<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA</title>
    <style>
body {
    font-family: Arial, Helvetica, sans-serif;
}
* {
    box-sizing: border-box;
}

.open-button {
    background-color: #2196F3;
    color: white;
    font-size: 15px;
    font-weight: bold;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    opacity: 0.8;
    position: absolute;
    top: 0%;
    right: 0%;     
    width: 280px;
}

.registration-button {
    background-color: #2196F3;
    color: white;
    font-size: 15px;
    font-weight: bold;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    opacity: 0.8;
    position: absolute;
    top: 0%;
    right: 300px;     
    width: 280px;
}


.form-popup-invisible {
    display: none;
    position: absolute;
    top: 20%;
    right: 40%;
    border: 3px solid #f1f1f1;
    z-index: 9;  
}

.form-popup-visible {
    display: block;
    position: absolute;
    top: 20%;
    right: 40%;
    border: 3px solid #f1f1f1;
    z-index: 9;  
}

.form-container {
    max-width: 300px;
    padding: 10px;
    background-color: white;  
}

.form-container input[type=text], .form-container input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    border: none;
    background: #f1f1f1;
}

.form-container input[type=text]:focus, .form-container input[type=password]:focus {
    background-color: #ddd;
    outline: none;
}

.form-container .btn {
    background-color: #1976D2;
    color: white;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    width: 100%;
    margin-bottom:10px;
    opacity: 0.8;
    font-size: 15px;
    font-weight: bold;
}

.form-container .cancel {
    background-color: #448AFF;
}

.form-container .btn:hover, .open-button:hover {
    opacity: 1;
}
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
    <h1>Залогиньтесь</h1>
    <label for="login"><b>Логин</b></label>
    <input name="login" type="text" placeholder="Логин" required>
    <label for="password"><b>Пароль</b></label>
    <input name="password" type="password" placeholder="Пароль" required>
    <input name="submit" class = "btn" type="submit" value="Войти">
    <button type="button" class="btn cancel" onclick="close_formLog()">Закрыть</button>
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