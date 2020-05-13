<?php
include "../../conn.php";
$mode = $_REQUEST['mode'];
$arr = array();
$arr['SEND'] = $_REQUEST;
$arr['DEBUG'] = '';
$arr['DATA'] = '';
$arr['CHECK'] = 1;
switch ($mode) {
    case "getSetting":
        $arr['DATA'] = getMYSQLValues($_REQUEST['tbname'], "id,name, '{$_REQUEST['tbname']}' as  'tbname'", "id='{$_REQUEST['xsite']}'");

        break;
    case "add".$_REQUEST['tbname']:
        $arr['DATA'] = "add".$_REQUEST['tbname'];
        $dbmy->add_db($_REQUEST['tbname'],array('name'=>$_REQUEST['tname']));
        break;
    case "edit".$_REQUEST['tbname']:
          $tbname = $_REQUEST['tbname'];
          $tid = $_REQUEST['tid'];
          $tname = $_REQUEST['tname'];
          $dbmy->update_db($tbname,array("name"=>$tname),"id = {$tid} ");
          $arr['DATA'] = "OK";
        break;

}
echo json_encode($arr);