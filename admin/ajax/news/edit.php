<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

// Подключение календаря
echo '<link rel="stylesheet" type="text/css" href="js/src_calendar/css/jscal2.css" />';
echo '<link rel="stylesheet" type="text/css" href="js/src_calendar/css/border-radius.css" />';
echo '<link rel="stylesheet" type="text/css" href="js/src_calendar/css/steel/steel.css" /> ';       
echo '<script type="text/javascript" src="js/src_calendar/js/jscal2.js"></script>';
echo '<script type="text/javascript" src="js/src_calendar/js/lang/ru.js"></script>';
// Подключение отправки формы
echo '<script type="text/javascript" src="js/jquery.form.js"></script>';
// Подключение мультивыгрузки
echo '<script type="text/javascript" src="js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>';
echo '<script type="text/javascript" src="js/uploadify/swfobject.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="js/uploadify/uploadify.css" />';

if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);

if(isset($_POST ['action'])) 
    if (!$action = validClass::sanitiseString($_POST['action']))
       unset($action);   
    
if(isset($_POST ['type'])) 
    if (!$type = validClass::sanitiseString($_POST['type']))
       unset($type);  
    
if(isset($_POST ['ids'])) 
    if (!$ids = validClass::sanitiseString($_POST['ids']))
       unset($ids);      
    
// Инициализируем подключение
$db = db :: getInstance();   

// Если пришла команда удалить файл
if ($action == 'del' && $id > 0)  
{
    $targetPath = $root . '/img/news/';
    
    switch ($type) {
        case "img":
            $qwery = "SELECT photo 
                      FROM news
                      WHERE id='".$id."'";
            // Удаляем фото
            $db -> query($qwery);
            $photo = $db -> getValue();

            $src_old = $targetPath.$photo;
            $thumb_old = $targetPath."thumb_".$photo;

            @unlink($src_old);
            @unlink($thumb_old);

            // Обновляем 
            $qwery = "UPDATE news
                      SET photo = ''
                      WHERE id='".$id."'";
            $db -> query($qwery);              
            break;
        
        case "imgGal":
            $qwery = "SELECT id_news, photo 
                      FROM news_galery
                      WHERE id='".$id."'";
            
            // Удаляем фото
            $db -> query($qwery);
             $photo = $db -> getRow();

            $src_old = '../../../img/news_gallery/'.$photo['photo'];
            $thumb_old = '../../../img/news_gallery/'."thumb_".$photo['photo'];

            @unlink($src_old);
            @unlink($thumb_old);
            
            $qwery = "DELETE FROM news_galery
                      WHERE id='".$id."'";
            $db -> query($qwery);  
            
            $id = $photo['id_news'];
            break;    
        
        case "imgAll":
            $qwery = "SELECT photo 
                      FROM news_galery
                      WHERE id_news='".$id."'";
            
            // Удаляем фото
            $db -> query($qwery);
            
            if ($db -> getCount() > 0) {   
                // достаем в массив полученные данные
                $arrItems = $db -> getArray();

                foreach ($arrItems as $item) {

                    $src_old = '../../../img/news_gallery/'.$item["photo"];
                    $thumb_old = '../../../img/news_gallery/'."thumb_".$item['photo'];
                    @unlink($src_old);
                    @unlink($thumb_old);
                }
            }           
               
            $qwery = "DELETE FROM news_galery
                      WHERE id_news='".$id."'";
            $db -> query($qwery);  
            break;  
            
        case "imgChecked":
            
            $arr = explode(";", $ids);
            $paramIds = "";
            
            $qwery = "SELECT photo 
                      FROM news_galery
                      WHERE ";
            
            if (count ($arr) > 1) {
                foreach ($arr as $elem) {
                    if ($elem > 0)
                        $paramIds .= "id='".$elem."' OR "; 
                }
            }
         
            //Обрезаем лишнее
            $sub = substr($paramIds, strlen($paramIds)-4,3);

            if ($sub == " OR")
                $paramIds = substr($paramIds, 0, strlen($paramIds) - 4);
            
            $qwery .= $paramIds;
            
            // Удаляем фото
            $db -> query($qwery);
            
            if ($db -> getCount() > 0) {   
                // достаем в массив полученные данные
                $arrItems = $db -> getArray();

                foreach ($arrItems as $item) {

                    $src_old = '../../../img/news_gallery/'.$item["photo"];
                    $thumb_old = '../../../img/news_gallery/'."thumb_".$item['photo'];
                    @unlink($src_old);
                    @unlink($thumb_old);
                }
            }           
               
            $qwery = "DELETE FROM news_galery
                      WHERE ".$paramIds;
            $db -> query($qwery);  
            break;              
    }
}
    
$item = null;
    
if (($action == 'edit' || $action == 'del') && $id > 0) {

    // Достаем
    $qwery = "SELECT * 
              FROM news 
              WHERE id='".$id."'";
    $db -> query($qwery);

    $item = $db -> getRow();
}

