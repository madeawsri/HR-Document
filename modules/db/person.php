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
$arr['FILES'] = $_FILES;
$arr['SQL'] = '';
$arr['DATA'] = '';
$arr['CONTENT'] = '';
$arr['REPORT'] = '';
$arr['MSG'] = '';
$arr['KEY_WHERE'] = "{$_REQUEST['keyid']} = {$_REQUEST[$_REQUEST['keyid']]} and kslid = '{$_REQUEST['site']}' ";

switch ($_REQUEST['mode']) {
    case "del" . $_REQUEST['tbname']:
        $tbname = $_REQUEST['tbname'];
        $arr['SQL'] = $dbmy->del($tbname,$arr['KEY_WHERE']);
        break;
    case "imgExist":
        $cid = $_REQUEST['cid'];
        $xsite = $_REQUEST['site'];
        $isDir = is_dir("../../uploads/{$xsite}/{$cid}");
        $isImage = file_exists("../../uploads/{$xsite}/{$cid}/{$cid}.jpg");
        if(!$isDir){
            mkdir("../../uploads/{$xsite}/{$cid}");
        }
        $arr['DATA']= $isImage;
        break;
    case "pic" . $_REQUEST['tbname']:
        $cid = $_REQUEST['cid'];
        $xsite = $_REQUEST['site'];
        $isDir = @is_dir("../../uploads/{$xsite}/{$cid}");
        $isImage = @file_exists("../../uploads/{$xsite}/{$cid}/{$cid}.jpg");
        if(!$isDir){
            $arr['MSG'] = "../../uploads/{$xsite}/{$cid}";
            mkdir("../../uploads/{$xsite}/{$cid}");
        }
        //$arr['MSG'] = $_FILES;
        if($_FILES){
            foreach($_FILES as $k=>$v){
                $images = $v["tmp_name"];
                $new_images = "{$cid}.jpg";//"S_".$v["name"];
                $pic = "../../uploads/{$xsite}/{$cid}/".$new_images;
                copy($images,$pic);
                $width=200;
                $size=GetimageSize($images);
                $height=round($width*$size[1]/$size[0]);
                $images_orig = ImageCreateFromJPEG($images);
                $photoX = ImagesX($images_orig);
                $photoY = ImagesY($images_orig);
                $images_fin = ImageCreateTrueColor($width, $height);
                ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1,
                    $height+1, $photoX, $photoY);
                ImageJPEG($images_fin,$pic);
                ImageDestroy($images_orig);
                ImageDestroy($images_fin);
            }
        }

        break;
    case "get":
        $arr['DATA'] = getMYSQLValues(
                          $_REQUEST['tbname'], "*,
                          '{$_REQUEST['tbname']}' as  'tbname'",
                          $arr['KEY_WHERE']);
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

        $idx = $dbmy->add_db($_REQUEST['tbname'], $insData);
        $dbmy->update_db($_REQUEST['tbname'],array("iorder"=>TIMESTAMP)," id = '{$idx}' ");

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
        $arr['SQL'] = $dbmy->update_db($tbname, $insData,$arr['KEY_WHERE'] );
        $arr['DATA'] = "OK";
        break;
}

$_html->boxTag('สรุปรายงาน', $arr['REPORT'], '', __boxStyle::Success);
$arr['REPORT'] = $_html->divTag('', $_html->boxRender(), '', ''); //style="zoom:0.8"
echo json_encode($arr);

?>