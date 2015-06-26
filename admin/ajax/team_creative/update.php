<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

$name_dir = "team_creative";

$maxWidthBig = $maxWidthTeamCreativeBig;
$maxHeightBig = $maxHeightTeamCreativeBig;

$maxWidthSmall = $maxWidthTeamCreativeSmall;
$maxHeightSmall = $maxHeightTeamCreativeSmall;

$maxWidthDown = $maxWidthTeamCreativeDown;
$maxHeightDown = $maxHeightTeamCreativeDown;

$maxWidthThumb = $maxWidthTeamCreativeThumb;
$maxHeightThumb = $maxHeightTeamCreativeThumb;

$db = db :: getInstance();

$editorClass = new editorClass();

if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);
    
if(isset($_POST ['name'])) 
    if (!$name = validClass::sanitiseString($_POST['name']))
       unset($name);

if(isset($_POST ['position'])) 
    if (!$position = validClass::sanitiseString($_POST['position']))
       unset($position);

if(isset($_POST ['weight'])) 
    if (!$weight = validClass::validNumber($_POST['weight']))
       unset($weight);

if(isset($_POST ['description'])) 
    if (!$description = $editorClass->replaceToInsert($_POST['description']))
       unset($description);  
    
if ($id > 0) {

    $imageClass = new imageClass();
    
    // Обновляем 
    $qwery = "UPDATE ".$name_dir."
              SET name = '".$name."',
                  position = '".$position."',
                  weight = '".$weight."',
                  description = '".$description."'
              WHERE id='".$id."'";
    $db -> query($qwery); 
    
    echo "<p style='color:green;'>Данные успешно обновлены</p>";

    if (($tempFile = $_FILES['url_image']['tmp_name']) != "") {

        $targetPath = $root . "/img/".$name_dir."/";

        if(!$image_info = $imageClass->getImageInfo($tempFile)) {
            echo "<p style='color:red;'>Обработка файла большого изображения невозможна</p>";
            exit;
        }

        if ($image_info['extension'] != "png") {
           echo "<p style='color:red;'>Допустимые расширения для большого изображения *.png</p>";
           exit;
        } 

        if ($image_info['width'] != $maxWidthBig || $image_info['height'] != $maxHeightBig) {
           echo "<p style='color:red;'>Допустимое разрешение для  большого изобр. $maxWidthBig x $maxHeightBig px</p>";
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
            echo "<p style='color:red;'>Файл большого изображения не загружен</p>";
            exit;
        }        
    }    
    
    if (($tempFile = $_FILES['url_image_small']['tmp_name']) != "") {

        $targetPath = $root . "/img/".$name_dir."/";

        if(!$image_info = $imageClass->getImageInfo($tempFile)) {
            echo "<p style='color:red;'>Обработка файла маленького изображения невозможна</p>";
            exit;
        }

        if ($image_info['extension'] != "png") {
           echo "<p style='color:red;'>Допустимые расширения для маленького изображения *.png</p>";
           exit;
        } 

        //if ($image_info['width'] != $maxWidthSmall || $image_info['height'] != $maxHeightSmall) {
        //   echo "<p style='color:red;'>Допустимое разрешение для маленького изобр. $maxWidthSmall x $maxHeightSmall px</p>";
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
                      SET photo_small = '".$newNameFile."'
                      WHERE id='".$id."'";
            $db -> query($qwery);   
        }
        else {
            echo "<p style='color:red;'>Файл маленького изображения не загружен</p>";
        }        
    }   
    
   if (($tempFile = $_FILES['url_image_down']['tmp_name']) != "") {

        $targetPath = $root . "/img/".$name_dir."/";

        if(!$image_info = $imageClass->getImageInfo($tempFile)) {
            echo "<p style='color:red;'>Обработка файла нижнего изображения невозможна</p>";
            exit;
        }

        if ($image_info['extension'] != "png") {
           echo "<p style='color:red;'>Допустимые расширения для нижнего изображения *.png</p>";
           exit;
        } 

        //if ($image_info['width'] != $maxWidthSmall || $image_info['height'] != $maxHeightSmall) {
        //   echo "<p style='color:red;'>Допустимое разрешение для нижнего изобр. $maxWidthSmall x $maxHeightSmall px</p>";
        //   exit;
        //}    

        if ($image_info['size'] > (1024 * 1024 * 10)) {
           echo "<p style='color:red;'>Файл нижнего изображения больше 10 Мб</p>";
           exit;
        }     

        $newNameFile = "down_".$id;
        $newNameFile .= '.'.$image_info['extension'];

        $uploadfile = $targetPath.$newNameFile;
        
        // Удаляем фото
        $qwery = "SELECT photo_down 
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
                      SET photo_down = '".$newNameFile."'
                      WHERE id='".$id."'";
            $db -> query($qwery);   
        }
        else {
            echo "<p style='color:red;'>Файл нижнего изображения не загружен</p>";
        }        
    }    
}

?> 