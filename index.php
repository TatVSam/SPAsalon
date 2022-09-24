<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   
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
    ?>



    <?php     
    //если пользователь авторизован
    if (!empty($_SESSION['auth'])) {
    

        $count = $_SESSION['count'] ?? 0;
        $count++;
        $_SESSION['count'] = $count;

        //назначаем уникальные именя для куки разных пользователей
        $name_login = "login_" . $_SESSION["login"];
        $entry_time = "entry_time_" . $_SESSION["login"];
        $entry_time_formatted = "entry_time_formatted_" . $_SESSION["login"];

        //если время входа задано, проверяем текущий ли пользователь записан в куки.
        //если пользователь правильный, берем из куки время входа
        if (!empty($_COOKIE[$entry_time])) {
                if ($_COOKIE[$name_login] === $_SESSION["login"]) {
                $_SESSION["entry_time"] = $_COOKIE[$entry_time];
                $_SESSION["entry_time_formatted"] = $_COOKIE[$entry_time_formatted];
                $entry_time_set = true;
            }
        }

        //если в куках нет времени входа, при авторизации берем текущее время и записываем в куки для данного пользователя
        // время жизни куки - 1 час
        if (empty ($entry_time_set)) {
            if ($_SESSION['count'] == 1 ) {
                $_SESSION["entry_time"] = time();
                $_SESSION["entry_time_formatted"] = date("H:i:s"); 
                setcookie(name: $entry_time, value: $_SESSION["entry_time"], expires_or_options: time() + 3600);
                setcookie(name: $entry_time_formatted, value: $_SESSION["entry_time_formatted"], expires_or_options: time() + 3600);
                setcookie(name: $name_login, value: $_SESSION["login"], expires_or_options: time() + 3600);
                $entry_time_set = true;
            }
        }

        //количество секунд, прошедших со времени входа   
        $time_difference = time() - $_SESSION["entry_time"];

        //уникальное имя куки, где хранится (или будет храниться) дата дня рождения пользователя
        $birthday_login = "birthday_" . $_SESSION["login"];

        //если др пользователя задано в куках, берем оттуда
        if (!empty($_COOKIE[$birthday_login])) {
            if ($_COOKIE[$name_login] === $_SESSION["login"]) {
                $birthday = $_COOKIE[$birthday_login];
                $_SESSION["date_is_set"] = true;
            }
        }

        //иначе берем из обработанной формы и сохраняем в куках

        if (!empty($_SESSION["DOB"])) {
            $birthday = date('jS F', strtotime($_SESSION["DOB"]));    
            setcookie(name: $birthday_login, value: $birthday, expires_or_options: time() + 3600);

        }

        //сколько всего секунд осталось до истечения 24 часов со времени входа
        $all_seconds_left = 86400 - $time_difference;

        if ($all_seconds_left > 0) {
            $discount_active = true; //если время не истекло, акция активна
            $seconds_left = $all_seconds_left % 60;
            $all_minutes_left = ($all_seconds_left - $seconds_left) / 60; 
            $minutes_left = $all_minutes_left % 60;
            $hours_left = ($all_minutes_left - $minutes_left) / 60;

        } else {
            $discount_active = false; //если время истекло, акция неактивна
        }
    ?>  

    <div class="nav"> 
        <!--При авторизации отображаем приветствие и кнопку для выхода-->
        <p class="welcome">Здравствуйте, <?=$_SESSION['login']?></p>
        <a href="logout.php"><button class="open-button btn btn-secondary" type="button">Выйти</button></a>         
    </div>


    <?php
        //форма с просьбой сообщить дату рождения выводится при входе и потом через пять последующих сессий до получения ответа
        
        if ((($_SESSION['count'] - 1) % 5 == 0) && empty($_SESSION["date_is_set"])){ ?>

            <div class="form-popup-visible" id="formLog">
                
                <form method = "post" action="process_date.php">
                    <p>Какого числа Вы родились?</p>
                    <div class="form-group">
                        <label for="DOB"><b>Дата рождения</b></label>
                        <input name="DOB" class="form-control" type="date" max="2020-01-01" placeholder="Логин" required>
                    </div>
    
                    <input name="submit" class ="btn btn-primary" type="submit" value="Отправить">
                    <button type="button" class="btn cancel btn-secondary" onclick="close_formLog()">Закрыть</button> 

                </form>
            </div>
    <?php 
        }


        if (isset($birthday)) {
            //преобразуем др в метку времени Unix
            $DOB_Unix=strtotime($birthday);
            //вычисляем сколько дней 
            $days_until_birthday=ceil(($DOB_Unix-time())/60/60/24);
        //если др пользователя будет в следующем году
        if ($days_until_birthday < 0) {
            $days_until_birthday = 365 + $days_until_birthday;
        }
        //если др пользователя сегодня
        if ($days_until_birthday == 0) {
            $user_birthday = true;
        } 

        }
    ?>


    <?php
        } //конец расчетов для авторизованного пользователя
    ?>

    <!--Если пользователь не авторизован-->
    <?php
        if (empty($_SESSION['auth'])) {
    ?>
      

        <div class="nav">  
            <!--Отображаем вверху кнопки авторизации и регистрации-->
            <button class="open-button btn btn-secondary" type="button" onclick="open_formLog()">Войдите</button>        
            <button class="registration-button btn btn-outline-secondary" type="button" onclick="open_formReg()">Зарегистрируйтесь</button>
              
        </div>
 
    <?php
        }
    ?>

    <!--Всплывающая форма авторизации без проблем авторизации, начальное состояние - невидима-->
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
   
            <button type="button" class="btn cancel btn-secondary" onclick="close_formLog()">Закрыть</button>
    
            <?php     
                $_SESSION["index"] = true; //отмечаем, что авторизуемся с главной страницы
            ?>
        </form>
    </div>

    <!--Всплывающая форма авторизации с проблемами авторизации (failed), которые возникли на главной странице
    начальное состояние - видима-->
    <?php
    if (!empty($_SESSION["index"]) && (!empty($_SESSION["failed"])) && empty($_SESSION["from_login"])) { 
        $_SESSION["failed"] = false;
        $_SESSION["from_login"] = false; //не со страницы login.php
    ?>

        <div class="form-popup-visible" id="formLog">
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

                <input name="submit" class ="btn btn-primary" type="submit" value="Войти">

                <button type="button" class="btn cancel btn-secondary" onclick="close_formLog()">Закрыть</button>
                
                <!--Выводим сообщения о возникших проблемах авторизации-->
                <?php  
                    if (!empty($_SESSION["isNull"])) {
                ?>
                    <small class="form-text text-danger">Введите логин и пароль!</small>
                <?php
                    } else {
                ?>
                    <small class="form-text text-danger">Неверный логин или пароль!</small>
    
                <?php
                    }
                ?>
            </form>
        </div>

    <?php
    }
    ?>

    <!--Всплывающая форма регистрации без проблем регистрации, начальное состояние - невидима-->

    <div class="form-popup-invisible" id="formReg">
        <form method = "post" action="process_reg.php">
            
            <div class="form-group">
                <input name="login" class="form-control" type="text" placeholder="Логин" required>
            </div>

            <div class="form-group">
                <input name="password" class="form-control" type="password" placeholder="Пароль" required>
            </div>

            <div class="form-group">     
                <input name="password_repeat" class="form-control" type="password" placeholder="Повторите пароль" required>
            </div>

            <input name="submit" class ="btn btn-primary" type="submit" value="Зарегистрироваться">

            <button type="button" class="btn cancel btn-secondary" onclick="close_formReg()">Закрыть</button>

            <?php     
                $_SESSION["index"] = true; //отмечаем, что регистрируемся с главной страницы
            ?>
        </form>
    </div>

    <!--Всплывающая форма регистрации с проблемами регистрации (failed_reg), которые возникли на главной странице
    начальное состояние - видима-->

    <?php
        if (!empty($_SESSION["index"]) && (!empty($_SESSION["failed_reg"]))) {
            $_SESSION["failed_reg"] = false; 
    ?>

        <div class="form-popup-visible" id="formReg">
            <form method = "post" action="process_reg.php">
                
                <div class="form-group">
                    <input name="login" class="form-control" type="text" placeholder="Логин" required>
                </div>
    
                <div class="form-group">
                    <input name="password" class="form-control" type="password" placeholder="Пароль" required>
                </div>
    
                <div class="form-group">
                    <input name="password_repeat" class="form-control" type="password" placeholder="Повторите пароль" required>
                </div>

                <input name="submit" class ="btn btn-primary" type="submit" value="Зарегистрироваться">

                <button type="button" class="btn cancel btn-secondary" onclick="close_formReg()">Закрыть</button>
                
                <!--Выводим сообщения о возникших проблемах авторизации-->
                <?php     
                    $_SESSION["index"] = true;
                    if (!empty($_SESSION["login_is_taken"])) {
                ?>
                        <small class="form-text text-danger">Логин занят!</small>

                <?php
                    }              
              
                    if (!empty($_SESSION["not_match"])) {
                ?>
                    <small class="form-text text-danger">Пароли не совпадают!</small>
                <?php
                    } 

                    if (!empty($_SESSION["password_too_short"])) {
                ?>
                    <small class="form-text text-danger">Пароль содержит менее 5 символов!</small>
                    
                <?php
                    }         
                ?>
            
            </form>
        </div>

    <?php
        }
    ?>

