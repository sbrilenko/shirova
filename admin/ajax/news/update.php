<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";
$db = db :: getInstance();

if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);
    
if(isset($_POST ['date_create'])) 
    if (!$date_create = validClass::sanitiseString($_POST['date_create']))
       unset($date_create);

$date_create = date("Y-m-d", strtotime($date_create));
    
if(isset($_POST ['description_rus'])) 
    if (!$description_rus = validClass::sanitiseString($_POST['description_rus']))
       unset($description_rus);
    
if ($id > 0) {

  if(!empty($description_rus))
	{
    $imageClass = new imageClass();
    
    // Обновляем 
    $qwery = "UPDATE news
              SET date_create = '".$date_create."',
                  text_rus = '".$description_rus."'
              WHERE id='".$id."'";
    $db -> query($qwery); 
    
    // Достаем id картинок новости

 echo "<p style='color:green;'>Данные успешно сохранены</p>";
if ($_FILES['images']['tmp_name'][0] != "") {   
    // достаем в массив полученные данные
    //$arrItems = $db -> getArray();
    $arrItems=$_FILES['images']['tmp_name'];   
    foreach ($arrItems as $item) {
        	   
    if(!$image_info = $imageClass->getImageInfo($item)) {
        echo "<p style='color:red;'>Обработка файла изображения невозможна</p>";
        exit;
    }
	if ($image_info['width'] != 910 || $image_info['height'] != 510) {
       echo "<p style='color:red;'>Допустимое разрешение фото для галереи 910 px * 510 px</p>";
       exit;
    }   
    if ($image_info['extension'] != "png") {
       echo "<p style='color:red;'>Допустимые расширения для изображения *.png</p>";
       exit;
    } 
            // Вставляем в temp
             $file_name=md5(microtime()).".png";
            $qwery = "INSERT INTO news_galery 
                        (photo, id_news) 
                     VALUES 
                        ('".$file_name."', '".$id."')";

            $db -> query($qwery);
			$src=$item;
            $src_save = '../../../img/news_gallery/'.$file_name;
            $thumb = '../../../img/news_gallery/'."thumb_".$file_name;

            $imageClass->resizeImage($src, $src_save, 910, 510); 
            $imageClass->createImageThumb($src, $thumb, 128, 128); 
         }
    }    
    
    if (($tempFile = $_FILES['url_image']['tmp_name']) != "") {

        $targetPath = $root . '/img/news/';
    if(!$image_info = $imageClass->getImageInfo($tempFile)) {
        echo "<p style='color:red;'>Обработка файла изображения невозможна</p>";
        exit;
    }
	if ($image_info['width'] != 128 || $image_info['height'] != 128) {
       echo "<p style='color:red;'>Допустимое разрешение фото 128 px * 128 px</p>";
       exit;
    }   
    if ($image_info['extension'] != "png") {
       echo "<p style='color:red;'>Допустимые расширения для изображения *.png</p>";
       exit;
    } 

    if ($image_info['size'] > (1024 * 1024 * 10)) {
       echo "<p style='color:red;'>Файл изображения больше 10 Мб</p>";
       exit;
    }  

        $newNameFile = uniqid(NULL);
        $newNameFile .= '.'.$image_info['extension'];

        $uploadfile = $targetPath.$newNameFile;

        if (move_uploaded_file($tempFile, $uploadfile)) {

            $thumb = $targetPath."thumb_".$newNameFile;
            
            $imageClass->createImageThumb($uploadfile, $thumb, 128, 128); 
            $imageClass->resizeImage($uploadfile, $uploadfile, 128, 128); 
            
            // Удаляем фото
            $qwery = "SELECT photo 
                      FROM news
                      WHERE id='".$id."'";
            $db -> query($qwery);
            
            $photo = $db -> getValue();
            
            $src_old = $targetPath.$photo;
            $thumb_old = $targetPath."thumb_".$photo;
            
            @unlink($src_old);
            @unlink($thumb_old);
            
            // Обновляем 
            $qwery = "UPDATE news
                      SET photo = '".$newNameFile."'
                      WHERE id='".$id."'";
            $db -> query($qwery);   
        }
        else {
            echo "<p style='color:red;'>Файл изображения не загружен</p>";
        }        
    }       
}
else
{
	echo "<p style='color:red;'>Описание обязательное поле</p>";	
}
}
?> 