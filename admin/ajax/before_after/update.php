<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";
$db = db :: getInstance();

$editorClass = new editorClass();

if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);
    
if(isset($_POST ['client'])) 
    if (!$client = validClass::sanitiseString($_POST['client']))
       unset($client);
    
if(isset($_POST ['description'])) 
    if (!$description = $editorClass->replaceToInsert($_POST['description']))
       unset($description);      
    
if ($id > 0) {

    $imageClass = new imageClass();
    
    // Обновляем 
    $qwery = "UPDATE before_after
              SET client = '".$client."',
                  description = '".$description."'
              WHERE id='".$id."'";
    $db -> query($qwery); 
    
    echo "<p style='color:green;'>Данные успешно обновлены</p>";

    if (($tempFile = $_FILES['url_image']['tmp_name']) != "") {

        $targetPath = $root . '/img/before_after/';

        if(!$image_info = $imageClass->getImageInfo($tempFile)) {
            echo "<p style='color:red;'>Обработка файла большого изображения невозможна</p>";
            exit;
        }

        if ($image_info['extension'] != "png") {
           echo "<p style='color:red;'>Допустимые расширения для большого изображения *.png</p>";
           exit;
        } 

        if ($image_info['width'] != $maxWidthBeforeAfterBig || $image_info['height'] != $maxHeightBeforeAfterBig) {
           echo "<p style='color:red;'>Допустимое разрешение для  большого изобр. $maxWidthBeforeAfterBig x $maxHeightBeforeAfterBig px</p>";
           exit;
        }     

        if ($image_info['size'] > (1024 * 1024 * 10)) {
           echo "<p style='color:red;'>Файл большого изображения больше 10 Мб</p>";
           exit;
        }     

        $newNameFile = $id;
        $newNameFile .= '.'.$image_info['extension'];

        $uploadfile = $targetPath.$newNameFile;

        // Удаляем фото
        $qwery = "SELECT photo 
                  FROM before_after
                  WHERE id='".$id."'";
        $db -> query($qwery);

        $photo = $db -> getValue();

        $src_old = $targetPath.$photo;
        $thumb_old = $targetPath."thumb_".$photo;

        @unlink($src_old);
        @unlink($thumb_old);        

        if (move_uploaded_file($tempFile, $uploadfile)) {

            $thumb = $targetPath."thumb_".$newNameFile;
            
            $imageClass->createImageThumb($uploadfile, $thumb, $maxWidthBeforeAfterThumb, $maxHeightBeforeAfterThumb); 
            
            // Обновляем 
            $qwery = "UPDATE before_after
                      SET photo = '".$newNameFile."'
                      WHERE id='".$id."'";
            $db -> query($qwery);   
        }
        else {
            echo "<p style='color:red;'>Файл большого изображения не загружен</p>";
            exit;
        }        
    }    
    
    if (($tempFile = $_FILES['url_image_small']['tmp_name']) != "") {

        $targetPath = $root . '/img/before_after/';

        if(!$image_info = $imageClass->getImageInfo($tempFile)) {
            echo "<p style='color:red;'>Обработка файла маленького изображения невозможна</p>";
            exit;
        }

        if ($image_info['extension'] != "png") {
           echo "<p style='color:red;'>Допустимые расширения для маленького изображения *.png</p>";
           exit;
        } 

        //if ($image_info['width'] != $maxWidthBeforeAfterSmall || $image_info['height'] != $maxHeightBeforeAfterSmall) {
       //    echo "<p style='color:red;'>Допустимое разрешение для маленького изобр. $maxWidthBeforeAfterSmall x $maxHeightBeforeAfterSmall px</p>";
        //   exit;
        //}     

        if ($image_info['size'] > (1024 * 1024 * 10)) {
           echo "<p style='color:red;'>Файл маленького изображения больше 10 Мб</p>";
           exit;
        }     

        $newNameFile = "small_".$id;
        $newNameFile .= '.'.$image_info['extension'];

        $uploadfile = $targetPath.$newNameFile;
        
        // Удаляем фото
        $qwery = "SELECT photo_small 
                  FROM before_after
                  WHERE id='".$id."'";
        $db -> query($qwery);

        $photo = $db -> getValue();

        $src_old = $targetPath.$photo;
        $thumb_old = $targetPath."thumb_".$photo;

        @unlink($src_old);
        @unlink($thumb_old);
        
        if (move_uploaded_file($tempFile, $uploadfile)) {

            $thumb = $targetPath."thumb_".$newNameFile;
            
            $imageClass->createImageThumb($uploadfile, $thumb, $maxWidthBeforeAfterThumb, $maxHeightBeforeAfterThumb); 
            
            // Обновляем 
            $qwery = "UPDATE before_after
                      SET photo_small = '".$newNameFile."'
                      WHERE id='".$id."'";
            $db -> query($qwery);   
        }
        else {
            echo "<p style='color:red;'>Файл маленького изображения не загружен</p>";
        }        
    }      
}

?> 