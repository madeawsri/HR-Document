<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "รายการนัดหมาย";
$_PageName = trim(str_replace('.php', '', basename($_SERVER['SCRIPT_NAME'])));
$_SESSION['M_FILE_NAME'] = $_PageName; // get menu name
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";
$boxContent = '';
$footer = '';
$divBody = '';
$frmBody = '';
$tbTables = array("hr_" . $_PageName => $title);
$tab = new tabClass();
foreach ($tbTables as $k => $v) {
    $tabColTitle = array("cid" => "บัตรประชาชน", "cname" => "ชื่อ-สกุล", "ptype" => "ตำแหน่งที่สมัคร",
        "ddate" => "วันนัดสัมภาษณ์","sotype"=>"ประเภทการสอบ", "ssite" => "หน่วยงานทดสอบ",
        "sname" => "ผู้สัมภาษณ์  คั่นด้วยเครื่อง Comma (,) ถ้าหลายคน", "rtype" => "ผลสัมภาษณ์", "note" => "หมายเหตุ", "");
    $tb_name = $k;
    $tb_title = $v;

    /* mode Add */
    //echo $_lib->isUser();
    //vvArray($_SESSION['SS_USER']);
    if($_lib->isUser()) {
        $dbPerson = $_hr->DbPersonRegPositionNotInterview('', $_SESSION['SS_USER']['pptype']);
    }else{
        $dbPerson = $_hr->DbPersonRegPositionNotInterview('');
    }


    //$_lib->isUser();
    //exit(0);
    $arCid = array();
    foreach ($dbPerson as $k => $v)
        $arCid[$v['rpid']] = $v['cid'] . ": " . $v['cname'] . " [ " . $v['rpname'] . " ]";

    $arInfos = $_hr->getLoginInfo();
    $arInfo = array();
    foreach ($arInfos as $k => $v)
        $arInfo[$v['loginid']] = $v['loginid'].": ".$v['name'] ;



    $pReq = '<span class="text-red">*</span>';
    $frm = $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
    $frm .= $_html->elementFormTag('textbox', 'id', 'id', '', '', 'hide', '');
    foreach ($tabColTitle as $k => $v) {
        if ($v != "" && $k != 'cname' && $k != 'ptype') {
            switch ($k) {

                case "cid":
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arCid, 'modal', " required ");
                    break;
                case "sname":
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arInfo, 'modal', " multiple ");

                    break;
                case "rtype":
                    $arPstype = getMYSQLValueAll('hr_rtype', 'id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype, 1);
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal hide', "  ");
                    break;
                case "ddate":
                    $frm .= $_html->elementFormTag('mask', $k, $k, $v, '', '', "data-inputmask='\"mask\": \"99/99/9999\"'  ");
                    break;

                case "sotype":
                    $arPstype = getMYSQLValueAll('hr_sotype', 'id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype, 1);
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', "  ");
                    break;
                case "note":
                $frm .= $_html->elementFormTag('textbox', $k, $k, $v, '', 'hide', '');
                    break;
                default :
                    $frm .= $_html->elementFormTag('textbox', $k, $k, $v, '', '', '');
            }
        }
    }
    //----- End Form Add
    echo $_hr->FnMyFromAdd($tb_name, $frm);
    /* mode Edit */
    if($_lib->isUser()) {
        $dbPerson = $_hr->DbPersonRegPositionInInterview('', $_SESSION['SS_USER']['pptype']);
    }else{
        $dbPerson = $_hr->DbPersonRegPositionInInterview('');
    }
    $arCid = array();
    if ($dbPerson)
        foreach ($dbPerson as $k => $v)
            $arCid[$v['cid']] = $v['cid'] . ": " . $v['cname'] . " [ " . $v['rpname'] . " ]";

    $pReq = '<span class="text-red">*</span>';
    $frm = $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
    $frm .= $_html->elementFormTag('textbox', 'id', 'id', '', '', 'hide', '');
    foreach ($tabColTitle as $k => $v) {
        if ($v != "" && $k != 'cname' && $k != 'ptype') {
            switch ($k) {
                case "cid":
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arCid, 'modal', " required ");
                    break;
                case "sname":
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arInfo, 'modal', " multiple ");
                    break;
                case "rtype":
                    $arPstype = getMYSQLValueAll('hr_rtype', 'id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype, 1);
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal hide', "  ");
                    break;
                case "sotype":
                    $arPstype = getMYSQLValueAll('hr_sotype', 'id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype, 1);
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', "  ");
                    break;
                case "ddate":
                    $frm .= $_html->elementFormTag('mask', $k, $k, $v, '', '', "data-inputmask='\"mask\": \"99/99/9999\"'  ");
                    break;
                case "note":
                $frm .= $_html->elementFormTag('textbox', $k, $k, $v, '', 'hide', '');
                break;
                default :
                    $frm .= $_html->elementFormTag('textbox', $k, $k, $v, '', '', '');
            }
        }
    }
    //----- End Form Edit
    echo $_hr->FnMyFromEdit($tb_name, $frm);


    $tabColTitle = array("cid" => "การสอบ", "cname" => "ชื่อ-สกุล", "ptype" => "ตำแหน่งที่สมัคร",
        "ddate" => "วันนัดสัมภาษณ์", "ssite" => "หน่วยงานทดสอบ", "sname" => "ผู้สัมภาษณ์" , ""); //, "rtype" => "ผลสัมภาษณ์/ หมายเหตุ"
    $datadb = $dbmy->exec("
        select (select so.name from hr_sotype so where so.id = x.sotype ) as sotype ,
               concat(y.pname,y.fname,' ',y.lname) as cname,
               rp.regp as rpname ,
               x.ddate,x.ssite,x.sname,

               x.id
        from hr_interview as x , hr_person as y , hr_reg_position rp
        where x.cid = y.cid and rp.id = x.rpid order by str_to_date(x.ddate, '%d/%m/%Y') DESC
        "); // must be use last "id" alway
//vvArray($datadb);
    $dbTable = array();
    if ($datadb)
        foreach ($datadb as $k => $v) {
            if($_lib->isUser()){
                if ($v['rpname'])
                    $dbJobDetail = $_hr->DbJobDetail($v['rpname'],$_SESSION['SS_USER']['pptype']);
            }else{
                if ($v['rpname'])
                    $dbJobDetail = $_hr->DbJobDetail($v['rpname']);
            }
            if (!$dbJobDetail) continue;
            if ($_lib->isMaster() || $_lib->isAdmin()) {
                if ($v['rpname']) {
                    $v['rpname'] = $dbJobDetail['pptype'] . "/ " . $dbJobDetail['ptype'];
                } else {
                    $v['rpname'] = '<span class="text-color-red-alpha">-- รอตำแหน่งว่าง --</span>';
                }
            } else {
                if ($v['rpname']) {
                    $v['rpname'] = $dbJobDetail['pptype'] . "/ " . $dbJobDetail['ptype'];
                } else {
                    continue;
                }
            }

            $xsname = explode(',',$v['sname']);
            $xsname = implode("','",$xsname);
            $xsname = "'{$xsname}'";
            $snames = array();
            $dataSname = getMYSQLValueAll('tbinfo','name'," loginid in ({$xsname}) ");
            if($dataSname){
                foreach($dataSname as $sk=>$sv){
                    $snames[]= "คนที่ ".($sk+1).") ".$sv['name'];
                }
            }
            $v['sname'] = implode("<br>",$snames);

            $dbTable[] = $v;
        }

if($_lib->isUser()){
    $htmlContent = $_hr->FnMyTable($tb_name, $tb_title, $tabColTitle, $dbTable,'add,edit');
}else{
    $htmlContent = $_hr->FnMyTable($tb_name, $tb_title, $tabColTitle, $dbTable,'add,edit,del');
}



    $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.7' "); //zoom:1.2
    $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_hr->FnTbWidth($_PageName,'id','10%');
echo $_hr->FnTbWidth($_PageName,'sotype','13%');
echo $_hr->FnTbWidth($_PageName,'sname','15%');
echo $_html->includeAll($_PageName);

//vvArray($_hr->DbPersonRegPosition('2'));

?>