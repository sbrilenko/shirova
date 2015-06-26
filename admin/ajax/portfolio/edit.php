<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";
// Подключение отправки формы
echo '<script type="text/javascript" src="js/jquery.form.js"></script>';

if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);

if(isset($_POST ['action'])) 
    if (!$action = validClass::sanitiseString($_POST['action']))
       unset($action);   
    
if(isset($_POST ['type'])) 
    if (!$type = validClass::sanitiseString($_POST['type']))
       unset($type);  
    
// Инициализируем подключение
$db = db :: getInstance();   

// Если пришла команда удалить файл
if ($action == 'del' && $id > 0)  
{
    $targetPath = $root . '/img/portfolio/';
    
    switch ($type) {
        case "img":
            $qwery = "SELECT photo 
                      FROM portfolio
                      WHERE id='".$id."'";
            // Удаляем фото
            $db -> query($qwery);
            $photo = $db -> getValue();

            $src_old = $targetPath.$photo;
            $thumb_old = $targetPath."thumb_".$photo;

            @unlink($src_old);
            @unlink($thumb_old);

            // Обновляем 
            $qwery = "UPDATE portfolio
                      SET photo = ''
                      WHERE id='".$id."'";
            $db -> query($qwery);              
            break;
    }
}
    
$item = null;
    
if (($action == 'edit' || $action == 'del') && $id > 0) {

    // Достаем
    $qwery = "SELECT * 
              FROM portfolio 
              WHERE id='".$id."'";
    $db -> query($qwery);

    $item = $db -> getRow();
}

echo "<div id='edit'>";
echo "<fieldset>";
echo "<legend align='center'>". (($item !== null) ? "Редактирование работы" : "Добавить работу") . "</legend>";
echo "<form name='form' id='". (($item !== null) ? "editForm" : "addForm") . "' method='post'>";
echo "<table >";
//------------------------------------
echo "<tr>";
echo "<td class='left'>Изображение";

echo "<div class='help'>";
echo "только *.png <br />";
echo "размер ".$maxWidthPortfolioBig."x".$maxHeightPortfolioBig." px";
echo "</div>";

echo "</td>";
echo "<td class='right'>";

if ($item !== null) {
    echo "<table cellpadding='0' cellspaicing='0'>";
    echo "<tr>";
    
    // Изображение
    if ($item['photo'] != '' && is_file($root."/img/portfolio/thumb_".$item['photo'])) {
        
        echo "<td class='in_table_img'>";
        echo "<img src='/img/portfolio/thumb_".$item['photo']."'
                   alt='Изображение' 
                   title='Изображение' 
                   width='128px'/>"; 
        
        echo "</td>";
        echo "<td class='in_table_drop'>";
        echo "<a href='#' onclick=\"loadBlock('ajax/portfolio/edit.php', 'del', ".$item['id'].", null, 'img');\">
              <img src='img/b_drop.png' alt='Удалить' title='Удалить' /></a>";
        echo "</td>";
    }	

    echo "<td class='right'>";
    echo "<input type='file' name='url_image' accept='image/png'> ";
    //echo "<span id='progress-image'></span>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";        
}
else {
    echo "<input type='file' name='url_image' accept='image/png'> ";
}
        

echo "</td>";
echo "</tr>";
//------------------------------------razdel
echo "<tr>";
echo "<td class='left'>Раздел</td>";
echo "<td class='right'>";

// Достаем категории
$qwery = "SELECT numb, title 
          FROM portfolio_razdel ORDER BY numb";
$db -> query($qwery);	
$arr = $db -> getArray();

print "<select id='portfolio_razdel' name='portfolio_razdel'>";
if(empty($item['razdel']))
{
	foreach ($arr as $index=>$myrow_) {
		
		  $selected = ($index == 0) ? 'selected' : '';
   		 print "<option value='".$myrow_['numb']."' ".$selected.">".$myrow_['title']."</option>";   
	}
}
else
{
	foreach ($arr as $index=>$myrow_) {

		 $selected = ($item['razdel'] == $myrow_['numb']) ? 'selected' : '';
   		 print "<option value='".$myrow_['numb']."' ".$selected.">".$myrow_['title']."</option>";
	}
}

