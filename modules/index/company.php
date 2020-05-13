<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "ข้อมูลประวัติการทำงาน";
$_PageName = trim(str_replace('.php','',basename($_SERVER['SCRIPT_NAME'])));
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_SESSION['M_FILE_NAME'] = $_PageName;
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";

$boxContent=''; $footer = ''; $divBody = ''; $frmBody = '';
$tbTables = array("hr_".$_PageName=>$title);
$tab = new tabClass();
foreach($tbTables as $k=>$v){
        $tabColTitle = array("cid"=>"บัตรประชาชน","cnamex"=>"ชื่อ-สกุล",
            "cname"=>"บริษัท", "cwork"=>"ตำแหน่ง/หน้าที่ " , "ctype"=>"สถานะการทำงาน" ,"");
        $tb_name = $k;
        $tb_title = $v;

        $dbPerson = getMYSQLValueAll('hr_person',"cid, concat(pname,fname,' ',lname) as cname ",
            " kslid = '{$_REQUEST['site']}' ORDER BY id desc" ); // must be use last "id" alway

        $arCid = array();
        foreach($dbPerson as $k=>$v){
                if(trim($v['cid']))
                $arCid[$v['cid']] = $v['cid']." - ".$v['cname'];
        }

        //-----
        $pReq = '<span class="text-red">*</span>';
        $frm =  $_html->elementFormTag('textbox','tbname','tbname','',$tb_name,'hide','') ;
        $frm .=  $_html->elementFormTag('textbox','id','id','','','hide','') ;
        foreach($tabColTitle as $k=>$v){
                if($v != "" && $k != 'cnamex'){
                        switch($k){
                                case "cid":
                                        $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arCid,'modal'," required ");
                                        break;
                                case "ctype":
                                        $arPstype = getMYSQLValueAll('hr_ctype','id,name');
                                        $arPstype = $_lib->arrayToSelect($arPstype);
                                        $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal'," required ");
                                        break;
                                case "dout":
                                case "dexp":
                                        $frm .=  $_html->elementFormTag('mask',$k,$k,$v,'','',"data-inputmask='\"mask\": \"99/99/9999\"'  ");
                                        break;
                                case "did":
                                        $frm .=  $_html->elementFormTag('mask',$k,$k,$v,'','',"data-inputmask='\"mask\": \"99999999\"'  ");
                                        break;
                                default :
                                        $frm .=  $_html->elementFormTag('textbox',$k,$k,$v,'','','') ;
                        }
                }
        }
        //----- End Form

        echo $_hr->FnMyFromAdd($tb_name,$frm);
        echo $_hr->FnMyFromEdit($tb_name,$frm);

        $datadb = getMYSQLValueAll("{$tb_name} as x , hr_person as y ",
            "x.cid , concat(y.pname,y.fname,' ',y.lname) as cnamex,".
            " x.cname,x.cwork,(select name from hr_ctype as ps where ps.id = x.ctype ) as ctype,x.id" ,
            " x.cid = y.cid  ORDER BY x.id desc"); // must be use last "id" alway

        $htmlContent = $_hr->FnMyTable($tb_name,$tb_title,$tabColTitle,$datadb,"add,edit,pdf,del");



        $boxContent = $_html->divTag('', $htmlContent ,'col-lg-12',"style='zoom:0.7' "); //zoom:1.2
        $tab->tabData('tab'.$tb_name,$tb_title,$boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle,$boxContentTab,$footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_hr->FnTbWidth($_PageName,'id','10%');
echo $_hr->FnTbWidth($_PageName,'cnamex','18%');
echo $_html->includeAll($_PageName);
?>