<?
ini_set("memory_limit", "700M");
set_time_limit(0);
include "../../conn.php";
$m = trim($_REQUEST['mode']);
$arr = array();
$arr['ERR'] = "";
$arr['SEND'] = $_REQUEST;
$arr['SQL'] = '';
$arr['DATA'] = '';
$arr['CONTENT'] = '';
$arr['REPORT'] = '';
$arr['MSG'] = '';
$arr['KEY_WHERE'] = "{$_REQUEST['keyid']} = '{$_REQUEST[$_REQUEST['keyid']]}'  ";
switch($m){
    case "del" . $_REQUEST['tbname']:
        $tbname = $_REQUEST['tbname'];
        $arr['SQL'] = $dbmy->del($tbname,$arr['KEY_WHERE']);
        break;
    case "edit-pmtype":
        $id = $_REQUEST['id'];
        $v = $_REQUEST['val'];
        $f = $_REQUEST['f'];
        $arr['SQL'] = $dbmy->update_db('gmenu',array("`{$f}`" =>$v)," id = '{$id}'  ");
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
        if (array_key_exists("kslid",$insData))
            $insData['kslid'] = SITE_NAME;

        //$insData['menus'] = implode(',',$_REQUEST['menus']);

        //if($_REQUEST['mid'])
        //    foreach($_REQUEST['mid'] as $k=>$v){
        //        $insData['mid'] = $v;
                $arr['SQL'] = $dbmy->add_db($_REQUEST['tbname'], $insData);
        //    }

        break;

    case "edit" . $_REQUEST['tbname']:
        $tbname = $_REQUEST['tbname'];
        $fields = $_REQUEST['dbfields'];
        $fields = explode(",", $fields);
        $insData = array();
        foreach ($fields as $v) {
            $insData[$v] = $_REQUEST[$v];
        }
        if (array_key_exists("kslid",$insData))
            $insData['kslid'] = SITE_NAME;

        $arr['SQL'] = $dbmy->update_db($tbname, $insData,$arr['KEY_WHERE'] );
        $arr['DATA'] = "OK";
        break;


}

$_html->boxTag('สรุปรายงาน', $arr['REPORT'], '', __boxStyle::Success);
$arr['REPORT'] = $_html->divTag('', $_html->boxRender(), '', ''); //style="zoom:0.8"
echo json_encode($arr);

?>

