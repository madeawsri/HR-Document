<?php
header('Content-Type: image/png');
include "../conn.php";
$fitemno = $_REQUEST['fitemno'];
$dirx = substr($fitemno,0,6);
$imageURL = IMAGE_CAR_PATH.'\\'.$dirx.'\\'.$fitemno.'.jpg';
if(file_exists($imageURL)){
    $data = file_get_contents($imageURL);
}else{
    $data = file_get_contents(IMAGE_CAR_PATH."\\no-image.png");
}
echo $data;
?>