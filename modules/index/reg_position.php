<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "ข้อมูลตำแหน่งสมัครงาน";
$_PageName = trim(str_replace('.php', '', basename($_SERVER['SCRIPT_NAME'])));
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_SESSION['M_FILE_NAME'] = $_PageName;
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";

$boxContent = '';
$footer = '';
$divBody = '';
$frmBody = '';
$tbTables = array("hr_" . $_PageName => $title);
$tab = new tabClass();
foreach ($tbTables as $k => $v) {
    $tabColTitle = array("cid" => "บัตรประชาชน", "cname" => "ชื่อ-สกุล",
        "regp" => "แผนก/ตำแหน่ง ที่สมัคร", "rdate" => "วันที่สมัคร", "");
    $tb_name = $k;
    $tb_title = $v;

    $dbPerson = getMYSQLValueAll('hr_person', "id,cid, concat(pname,fname,' ',lname) as cname ",
        " kslid = '{$_REQUEST['site']}' ORDER BY id desc"); // must be use last "id" alway
    $arCid = array();
    foreach ($dbPerson as $k => $v) {
        if(strlen(trim($v['cid'])) != 13)
           $arCid[$v['id']] = $v['cid'] . " - " . $v['cname'];
        else $arCid[$v['cid']] = $v['cid'] . " - " . $v['cname'];
    }

    $arJobDetail = $_hr->DbJobDetail();
    $arJob = array();
    $arJob['0'] = " -- ว่าง --";
    foreach ($arJobDetail as $k => $v) {
        $arJob[$v['id']] = "ประกาศวันที่ " . $v['din'] . " : " . $v['pptype'] . " - " . $v['ptype'];
    }

   // vvArray($arCid);
    //-----
    $pReq = '<span class="text-red">*</span>';
    $frm = $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
    $frm .= $_html->elementFormTag('textbox', 'id', 'id', '', '', 'hide', '');
    foreach ($tabColTitle as $k => $v) {
        if ($v != "" && $k != 'cname' ) {
            switch ($k) {
                case "cid":
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arCid, 'modal', "  ");
                    break;
                case "regp":
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arJob, 'modal', " required ");
                    break;
                /*
                case "regp":
                        $arPstype = getMYSQLValueAll('hr_ptype','id,name');
                        $arPstype = $_lib->arrayToSelect($arPstype);
                        $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal'," required ");
                        break;
                */
                case "rdate":
                    $frm .= $_html->elementFormTag('mask', $k, $k, $pReq . $v, $_lib->getDateTH(TIMESTAMP), '', "data-inputmask='\"mask\": \"99/99/9999\"' required ");
                    break;
                default :
                    $frm .= $_html->elementFormTag('textbox', $k, $k, $v, '', '', '');
            }
        }
    }
    //----- End Form

    echo $_hr->FnMyFromAdd($tb_name, $frm);
    echo $_hr->FnMyFromEdit($tb_name, $frm);

    $datadb = getMYSQLValueAll("{$tb_name} as x , hr_person as y ",
        "x.cid , concat(y.pname,y.fname,' ',y.lname) as cname," .
        " regp ,
                                               x.rdate ,x.id  ",
        " (x.cid = y.cid  or x.cid=y.id)   ORDER BY  x.dedit desc ,  x.id desc  "); // must be use last "id" alway


    $datadb = getMYSQLValueAll("{$tb_name} as x , hr_person as y ",
        "x.cid , concat(y.pname,y.fname,' ',y.lname) as cname," .
        " regp ,
                                               x.rdate ,x.id  ",
        " (x.cid = y.cid  or x.cid like y.id)   ORDER BY str_to_date(x.rdate, '%d/%m/%Y')  desc   "); // must be use last "id" alway

    $dbTable = array();
    if ($datadb)
        foreach ($datadb as $k => $v) {
            if ($v['regp']) {
                $dbJobDetail = $_hr->DbJobDetail($v['regp']);
                $v['regp'] = "ประกาศวันที่ {$dbJobDetail['din']} ถึง {$dbJobDetail['dexp']} <br> " . $dbJobDetail['pptype'] . " - " . $dbJobDetail['ptype'];
            } else {
                $v['regp'] = '<span class="text-color-red-alpha">-- รอตำแหน่งว่าง --</span>';
            }
            $dbTable[] = $v;
        }

    //vvArray($dbTable);
    $htmlContent = $_hr->FnMyTable($tb_name, $tb_title, $tabColTitle, $dbTable, "add,edit,pdf,del");
    $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.7' "); //zoom:1.2
    $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');

echo $_html->includeAll($_PageName);
?>