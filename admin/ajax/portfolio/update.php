<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/admin/blocks/include.php";
$db = db :: getInstance();

$editorClass = new editorClass();


if(isset($_POST ['id'])) 
    if (!$id = validClass::validNumber($_POST['id']))
       unset($id);
    
if(isset($_POST ['portfolio_cat'])) 
    if (!$portfolio_cat = validClass::validNumber($_POST['portfolio_cat']))
       unset($portfolio_cat);
    
if(isset($_POST ['name'])) 
    if (!$client = validClass::validNumber($_POST['name']))
       unset($client);
    
if(isset($_POST ['description'])) 
    if (!$description = $editorClass->replaceToInsert($_POST['description']))
       unset($description);      
    
if ($id > 0) {

    $imageClass = new imageClass();
    $select_name_client='SELECT name FROM partner_logo WHERE id='.$client;
	$db->query($select_name_client);
	if($db->getCount()>0)
	{
		$client_text=$db->getValue();
	}
    // Обновляем 
    $qwery = "UPDATE portfolio
              SET id_portfolio_cat = '".$portfolio_cat."',
                  client2 = ".$client.",
                  client='".$client_text."',
                  description = '".$description."', razdel=".$_POST['portfolio_razdel']."
              WHERE id='".$id."'";
    $db -> query($qwery); 
    
    echo "<p style='color:green;'>Данные успешно обновлены</p>";

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

         // Удаляем фото
        $qwery = "SELECT photo 
                  FROM portfolio
                  WHERE id='".$id."'";
        $db -> query($qwery);

        $photo = $db -> getValue();

        $src_old = $targetPath.$photo;
        $thumb_old = $targetPath."thumb_".$photo;

        @unlink($src_old);
        @unlink($thumb_old); 
            
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
}

?> 