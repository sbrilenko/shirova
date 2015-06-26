<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";

$db = db :: getInstance();

$editorClass = new editorClass();

if(isset($_POST ['portfolio_cat'])) 
    if (!$portfolio_cat = validClass::validNumber($_POST['portfolio_cat']))
       unset($portfolio_cat);
    
if(isset($_POST ['client'])) 
    if (!$client = validClass::sanitiseString($_POST['client']))
       unset($client);
    
if(isset($_POST ['description'])) 
    if (!$description = $editorClass->replaceToInsert($_POST['description']))
       unset($description);

$imageClass = new imageClass();

$qwery = "INSERT INTO portfolio 
            (id_portfolio_cat, client, description,create_time) 
         VALUES 
            ('".$portfolio_cat."', '".$client."', '".$description."', '".date('YmdHis')."')";
        
$db -> query($qwery);

$id = $db -> last();

echo "<p style='color:green;'>Данные успешно сохранены</p>";

if (($tempFile = $_FILES['url_image']['tmp_name']) != "") {
    
    $targetPath = $root . '/img/portfolio/';
    
    if(!$image_info = $imageClass->getImageInfo($tempFile)) {
        echo "<p style='color:red;'>Обработка файла изображения невозможна</p>";
        exit;
    }

    if ($image_info['extension'] != "png") {
       echo "<p style='color:red;'>Допустимые расширения для изображения *.png</p>";
       exit;
    } 
    
    if ($image_info['width'] != $maxWidthPortfolioBig || $image_info['height'] != $maxHeightPortfolioBig) {
       echo "<p style='color:red;'>Допустимое разрешение $maxWidthPortfolioBig x $maxHeightPortfolioBig px</p>";
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

        $imageClass->createImageThumb($uploadfile, $thumb, $maxWidthPortfolioThumb, $maxHeightPortfolioThumb); 
        // Обновляем 
        $qwery = "UPDATE portfolio
                  SET photo = '".$newNameFile."'
                  WHERE id='".$id."'";
        $db -> query($qwery);   
    }
    else {
        echo "<p style='color:red;'>Файл изображения не загружен</p>";
    }        
}
?> 