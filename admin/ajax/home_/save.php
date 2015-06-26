<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

$db = db :: getInstance();

$imageClass = new imageClass();

$qwery = "SELECT max(id) FROM home";

$db -> query($qwery);

$id = $db -> getValue();

if ($id == 0 || $id == '') {
    $id = 1;
}

echo "<p style='color:green;'>Данные успешно сохранены</p>";

if (($tempFile = $_FILES['url_image']['tmp_name']) != "") {
    
    $targetPath = $root . '/img/home/';
    
    if(!$image_info = $imageClass->getImageInfo($tempFile)) {
        echo "<p style='color:red;'>Обработка файла изображения невозможна</p>";
        exit;
    }

    if ($image_info['extension'] != "png") {
       echo "<p style='color:red;'>Допустимые расширения для изображения *.png</p>";
       exit;
    } 

    if ($image_info['width'] != $maxWidthHomeBig || $image_info['height'] != $maxHeightHomeBig) {
       echo "<p style='color:red;'>Допустимое разрешение $maxWidthHomeBig x $maxHeightHomeBig px</p>";
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

        $imageClass->createImageThumb($uploadfile, $thumb, $maxWidthHomeThumb, $maxHeightHomeThumb);
        
        $qwery = "INSERT INTO home 
                    (photo) 
                 VALUES 
                    ('".$newNameFile."')";

        $db -> query($qwery);   
    }
    else {
        echo "<p style='color:red;'>Файл изображения не загружен</p>";
    }        
}
?> 