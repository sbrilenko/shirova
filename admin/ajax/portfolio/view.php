<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

// Проверка и очистка входящих данных
if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);

if(isset($_POST ['action'])) 
    if (!$action = validClass::sanitiseString($_POST['action']))
       unset($action);    

if(isset($_POST ['portfolio_cat'])) 
    if (!$portfolio_cat = validClass::validNumber($_POST['portfolio_cat']))
       unset($portfolio_cat);   
 
// Подключение к БД
$db = db :: getInstance();

// Удаляем запись
if ($action == "del" && $id > 0) {
	
    // Достаем фотки
    $qwery = "SELECT photo  
              FROM portfolio 
              WHERE id='".$id."'";
    $db -> query($qwery);	
    $value = $db -> getValue();
    
    // Удаляем фотки
    $uploaddir = $root.'/img/portfolio/';
    @unlink($uploaddir . $value);
    @unlink($uploaddir . "thumb_" . $value);
    
    // Удаляем запись
    $qwery = "DELETE FROM portfolio 
              WHERE id='".$id."'";
    $db -> query($qwery);
}

// Если задана категория учитываем это в запросе
if ($action == 'load_portfolio_cat' && $portfolio_cat > 0) {
	// Достаем 
	$qwery = "SELECT portfolio.*, 
                         portfolio_cat.title AS portfolio_cat
                  FROM portfolio 
                  LEFT JOIN portfolio_cat 
                  ON portfolio.id_portfolio_cat = portfolio_cat.id
                  WHERE portfolio.id_portfolio_cat='".$portfolio_cat."'";
}
else {
    
    if ($portfolio_cat < 0)
	// Достаем публикации
	$qwery = "SELECT portfolio.*, 
                     portfolio_cat.title AS portfolio_cat
              FROM portfolio
              INNER JOIN portfolio_cat 
              ON portfolio.id_portfolio_cat = portfolio_cat.id";
    else 
        // Достаем публикации
	$qwery = "SELECT portfolio.*, 
                     portfolio_cat.title AS portfolio_cat
              FROM portfolio
              INNER JOIN portfolio_cat 
              ON portfolio.id_portfolio_cat = portfolio_cat.id
              WHERE portfolio.id_portfolio_cat IN (SELECT id FROM portfolio_cat WHERE title='" . date("Y") . "')";
}

$db -> query($qwery);

if ($db -> getCount() > 0) {
    // достаем в массив полученные данные
    $arrItems = $db -> getArray();

    // Цикл по записям
    foreach ($arrItems as $item) {

        echo "<div class='bigItem'>";
        echo "<table cellpadding='3px' cellspaicing='3px' width='100%'>";
        echo "<tr>";
        echo "<td rowspan='3' width='150px' align='center'>";

        // Изображение
        if ($item['photo'] == '' || !is_file($root."/img/portfolio/thumb_".$item['photo']))
            echo "<img width='128px' src='img/empty.gif' alt='Нет изображения' title='Нет изображения' />";
        
        else 
            echo "<img src='/img/portfolio/thumb_".$item['photo']."'
                       alt='Изображение' 
                       title='Изображение' 
                       width='128px'/>";   

        echo "</td>";

        echo "<td class='titles'>Категория</td>";
        echo "<td class='text'>".$item['portfolio_cat']."</td>";
        echo "<td class='buttons'>";
        echo "<a href='#' onclick=\"loadBlock('ajax/portfolio/edit.php', 'edit', ".$item['id'].");\">
                  <img src='img/b_edit.png' alt='Редактировать' title='Редактировать' /></a>";
        echo "</td>";
        echo "</tr>";
        // ---------------------------------------------------
        echo "<tr>";
        echo "<td class='titles'>Заказчик</td>";

        //$description = validClass::cutText($item['client']);
        $qwery = "SELECT name FROM partner_logo WHERE id=".$item['client2']." ORDER BY name";
		$db->query($qwery);
		if($db->getCount()>0){
			 echo "<td class='text'>".$db->getValue()."</td>" ;
		}
		else
		{
			 echo "<td class='text'></td>" ;
		}
       
        echo "<td class='buttons'>";
        echo "<a href='#' onclick=\"deleteItem('ajax/portfolio/view.php', 'del', ".$item['id'].");\">
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
        echo "</table>";
        echo "</div>";


    } // end foreach ($arrItems as $item) { 
    
} // end if ($db -> getCount() > 0)
else {
    echo "<p class='error'>Ничего не найдено</p>";
}
	
?>

					  

					
					
				
			
			