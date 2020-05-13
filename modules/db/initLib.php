<?php
/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 30/3/2560
 * Time: 16:56
 */
ini_set("memory_limit", "700M");
set_time_limit(0);
include "../../conn.php";

$arr = array();
$arr['ERR'] = "";
$arr['SEND'] = $_REQUEST;
$arr['FILES'] = $_FILES;
$arr['SQL'] = '';
$arr['DATA'] = '';
$arr['CONTENT'] = '';
$arr['REPORT'] = '';
$arr['MSG'] = '';

switch($_REQUEST['mode']) {
    case "getPdf":
        $arr['DATA'] = getMYSQLValueAll('hr_docref', "*", "tbname = '{$_REQUEST['tbname']}'
                       and kslid = '{$_REQUEST['site']}' and cid = '{$_REQUEST['cid']}'  ");
        break;
    case "pdfUpload":
        $cid = $_REQUEST['cid'];
        $xsite = $_REQUEST['site'];
        $y = date('Y', TIMESTAMP) + 543;
        $dtime = date('dm', TIMESTAMP) . $y . date('his', TIMESTAMP);
        $fileName = $cid . $dtime . strtoupper(str_replace('hr_', '', $_REQUEST['tbname'])) . ".pdf";
        $dir = "../../uploads/{$xsite}/{$cid}";
        $isDir = is_dir($dir);
        if(!$isDir){
            @mkdir($dir);
        }
        $insData = array("kslid" => $xsite, "cid" => $cid, "detail" => $_REQUEST['detail'],
            "dtime" => $dtime, "filename" => $fileName, "tbname" => $_REQUEST['tbname']);

        if ($_FILES) {
            foreach ($_FILES as $k => $v) {
                $images = $v["tmp_name"];
                $new_images = $fileName;
                copy($v["tmp_name"], "../../uploads/{$xsite}/{$cid}/" . $new_images);
            }
        }
        $insData['owner'] = $_SESSION['SS_USER']['id'];
        $dbmy->add_db('hr_docref', $insData);
        $arr['DATA'] = getMYSQLValueAll('hr_docref', "*", "tbname = '{$_REQUEST['tbname']}'
                       and kslid = '{$_REQUEST['site']}' and cid = '{$_REQUEST['cid']}'  ");
        break;
    case "pdfUpload2":
        $cid = $_REQUEST['cid'];
        $xsite = $_REQUEST['site'];
        $y = date('Y', TIMESTAMP) + 543;
        $dtime = date('dm', TIMESTAMP) . $y . date('his', TIMESTAMP);
        $fileName = $cid . $dtime . strtoupper(str_replace('hr_', '', $_REQUEST['tbname'])) . ".pdf";
        $dir = "../../uploads/{$xsite}/AppJob";
        $isDir = is_dir($dir);
        if(!$isDir){
            @mkdir($dir);
        }
        $insData = array("kslid" => $xsite, "cid" => $cid, "detail" => $_REQUEST['detail'],
            "dtime" => $dtime, "filename" => $fileName, "tbname" => $_REQUEST['tbname']);

        if ($_FILES) {
            foreach ($_FILES as $k => $v) {
                $images = $v["tmp_name"];
                $new_images = $fileName;
                copy($v["tmp_name"], "../../uploads/{$xsite}/AppJob/" . $new_images);
            }
        }
        $insData['owner'] = $_SESSION['SS_USER']['id'];
        $dbmy->add_db('hr_docref', $insData);
        $arr['DATA'] = getMYSQLValueAll('hr_docref', "*", "tbname = '{$_REQUEST['tbname']}'
                       and kslid = '{$_REQUEST['site']}' and cid = '{$_REQUEST['cid']}'  ");
        break;
    case "delPdf":
        $cid = $_REQUEST['cid'];
        $xsite = $_REQUEST['site'];
        $dbmy->del('hr_docref','id = '.$_REQUEST['id']);
        @unlink("../../uploads/{$xsite}/{$cid}/" . $new_images);

        break;
    case "pptype":
        $arr['DATA'] = getMYSQLValueAll('hr_pptype','id,name');
        break;
    case "ptype":
        $arr['DATA'] = getMYSQLValueAll('hr_ptype','id,name');
        break;
}
echo json_encode($arr);