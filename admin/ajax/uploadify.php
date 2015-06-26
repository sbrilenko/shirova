<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/classes/class.symbianm.image.php";
require_once $root."/scripts/config.php";
require_once $root."/scripts/class.invis.db.php";

if (!empty($_FILES)) {
    
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $root . $_REQUEST['folder'] . '/';
	
    $imageClass = new imageClass();
    
    if(!$image_info = $imageClass->getImageInfo($tempFile)) {
	echo "<p style='color:red;'>Обработка файла изображения невозможна</p>";
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
         
        // Инициализируем подключение
        $db = db :: getInstance();
        
        // Вставляем в temp
        $qwery = "INSERT INTO temp_images 
                    (photo, dir) 
                 VALUES 
                    ('".$newNameFile."', '".$targetPath."')";
        
        $db -> query($qwery);

        echo $newNameFile; 
    }
    else {
        echo "<p style='color:red;'>Файл изображения не загружен</p>";
    }
}

?>