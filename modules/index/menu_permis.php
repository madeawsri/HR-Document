<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "กำหนดสิทธิ์เข้าถึงเมนู";
$_PageName = trim(str_replace('.php', '', basename($_SERVER['SCRIPT_NAME'])));
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_SESSION['M_FILE_NAME'] = $_PageName;
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";

$boxContent = '';
$footer = '';
$divBody = '';
$frmBody = '';
$tbTables = array("gmenu" => $title);
$tab = new tabClass();
foreach ($tbTables as $k => $v) {
    $tb_name = $k;
    $tb_title = $v;

    //-----
    $pReq = '<span class="text-red">*</span>';
    $frm = $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
    $frm .= $_html->elementFormTag('textbox', 'id', 'id', '', '', 'hide', '');

    $arPmtype = $_hr->getPmtype();
    $arPmtype = $_lib->arrayToSelect($arPmtype);
    $frm .= $_html->elementFormTag('select', 'pmid', 'pmid', ' ชื่อกลุ่มสิทธิ์ในการเข้าถึงเมนู ', $arPmtype, 'modal', '');
    $arMenu = getMYSQLValueAll('menu', 'id,name');
    $arMenu = $_lib->arrayToSelect($arMenu);
    $frm .= $_html->elementFormTag('select', 'mid', 'mid', ' เมนู (เลือกได้มากกว่า 1 รายการ) ', $arMenu, 'modal', "  ");

    //----- End Form

    echo $_hr->FnMyFromAdd($tb_name, $frm);
    echo $_hr->FnMyFromEdit($tb_name, $frm);

    $datadb = $_lib->dbGMenu();
    // vvArray($datadb);
    $dbTable = array();

    if ($datadb)
        foreach ($datadb as $k => $v) {
            $temp = array();
            $temp['pmid'] = $v['gmname'];

            $menus = $_lib->dbMenu($v['mid']);
            $temp['mid'] .= " {$menus[0]['name']} ";

            $op = array("open" => "checked", "add" => "checked", "edit" => "checked", "del" => "checked",
                "pdf" => "checked", "exp" => "checked", "ass" => "checked");

            if(!$v['open']) $op['open'] = "";
            if(!$v['add']) $op['add'] = "";
            if(!$v['edit']) $op['edit'] = "";
            if(!$v['del']) $op['del'] = "";
            if(!$v['pdf']) $op['pdf'] = "";
            if(!$v['exp']) $op['exp'] = "";
            if(!$v['ass']) $op['ass'] = "";


            $id = $v['gmid'];

            $temp['open'] .= ' <label style="cursor: pointer;"><input type="checkbox" name="pm' . $v['gmid'] . '"
                              data-id="' . $id . '" data-option="open"  class="minimal pmRadio"  ' . $op['open'] . '> </label>   ';
            $temp['add'] .= ' <label style="cursor: pointer;"><input type="checkbox" name="pm' . $v['gmid'] . '"
                              data-id="' . $id . '" data-option="add" class="minimal pmRadio" ' . $op['add'] . '></label>   ';
            $temp['edit'] .= ' <label style="cursor: pointer;"><input type="checkbox" name="pm' . $v['gmid'] . '"
                              data-id="' . $id . '" data-option="edit" class="minimal pmRadio"  ' . $op['edit'] . '></label>   ';
            $temp['del'] .= ' <label style="cursor: pointer;"><input type="checkbox" name="pm' . $v['gmid'] . '"
                              data-id="' . $id . '" data-option="del" class="minimal pmRadio"  ' . $op['del'] . '></label>   ';
            $temp['pdf'] .= ' <label style="cursor: pointer;"><input type="checkbox" name="pm' . $v['gmid'] . '"
                              data-id="' . $id . '" data-option="pdf" class="minimal pmRadio"  ' . $op['pdf'] . '></label>   ';

            $temp['exp'] .= ' <label style="cursor: pointer;"><input type="checkbox" name="pm' . $v['gmid'] . '"
                              data-id="' . $id . '" data-option="exp" class="minimal pmRadio"  ' . $op['exp'] . '></label>   ';

            $temp['ass'] .= ' <label style="cursor: pointer;"><input type="checkbox" name="pm' . $v['gmid'] . '"
                              data-id="' . $id . '" data-option="ass" class="minimal pmRadio"  ' . $op['ass'] . '></label>   ';

            $temp['id'] = $v['gmid'];

            $dbTable[] = $temp;
        }

    //vvArray($dbTable);
    //$arrDataX[] = array('name'=>'','menus'=>'','id'=>'');
    $htmlContent = $_hr->FnMyTable($tb_name, $tb_title, array("ระดับการเข้าถึงเมนู", "รายการเมนู", "เปิด", "เพิ่ม", "แก้ไข", "ลบ", "ดาวน์โหลด","นำออกไฟล์","แบบประเมิน", ''), $dbTable, 'add,edit,del,checkbox');
    $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.7' "); //zoom:1.2
    $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
//echo $_lib->JRender(' jMenuPermis(); ');
echo $_html->divTag('rpShow');

echo $_hr->FnTbWidth('tbgmenu', 'pmid', '20%', 0);
echo $_hr->FnTbWidth('tbgmenu', 'mid', '30%', 0);
echo $_hr->FnTbWidth('tbgmenu', 'open', '3%', 0);
echo $_hr->FnTbWidth('tbgmenu', 'add', '3%', 0);
echo $_hr->FnTbWidth('tbgmenu', 'edit', '3%', 0);
echo $_hr->FnTbWidth('tbgmenu', 'del', '3%', 0);
echo $_hr->FnTbWidth('tbgmenu', 'pdf', '3%', 0);
echo $_hr->FnTbWidth('tbgmenu', 'exp', '7%', 0);
echo $_hr->FnTbWidth('tbgmenu', 'ass', '8%', 0);
echo $_html->includeAll($_PageName);


?>