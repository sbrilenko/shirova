<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";
$db = db :: getInstance();

$editorClass = new editorClass();


if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);
    
if(isset($_POST ['portfolio_cat'])) 
    if (!$portfolio_cat = validClass::validNumber($_POST['portfolio_cat']))
       unset($portfolio_cat);
    
if(isset($_POST ['client'])) 
    if (!$client = validClass::sanitiseString($_POST['client']))
       unset($client);
    
if(isset($_POST ['description'])) 
    if (!$description = $editorClass->replaceToInsert($_POST['description']))
       unset($description);      
    
if (($client!='') AND ($description!='') AND ($_POST['video']!='') AND $_POST['date']!='') {
	$str=strpos($_POST['video'],'v=');
	$str2=strpos($_POST['video'],'feature');
	if($str>$str2)
	{$video_url=substr($_POST['video'], $str+2, $str.length);}
	else 
	{$video_url=substr($_POST['video'], $str+2, $str2-$str-3);}
	$video_url='www.youtube.com/v/'.$video_url;
	if($str==null)
	{
		$video_url=$_POST['video'];
	}
$date=explode('.',$_POST['date']);
$date=$date[2].'-'.$date[1].'-'.$date[0];
//http://www.youtube.com/watch?feature=player_detailpage&v=z0SFVDVXIhQ
//http://www.youtube.com/watch?v=7jSK443tTYM&feature=player_detailpage
//http://www.youtube.com/watch?v=yV1Lrm1vDdk&feature=player_profilepage
$qwery="UPDATE backstage SET data_create='".$date."', title='".$client."', description='".$description."',flv='".$video_url."' WHERE id=".$id;
        
$db -> query($qwery);
echo "<p style='color:green;'>Данные успешно обновлены</p>";
}
else echo "<p style='color:red;'>Все поля обязательны для заполнения</p>";

?>
<object style="height: 390px; width: 640px"><param name="movie" value="http://www.youtube.com/v/fwr1hm_oBxE?version=3"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="http://www.youtube.com/v/fwr1hm_oBxE?version=3" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="640" height="360"></object> 