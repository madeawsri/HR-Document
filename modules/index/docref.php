<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "ค้นหาเอกสารทั้งหมด";
$_PageName = trim(str_replace('.php', '', basename($_SERVER['SCRIPT_NAME'])));
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_SESSION['M_FILE_NAME'] = $_PageName;
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";
// vvArray($_SESSION[SS_USER]);
$boxContent = '';
$footer = '';
$divBody = '';
$frmBody = '';
$tbTables = array("hr_docref" => $title);
$tab = new tabClass();
foreach ($tbTables as $k => $v) {
    $tb_name = $k;
    $tb_title = $v;

    if (!$_lib->isUser()) {
        $tabColTitle["status"] = " สถานะการลงประกาศ ";
    }

    $tabColTitle = array(
        "dtime" => "วันที่เอกสาร",
        "fname"=>"ชื่อเอกสาร",
        "detail" => "รายละเอียดเอกสาร",
        "oname"=>"เจ้าของเอกสาร",
        "filename" => "ดาว์นโหลดเอกสาร",
        "");

    $datadb = $dbmy->exec("

     select dtime,detail,filename,id,tbname,cid as xid,owner

     from hr_docref where kslid = '" . SITE_NAME . "' order by id DESC

    ");

    $dataTable = array();
    if($datadb){
        foreach($datadb as $k=>$v){
            $temp = array();
            $dtime = "";
            $dtime = $v['dtime'];
            $temp['dtime'] = "{$dtime[0]}{$dtime[1]}/{$dtime[2]}{$dtime[3]}/{$dtime[4]}{$dtime[5]}{$dtime[6]}{$dtime[7]}";

            if(strstr($v['tbname'],'hr_appjob')){
                $temp['fname'] = 'ใบขออนุมัติอัตรา';
                $mm = 'ขออนุมัติอัตรากำลัง';
            }else{
                $mm = getMYSQLValue('menu','name'," concat('hr_',fname) like '%{$v['tbname']}%' ");
                $temp['fname'] = getMYSQLValue('hr_person',"concat(pname,fname,' ',lname) ","cid = '{$v['xid']}' ") ;
            }



            $temp['detail'] = "หมวด : <span class='text-color-blue bb'>{$mm}</span><br>";
            $temp['detail'] .= $v['detail'];

            $temp['oname'] = getMYSQLValue('tbinfo','name'," loginid = {$v['owner']} ");

            if(strstr($v['tbname'],'hr_appjob')){

            $temp['filename'] = "<a href='".SERVER_NAME."/../uploads/".SITE_NAME."/AppJob/{$v['filename']}'
                                download='".TIMESTAMP."'><i class='fa fa-download fa-2x'></i></a>";
            }else{

                $temp['filename'] = "<a href='".SERVER_NAME."/../uploads/".SITE_NAME."/{$v['xid']}/{$v['filename']}'
                                download='".TIMESTAMP."'><i class='fa fa-download fa-2x'></i></a>";
            }

            $temp['id']=$v['id'];

            $dataTable[] = $temp;
        }
    }
    $htmlContent = $_hr->FnMyTable($tb_name, $tb_title, $tabColTitle, $dataTable, "del");
    $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.8' "); //zoom:1.2
    $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}

$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_hr->FnTbWidth($_PageName,'dtime','10%');
echo $_hr->FnTbWidth($_PageName,'fname','15%');
echo $_hr->FnTbWidth($_PageName,'oname','15%');
echo $_hr->FnTbWidth($_PageName,'detail','30%');
echo $_html->includeAll($_PageName);

?>



