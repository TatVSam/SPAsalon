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


.form-popup {
    display: none;
    position: absolute;
    top: 20%;
    right: 40%;
    border: 3px solid #f1f1f1;
    z-index: 9;  
}

.form-popup1 {
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
  <button class="open-button" onclick="openForm()">Войдите</button>
  <button class="registration-button" onclick="open_formReg()">Зарегистрируйтесь</button>
<?php
}
?>



<div class="form-popup" id="myForm">
<form method = "post" action="process.php">
    <h1>Залогиньтесь</h1>
    <label for="login"><b>Логин</b></label>
    <input name="login" type="text" placeholder="Логин" required>
    <label for="password"><b>Пароль</b></label>
    <input name="password" type="password" placeholder="Пароль" required>
    <input name="submit" class = "btn" type="submit" value="Войти">
    <button type="button" class="btn cancel" onclick="closeForm()">Закрыть</button>
    <?php
      session_start();
      $_SESSION["index"] = true;
      if (isset($_SESSION["failed"])) echo "Неверный логин или пароль!";

?>
</form>
</div>



<div class="form-popup" id="formReg">
<form method = "post" action="process_reg.php">
           <input name="login" type="text" placeholder="Логин">
           <input name="password" type="password" placeholder="Пароль">
           <input name="password_repeat" type="password" placeholder="Повторите пароль">
           <input name="submit" class = "btn" type="submit" value="Зарегистрироваться">
           <button type="button" class="btn cancel" onclick="close_formReg()">Закрыть</button>
</form>
</div>


<?php     



if (!empty($_SESSION['auth'])) {

  $count = $_SESSION['count'] ?? 0;
  $count++;
  $_SESSION['count'] = $count;

  echo $_SESSION['count'] . nl2br("\n");

  if ($_SESSION['count'] == 1 ) {
    $_SESSION["entry_time"] = time();
    $_SESSION["entry_time_formatted"] = date("H:i:s"); 
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

<?php if ((($_SESSION['count'] - 1) % 5 == 0) && empty($_SESSION["date_is_set"])){ ?>

<div class="form-popup1" id="myForm">
<form method = "post" action="process_date.php">
    <h1>Какого числа вы родились?</h1>
    <label for="DOB"><b>Дата рождения</b></label>
    <input name="DOB" type="date" placeholder="Логин" required>

    <input name="submit" class = "btn" type="submit" value="Отправить">
    <button type="button" class="btn cancel" onclick="closeForm()">Закрыть</button>
   


  </form>
</div>
<?php }

if (!empty($_SESSION["DOB"])) {
    echo "Вы родились " . $_SESSION["DOB"] . nl2br("\n");
    $birthday = date('jS F', strtotime($_SESSION["DOB"]));
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
function openForm() {
    document.getElementById("myForm").style.display = "block"; 
}

function closeForm() {
let forms = document.querySelectorAll("#myForm");
forms.forEach (elem => elem.style.display = "none");
    
}

function open_formReg() {
    document.querySelector("#formReg").style.display = "block"; 
}

function close_formReg() {
    document.querySelector("#formReg").style.display = "none"; 
}
</script>
   

</body>
</html>