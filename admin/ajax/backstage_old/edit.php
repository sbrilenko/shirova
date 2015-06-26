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
  
$item = null;
if (($action == 'edit') && $id > 0) {

    // Достаем
    $qwery = "SELECT * 
              FROM backstage 
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
echo "<td class='left'>Вставте ссылку с сайта YouTube.com";

echo "</td>";
echo "<td class='right'>";

if ($item !=null) {
    echo "<table cellpadding='0' cellspaicing='0'>";
    echo "<tr>";

    echo "<td class='right'>";
    echo "<input type='text' name='video' id='video' value='".$item['flv']."'>";
    //echo "<span id='progress-image'></span>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";        
}
else {
    echo "<input type='text' name='video' id='video' value=''>";
}
        

echo "</td>";
echo "</tr>";

//------------------------------------
echo "<tr>";
echo "<td class='left'>Заказчик</td>";
echo "<td class='right'>";
echo "<input type='text' name='client' id='client' value='".$item['title']."'>";
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
echo "<div>Как скопировать ссылку с youtube.com</div>";
echo "<div><img style='width:695px;height:510px;' src='../img/back_yout_help.png'/></div>";
echo "</div>";


?>
<script type="text/javascript">

$(document).ready(function(){
    
    <?php if ($item == null) {?>
        $('#portfolio_cat').attr('value', $('#portfolio_cat_index').val());
    <?php } ?>
    
    var optionsSave = {
        target: "#progress-form",
        url:    "ajax/backstage/save.php",
        
        beforeSubmit: function(jqForm) { // Здесь проверяем данные формы
            $('#progress-form').text('Сохранение данных...');
        },

        success: function(responseText) { // Здесь проверяем ответ
            if (responseText.indexOf("red") == -1) {
                    location.href='backstage.php';
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
        url:    "ajax/backstage/update.php",
        
        beforeSubmit: function(jqForm) { // Здесь проверяем данные формы
            $('#progress-form').text('Обновление данных...');
        },

        success: function(responseText) { // Здесь проверяем ответ
            if (responseText.indexOf("red") == -1) {
                    location.href='backstage.php';
               // loadBlock('ajax/backstage/edit.php', 'edit', <?php echo ($item !== null) ? $item['id'] : 0;?>)
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