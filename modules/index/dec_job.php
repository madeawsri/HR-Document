<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$title = "บันทึกข้อมูลสมัครงาน";
$_PageName = trim(str_replace('.php','',basename($_SERVER['SCRIPT_NAME'])));
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_SESSION['M_FILE_NAME'] = $_PageName;
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";

$boxContent=''; $footer = ''; $divBody = ''; $frmBody = '';
$tbTables = array("hr_".$_PageName=>$title);
$tab = new tabClass();
foreach($tbTables as $k=>$v){
        $tabColTitle = array("pptype"=>"แผนก","ptype"=>"ตำแหน่ง","agtype"=>"อายุ",
            "sxtype"=>"เพศ" , "etypes"=>"วุฒิการศึกษา" , "vtypes"=>"สาขาวิชา" ,"attb"=>"คุณสัมบัติ","satype"=>"อัตราเงินเดือน","");
        $tb_name = $k;
        $tb_title = $v;

        /* mode Add */
        $dbPerson = $_hr->DbPersonRegPositionNotInterview();
        $arCid = array();
        foreach($dbPerson as $k=>$v)
                $arCid[$v['rpid']] = $v['cid'].": ".$v['cname']." [ ".$v['rpname']." ]";
        $pReq = '<span class="text-red">*</span>';
        $frm =  $_html->elementFormTag('textbox','tbname','tbname','',$tb_name,'hide','') ;
        $frm .=  $_html->elementFormTag('textbox','id','id','','','hide','') ;
        foreach($tabColTitle as $k=>$v){
                if($v != "" && $k != 'cname' ){
                        switch($k){
                                case "pptype": case "ptype": case "sxtype": case "agtype": case "satype":
                                $arPstype = getMYSQLValueAll('hr_'.$k,'id,name');
                                $arPstype = $_lib->arrayToSelect($arPstype);
                                $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal',"  ");
                                break;
                                case "etypes": case "vtypes":
                                $arPstype = getMYSQLValueAll('hr_'.rtrim($k,'s'),'id,name');
                                $arPstype = $_lib->arrayToSelect($arPstype,1);
                                $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal'," multiple ");
                                break;
                                case "din": case "dexp":
                                $frm .=  $_html->elementFormTag('mask',$k,$k,$v,'','',"data-inputmask='\"mask\": \"99/99/9999\"'  ");
                                break;
                                case "attb":
                                        $frm .=  $_html->elementFormTag('textarea',$k,$k,$v,'','','') ; break;
                                default :
                                        $frm .=  $_html->elementFormTag('textbox',$k,$k,$v,'','','') ;

                        }
                }
        }
        //----- End Form Add
        echo $_hr->FnMyFromAdd($tb_name,$frm);
        /* mode Edit */
        $dbPerson = $_hr->DbPersonRegPositionInInterview();
        $arCid = array();
        if($dbPerson)
                foreach($dbPerson as $k=>$v)
                        $arCid[$v['rpid']] = $v['cid'].": ".$v['cname']." [ ".$v['rpname']." ]";
        $pReq = '<span class="text-red">*</span>';
        $frm =  $_html->elementFormTag('textbox','tbname','tbname','',$tb_name,'hide','') ;
        $frm .=  $_html->elementFormTag('textbox','id','id','','','hide','') ;
        foreach($tabColTitle as $k=>$v){
                if($v != "" && $k != 'cname' ){
                        switch($k){
                                case "pptype": case "ptype": case "sxtype": case "agtype": case "satype":
                                $arPstype = getMYSQLValueAll('hr_'.$k,'id,name');
                                $arPstype = $_lib->arrayToSelect($arPstype);
                                $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal',"  ");
                                break;
                                case "etypes": case "vtypes":
                                $arPstype = getMYSQLValueAll('hr_'.rtrim($k,'s'),'id,name');
                                $arPstype = $_lib->arrayToSelect($arPstype,1);
                                $frm .=  $_html->elementFormTag('select',$k,$k,$v,$arPstype,'modal'," multiple ");
                                break;
                                case "din": case "dexp":
                                $frm .=  $_html->elementFormTag('mask',$k,$k,$v,'','',"data-inputmask='\"mask\": \"99/99/9999\"'  ");
                                break;
                                case "attb":
                                        $frm .=  $_html->elementFormTag('textarea',$k,$k,$v,'','','') ; break;
                                default :
                                        $frm .=  $_html->elementFormTag('textbox',$k,$k,$v,'','','') ;

                        }
                }
        }
        //----- End Form Edit
        echo $_hr->FnMyFromEdit($tb_name,$frm);

        $tabColTitle = array("แผนก","ตำแหน่ง","อายุ","เพศ","วุฒิการศึกษา/ สาขาวิชา","คุณสัมบัติ","อัตราเงินเดือน","");

        if($_lib->isUser()){
                $datadb = $dbmy->exec("
        select (select pp.name from hr_pptype as pp where pp.id = pptype) as pptype,
               (select pp.name from hr_ptype as pp where pp.id =  ptype) as ptype,
               (select pp.name from hr_agtype as pp where pp.id = agtype) as agtype,
               (select pp.name from hr_sxtype as pp where pp.id = sxtype) as sxtype,
               concat(etypes,'|',vtypes) as ev,
               attb,
               (select pp.name from hr_satype as pp where pp.id = satype) as satype,
               id
        from hr_dec_job
        where kslid = '".SITE_NAME."' and pptype = {$_SESSION['SS_USER']['pptype']} order by id desc
        "); // must be use last "id" alway
        }else{
                $datadb = $dbmy->exec("
        select (select pp.name from hr_pptype as pp where pp.id = pptype) as pptype,
               (select pp.name from hr_ptype as pp where pp.id =  ptype) as ptype,
               (select pp.name from hr_agtype as pp where pp.id = agtype) as agtype,
               (select pp.name from hr_sxtype as pp where pp.id = sxtype) as sxtype,
               concat(etypes,'|',vtypes) as ev,
               attb,
               (select pp.name from hr_satype as pp where pp.id = satype) as satype,
               id
        from hr_dec_job
        where kslid = '".SITE_NAME."' order by id desc
        "); // must be use last "id" alway
        }



        $dbTable = array();
        if($datadb)
        foreach($datadb as $k=>$v){
                $str = $v['ev'];
                $str = explode('|', $str);

                if($str[0]) {
                        $ex = getMYSQLValueAll('hr_etype', 'name', 'id in (' . $str[0] . ') ');
                        $exx = array();
                        foreach ($ex as $ke => $ve) $exx[] = $ve['name'];
                        $ex = implode(', ', $exx);
                }
                if($str[1]) {
                        $ev = getMYSQLValueAll('hr_vtype', 'name', 'id in (' . $str[1] . ') ');
                        $exv = array();
                        foreach ($ev as $ke => $ve) $exv[] = $ve['name'];
                        $ev = implode(', ', $exv);
                }

                $v['ev'] = "" . $ex . '<br>' . $ev . "";
                //$v['attb'] = "<div class='content-block' >{$v['attb']}</div>";
                $dbTable[] = $v;
        }

        $htmlContent = $_hr->FnMyTable($tb_name,$tb_title,$tabColTitle,$dbTable);
        $boxContent = $_html->divTag('', $htmlContent ,'col-lg-12',"style='zoom:0.7' "); //zoom:1.2
        $tab->tabData('tab'.$tb_name,$tb_title,$boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle,$boxContentTab,$footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');

echo $_hr->FnTbWidth($_PageName,'attb','30%');
echo $_hr->FnTbWidth($_PageName,'pptype','10%');
echo $_hr->FnTbWidth($_PageName,'ptype','10%');
echo $_hr->FnTbWidth($_PageName,'satype','10%');
echo $_hr->FnTbWidth($_PageName,'sxtype','3%');
echo $_hr->FnTbWidth($_PageName,'agtype','6%');
echo $_hr->FnTbWidth($_PageName,'ev','15%');
echo $_hr->FnTbWidth($_PageName,'id','5%');

//echo $_lib->JRender(" jWidth('tbhr_dec_jobattb1','350'); "); // กำหนดความกว้างของคอลัม
echo $_html->includeAll($_PageName);

//vvArray($_hr->DbPersonRegPosition('2'));

?>