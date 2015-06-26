<?php
require_once 'lock.php';
// Подключаем заголовок
include "blocks/head.php";
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/scripts/config.php";
require_once $root."/scripts/class.invis.db.php";
echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
?>

<table height='100%' cellpadding="2" cellspacing="0" class="main">
  <tr>
    <td class="head">
        <?php 
        // Вехнее меню
        $tut = 'backstage';
        include "blocks/menu.php"; 
        ?>
    </td>
  </tr>
  <tr>
    <td id='content'>
        <div id='action'> 
            <a href="#" onclick="loadBlock('ajax/backstage/view.php', '', 0, this);" class='tut'>Список backstage</a> | 
            <a href="#" onclick="loadBlock('ajax/backstage/edit.php', 'add', 0, this);">Добавить backstage</a><br />
           
        </div>

        <div id='actionContent'> 

            <?php
            include "ajax/backstage/view.php"; 
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
