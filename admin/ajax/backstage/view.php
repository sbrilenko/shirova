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
$qwery="SELECT * FROM backstage ORDER BY data_create DESC";
$db -> query($qwery);

if ($db -> getCount() > 0) {
    // достаем в массив полученные данные
    $arrItems = $db -> getArray();
	
    // Цикл по записям
    foreach ($arrItems as $item) {

        echo "<div class='bigItem'>";
        echo "<table cellpadding='3px' cellspaicing='3px' width='100%'>";
        // ---------------------------------------------------
        echo "<tr>";
		echo "<td class='titles'>ссылка </td>";
		  echo "<td class='text'>".$item['flv']."</td>";
        echo "</tr>";
        echo "<tr>";
		
        echo "<td class='titles'>Заказчик</td>";

        $description = validClass::cutText($item['title']);
        echo "<td class='text'>".$description."</td>";
        echo "<td class='buttons'>";
        echo "<a id='del' href='".$item['id']."'>
                  <img src='img/b_drop.png' alt='Удалить' title='Удалить' /></a>";
        echo "</td>";
        echo "</tr>";
        // ---------------------------------------------------
        echo "<tr>";
        echo "<td class='titles'>Описание</td>";

        $description = validClass::cutText($item['description']);

        echo "<td class='text'>".$description."</td>";
		 echo "<td class='buttons'>";
        echo "<a href='#' onclick=\"loadBlock('ajax/backstage/edit.php', 'edit', ".$item['id'].");\">
                  <img src='img/b_edit.png' alt='Редактировать' title='Редактировать' /></a>";
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

	 <script type="text/javascript">
	 $('a#del img').bind('click',function()
   {
   	$.post("ajax/backstage/del.php", {id:$(this).parents().attr('href')}, function(data){
   		 $('#actionContent').html(data);
         
							})
   	return false;
   })
	</script>				  

					
					
				
			
			