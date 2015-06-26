<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";
$db = db :: getInstance();

if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);
    
if ($id > 0) {

    $imageClass = new imageClass();
 
    if (($tempFile = $_FILES['url_image']['tmp_name']) != "") {

        $targetPath = $root . '/img/home/';

        if(!$image_info = $imageClass->getImageInfo($tempFile)) {
            echo "<p style='color:red;'>Обработка файла изображения невозможна</p>";
            exit;
        }

        if ($image_info['extension'] != "png" AND $image_info['extension'] != "gif") {
           echo "<p style='color:red;'>Допустимые расширения для изображения *.png или *.gif</p>";
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
       
        // Удаляем фото
        $qwery = "SELECT photo 
                  FROM home
                  WHERE id='".$id."'";
        $db -> query($qwery);

        $photo = $db -> getValue();

        $src_old = $targetPath.$photo;
        $thumb_old = $targetPath."thumb_".$photo;

        @unlink($src_old);
        @unlink($thumb_old);
        
        if (move_uploaded_file($tempFile, $uploadfile)) {

            $thumb = $targetPath."thumb_".$newNameFile;

            $imageClass->createImageThumb($uploadfile, $thumb, $maxWidthHomeThumb, $maxHeightHomeThumb);
            
           
            // Обновляем 
            $qwery = "UPDATE home
                      SET photo = '".$newNameFile."'
                      WHERE id='".$id."'";
            $db -> query($qwery);   
            
            echo "<p style='color:green;'>Данные успешно обновлены</p>";
        }
        else {
            echo "<p style='color:red;'>Файл изображения не загружен</p>";
        }        
    }       
}

?> 