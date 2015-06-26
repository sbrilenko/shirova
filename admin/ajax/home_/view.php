<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);

if(isset($_POST ['action'])) 
    if (!$action = validClass::sanitiseString($_POST['action']))
       unset($action);    
 
$db = db :: getInstance();

// Удаляем запись
if ($action == "del" && $id > 0) {
	
    // Достаем id картинок новости
    $qwery = "SELECT photo  
              FROM home 
              WHERE id='".$id."'";
    $db -> query($qwery);	
    $value = $db -> getValue();

    $uploaddir = $root.'/img/home/';
    @unlink($uploaddir . $value);
    @unlink($uploaddir . "thumb_" . $value);
    
    $qwery = "DELETE FROM home 
              WHERE id='".$id."'";
    $db -> query($qwery);
}

// Достаем картинки
$qwery = "SELECT * FROM home";

$db -> query($qwery);

if ($db -> getCount() > 0) {
    // достаем в массив полученные данные
    $arrItems = $db -> getArray();

    // Цикл по записям
    foreach ($arrItems as $item) {

        echo "<div class='pictureItem' id='item".$item['id']."'>";
        echo "<table cellpadding='3px' cellspaicing='3px' width='100%'>";
        echo "<tr>";
        echo "<td class='text'>";

        // Изображение
        if ($item['photo'] == '' || !is_file($root."/img/home/thumb_".$item['photo']))
            echo "<img width='128px' src='img/empty.gif' alt='Нет изображения' title='Нет изображения' />";
        
        else 
            echo "<img src='/img/home/thumb_".$item['photo']."'
                       alt='Изображение' 
                       title='Изображение' 
                       width='128px'/>";                        
        
        echo "</td>";

        echo "<td class='buttons'>";
            echo "<a href='#' onclick=\"loadBlock('ajax/home/edit.php', 'edit', ".$item['id'].");\">
                  <img src='img/b_edit.png' alt='Редактировать' title='Редактировать' /></a><br/><br/>";                
            
            echo "<a href='#' onclick=\"deleteItem('ajax/home/view.php', 'del', ".$item['id'].");\">
                  <img src='img/b_drop.png' alt='Удалить' title='Удалить' /></a>";
        echo "</td>";
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

					  

					
					
				
			
			