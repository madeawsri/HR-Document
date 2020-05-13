<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "แบบฟอร์มขออนุมัติอัตรากำลัง";
$_PageName = trim(str_replace('.php', '', basename($_SERVER['SCRIPT_NAME'])));
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_SESSION['M_FILE_NAME'] = $_PageName;
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";
// vvArray($_SESSION[SS_USER]);
$boxContent = '';
$footer = '';
$divBody = '';
$frmBody = '';
$tbTables = array("hr_appjob" => $title);
$tab = new tabClass();
foreach ($tbTables as $k => $v) {
    $tabColTitle = array("datein" => "วันที่ขอ",
        "grtype" => " ฝ่าย ", "sutype" => " ส่วน ",
        "ptype" => "ตำแหน่งงาน",
        "satype" => "อัตราเงินเดือน",
        "aptype1" => "ประเภทตำแหน่ง 1 ", "aptype2" => " ประเภทตำแหน่ง 2  ",
        "sxtype" => "เพศ ", "agtype" => " ช่วงอายุ  ", "etypes" => " การศึกษา  ",
        "ns" => "จำนวนคน",
        "ndate" => "วันที่ต้องการ",
        "note" => " รายชื่อผู้ถูกทดแทน / เหตุผลที่ขอเพิ่ม",
        "");

    if(!$_lib->isUser()){
        $tabColTitle["status"] = " สถานะการลงประกาศ ";
    }

    $tb_name = $k;
    $tb_title = $v;

    /* mode Add */
    $dbPerson = $_hr->DbPersonRegPositionNotInterview();
    $arCid = array();
    foreach ($dbPerson as $k => $v)
        $arCid[$v['rpid']] = $v['cid'] . ": " . $v['cname'] . " [ " . $v['rpname'] . " ]";
    $pReq = '<span class="text-red">*</span>';
    $frm = $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
    $frm .= $_html->elementFormTag('textbox', 'id', 'id', '', '', 'hide', '');
    foreach ($tabColTitle as $k => $v) {
        if ($v != "" && $k != '') {
            switch ($k) {
                case "satype":
                case "agtype":
                case "sxtype":
                case "aptype2":
                case "aptype1":
                case "ptype":
                case "grtype":
                case "sutype":
                    $arPstype = getMYSQLValueAll('hr_' . $k, 'id,name');

                    $arPstype = $_lib->arrayToSelect($arPstype);
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', "  ");
                    break;
                case "etypes":
                    $arPstype = $_lib->arrayToSelect(array(
                        array("id" => 1, "name" => $mEduTypes[1]),
                        array("id" => 2, "name" => $mEduTypes[2]),
                        array("id" => 3, "name" => $mEduTypes[3]),
                        array("id" => 4, "name" => $mEduTypes[4]),));
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', " multiple ");
                    break;
                case "status":

                    $arPstype = $_lib->arrayToSelect(array(
                        array("id" => 0, "name" => $mStatusAppJob[0]),
                        array("id" => 1, "name" => $mStatusAppJob[1]),
                    ));
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', "  ");
                    break;
                case "datein":
                case "ndate":
                    $frm .= $_html->elementFormTag('mask', $k, $k, $v, $_lib->getDateTH(TIMESTAMP), '', "data-inputmask='\"mask\": \"99/99/9999\"'  ");
                    break;
                case "note":
                    $frm .= $_html->elementFormTag('textarea', $k, $k, $v, '', '', '');
                    break;
                case "ns" :
                    $frm .= $_html->elementFormTag('number', $k, $k, $v, '1', '', "   ");
                    break;
                default :
                    $frm .= $_html->elementFormTag('textbox', $k, $k, $v, '', '', '');

            }
        }
    }
    //----- End Form Add
    echo $_hr->FnMyFromAdd($tb_name, $frm);
    /* mode Edit */
    echo $_hr->FnMyFromEdit($tb_name, $frm);

    $tabColTitle = array("datein" => "วันที่ขอ",
        "ndate" => "วันที่ต้องการ",
        "djob" => "ตำแหน่งขออนุมัติ",
        "detail" => "รายละเอียด",
        "ns" => "จำนวนที่ขอ",
        "");

    if ($_lib->isUser()) {

        $datadb = $dbmy->exec("
        select x.datein,
               (select pp.name from hr_grtype as pp where pp.id = x.grtype) as grtype,
               (select pp.name from hr_sutype as pp where pp.id = x.sutype) as sutype,
               (select pp.name from hr_pptype as pp where pp.id = x.grtype) as pptype,
               (select pp.name from hr_ptype as pp where pp.id = x.ptype) as ptype,
                x.ndate,x.ns,
               (select pp.name from hr_sxtype as pp where pp.id = x.sxtype) as sxtype,
               (select pp.name from hr_agtype as pp where pp.id = x.agtype) as agtype,
               (select pp.name from hr_satype as pp where pp.id = x.satype) as satype,
                x.etypes, x.aptype1, x.aptype2,
               (select pp.name from hr_pptype as pp where pp.id = x.grtype) as pptype,
               (select pp.name from tbinfo as pp where pp.loginid = x.uid) as uname,
               x.status,
               x.id
        from hr_appjob as x
        where  x.kslid = '" . SITE_NAME . "' and x.uid = '{$_SESSION['SS_USER']['id']}'
        order by datein desc
        ");

    } else {

        $datadb = $dbmy->exec("
        select x.datein,
               (select pp.name from hr_grtype as pp where pp.id = x.grtype) as grtype,
               (select pp.name from hr_sutype as pp where pp.id = x.sutype) as sutype,
               (select pp.name from hr_pptype as pp where pp.id = x.grtype) as pptype,
               (select pp.name from hr_ptype as pp where pp.id = x.ptype) as ptype,
                x.ndate,x.ns,
               (select pp.name from hr_sxtype as pp where pp.id = x.sxtype) as sxtype,
               (select pp.name from hr_agtype as pp where pp.id = x.agtype) as agtype,
               (select pp.name from hr_satype as pp where pp.id = x.satype) as satype,
                x.etypes, x.aptype1, x.aptype2,
               (select pp.name from hr_pptype as pp where pp.id = x.grtype) as pptype,
               (select pp.name from tbinfo as pp where pp.loginid = x.uid) as uname,
               x.status,
               x.id
        from hr_appjob as x
        where  x.kslid = '" . SITE_NAME . "'
        order by datein desc

        ");

    }

//    exit;
    $dataTable = array();
    /*  filter  status */
    if ($datadb)
        foreach ($datadb as $k => $v) {
            $temp = array();
            $temp['datein'] = $v['datein'];
            $temp['ndate'] = $v['ndate'];
            $temp['djob'] = "
                        <p class='bb'>แผนก{$v['pptype']}</p>
                        <p>ตำแหน่ง : <b>{$v['ptype']}</b></p>
                        <p>อัตราเงินเดือน : <b>{$v['satype']}</b></p>
                    ";
            $etype = explode(',', $v['etypes']);
            $et = array();
            if ($etype)
                foreach ( $etype as $ek => $ev)
                    $et[] = $mEduTypes[$ev];
            $etype = implode(', ', $et);
            if($_lib->isUser()){
                $temp['detail'] = "
                        <p>ผู้ขอ : <b>{$v['uname']}</b></p>
                        <p>เพศ : <b>{$v['sxtype']}</b></p>
                        <p>ช่วงอายุ : <b>{$v['agtype']}</b></p>
                        <p>วุฒิ : <b>{$etype}</b></p>
                        <p>สถานะ : <b>{$mStatusAppJob[$v['status']]}</b></p>
                    ";
            }else{
                $temp['detail'] = "
                        <p>ผู้ขอ : <b>{$v['uname']}</b></p>
                        <p>เพศ : <b>{$v['sxtype']}</b></p>
                        <p>ช่วงอายุ : <b>{$v['agtype']}</b></p>
                        <p>วุฒิ : <b>{$etype}</b></p>
                    ";

                $sendid = getMYSQLValue('hr_docref','count(cid)'," tbname like 'hr_appjob' and cid = '{$v['id']}'  group by cid  ");
                $sendid = (int)($sendid > 0);

                $temp['detail'] .= '<p>ส่งเอกสาร : <b>';
                $temp['detail'] .= "{$mSendAppJob[$sendid]}";
                $temp['detail'] .='</b></p>';

                $temp['detail'] .= '<p>สถานะ : <b>';
                $temp['detail'] .= "{$mStatusAppJob[$v['status']]}";
                $temp['detail'] .='</b></p>';

            }


            $temp['ns'] = $v['ns'];
            $temp['id'] = $v['id'];

            $dataTable[] = $temp;
        }


    $htmlContent = $_hr->FnMyTable($tb_name, $tb_title, $tabColTitle, $dataTable, "add,edit,del,print,send");

    $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.8' "); //zoom:1.2
    $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_html->includeAll($_PageName);

?>

