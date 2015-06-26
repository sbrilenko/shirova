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
        $tut = 'partner_logo';
        include "blocks/menu.php"; 
        ?>
    </td>
  </tr>
  <tr>
    <td id='content'>
        <div id='action'> 
            <a href="#" onclick="loadBlock('ajax/partner_logo/view.php', '', 0, this);" class='tut'>Просмотр</a> | 
            <a href="#" onclick="loadBlock('ajax/partner_logo/edit.php', 'add', 0, this);">Добавить</a><br />
        </div>

        <div id='actionContent'> 

            <?php
            include "ajax/partner_logo/view.php"; 
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
