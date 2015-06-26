<?php
// Подключаем конфигурацию и класс базы данных
require_once "../scripts/config.php";
require_once "../scripts/class.invis.db.php";
require_once "classes/class.symbianm.valid.php";

if(isset($_POST ['pass'])) 
    if (!$pass = validClass::sanitiseString($_POST['pass']))
       unset($pass);
    
if(isset($_POST ['login'])) 
    if (!$login = validClass::sanitiseString($_POST['login']))
       unset($login);    
    
//-------------------------------------------------------
if (($redir = $_SERVER['HTTP_REFERER']) == ""){
    die ("Error cod.:1 - Строка запроса пуста!");
    exit;
}
//-------------------------------------------------------
if (isset($login) && isset($pass)) {

    $pass=md5(md5(md5($pass)));  

    // Инициализируем подключение
    $db = db :: getInstance();

    $db -> query("SELECT id, login, pass 
                  FROM admin 
                  WHERE login='".$login."'");

    if ($db -> getCount() > 0) {

        $myrow = $db -> getRow();
        
        // Проверка пароля
        if ($pass != $myrow['pass']) {
            Header ("Location: $redir?errorLogin=3");
            exit;
        }
        // Запускаем сессию
        session_name("Autentification");
        session_start();
        session_cache_limiter('nocache,private');
        
        // Вставляем переменные
        $_SESSION['user_id']    = $myrow['id'];
        $_SESSION['user_login'] = $myrow['login'];
        $_SESSION['user_pass']  = $myrow['pass'];

        Header ("Location: index.php");
        exit;
    }
    else {
        Header ("Location: $redir?errorLogin=4");
        exit;
    }
} 
else 
    if (isset($login) && !isset($pass)) {
        Header ("Location: $redir?errorLogin=2");
        exit;
    }
    else
        if (!isset($login) && isset($pass)) {
            Header ("Location: $redir?errorLogin=1");
            exit;
        }
        else {
            Header ("Location: $redir?errorLogin=0");
            exit;
        }
?>