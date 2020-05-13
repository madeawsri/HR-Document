<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "ข้อมูลการศึกษา";
$_PageName = trim(str_replace('.php','',basename($_SERVER['SCRIPT_NAME'])));
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_SESSION['M_FILE_NAME'] = $_PageName;
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";

$boxContent=''; $footer = ''; $divBody = ''; $frmBody = '';
$tbTables = array("hr_".$_PageName=>$title);
$tab = new tabClass();
foreach($tbTables as $k=>$v){
        $tabColTitle = array("cid"=>"บัตรประชาชน","cname"=>"ชื่อ-สกุล","cer"=>"วุฒิการศึกษา","skk"=>"สาขาวิชา",
            "suc"=>"ปีการศึกษา", "gra"=>"เกรด","edu"=>"สถานศึกษา","");
        $tb_name = $k;
        $tb_title = $v;

        $dbPerson = getMYSQLValueAll('hr_person',"cid, concat(pname,fname,' ',lname) as cname ",
             " kslid = '{$_REQUEST['site']}' and cid  not in (select x.cid from hr_education as x  ) ORDER BY id desc " ); // must be use last "id" alway

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
          if($v != "" && $k != 'cname'){
            switch($k){
                    case "cid":
                            $frm .=  $_html->elementFormTag('select',$k,$k,' เลขบัตรประชาชน',$arCid,'modal'," required ");
                            break;
                    case "cer":
                    $arPstype = getMYSQLValueAll('hr_etype','id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype);
                    $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal'," required ");
                    break;

                case "skk":
                    $arPstype = getMYSQLValueAll('hr_vtype','id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype);
                    $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal',"  ");
                    break;
                case "edu":
                    $arPstype = getMYSQLValueAll('hr_eutype','id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype);
                    $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal',"  ");
                    break;
                case "suc":
                    $frm .=  $_html->elementFormTag('mask',$k,$k,$v,'','',"data-inputmask='\"mask\": \"9999\"'  ");
                    break;
                case "gra":
                    $frm .=  $_html->elementFormTag('mask',$k,$k,$v,'','',"data-inputmask='\"mask\": \"9.99\"'  "); break;
                default :
                            $frm .=  $_html->elementFormTag('textbox',$k,$k,$v,'','','') ;
            }
          }
        }
        //----- End Form

        echo $_hr->FnMyFromAdd($tb_name,$frm);

    $dbPerson = getMYSQLValueAll('hr_person',"cid, concat(pname,fname,' ',lname) as cname ",
        " kslid = '{$_REQUEST['site']}' and cid   in (select x.cid from hr_education as x  ) ORDER BY id desc " ); // must be use last "id" alway

    $arCid = array();
    foreach($dbPerson as $k=>$v){
        $arCid[$v['cid']] = $v['cid']." - ".$v['cname'];
    }

    //-----
    $pReq = '<span class="text-red">*</span>';
    $frm =  $_html->elementFormTag('textbox','tbname','tbname','',$tb_name,'hide','') ;
    $frm .=  $_html->elementFormTag('textbox','id','id','','','hide','') ;
    foreach($tabColTitle as $k=>$v){
        if($v != "" && $k != 'cname'){
            switch($k){
                case "cid":
                    $frm .=  $_html->elementFormTag('select',$k,$k,' เลขบัตรประชาชน',$arCid,'modal'," required ");
                    break;
                case "cer":
                    $arPstype = getMYSQLValueAll('hr_etype','id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype);
                    $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal'," required ");
                    break;

                case "skk":
                    $arPstype = getMYSQLValueAll('hr_vtype','id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype);
                    $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal',"  ");
                    break;
                case "edu":
                    $arPstype = getMYSQLValueAll('hr_eutype','id,name');
                    $arPstype = $_lib->arrayToSelect($arPstype);
                    $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal',"  ");
                    break;
                case "suc":
                    $frm .=  $_html->elementFormTag('mask',$k,$k,$v,'','',"data-inputmask='\"mask\": \"9999\"'  ");
                    break;
                case "gra":
                    $frm .=  $_html->elementFormTag('mask',$k,$k,$v,'','',"data-inputmask='\"mask\": \"9.99\"'  "); break;
                default :
                    $frm .=  $_html->elementFormTag('textbox',$k,$k,$v,'','','') ;
            }
        }
    }
    //----- End Form
        echo $_hr->FnMyFromEdit($tb_name,$frm);

        $datadb = getMYSQLValueAll("{$tb_name} as x , hr_person as y ",
            "x.cid , concat(y.pname,y.fname,' ',y.lname) as cname,
            ( select name from hr_etype et where et.id = x.cer  ) as cer,
            ( select name from hr_vtype et where et.id = x.skk  ) as skk,
            x.suc, x.gra,
            ( select name from hr_eutype et where et.id = x.edu  ) as edu,
            x.id" ,
            " x.cid = y.cid  order by id desc "); // must be use last "id" alway
        $htmlContent = $_hr->FnMyTable($tb_name,$tb_title,$tabColTitle,$datadb,"add,edit,pdf,del");
        $boxContent = $_html->divTag('', $htmlContent ,'col-lg-12',"style='zoom:0.6' "); //zoom:1.2
        $tab->tabData('tab'.$tb_name,$tb_title,$boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle,$boxContentTab,$footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_hr->FnTbWidth($_PageName,'id','10%');
echo $_html->includeAll($_PageName);
?>