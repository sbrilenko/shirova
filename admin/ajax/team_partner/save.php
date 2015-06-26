<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

$name_dir = "team_partner";

$maxWidthBig = $maxWidthTeamPartnerBig;
$maxHeightBig = $maxHeightTeamPartnerBig;

$maxWidthThumb = $maxWidthTeamPartnerThumb;
$maxHeightThumb = $maxHeightTeamPartnerThumb;

$db = db :: getInstance();

$editorClass = new editorClass();
    
if(isset($_POST ['url'])) 
    if (!$url = validClass::sanitiseString($_POST['url']))
       unset($url);

if(isset($_POST ['weight'])) 
    if (!$weight = validClass::validNumber($_POST['weight']))
       unset($weight);

$imageClass = new imageClass();

$qwery = "INSERT INTO ".$name_dir." 
            (url, weight) 
         VALUES 
            ('".$url."', '".$weight."')";
        
$db -> query($qwery);

$id = $db -> last();

echo "<p style='color:green;'>Данные успешно сохранены</p>";

if (($tempFile = $_FILES['url_image']['tmp_name']) != "") {
    
    $targetPath = $root . "/img/".$name_dir."/";
    
    if(!$image_info = $imageClass->getImageInfo($tempFile)) {
        echo "<p style='color:red;'>Обработка файла изображения невозможна</p>";
        exit;
    }

    if ($image_info['extension'] != "png") {
       echo "<p style='color:red;'>Допустимые расширения для изображения *.png</p>";
       exit;
    } 
    
    if ($image_info['width'] != $maxWidthBig || $image_info['height'] != $maxHeightBig) {
       echo "<p style='color:red;'>Допустимое разрешение для изобр. $maxWidthBig x $maxHeightBig px</p>";
       exit;
    }     

    if ($image_info['size'] > (1024 * 1024 * 10)) {
       echo "<p style='color:red;'>Файл изображения больше 10 Мб</p>";
       exit;
    }    

    $newNameFile = $id;
    $newNameFile .= '.'.$image_info['extension'];

    $uploadfile = $targetPath.$newNameFile;

    if (move_uploaded_file($tempFile, $uploadfile)) {

        $thumb = $targetPath."thumb_".$newNameFile;

        $imageClass->createImageThumb($uploadfile, $thumb, $maxWidthThumb, $maxHeightThumb); 
        // Обновляем 
        $qwery = "UPDATE ".$name_dir."
                  SET photo = '".$newNameFile."'
                  WHERE id='".$id."'";
        $db -> query($qwery);   
    }
    else {
        echo "<p style='color:red;'>Файл изображения не загружен</p>";
    }        
}
?> 