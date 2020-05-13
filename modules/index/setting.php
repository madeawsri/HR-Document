<?
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$tab = new tabClass();
$_PageName = trim(str_replace('.php','',basename($_SERVER['SCRIPT_NAME'])));
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_SESSION['M_FILE_NAME'] = $_PageName;
$title = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> ตั้งค่าข้อมูลพื้นฐาน ";

$boxContent=''; $footer = ''; $divBody = ''; $frmBody = '';
$tbTables = array(  "hr_pstype"=>"ข้อมูลสถานะภาพ",
                    "hr_ctype"=>"สถานะการทำงาน",
                    "hr_dtype"=>"ข้อมูลใบขับขี่",
                    "hr_stype"=>"สถานะการเกณฑ์ทหาร",
                    "hr_etype"=>"ระดับการศึกษา",
                    "hr_eutype"=>"สถาบัน",
                    "hr_vtype"=>"สาขาวิชา",
                    "hr_pptype"=>"ข้อมูลแผนก",
                    "hr_ptype"=>"รวมตำแหน่งงาน",
                    "hr_rtype"=>"ผลการสัมภาษณ์",
                    "hr_sotype"=>"ประเภทการสอบ",
                    "hr_pmtype"=>" กลุ่มสิทธิในการเข้าใช้งาน ",
                    "hr_notype"=>" สรุปความเห็นผู้สัมภาษณ์ ",
                    "hr_grtype"=>"ข้อมูลชื่อฝ่าย",
                    "hr_sutype"=>"ข้อมูลชื่อส่วนงาน",

                  );
foreach($tbTables as $k=>$v){
    $tb_name = $k;
    $tb_title = $v;
    echo $_hr->FnFromAdd($tb_name);
    echo $_hr->FnFromEdit($tb_name);
    $htmlContent = $_hr->FnTable($tb_name,$tb_title);
    $boxContent = $_html->divTag('', $htmlContent ,'col-lg-12',"style='zoom:0.9' "); //zoom:1.2
    $tab->tabData('tab'.$tb_name,$tb_title,$boxContent);
}
echo $_lib->JRender("$('.editSettingButton').on('click', function () {
                    jPageSettingEdit($(this));
                });");
$boxContentTab = $tab->render();
$_html->boxTag($title,$boxContentTab,$footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_html->includeAll($_PageName);
?>