<!--Содержание главной страницы-->
<!--Шапка с фото салон (CSS)-->
    <header>
   
    </header>

    <!--Сообщения в шапке для авторизованных пользователей-->
    <?php
        if (!empty($_SESSION["auth"])) {
    ?>
        <div class="notifications-container">
            <p class="user_notifications">
                Время входа: <?=$_SESSION["entry_time_formatted"]?>
                <br>
        <?php
            if($discount_active) {
        ?>
                Персональная скидка 7% истекает через: <?=$hours_left?>:<?=$minutes_left?>:<?=$seconds_left?>
                <br>
        <?php
            }

            if (isset($days_until_birthday)) {
                if ($days_until_birthday == 0) {
        ?>  
                    Поздравляем с Днем Рождения! Дарим скидку 5% на все услуги!
                    <br>
        <?php
                } else {
        ?>
                    Вы родились <?=getRussianDate($birthday)?>. До Вашего дня рождения <?=$days_until_birthday . " " . dayEnding($days_until_birthday)?> 
        <?php
                }
            }
         }
        ?>
            </p>
        </div>

    <!--Услуги с расчетом скидок и новых цен-->
    
    <div class="figure-container">
        
        <figure>
            <div class="img-container">
                <img src="images/bali_massage.jpg" alt="Trulli">
             </div>

            <figcaption>Традиционный балийский массаж с аромамаслами</figcaption>
            <?php
                $discount = getDiscount (14);
                $oldprice = 7100;
                if (hasDiscount($discount)) {
            ?>

                    <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                    <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                    <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>

        <figure>
            <div class="img-container">
                <img src="images/chocolate.jpg" alt="Trulli">
            </div>           
            
            <figcaption>Шоколадное обертывание</figcaption>
            <?php
                $discount = getDiscount (0);
                $oldprice = 5500;
                if (hasDiscount($discount)) {
            ?>
                    <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                    <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                    <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>

        <figure>
            <div class="img-container">
                <img src="images/grapes.jpg" alt="Trulli">
            </div>
            
            <figcaption>Виноградное обертывание</figcaption>
            <?php
                $discount = getDiscount (6);
                $oldprice = 5500;
                if (hasDiscount($discount)) {
            ?>
                    <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                    <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                    <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>

        <figure>
            <div class="img-container">
                <img src="images/honey.jpg" alt="Trulli">
            </div>

            <figcaption>Медовое обертывание</figcaption>
            <?php
                $discount = getDiscount(0);
                $oldprice = 5500;
                if (hasDiscount($discount)) {
            ?>
                    <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                    <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>
    
    
        <figure>
            <div class="img-container">            
                <img src="images/hot_stones.jpg" alt="Trulli">
            </div>
       
            <figcaption>Массаж горячими камнями</figcaption>
            <?php
                $discount = getDiscount (5);
                $oldprice = 8000;
                if (hasDiscount($discount)) {
            ?>
                    <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                    <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                    <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>

        <figure>
            <div class="img-container">
                <img src="images/laminaria.jpg" alt="Trulli">
            </div>
            
            <figcaption>Обертывание ламинарией</figcaption>
            <?php
                $discount = getDiscount (0);
                $oldprice = 7800;
                if (hasDiscount($discount)) {
            ?>
                    <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                    <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                    <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>

        <figure>
            <div class="img-container">
                <img src="images/peeling.jpg" alt="Trulli">
            </div>

            <figcaption>Натуральный экспресс пилинг на выбор</figcaption>
            <?php
                $discount = getDiscount (0);
                $oldprice = 7000;
                if (hasDiscount($discount)) {
            ?>
                <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>

        <figure>
            <div class="img-container">
                <img src="images/turkey_massage.jpg" alt="Trulli">
            </div>
            
            <figcaption>Турецкий мыльный массаж</figcaption>
            <?php
                $discount = getDiscount(0);
                $oldprice = 7500;
                if (hasDiscount($discount)) {
            ?>
                <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>

        <figure>
            <div class="img-container">
                <img src="images/coco.jpg" alt="Trulli">
            </div>
            
            <figcaption>Кокосовый скраб </figcaption>
            <?php
                $discount = getDiscount (7);
                $oldprice = 2000;
                if (hasDiscount($discount)) {
            ?>
                    <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                    <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                    <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>

        <figure>
            <div class="img-container">
                <img src="images/mango.jpg" alt="Trulli">
            </div>
            
            <figcaption>Манговый скраб</figcaption>
            <?php
                $discount = getDiscount(0);
                $oldprice = 2000;
                if (hasDiscount($discount)) {
            ?>
                    <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                    <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                    <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>
       
        <figure>
            <div class="img-container">
                <img src="images/gommage.jpg" alt="Trulli">
            </div>

            <figcaption>Аюрведический гоммаж</figcaption>
            <?php
                $discount = getDiscount(10);
                $oldprice = 3000;
                if (hasDiscount($discount)) {
            ?>
                    <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                    <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                    <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>            
        </figure>

        <figure>
            <div class="img-container">
                <img src="images/face.jpg" alt="Trulli">
            </div>

            <figcaption>Массаж лица</figcaption>
            <?php
                $discount = getDiscount(0);
                $oldprice = 2500;
                if (hasDiscount($discount)) {
            ?>
                    <figcaption><span class="new-price"><?=getNewPrice ($oldprice, $discount)?> &#8381;</span></figcaption>
                    <figcaption><span class="old-price"><?=$oldprice?> &#8381;</span><span class="discount">-<?=$discount?>%</span></figcaption>
            <?php
                } else {
            ?>
                    <figcaption><span class="new-price"><?=$oldprice?> &#8381;</span></figcaption>
            <?php
                }
            ?>
        </figure>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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