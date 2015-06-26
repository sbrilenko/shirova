<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

$name_dir = "partner_logo";

$maxWidthBig = $maxWidthPartnerLogoBig;
$maxHeightBig = $maxHeightPartnerLogoBig;

$maxWidthThumb = $maxWidthTeamPartnerThumb;
$maxHeightThumb = $maxHeightTeamPartnerThumb;

$db = db :: getInstance();

$editorClass = new editorClass();

if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);
    
if(isset($_POST ['name'])) 
    if (!$url = validClass::sanitiseString($_POST['name']))
       unset($url);

if(isset($_POST ['weight'])) 
    if (!$weight = validClass::validNumber($_POST['weight']))
       unset($weight);
    
if ($id > 0) {
 if(!empty($url))
 {
 	  $imageClass = new imageClass();
    
    // Обновляем 
    $qwery = "UPDATE ".$name_dir."
              SET name = '".$url."',
                  weight = '".$weight."'
              WHERE id='".$id."'";
    $db -> query($qwery); 
    echo "<p style='color:green;'>Данные успешно обновлены</p>";
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

        // Удаляем фото
        $qwery = "SELECT photo 
                  FROM ".$name_dir."
                  WHERE id='".$id."'";
        $db -> query($qwery);

        $photo = $db -> getValue();

        $src_old = $targetPath.$photo;
        $thumb_old = $targetPath."thumb_".$photo;

        @unlink($src_old);
        @unlink($thumb_old);        

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
            exit;
        }        
    }
 }
 else
 {
 	  echo "<p style='color:red;'>Введите название заказчика</p>";
 }
  
  
}

?> 