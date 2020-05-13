<?
include "../../conn.php";
$m = trim($_REQUEST['mode']);
switch($m){
case "edit-pmtype":
    $id = $_REQUEST['id'];
    $v = $_REQUEST['val'];
    $dbmy->update_db("tbinfo",array('pmtype'=>$v)," loginid = '{$id}'  ");
break;



}

?>

