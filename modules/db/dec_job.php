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
        $arr['SQL'] = $dbmy->del($tbname,$arr['KEY_WHERE']);
        break;
    case "get":
        $arr['DATA'] = getMYSQLValues(
            $_REQUEST['tbname'], "pptype,ptype, agtype,sxtype,etypes,vtypes,attb,satype,id,
                          '{$_REQUEST['tbname']}' as  'tbname'",
            $arr['KEY_WHERE']);


        $arr['DATA_MULTI']['etypes'] = explode(',',$arr['DATA']['etypes']);
        $arr['DATA_MULTI']['vtypes'] = explode(',',$arr['DATA']['vtypes']);

        break;
    case "add" . $_REQUEST['tbname']:
        $arr['DATA'] = "add" . $_REQUEST['tbname'];
        $fields = $_REQUEST['dbfields'];
        $fields = explode(",", $fields);
        $insData = array();
        foreach ($fields as $v) {
            $insData[$v] = $_REQUEST[$v];
        }
        if (array_key_exists("cid",$insData))
            $insData['cid'] = str_replace('-', '', $insData['cid']);

        $insData['kslid'] = SITE_NAME;
        /* X CASE */
        $insData['etypes'] = implode(',',$_REQUEST['etypes']);
        $insData['vtypes'] = implode(',',$_REQUEST['vtypes']);
        $arr['SQL'] = $dbmy->add_db($_REQUEST['tbname'], $insData );
        break;

    case "edit" . $_REQUEST['tbname']:

        $tbname = $_REQUEST['tbname'];
        $fields = $_REQUEST['dbfields'];
        $fields = explode(",", $fields);
        $insData = array();
        foreach ($fields as $v) {
            $insData[$v] = $_REQUEST[$v];
        }
        if (array_key_exists("cid",$insData))
            $insData['cid'] = str_replace('-', '', $insData['cid']);

        $insData['kslid'] = SITE_NAME;
        /* X CASE */
        $insData['etypes'] = implode(',',$_REQUEST['etypes']);
        $insData['vtypes'] = implode(',',$_REQUEST['vtypes']);

        $arr['SQL'] = $dbmy->update_db($tbname, $insData,$arr['KEY_WHERE'] );
        $arr['DATA'] = "OK";

        break;
}

$_html->boxTag('สรุปรายงาน', $arr['REPORT'], '', __boxStyle::Success);
$arr['REPORT'] = $_html->divTag('', $_html->boxRender(), '', ''); //style="zoom:0.8"
echo json_encode($arr);

?>