<?php
//echo md5(md5(md5("zayaccool")));
session_name("Autentification");
session_start();
session_destroy();
// Подключаем шапку
require_once "blocks/head.php";
require_once "blocks/variables.php";
?>

<table height='100%' cellpadding="2" cellspacing="0" class="main">
  <tr>
    <td class="head">
 	<?php
            // Подключаем создателя
            include ("blocks/creator.php");
        ?>	
    </td>
  </tr>
  <tr>
    <td class='center' align='center'>
	<form name="log" method="post" action="login.php" >
            <div id="loginFields">
                <?php 
                    if (isset($_GET['errorLogin'])){
                       $error = $_GET['errorLogin'];
                       echo "<p style='color:#CC0000; margin:3px;'>Ошибка: ".$errorLogin[$error]."</p>";
                    }

                    $textLogin = 'Логин';
                    $textPass = 'Пароль';

                    echo "<p>".$textLogin." <input type='text' name='login' title='".$textLogin."'></p>";
                    echo "<p>".$textPass ." <input type='password' name='pass' title='".$textPass."'></p>";

                    echo "<input name='goIn' type='submit' value='Вход'>";
                ?>
            </div>
	</form> 
        <div id="helpIn">
            <p>Для правильной работы админки неободимо включить JavaScript</p>
            <p>Для корректной работы админки используйте
                <a href='http://mozilla-russia.org/' target='_blank'>Firefox 4</a> или 
                <a href='http://www.google.com/chrome/?hl=ru' target='_blank'>Google Chrome</a>
            </p>            
        </div>
    </td>
  </tr>
  <tr>
    <td class="foot" colspan='2'>
	<?php
            // Подключаем создателя
            include ("blocks/creator.php");
        ?>	
    </td>
  </tr>
</table>

</body>
</html>
