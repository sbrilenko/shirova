<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/scripts/config.php";
require_once $root."/scripts/class.invis.db.php";

$targetFile = $root. '/' . $_REQUEST['dir'] . '/' . $_REQUEST['name'];

@unlink($targetFile);

$db = db :: getInstance();

$qwery = "DELETE FROM temp_images 
          WHERE photo='".$_REQUEST['name']."'";
$db -> query($qwery);

?>