echo "<div id='edit'>";
echo "<fieldset>";
echo "<legend align='center'>". (($item !== null) ? "Редактирование новости" : "Добавить новость") . "</legend>";
echo "<form name='form' id='". (($item !== null) ? "editForm" : "addForm") . "' method='post'>";
echo "<table >";
//------------------------------------
echo "<tr>";
echo "<td class='left'>Изображение";

echo "<div class='help'>";
echo "только *.png <br />";
echo "размер 128х128 px";
echo "</div>";

echo "</td>";
echo "<td class='right'>";

if ($item !== null) {
    echo "<table cellpadding='0' cellspaicing='0'>";
    echo "<tr>";
    
    // Изображение
    if ($item['photo'] != '' && is_file($root."/img/news/thumb_".$item['photo'])) {
        
        echo "<td class='in_table_img'>";
        echo "<img src='/img/news/thumb_".$item['photo']."'
                   alt='Изображение' 
                   title='Изображение' 
                   width='128px'/>"; 
        
        echo "</td>";
        echo "<td class='in_table_drop'>";
        echo "<a href='#' onclick=\"loadBlock('ajax/news/edit.php', 'del', ".$item['id'].", null, 'img');\">
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
echo "<td class='left'>Дата выхода</td>";
echo "<td class='right'>";
$date_create = (($item !== null) ? date("d-m-Y", strtotime($item['date_create'])) : date("d-m-Y"));
echo "<input type='text' name='date_create' id='date_create' class='date' readonly value='".$date_create."'>";
echo "<button id='b_btn' type='button'>...</button>";
?>	
<script type="text/javascript">//<![CDATA[
        Calendar.setup({
                inputField : "date_create",
                trigger    : "b_btn",
                onSelect   : function() { this.hide() },
                dateFormat : "%d-%m-%Y"
        });
//]]></script>	
<?php
echo "</td>";
echo "</tr>";
//------------------------------------
echo "<tr>";
echo "<td class='left'>Описание</td>";
echo "<td class='right'>";

$editorClass = new editorClass();

$description = $editorClass->replaceToDraw($item['text_rus']);

$editorClass->drawEditor('description_rus', $description);

echo "</td>";
echo "</tr>";
//------------------------------------
echo "<tr>";
echo "<td class='left'>Фото отчет";

echo "<div class='help'>";
echo "только *.png <br />";
echo "размер 910x510 px. Групповая загрузка";
echo "</div>";

echo "</td>";
echo "<td class='right' id='images'>";

if ($item != null) {
    // Достаем фото
    $qwery = "SELECT id, photo 
              FROM news_galery 
              WHERE id_news='".$item['id']."'";
    $db -> query($qwery);
    $arr_images = $db -> getArray();

    // если есть выводим на экран
    if (count($arr_images) > 0) {
        foreach ($arr_images as $img) {
            echo "<div id='image_".$img['photo']."' style='display: inline-block;'>";
            
            echo "<table>";
            echo "<tr>";
            echo "<td>";
            echo "<img src='/img/news_gallery/thumb_".$img['photo']."' 
                       alt='Изображение фото отчета' 
                       title='Изображение фото отчета' 
                       width='70px' />  ";
            
            echo "</td>";           
            echo "<td>";
            echo "<input type='checkbox' value='".$img['id']."'/><br/><br/>";
            echo "<a href='#' onclick=\"loadBlock('ajax/news/edit.php', 'del', ".$img['id'].", null, 'imgGal');\">
                  <img src='img/b_drop.png' alt='Удалить' title='Удалить' /></a>";
            echo "</td>"; 
            echo "</tr>";
            echo "</table>";
            echo "</div>";
        }
        
        echo '<div id="buttons-checkbox" style="margin: 5px;">';
        echo "<a href='javascript: checkAll(true);'>Отметить все</a> | ";
        echo "<a href='javascript: checkAll(false);'>Снять отметки</a> | ";
        echo "<a href='#' onClick=\"deleteChecked('ajax/news/edit.php', 'del', ".$item['id'].", 'imgChecked');\">Удалить отмеченные</a> | ";
        echo "<a href='#' onClick=\"loadBlock('ajax/news/edit.php', 'del', ".$item['id'].", null, 'imgAll');\">Удалить все</a>";
        echo "</div><br />";    
    }

}

echo '<div id="response" style="margin-bottom: 3px;"></div>';
echo '<div id="fileQueue" style="margin-bottom: 3px;"></div>';
echo "<input type='file' name='images[]' multiple value='".$item['id']."'>";

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
        url:    "ajax/news/save.php",
        beforeSubmit: function(jqForm) { // Здесь проверяем данные формы
            $('#progress-form').text('Сохранение данных...');
        },

        success: function(responseText) { // Здесь проверяем ответ
            if (responseText.indexOf("red") == -1) {
                    location.href='news.php';
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
        url:    "ajax/news/update.php",
        
        beforeSubmit: function(jqForm) { // Здесь проверяем данные формы
            $('#progress-form').text('Обновление данных...');
        },

        success: function(responseText) { // Здесь проверяем ответ
            if (responseText.indexOf("red") ==-1) {
                loadBlock('ajax/news/edit.php', 'edit', <?php echo ($item !== null) ? $item['id'] : 0;?>)
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