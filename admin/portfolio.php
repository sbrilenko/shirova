<?php
require_once 'lock.php';
// Подключаем заголовок
include "blocks/head.php";
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/scripts/config.php";
require_once $root."/scripts/class.invis.db.php";
?>

<table height='100%' cellpadding="2" cellspacing="0" class="main">
  <tr>
    <td class="head">
        <?php 
        // Вехнее меню
        $tut = 'portfolio';
        include "blocks/menu.php"; 
        ?>
    </td>
  </tr>
  <tr>
    <td id='content'>
        <div id='action'> 
            <a href="#" onclick="loadBlock('ajax/portfolio/view.php', '', 0, this);" class='tut'>Просмотр портфолио</a> | 
            <a href="#" onclick="loadBlock('ajax/portfolio/edit.php', 'add', 0, this);">Добавить работу</a><br />
            <?php

            // Инициализируем подключение
            $db = db :: getInstance();

            // Достаем категории
            $qwery = "SELECT id, title
                      FROM portfolio_cat ORDER BY title";
            $db -> query($qwery);	
            $arr = $db -> getArray();

            print "<select id='portfolio_cat_index' name='portfolio_cat' onChange=\"sendCat(this, 'ajax/portfolio/view.php', 'load_portfolio_cat');\">";
            print "<option value='-1'>Выберите категорию</option>";
            foreach ($arr as $myrow_) {
                if ($myrow_['title'] == date("Y"))
                    print "<option value='".$myrow_['id']."' selected='selected'>".$myrow_['title']."</option>";
                else
                    print "<option value='".$myrow_['id']."'>".$myrow_['title']."</option>";
            }
            print "</select>";

            ?>
        </div>

        <div id='actionContent'> 

            <?php
            include "ajax/portfolio/view.php"; 
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
