<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

$name_dir = "team_model";

$maxWidthBig = $maxWidthTeamModelBig;
$maxHeightBig = $maxHeightTeamModelBig;

$maxWidthThumb = $maxWidthTeamModelThumb;
$maxHeightThumb = $maxHeightTeamModelThumb;

$db = db :: getInstance();

$editorClass = new editorClass();
    
if(isset($_POST ['name'])) 
    if (!$name = validClass::sanitiseString($_POST['name']))
       unset($name);

if(isset($_POST ['weight'])) 
    if (!$weight = validClass::validNumber($_POST['weight']))
       unset($weight);

if(isset($_POST ['description'])) 
    if (!$description = $editorClass->replaceToInsert($_POST['description']))
       unset($description);

$imageClass = new imageClass();

$qwery = "INSERT INTO ".$name_dir." 
            (name, weight, description) 
         VALUES 
            ('".$name."', '".$weight."', '".$description."')";
        
$db -> query($qwery);

$id = $db -> last();

//echo "<p style='color:green;'>Данные успешно сохранены</p>";

echo $id;

if (($tempFile = $_FILES['url_image']['tmp_name']) != "") {
    
    $targetPath = $root . "/img/".$name_dir."/";
    
    if(!$image_info = $imageClass->getImageInfo($tempFile)) {
        echo "<p style='color:red;'>Обработка файла лого невозможна</p>";
        exit;
    }

    if ($image_info['extension'] != "png") {
       echo "<p style='color:red;'>Допустимые расширения для лого *.png</p>";
       exit;
    } 
    
    if ($image_info['width'] != $maxWidthBig || $image_info['height'] != $maxHeightBig) {
       echo "<p style='color:red;'>Допустимое разрешение для  большого изобр. $maxWidthBig x $maxHeightBig px</p>";
       exit;
    }     

    if ($image_info['size'] > (1024 * 1024 * 10)) {
       echo "<p style='color:red;'>Файл лого больше 10 Мб</p>";
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
        echo "<p style='color:red;'>Файл лого не загружен</p>";
    }        
}

if (($tempFile = $_FILES['url_image1']['tmp_name']) != "") {
    
    $targetPath = $root . "/img/".$name_dir."/";
    
    if(!$image_info = $imageClass->getImageInfo($tempFile)) {
        echo "<p style='color:red;'>Обработка файла большого изображения невозможна</p>";
        exit;
    }

    if ($image_info['extension'] != "png") {
       echo "<p style='color:red;'>Допустимые расширения для большого изображения *.png</p>";
       exit;
    } 
    
    if ($image_info['width'] != $maxWidthTeamModelGalleryBig || $image_info['height'] != $maxHeightTeamModelGalleryBig) {
       echo "<p style='color:red;'>Допустимое разрешение для  большого изобр. $maxWidthTeamModelGalleryBig x $maxHeightTeamModelGalleryBig px</p>";
       exit;
    }     

    if ($image_info['size'] > (1024 * 1024 * 10)) {
       echo "<p style='color:red;'>Файл большого изображения больше 10 Мб</p>";
       exit;
    }    

    $newNameFile = uniqid(null);
    $newNameFile .= '.'.$image_info['extension'];

    $uploadfile = $targetPath.$newNameFile;

    if (move_uploaded_file($tempFile, $uploadfile)) {

        $thumb = $targetPath."thumb_".$newNameFile;

        $imageClass->createImageThumb($uploadfile, $thumb, $maxWidthThumb, $maxHeightThumb); 
        
        // Обновляем 
        $qwery = "INSERT INTO ".$name_dir."_gallery 
                    (photo, id_team_model) 
                 VALUES 
                    ('".$newNameFile."', '".$id."')";
        
        $db -> query($qwery);
        
        $last = $db -> last();
  
    }
    else {
        echo "<p style='color:red;'>Файл большого изображения не загружен</p>";
    }        
}

if (($tempFile = $_FILES['url_image2']['tmp_name']) != "") {
    
    $targetPath = $root . "/img/".$name_dir."/";
    
    if(!$image_info = $imageClass->getImageInfo($tempFile)) {
        echo "<p style='color:red;'>Обработка файла маленького изображения невозможна</p>";
        exit;
    }

    if ($image_info['extension'] != "png") {
       echo "<p style='color:red;'>Допустимые маленького для большого изображения *.png</p>";
       exit;
    } 
    
    if ($image_info['width'] != $maxWidthTeamModelGallerySmall || $image_info['height'] != $maxHeightTeamModelGallerySmall) {
		if ($image_info['width'] != $maxWidthTeamModelGallerySmallVertical || $image_info['height'] != $maxHeightTeamModelGallerySmallVertical) {
			echo "<p style='color:red;'>Допустимое разрешение для  маленького изобр. $maxWidthTeamModelGallerySmall x $maxHeightTeamModelGallerySmall px<br />";
			echo "или $maxWidthTeamModelGallerySmallVertical x $maxHeightTeamModelGallerySmallVertical px</p>";
		    exit;
		}
    }     

    if ($image_info['size'] > (1024 * 1024 * 10)) {
       echo "<p style='color:red;'>Файл маленького изображения больше 10 Мб</p>";
       exit;
    }    

    $newNameFile = uniqid(null);
    $newNameFile .= '.'.$image_info['extension'];

    $uploadfile = $targetPath.$newNameFile;

    if (move_uploaded_file($tempFile, $uploadfile)) {

        $thumb = $targetPath."thumb_".$newNameFile;

        $imageClass->createImageThumb($uploadfile, $thumb, $maxWidthThumb, $maxHeightThumb); 
        
        // Обновляем 
        $qwery = "UPDATE ".$name_dir."_gallery
                  SET photo_small = '".$newNameFile."'
                  WHERE id='".$last."'";
        
        $db -> query($qwery);
  
    }
    else {
        echo "<p style='color:red;'>Файл маленького изображения не загружен</p>";
    }        
}
?> 