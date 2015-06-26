<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

$name_dir = "team_creative";

// Проверка и очистка входящих данных
if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);

if(isset($_POST ['action'])) 
    if (!$action = validClass::sanitiseString($_POST['action']))
       unset($action);    
 
// Подключение к БД
$db = db :: getInstance();

// Удаляем запись
if ($action == "del" && $id > 0) {
	
    // Достаем фотки
    $qwery = "SELECT photo, photo_small, photo_down  
              FROM ".$name_dir." 
              WHERE id='".$id."'";
    $db -> query($qwery);	
    $value = $db -> getRow();
    
    // Удаляем фотки
    $uploaddir = $root."/img/".$name_dir."/";
    @unlink($uploaddir . $value["photo"]);
    @unlink($uploaddir . "thumb_" . $value["photo"]); 
    @unlink($uploaddir . $value["photo_small"]);
    @unlink($uploaddir . "thumb_" . $value["photo_small"]);   
    @unlink($uploaddir . $value["photo_down"]);
    @unlink($uploaddir . "thumb_" . $value["photo_down"]);   
    
    // Удаляем запись
    $qwery = "DELETE FROM ".$name_dir." 
              WHERE id='".$id."'";
    $db -> query($qwery);
}

// Достаем картинки
$qwery = "SELECT * FROM ".$name_dir;


$db -> query($qwery);

if ($db -> getCount() > 0) {
    // достаем в массив полученные данные
    $arrItems = $db -> getArray();

    // Цикл по записям
    foreach ($arrItems as $item) {

        echo "<div class='bigItem'>";
        echo "<table cellpadding='3px' cellspaicing='3px' width='100%'>";
        echo "<tr>";
        echo "<td rowspan='5' width='150px' align='center'>";

        // Изображение
        if ($item['photo'] == '' || !is_file($root."/img/".$name_dir."/thumb_".$item['photo']))
            echo "<img width='128px' src='img/empty.gif' alt='Нет изображения' title='Нет изображения' />";
        
        else 
            echo "<img src='/img/".$name_dir."/thumb_".$item['photo']."'
                       alt='Изображение' 
                       title='Изображение' 
                       width='128px'/>";   

        echo "</td>";

        echo "<td class='titles'>ФИО</td>";
        echo "<td class='text'>".$item['name']."</td>";
        echo "<td class='buttons'>";
        echo "<a href='#' onclick=\"loadBlock('ajax/".$name_dir."/edit.php', 'edit', ".$item['id'].");\">
                  <img src='img/b_edit.png' alt='Редактировать' title='Редактировать' /></a>";
        echo "</td>";
        echo "</tr>";
        // ---------------------------------------------------
        echo "<tr>";
        echo "<td class='titles'>Должность</td>";
        echo "<td class='text'>".$item['position']."</td>";
        echo "<td class='buttons'>";
        echo "<a href='#' onclick=\"deleteItem('ajax/".$name_dir."/view.php', 'del', ".$item['id'].");\">
                  <img src='img/b_drop.png' alt='Удалить' title='Удалить' /></a>";
        echo "</td>";
        echo "</tr>";
        // ---------------------------------------------------
        echo "<tr>";
        echo "<td class='titles'>Описание</td>";
        
        $description = validClass::cutText($item['description']);

        echo "<td class='text'>".$description."</td>";
        echo "<td class='buttons'>&nbsp;</td>";
        echo "</tr>";
        // ---------------------------------------------------
        echo "<tr>";
        echo "<td class='titles'>Вес</td>";
        echo "<td class='text'>".$item['weight']."</td>";
        echo "<td class='buttons'>&nbsp;</td>";
        echo "</tr>";
        // ---------------------------------------------------
        echo "<tr>";
        echo "<td class='titles'>Еще изображения</td>";
        echo "<td class='text'>";

        // Изображение
        if ($item['photo_small'] != '' && is_file($root."/img/".$name_dir."/thumb_".$item['photo_small']))
            echo "<img src='/img/".$name_dir."/thumb_".$item['photo_small']."'
                       alt='Изображение поменьше' 
                       title='Изображение поменьше' 
                       width='50px'/>";   
        else
            echo "&nbsp;";
        
        // Изображение
        if ($item['photo_down'] != '' && is_file($root."/img/".$name_dir."/thumb_".$item['photo_down']))
            echo "<img src='/img/".$name_dir."/thumb_".$item['photo_down']."'
                       alt='Изображение снизу' 
                       title='Изображение снизу' 
                       width='50px'/>";   
        else
            echo "&nbsp;";

        echo "</td>";
        echo "<td class='buttons'>&nbsp;</td>";
        echo "</tr>";        
        // ---------------------------------------------------
        echo "</table>";
        echo "</div>";


    } // end foreach ($arrItems as $item) { 
    
} // end if ($db -> getCount() > 0)
else {
    echo "<p class='error'>Ничего не найдено</p>";
}
	
?>

					  

					
					
				
			
			