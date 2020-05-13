<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "รายงานตัวทำสัญญาจ้าง";
$_PageName = trim(str_replace('.php', '', basename($_SERVER['SCRIPT_NAME'])));
$_SESSION['M_FILE_NAME'] = $_PageName;//$_GET['mfname'];
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";
$boxContent = '';
$footer = '';
$divBody = '';
$frmBody = '';
$tbTables = array("hr_interview" => $title);
$tab = new tabClass();
foreach ($tbTables as $k => $v) {
        $tabColTitle = array("cid" => "บัตรประชาชน",
            "rdate" => "วันรายงานตัว", "idate" => "วันที่เริ่มงาน", "note2" => " หมายเหตุ", "");
        $tb_name = $k;
        $tb_title = $v;

        /* mode Add */
        if($_lib->isUser()) {
                $dbPerson = $_hr->DbPersonRegPositionNotInterview('', $_SESSION['SS_USER']['pptype']);
        }else{
                $dbPerson = $_hr->DbPersonRegPositionNotInterview('');
        }

        $arCid = array();
        foreach ($dbPerson as $k => $v)
                $arCid[$v['rpid']] = $v['cid'] . ": " . $v['cname'] . " [ " . $v['rpname'] . " ]";


        $pReq = '<span class="text-red">*</span>';
        $frm = $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
        $frm .= $_html->elementFormTag('textbox', 'id', 'id', '', '', 'hide', '');
        foreach ($tabColTitle as $k => $v) {
                if ($v != "" && $k != 'cname' && $k != 'ptype') {
                        switch ($k) {
                                case "cid":
                                        $frm .= $_html->elementFormTag('select', $k, $k, $v, $arCid, 'modal', " required ");
                                        break;
                                case "rtype":
                                        $arPstype = getMYSQLValueAll('hr_rtype', 'id,name');
                                        $arPstype = $_lib->arrayToSelect($arPstype, 1);
                                        $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', "  ");
                                        break;
                                case "idate": case "rdate":
                                        $frm .= $_html->elementFormTag('mask', $k, $k, $v, '', '', "data-inputmask='\"mask\": \"99/99/9999\"'  ");
                                        break;

                                case "sotype":
                                        $arPstype = getMYSQLValueAll('hr_sotype', 'id,name');
                                        $arPstype = $_lib->arrayToSelect($arPstype, 1);
                                        $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', "  ");
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
                                case "rtype":
                                        $arPstype = getMYSQLValueAll('hr_rtype', 'id,name');
                                        $arPstype = $_lib->arrayToSelect($arPstype, 1);
                                        $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', "  ");
                                        break;
                                case "sotype":
                                        $arPstype = getMYSQLValueAll('hr_sotype', 'id,name');
                                        $arPstype = $_lib->arrayToSelect($arPstype, 1);
                                        $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', "  ");
                                        break;
                                case "ddate":
                                        $frm .= $_html->elementFormTag('mask', $k, $k, $v, '', '', "data-inputmask='\"mask\": \"99/99/9999\"'  ");
                                        break;
                                default :
                                        $frm .= $_html->elementFormTag('textbox', $k, $k, $v, '', '', '');
                        }
                }
        }
        //----- End Form Edit
        echo $_hr->FnMyFromEdit($tb_name, $frm);


        $tabColTitle = array( "cname" => "ชื่อ-สกุล", "tel"=>"ติดต่อ", "ptype" => "ตำแหน่งที่สมัคร",
            "ddate" => "วันสัมภาษณ์", "ssite" => "วันรายงานตัว", "sname" => "วันที่เริ่มงาน", "rtype" => " หมายเหตุ", "");
        $datadb = $dbmy->exec("
        select
               concat(y.pname,y.fname,' ',y.lname) as cname,
               concat('<p>โทร.',y.tel,'</p><p>',y.lineid,'</p>') as tel,
               rp.regp as rpname ,
               x.ddate, x.rdate, x.idate,
               x.note2,
               x.id
        from hr_interview as x , hr_person as y , hr_reg_position rp
        where x.cid = y.cid and rp.id = x.rpid and x.rtype = 1
        "); // must be use last "id" alway

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
                        $dbTable[] = $v;
                }

        if($_lib->isUser()){
                $htmlContent = $_hr->FnMyTable($tb_name, $tb_title, $tabColTitle, $dbTable,'edit');
        }else{
                $htmlContent = $_hr->FnMyTable($tb_name, $tb_title, $tabColTitle, $dbTable,'edit');
        }



        $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.7' "); //zoom:1.2
        $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_hr->FnTbWidth($_PageName,'id','5%');
echo $_hr->FnTbWidth($_PageName,'tel','10%');
echo $_hr->FnTbWidth($_PageName,'cname','15%');
echo $_hr->FnTbWidth($_PageName,'ddate','9%');
echo $_hr->FnTbWidth($_PageName,'rdate','9%');
echo $_hr->FnTbWidth($_PageName,'idate','9%');
echo $_hr->FnTbWidth($_PageName,'rpname','10%');

echo $_html->includeAll($_PageName);

//vvArray($_hr->DbPersonRegPosition('2'));

?>