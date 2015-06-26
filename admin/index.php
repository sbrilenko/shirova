<?php
require_once 'lock.php';
// Подключаем заголовок
include "blocks/head.php";
?>

<table height='100%' cellpadding="2" cellspacing="0" class="main">
  <tr>
    <td class="head">
        <?php 
        // Вехнее меню
        $tut = 'home';
        include "blocks/menu.php"; 
        ?>
    </td>
  </tr>
  <tr>
    <td id='content'>
        <div id='action'> 
            <a href="#" onclick="loadBlock('ajax/home/view.php', '', 0, this);" class='tut'>Просмотр изображений</a> | 
            <a href="#" onclick="loadBlock('ajax/home/edit.php', 'add', 0, this);">Добавить изображение</a><br />
        </div>

        <div id='actionContent'> 

            <?php
            include "ajax/home/view.php"; 
            ?>

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
