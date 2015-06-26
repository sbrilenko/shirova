<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";
// Подключение отправки формы
echo '<script type="text/javascript" src="js/jquery.form.js"></script>';

$name_dir = "team_model";

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
    $targetPath = $root . "/img/".$name_dir."/";
    
    switch ($type) {
        case "img":
            $qwery = "SELECT photo 
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
                      SET photo = ''
                      WHERE id='".$id."'";
            $db -> query($qwery);              
            break;
        
        case "imgGal":
            $qwery = "SELECT * 
                      FROM ".$name_dir."_gallery
                      WHERE id='".$id."'";
            
            // Удаляем фото
            $db -> query($qwery);
            $photo = $db -> getRow();

            $src_old = $targetPath.$photo['photo'];
            $thumb_old = $targetPath."thumb_".$photo['photo'];
            $small_old = $targetPath.$photo['photo_small'];
            $thumb_small_old  = $targetPath."thumb_".$photo['photo_small'];
            
            @unlink($src_old);
            @unlink($thumb_old);
            @unlink($small_old);
            @unlink($thumb_small_old);
            
            $qwery = "DELETE FROM ".$name_dir."_gallery
                      WHERE id='".$id."'";
            $db -> query($qwery);  
            
            $id = $photo['id_team_model'];
            break; 
        
        
        case "imgAll":
            $qwery = "SELECT * 
                      FROM ".$name_dir."_gallery
                      WHERE id_team_model='".$id."'";
            
            // Удаляем фото
            $db -> query($qwery);
            
            if ($db -> getCount() > 0) {   
                // достаем в массив полученные данные
                $arrItems = $db -> getArray();

                foreach ($arrItems as $item) {

                    $src_old = $targetPath.$item["photo"];
                    $thumb_old = $targetPath."thumb_".$item['photo'];
                    $small_old = $targetPath.$item['photo_small'];
                    $thumb_small_old  = $targetPath."thumb_".$item['photo_small'];
                    @unlink($src_old);
                    @unlink($thumb_old);
                    @unlink($small_old);
                    @unlink($thumb_small_old);
                }
            }           
               
            $qwery = "DELETE FROM ".$name_dir."_gallery
                      WHERE id_team_model='".$id."'";
            $db -> query($qwery);  
            break;  
            
        case "imgChecked":
            
            $arr = explode(";", $ids);

            if (count ($arr) > 0) {
                
                $paramIds = "";
            
                $qwery = "SELECT * 
                          FROM ".$name_dir."_gallery
                          WHERE ";
            
                foreach ($arr as $elem) {
                    if ($elem > 0)
                        $paramIds .= "id='".$elem."' OR "; 
                }
                
                //Обрезаем лишнее
                $sub = substr($paramIds, strlen($paramIds)-4,3);

                if ($sub == " OR")
                    $paramIds = substr($paramIds, 0, strlen($paramIds) - 4);

                $qwery .= $paramIds;
                //echo $ids;
                //exit;

                // Удаляем фото
                $db -> query($qwery);

                if ($db -> getCount() > 0) {   
                    // достаем в массив полученные данные
                    $arrItems = $db -> getArray();

                    foreach ($arrItems as $item) {

                        $src_old = $targetPath.$item["photo"];
                        $thumb_old = $targetPath."thumb_".$item['photo'];
                        $small_old = $targetPath.$item['photo_small'];
                        $thumb_small_old  = $targetPath."thumb_".$item['photo_small'];
                        @unlink($src_old);
                        @unlink($thumb_old);
                        @unlink($small_old);
                        @unlink($thumb_small_old);
                    }
                }           

                $qwery = "DELETE FROM ".$name_dir."_gallery
                          WHERE ".$paramIds;
                $db -> query($qwery);  
                break;  
                
            }
         
            
    }
    
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
echo "размер ".$maxWidthTeamModelBig."x".$maxHeightTeamModelBig." px";
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
echo "<td class='left'>Имя</td>";
echo "<td class='right'>";
echo "<input type='text' name='name' id='name' value='".$item['name']."'>";
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
echo "<td class='left'>Фото";

