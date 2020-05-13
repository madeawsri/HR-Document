<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "ลงประกาศสมัครงาน";
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
    $tabColTitle = array("din" => "วันที่เปิด", "dexp" => "วันที่ปิด", "jtype" => "ประเภทตำแหน่ง", "djob" => "ตำแหน่งงาน",
        "nn" => "จำนวนคน", "");
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
        if ($v != "" && $k != 'cname') {
            switch ($k) {
                case "jtype":
                    $arPstype = getMYSQLValueAll('hr_' . $k, 'id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype);
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', "  ");
                    break;
                case "djob":
                    $arPstype = getMYSQLValueAll('hr_dec_job', "id,
                                concat((select pp.name from hr_pptype as pp where pp.id = pptype),' : ',
                                       (select pp.name from hr_ptype as pp where pp.id = ptype)) as name ", " kslid = '" . SITE_NAME . "' order by pptype,ptype");
                    $arPstype = $_lib->arrayToSelect($arPstype);
                    $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal', "  ");
                    break;
                case "din":
                case "dexp":
                    $frm .= $_html->elementFormTag('mask', $k, $k, $v, $_lib->getDateTH(TIMESTAMP), '', "data-inputmask='\"mask\": \"99/99/9999\"'  ");
                    break;
                case "attb":
                    $frm .= $_html->elementFormTag('textarea', $k, $k, $v, '', '', '');
                    break;
                case "nn" :
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
    //----- End Form Edit
    echo $_hr->FnMyFromEdit($tb_name, $frm);

    //$tabColTitle = array("แผนก","ตำแหน่ง","อายุ","เพศ","วุฒิการศึกษา/ สาขาวิชา","คุณสัมบัติ","อัตราเงินเดือน","");
    $tabColTitle = array("din" => "วันที่เปิด", "dexp" => "วันที่ปิด", "jtype" => "ประเภทตำแหน่ง", "djob" => "ตำแหน่งงาน",
        "nn" => "จำนวนคน", "nx" => "สมัครแล้ว", "");


    if($_lib->isUser()){
        $datadb = $dbmy->exec("
        select
               x.din, x.dexp,
               (select pp.name from hr_jtype as pp where pp.id = x.jtype) as jtype,
               concat('<b>',(select pp.name from hr_pptype as pp where pp.id = y.pptype),'</b><br> - ',
                              (select pp.name from hr_ptype as pp where pp.id = y.ptype)) as djob,
               x.nn,
               (select count(rp.regp) from hr_reg_position as rp where rp.regp = x.id group by rp.regp) as  nx,
               x.id
        from hr_job as x , hr_dec_job as y
        where  x.djob in (y.id) and y.kslid = '" . SITE_NAME . "' and x.approved = 1 and y.pptype = {$_SESSION['SS_USER']['pptype']} order by dtime desc
        "); // must be use last "id" alway
    }else{
        $datadb = $dbmy->exec("
        select
               x.din, x.dexp,
               (select pp.name from hr_jtype as pp where pp.id = x.jtype) as jtype,
               concat('<b>',(select pp.name from hr_pptype as pp where pp.id = y.pptype),'</b><br> - ',
                              (select pp.name from hr_ptype as pp where pp.id = y.ptype)) as djob,
               x.nn,
               (select count(rp.regp) from hr_reg_position as rp where rp.regp = x.id group by rp.regp) as  nx,
               x.id
        from hr_job as x , hr_dec_job as y
        where  x.djob in (y.id) and y.kslid = '" . SITE_NAME . "' and x.approved = 1  order by dtime desc
        "); // must be use last "id" alway
    }





   $dataTable = array();
    /*  filter  status */
    if ($datadb)
        foreach ($datadb as $k => $v) {

            $temp = array();
            $v['nx'] = $v['nx']." | <a href='javascript:void(0);'
            onclick=\"jPersonInfo( encodeURI('{$v['djob']}'),{$v['id']});\"
            class='person-info'><i class='fa fa-hospital-o fa-2x '></i></a>";

            $dataTable[] = $v;
        }


    $htmlContent = $_hr->FnMyTable($tb_name, $tb_title, $tabColTitle, $dataTable);
    $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.7' "); //zoom:1.2
    $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_html->includeAll($_PageName);

//vvArray($_hr->DbPersonRegPosition('2'));

?>