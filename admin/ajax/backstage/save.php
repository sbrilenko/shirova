<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

$db = db :: getInstance();

$editorClass = new editorClass();
if(isset($_POST ['client'])) 
    if (!$client = validClass::sanitiseString($_POST['client']))
       unset($client);
    
if(isset($_POST ['description'])) 
    if (!$description = $editorClass->replaceToInsert($_POST['description']))
       unset($description);
if (!empty($client) AND !empty($description) AND !empty($_POST['video']) AND !empty($_POST['start_period'])) {
	$str=strpos($_POST['video'],'v=');
	$str2=strpos($_POST['video'],'feature');
	if($str>$str2)
	{$video_url=substr($_POST['video'], $str+2, $str.length);}
	else 
	{$video_url=substr($_POST['video'], $str+2, $str2-$str-3);}
	$video_url='www.youtube.com/v/'.$video_url;
//http://www.youtube.com/watch?feature=player_detailpage&v=z0SFVDVXIhQ
//http://www.youtube.com/watch?v=7jSK443tTYM&feature=player_detailpage
//http://www.youtube.com/watch?v=yV1Lrm1vDdk&feature=player_profilepage
$date=explode('.',$_POST['start_period']);
$date=$date[2].'-'.$date[1].'-'.$date[0];
$qwery = "INSERT INTO backstage 
            ( title, description,flv, data_create) 
         VALUES 
            ( '".$client."', '".$description."','".$video_url."','".$date."')";
        
			$db -> query($qwery);
echo "<p style='color:green;'>Данные успешно сохранены</p>";
}
else echo "<p style='color:red;'>Все поля обязательны для заполнения</p>";


?> 