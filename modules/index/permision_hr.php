<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "กำหนดสิทธิ์ดูรายงาน";
$_PageName = trim(str_replace('.php', '', basename($_SERVER['SCRIPT_NAME'])));
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_SESSION['M_FILE_NAME'] = $_PageName;
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";

$boxContent = '';
$footer = '';
$divBody = '';
$frmBody = '';
$tbTables = array("hr_person" => $title);
$tab = new tabClass();
foreach ($tbTables as $k => $v) {
    $tb_name = $k;
    $tb_title = $v;

    //-----
    $pReq = '<span class="text-red">*</span>';
    $frm = $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
    $frm .= $_html->elementFormTag('textbox', 'id', 'id', '', '', 'hide', '');
    $frm .= $_html->elementFormTag('mask', 'cid', 'cid', ' เลขบัตรประชาชน', '', '', "data-inputmask='\"mask\": \"9-9999-99999-99-9\"' ");
    $frm .= $_html->elementFormTag('select', 'pname', 'pname', 'คำนำหน้า', array("นาย" => "นาย", "นาง" => "นาง", "นางสาว" => "นางสาว"), 'modal', '');
    $frm .= $_html->elementFormTag('textbox', 'fname', 'fname', 'ชื่อ', '', '', '');
    $frm .= $_html->elementFormTag('textbox', 'lname', 'lname', 'สกุล', '', '', '');
    $frm .= $_html->elementFormTag('mask', 'bdate', 'bdate', $pReq . ' วันเกิด ว/ด/พ.ศ.', '', '', "data-inputmask='\"mask\": \"99/99/9999\"' required ");
    $frm .= $_html->elementFormTag('textbox', 'addr', 'addr', 'ที่อยู่', '', '', '');
    $frm .= $_html->elementFormTag('textbox', 'tel', 'tel', 'เบอร์ติดต่อ', '', '', '');
    $frm .= $_html->elementFormTag('textbox', 'email', 'email', 'อีเมล', '-', '', '');
    $frm .= $_html->elementFormTag('textbox', 'lineid', 'lineid', 'ไลน์ไอดี', '', '', '');
    //----- End Form

    echo $_hr->FnMyFromAdd($tb_name, $frm);
    echo $_hr->FnMyFromEdit($tb_name, $frm);

    $dsUsers = getMYSQLValueAll("tblogin x, tbinfo y",
        "  x.user,y.name,
         ((select pp.name from hr_pptype as pp where pp.id = y.pptype)) as job,
        y.work,concat(x.id,'|',y.pmtype) as id ",
        "x.id = y.loginid and pmtype <> 0 order by x.id desc ");
  //  vvArray($dsUsers);
    $dbPmtype = $_hr->getPmtype();

    $dataTable = array();
    if ($dsUsers)
        foreach ($dsUsers as $k => $v) {

            $xid = explode('|', $v['id']);
            $uid = $xid[0];
            $pmid = $xid[1];

            $v['id'] = '';
            foreach ($dbPmtype as $pk => $pv) {

                if ($pmid == $pv['id']) {

                    $v['id'] .= ' <label style="cursor: pointer;"><input type="radio" name="pm' . $uid . '"
                            data-id="' . $uid . '" data-option="open"  class="minimal pmRadio" value="'.$pv['id'].'"
                            checked> ' . $pv['name'] . ' </label>   ';

                } else {
                    $v['id'] .= ' <label style="cursor: pointer;"><input type="radio" name="pm' . $uid . '"
                            data-id="' . $uid . '" data-option="open"  class="minimal pmRadio" value="'.$pv['id'].'" > ' .
                        $pv['name'] . ' </label>   ';
                }
            }
            $dataTable[] = $v;
        }

    $htmlContent = $_hr->FnPermisTable($tb_name, $tb_title, array("@kslgroup.com", "ชื่อ-สกุล", "แหนก/ ตำแหน่ง", "หน้าที่", "สิทธิดูรายงาน"), $dataTable);
    $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.7' "); //zoom:1.2
    $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');

echo $_html->includeAll($_PageName);

?>