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
              FROM news 
              WHERE id='".$id."'";
    $db -> query($qwery);	
    $value = $db -> getValue();

    $uploaddir = $root.'/img/news/';
    @unlink($uploaddir . $value);
    @unlink($uploaddir . "thumb_" . $value);
    
    $qwery = "DELETE FROM news 
              WHERE id='".$id."'";
    $db -> query($qwery);
    
    // Удаляем фото из галлереи
    $qwery = "SELECT photo  
              FROM news_galery
              WHERE id_news='".$id."'";

    $db -> query($qwery);

    if ($db -> getCount() > 0) {   
        // достаем в массив полученные данные
        $arrItems = $db -> getArray();

        foreach ($arrItems as $item) {

            $src = '../../../img/news_gallery/'.$item["photo"];
            $src_thumb = '../../../img/news_galery/'."thumb_".$item["photo"];
            @unlink($src);
            @unlink($src_thumb);
        }

        $qwery = "DELETE FROM news_galery
                  WHERE id_news='".$id."'";
        $db -> query($qwery);
    }    
}

// Достаем картинки
$qwery = "SELECT * FROM news";

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
        if ($item['photo'] == '' || !is_file($root."/img/news/thumb_".$item['photo']))
            echo "<img width='128px' src='img/empty.gif' alt='Нет изображения' title='Нет изображения' />";
        
        else 
            echo "<img src='/img/news/thumb_".$item['photo']."'
                       alt='Изображение' 
                       title='Изображение' 
                       width='128px'/>";   

        echo "</td>";

        echo "<td class='titles'>Дата выхода</td>";
        $date_create = date("d-m-Y", strtotime($item['date_create']));
        echo "<td class='text'>".$date_create."</td>";
        echo "<td class='buttons'>";
        echo "<a href='#' onclick=\"loadBlock('ajax/news/edit.php', 'edit', ".$item['id'].");\">
                  <img src='img/b_edit.png' alt='Редактировать' title='Редактировать' /></a>";
        echo "</td>";
        echo "</tr>";
        // ---------------------------------------------------
        echo "<tr>";
        echo "<td class='titles'>Новость</td>";

        $description = validClass::cutText($item['text_rus']);

        echo "<td class='text'>".$description."</td>";
        echo "<td class='buttons'>";
        echo "<a href='#' onclick=\"deleteItem('ajax/news/view.php', 'del', ".$item['id'].");\">
                  <img src='img/b_drop.png' alt='Удалить' title='Удалить' /></a>";
        echo "</td>";
        echo "</tr>";

        // ---------------------------------------------------
        echo "<tr>";
        echo "<td class='titles'>Фото отчет</td>";

        // Достаем фото
        $qwery = "SELECT photo 
                  FROM news_galery 
                  WHERE id_news='".$item['id']."'";
        $db -> query($qwery);
        $arr_images = $db -> getArray();

        echo "<td class='text'>";

        // если есть выводим на экран
        if (count($arr_images) > 0) {
            foreach ($arr_images as $img) {
                 echo "<img src='/img/news_gallery/thumb_".$img['photo']."'
                       alt='Изображение фото отчета' 
                       title='Изображение фото отчета' 
                       width='50px'/>";
            }
        }
        else {
            echo "&nbsp";
        }

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

					  

					
					
				
			
			