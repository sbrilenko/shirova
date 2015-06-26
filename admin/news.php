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
        $tut = 'news';
        include "blocks/menu.php"; 
        ?>
    </td>
  </tr>
  <tr>
    <td id='content'>
        <div id='action'> 
            <a href="#" onclick="loadBlock('ajax/news/view.php', '', 0, this);" class='tut'>Просмотр новостей</a> | 
            <a href="#" onclick="loadBlock('ajax/news/edit.php', 'add', 0, this);">Добавить новость</a><br />
        </div>

        <div id='actionContent'> 

            <?php
            include "ajax/news/view.php"; 
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
