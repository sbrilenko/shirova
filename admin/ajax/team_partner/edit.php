<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";
// Подключение отправки формы
echo '<script type="text/javascript" src="js/jquery.form.js"></script>';

$name_dir = "team_partner";

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
    $targetPath = $root . "/img/".$name_dir."/";
    
    switch ($type) {
        case "img":
            
            $cell = "photo";
            break;
    }
    
    $qwery = "SELECT ".$cell." 
              FROM ".$name_dir."
              WHERE id='".$id."'";
    // Удаляем фото
    $db -> query($qwery);
    $photo = $db -> getValue();

    $src_old = $targetPath.$photo;
    $thumb_old = $targetPath."thumb_".$photo;

    @unlink($src_old);
    @unlink($thumb_old);

    // Обновляем 
    $qwery = "UPDATE ".$name_dir."
              SET ".$cell." = ''
              WHERE id='".$id."'";
    $db -> query($qwery);  
}
    
$item = null;
    
if (($action == 'edit' || $action == 'del') && $id > 0) {

    // Достаем
    $qwery = "SELECT * 
              FROM ".$name_dir." 
              WHERE id='".$id."'";
    $db -> query($qwery);

    $item = $db -> getRow();
}

echo "<div id='edit'>";
echo "<fieldset>";
echo "<legend align='center'>". (($item !== null) ? "Редактирование команды" : "Добавить команду") . "</legend>";
echo "<form name='form' id='". (($item !== null) ? "editForm" : "addForm") . "' method='post'>";
echo "<table >";
//------------------------------------
echo "<tr>";
echo "<td class='left'>Изображение";

echo "<div class='help'>";
echo "только *.png <br />";
echo "размер ".$maxWidthTeamPartnerBig."x".$maxHeightTeamPartnerBig." px";
echo "</div>";

echo "</td>";
echo "<td class='right'>";

if ($item !== null) {
    echo "<table cellpadding='0' cellspaicing='0'>";
    echo "<tr>";
    
    // Изображение
    if ($item['photo'] != '' && is_file($root."/img/".$name_dir."/thumb_".$item['photo'])) {
        
        echo "<td class='in_table_img'>";
        echo "<img src='/img/".$name_dir."/thumb_".$item['photo']."'
                   alt='Изображение' 
                   title='Изображение' 
                   width='128px'/>"; 
        
        echo "</td>";
        echo "<td class='in_table_drop'>";
        echo "<a href='#' onclick=\"loadBlock('ajax/".$name_dir."/edit.php', 'del', ".$item['id'].", null, 'img');\">
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
//------------------------------------
echo "<tr>";
echo "<td class='left'>Ссылка</td>";
echo "<td class='right'>";
echo "<input type='text' name='url' id='url' value='".$item['url']."'>";
echo "</td>";
echo "</tr>";
//------------------------------------
echo "<tr>";
echo "<td class='left'>Вес</td>";
echo "<td class='right'>";

if ($item == null || $item['weight'] == '') {
    $qwery = "SELECT max(id) FROM ".$name_dir;
    $db -> query($qwery);
    $weight = $db -> getValue(); 
    $weight++;
}
else 
    $weight = $item['weight'];

echo "<input type='text' name='weight' id='weight' value='".$weight."'>";
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
    
    var optionsSave = {
        target: "#progress-form",
        url:    "ajax/<?= $name_dir; ?>/save.php",
        
        beforeSubmit: function(jqForm) { // Здесь проверяем данные формы
            $('#progress-form').text('Сохранение данных...');
        },

        success: function(responseText) { // Здесь проверяем ответ
            if (responseText.indexOf("red") == -1) {
                    location.href='<?= $name_dir; ?>.php';
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
        url:    "ajax/<?= $name_dir; ?>/update.php",
        
        beforeSubmit: function(jqForm) { // Здесь проверяем данные формы
            $('#progress-form').text('Обновление данных...');
        },

        success: function(responseText) { // Здесь проверяем ответ
            if (responseText.indexOf("red") == -1) {
                loadBlock('ajax/<?= $name_dir; ?>/edit.php', 'edit', <?php echo ($item !== null) ? $item['id'] : 0;?>)
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