print "</select>";

echo "</td>";
echo "</tr>";

//------------------------------------
echo "<tr>";
echo "<td class='left'>Категория</td>";
echo "<td class='right'>";

// Достаем категории
$qwery = "SELECT id, title 
          FROM portfolio_cat ORDER BY title";
$db -> query($qwery);	
$arr = $db -> getArray();

print "<select id='portfolio_cat' name='portfolio_cat'>";
print "<option value='0'>Выберите категорию</option>";
foreach ($arr as $myrow_) {
    $selected = ($item['id_portfolio_cat'] == $myrow_['id']) ? 'selected' : '';
    print "<option value='".$myrow_['id']."' ".$selected.">".$myrow_['title']."</option>";
}
print "</select>";

echo "</td>";
echo "</tr>";

//------------------------------------
echo "<tr>";
echo "<td class='left'>Заказчик</td>";
echo "<td class='right'>";
//echo "<input type='text' name='client' id='client' value='".$item['client']."'>";
$qwery = "SELECT id,name FROM partner_logo ORDER BY name";
		  
$db -> query($qwery);	
$arr = $db -> getArray();
print "<select id='name' name='name'>";

if(empty($item['client2']))
{
	print "<option value='0'>Выберите заказчика</option>";
	foreach ($arr as $myrow_) {
    print "<option value='".$myrow_['id']."' ".$selected.">".$myrow_['name']."</option>";
	}
}
else
{
	foreach ($arr as $myrow_) {
    $selected = ($item['client2'] == $myrow_['id']) ? 'selected' : '';
    print "<option value='".$myrow_['id']."' ".$selected.">".$myrow_['name']."</option>";
	}
}

print "</select>";

echo "</td>";
echo "</tr>";
//------------------------------------
echo "<tr>";
echo "<td class='left'>Описание</td>";
echo "<td class='right'>";

$editorClass = new editorClass();

$description = $editorClass->replaceToDraw($item['description']);

$editorClass->drawEditor('description', $description);

echo "</td>";
echo "</tr>";
//------------------------------------
echo "<tr>";
echo "<td class='left'>&nbsp;</td>";
echo "<td class='right'>";
echo "<span id='progress-form'></span>";
echo "</td>";
echo "</tr>";
//------------------------------------
echo "<tr>";
echo "<td class='left'>&nbsp;</td>";
echo "<td class='right'>";

echo "<input type='hidden' name='id' value='".$item['id']."'>";

echo "<input type='submit' value='Сохранить данные'>";
echo "</td>";
echo "</tr>";
//------------------------------------
echo "</table>";
echo "</form>";
echo "</fieldset>";
echo "</div>";


?>
<script type="text/javascript">

$(document).ready(function(){
    
    <?php if ($item == null) {?>
        $('#portfolio_cat').attr('value', $('#portfolio_cat_index').val());
    <?php } ?>
    
    var optionsSave = {
        target: "#progress-form",
        url:    "ajax/portfolio/save.php",
        
        beforeSubmit: function(jqForm) { // Здесь проверяем данные формы
            $('#progress-form').text('Сохранение данных...');
        },

        success: function(responseText) { // Здесь проверяем ответ
            if (responseText.indexOf("red") == -1) {
                    location.href='portfolio.php';
            }
        }
    };

    // привязываем событие submit к форме
    $('#addForm').submit(function() { 
        $(this).ajaxSubmit(optionsSave); 
            return false;
    }); 
    
    //------------------------------------------
    var optionsUpdate = {
        target: "#progress-form",
        url:    "ajax/portfolio/update.php",
        
        beforeSubmit: function(jqForm) { // Здесь проверяем данные формы
            $('#progress-form').text('Обновление данных...');
        },

        success: function(responseText) { // Здесь проверяем ответ
            if (responseText.indexOf("red") == -1) {
               loadBlock('ajax/portfolio/edit.php', 'edit', <?php echo ($item !== null) ? $item['id'] : 0;?>)
            }
        }
    };

    // привязываем событие submit к форме
    $('#editForm').submit(function() { 
        $(this).ajaxSubmit(optionsUpdate); 
            return false;
    });     

});

    
</script>