echo "<div class='help'>";
echo "только *.png <br />";
echo "большая ".$maxWidthTeamModelGalleryBig."x".$maxHeightTeamModelGalleryBig." px<br />";
echo "маленькая ".$maxWidthTeamModelGallerySmall."x".$maxHeightTeamModelGallerySmall." px<br />";
echo "или ".$maxWidthTeamModelGallerySmallVertical."x".$maxHeightTeamModelGallerySmallVertical." px";
echo "</div>";

echo "</td>";
echo "<td class='right' id='images'>";

echo "<table cellpadding='0' cellspaicing='0' id='pictures'>";
echo "<tr align='center'>";
echo "<td>";
echo "<p>Большое фото</p>";
echo "</td>";           
echo "<td>";
echo "<p>Маленькое фото</p>";
echo "</td>";           
echo "<td>";
echo "<p>Добавить</p>";
echo "</td>"; 
echo "</tr>";    


if ($item != null) {
    // Достаем фото
    $qwery = "SELECT * 
              FROM team_model_gallery 
              WHERE id_team_model='".$id."'";
    $db -> query($qwery);
    $arr_images = $db -> getArray();
    
    // если есть выводим на экран
    if (count($arr_images) > 0) {
        foreach ($arr_images as $img) {
            
            echo "<tr align='center'>";
            echo "<td>";
            echo "<img src='/img/".$name_dir."/thumb_".$img['photo']."' 
                       alt='Изображение большое' 
                       title='Изображение большое' 
                       width='70px' />  ";

            echo "</td>";           
            echo "<td>";
            echo "<img src='/img/".$name_dir."/thumb_".$img['photo_small']."' 
                       alt='Изображение маленькое' 
                       title='Изображение маленькое' 
                       width='70px' />  ";

            echo "</td>";           
            echo "<td>";
            echo "<input type='checkbox' value='".$img['id']."'/><br/><br/>";
            echo "<a href='#' onclick=\"loadBlock('ajax/".$name_dir."/edit.php', 'del', ".$img['id'].", null, 'imgGal');\">
                  <img src='img/b_drop.png' alt='Удалить' title='Удалить' /></a>";
            echo "</td>"; 
            echo "</tr>";
            
        }
        echo "<tr align='center'>";
        echo "<td colspan='3'>";
        echo '<div id="buttons-checkbox" style="margin: 5px;">';
        echo "<a href='javascript: checkAll(true);'>Отметить все</a> | ";
        echo "<a href='javascript: checkAll(false);'>Снять отметки</a> | ";
        echo "<a href='#' onClick=\"deleteChecked('ajax/".$name_dir."/edit.php', 'del', ".$item['id'].", 'imgChecked');\">Удалить отмеченные</a> | ";
        echo "<a href='#' onClick=\"loadBlock('ajax/".$name_dir."/edit.php', 'del', ".$item['id'].", null, 'imgAll');\">Удалить все</a>";
        echo "</div>";
        echo "</td>";           
        echo "</tr>";   
 
    }     
}

echo "<tr align='center'>";
echo "<td>";
echo "<input type='file' name='url_image1' accept='image/png'> ";
echo "</td>";           
echo "<td>";
echo "<input type='file' name='url_image2' accept='image/png'> ";
echo "</td>";           
echo "<td>";
echo "<input type='submit' value='+'>";
echo "</td>"; 
echo "</tr>";    
echo "</table>";
 
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
                
                var id = responseText.replace(" ", "").replace(/[\r\n]/g, "");
                
                loadBlock('ajax/<?= $name_dir; ?>/edit.php', 'edit', id);
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
    
    //------------------------------------------
    var optionsUpload = {
        target: "#progress-form",
        url:    "ajax/<?= $name_dir; ?>/upload.php",
        
        beforeSubmit: function(jqForm) { // Здесь проверяем данные формы
            $('#progress-form').text('Обновление данных...');
            alert ();
        },

        success: function(responseText) { // Здесь проверяем ответ
            $('#progress-form').html(responseText);
        }
    };

    // привязываем событие submit к форме
    $('#uploadForm').submit(function() { 
        $(this).ajaxSubmit(optionsUpload); 
            return false;
    });    

});

    
</script>