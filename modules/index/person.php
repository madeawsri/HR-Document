<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "ข้อมูลส่วนตัว";
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
$pnames = array("นาย" => "นาย", "นาง" => "นาง", "นางสาว" => "นางสาว", "ต.ส."=>"ต.ส.","ว่าที่ ร.ต.ด."=>"ว่าที่ ร.ต.ด.");
foreach ($tbTables as $k => $v) {
    $tb_name = $k;
    $tb_title = $v;

    //-----
    $pReq = '<span class="text-red">*</span>';
    $frm = $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
    $frm .= $_html->elementFormTag('textbox', 'id', 'id', '', '', 'hide', '');
    $frm .= $_html->elementFormTag('mask', 'cid', 'cid', ' เลขบัตรประชาชน', '', '', "data-inputmask='\"mask\": \"9-9999-99999-99-9\"' ");
    $frm .= $_html->elementFormTag('select', 'pname', 'pname', 'คำนำหน้า', $pnames, 'modal', '');
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
    // echo $_hr->FnFromEdit($tb_name);
    $datadb = getMYSQLValueAll($tb_name, "cid, concat(pname,fname,' ',lname) as cname, bdate,addr,concat(tel,'<p>',email,'</p>') as tel ,id ",
        " kslid = '{$_REQUEST['site']}' order by iorder desc, id desc  "); // must be use last "id" alway

    $htmlContent = $_hr->FnMyTable($tb_name, $tb_title, array("บัตรประชาชน", "ชื่อ-สกุล", "วันเกิด", "ที่อยู่", "เบอร์โทร", ""), $datadb, "add,edit,pic,pdf");

    $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.7' "); //zoom:1.2
    $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_hr->FnTbWidth($_PageName, 'cname', '15%');
echo $_hr->FnTbWidth($_PageName, 'tel', '20%');
echo $_hr->FnTbWidth($_PageName, 'id', '10%');
echo $_html->includeAll($_PageName);


?>