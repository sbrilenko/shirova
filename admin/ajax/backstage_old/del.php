<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/class.invis.db.php";
require_once $root."/admin/classes/class.symbianm.valid.php";
$db = db :: getInstance();
$var=$_POST['id'];
$qwery = "DELETE FROM backstage WHERE id=".$var;
$db->query($qwery);
           $qwery="SELECT * FROM backstage";
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
         //location.href='/admin/portfolio.php';
         
							})
   	return false;
   })
 </script>