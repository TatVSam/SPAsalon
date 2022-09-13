<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA</title>
    <style>
    body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

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

.form-popup {
  display: none;
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
session_start();

if (empty($_SESSION['auth'])) {
    ?>
<button class="open-button" onclick="openForm()">Подпишитесь</button>
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
    if (isset($_SESSION["failed"])) echo "Неверный логин или пароль!";

?>
  </form>
</div>


<?php     






if ($_SESSION) {
if ($_SESSION['auth']) {
    $count = $_SESSION['count'] ?? 0;
$count++;
$_SESSION['count'] = $count;

echo $_SESSION['count'] . nl2br("\n");

if ($_SESSION['count'] == 1 ) {
    $_SESSION["entry_time"] = date("h:i:sa"); 
}
    echo "Привет, " . $_SESSION['login'] . nl2br("!");
   
   
    echo $_SESSION["entry_time"] . nl2br("\n");
    echo "The time is " . date("h:i:sa");
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

<script>
function openForm() {
    document.getElementById("myForm").style.display = "block"; }

    function closeForm() {
    document.getElementById("myForm").style.display = "none";
}
</script>
   

</body>
</html>