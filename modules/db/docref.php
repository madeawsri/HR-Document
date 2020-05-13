<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 **/
ini_set("memory_limit", "700M");
set_time_limit(0);
include "../../conn.php";

$arr = array();
$arr['ERR'] = "";
$arr['SEND'] = $_REQUEST;
$arr['SQL'] = '';
$arr['DATA'] = '';
$arr['DATA_MULTI'] = '';
$arr['CONTENT'] = '';
$arr['REPORT'] = '';
$arr['MSG'] = '';
$arr['KEY_WHERE'] = "{$_REQUEST['keyid']} = '{$_REQUEST[$_REQUEST['keyid']]}'  ";

switch ($_REQUEST['mode']) {
    case "del" . $_REQUEST['tbname']:
        $tbname = $_REQUEST['tbname'];

        $arr['DATA'] = getMYSQLValues($tbname,"*,tbname as xx",$arr['KEY_WHERE']);
        $arr['SQL'] = $dbmy->del($tbname, $arr['KEY_WHERE']);
        if(strstr($arr['DATA']['tbname'],'hr_appjob')){
            $path = "../../uploads/".SITE_NAME."/AppJob/{$arr['DATA']['filename']}";
        }else{
            $path = "../../uploads/".SITE_NAME."/{$arr['DATA']['cid']}/{$arr['DATA']['filename']}";
        }
        $arr['MSG'] = $path;
        @unlink($arr['MSG']);

        break;
    case "get":
        $arr['DATA'] = getMYSQLValues(
            $_REQUEST['tbname'], "*,
                          '{$_REQUEST['tbname']}' as  'tbname'",
            $arr['KEY_WHERE']);

        // $arr['DATA_MULTI']['etypes'] = explode(',',$arr['DATA']['etypes']);
        break;
}
$_html->boxTag('สรุปรายงาน', $arr['REPORT'], '', __boxStyle::Success);
$arr['REPORT'] = $_html->divTag('', $_html->boxRender(), '', ''); //style="zoom:0.8"
echo json_encode($arr);

?>