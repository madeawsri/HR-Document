<?
include "../../conn.php";
$m = trim($_REQUEST['mode']);
switch($m){
    case "edit-app":
        $id = $_REQUEST['id'];
        $v = $_REQUEST['val'];
        $dbmy->update_db("hr_interview",array('approved'=>$v)," id = '{$id}'  ");
        break;



}

?>

