<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$_lib->checkSession();
$title = "แบบฟร์อมประเมินผลสัมภาษณ์ (HR)";
$_PageName = trim(str_replace('.php', '', basename($_SERVER['SCRIPT_NAME'])));
$_SESSION['M_FILE_NAME'] = $_PageName; // get menu name
//_p($_SESSION[SS_USER][id], $_REQUEST[m], 'vie');
$_PageTitle = "<a href=\"javascript:JLoadMain('{$_PageName}');\"><i class='fa fa-cogs  '></i></a> {$title} ";
$boxContent = '';
$footer = '';
$divBody = '';
$frmBody = '';
$tbTables = array("hr_interview" => $title);
$tab = new tabClass();
foreach ($tbTables as $k => $v) {
        $tabColTitle = array("cid" => "บัตรประชาชน", "cname" => "ชื่อ-สกุล", "ptype" => "ตำแหน่งที่สมัคร",
            "asdate" => "วันที่ประเมิน","asids"=>"ประเมินผลการสัมภาษณ์", "note" => "ความคิดเห็นเพิ่มเติม" , "notype"=>"สรุปผลการประเมิน"  );

        $tb_name = 'hr_interview';
        $tb_title = $v;

        /* mode Edit */
        if($_lib->isUser()) {
                $dbPerson = $_hr->DbPersonRegPositionInInterview('', $_SESSION['SS_USER']['pptype']);
        }else{
                $dbPerson = $_hr->DbPersonRegPositionInInterview('');
        }


        /*  get data  */
        $datadb = $dbmy->exec("

        select
               concat(y.pname,y.fname,' ',y.lname) as cname,
               rp.regp as rpname ,
               x.asdate,
               x.score,
               x.note,
               ''  as notype,
               concat(x.id,',',x.approved) as id
        from hr_interview as x , hr_person as y , hr_reg_position rp
        where x.cid = y.cid and rp.id = x.rpid

        "); // must be use last "id" alway
// and {$_SESSION['SS_USER']['id']} in (sname)
//vvArray($datadb);
        //  exit(0);

        $arCid = array();
        if ($dbPerson)
                foreach ($dbPerson as $k => $v)
                        $arCid[$v['cid']] = $v['cid'] . ": " . $v['cname'] . " [ " . $v['rpname'] . " ]";

        $pReq = '<span class="text-red">*</span>';
        $frm = $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
        $frm .= $_html->elementFormTag('textbox', 'id', 'id', '', '', 'hide', '');
        foreach ($tabColTitle as $k => $v) {
                if ($v != "" && $k != 'cname' && $k != 'ptype') {
                        switch ($k) {
                                case "cid":
                                        $frm .= $_html->elementFormTag('select', $k, $k, $v, $arCid, 'modal', " required ");
                                        break;
                                case "notype":
                                        $arPstype = getMYSQLValueAll('hr_notype', 'id,name');
                                        $arPstype = $_lib->arrayToSelect($arPstype, 1);
                                        $frm .= $_html->elementFormTag('select', $k, $k, $v, $arPstype, 'modal ', "  ");
                                        break;
                                case "asids":

                                        $frm .= "<p class='bb'> {$v} </p>";
                                        $arList = getMYSQLValueAll('hr_lst_asm','*',' asid =1 ');
                                        $wval = array();
                                        if($arList)
                                                foreach($arList as $lk=>$lv)
                                                        $wval[] = $lv['wval'];

                                        $wval = implode(',',$wval);
                                        if($arList)
                                                foreach($arList as $lk=>$lv){
                                                        $li = $lk+1;

                                                        for($i=0;$i<=3; $i++) {
                                                                if($i==0){
                                                                        $chk = "checked";
                                                                }else{
                                                                        $chk = '';
                                                                }
                                                                $c[$i] = ' <label style="cursor: pointer;">
                               <input type="radio"  name="pm' . $lv['id'] . '"  id="pm' . $lv['id'] . '"
                                      data-id="' . $lv['id'] . '"
                                      data-cate="' . $lv['asid'] . '"
                                      data-wval="' . $wval . '"
                                      data-option="ass"
                                      value="' . $i . '"
                                      class="minimal pmRadio-ass" id="pmRadio-ass"  '.$chk.'></label>   ';
                                                        }
                                                        $chkdata  .= "<tr>
                                  <td width='60%'>{$li}) <span class='bu'>{$lv['tname']}</span> {$lv['name']}</td>
                                  <td width='10%' align='center'>{$c[3]}</td>
                                  <td width='10%' align='center'>{$c[2]}</td>
                                  <td width='10%' align='center'>{$c[1]}</td>
                                  <td width='10%' align='center'>{$c[0]}</td>
                                </tr>";
                                                }
                                        $frm .= "<table class='table' style='zoom: 0.7;'>
                               <tr >
                                 <th width='60%'>รายการ</th>
                                 <th width='10%' align='center'>ดีมาก</th>
                                 <th width='10%' align='center'>ดี</th>
                                 <th width='10%' align='center'>พอใช้</th>
                                 <th width='10%' align='center'>ไม่ดี</th>
                               </tr>
                               {$chkdata}
                            </table>";
                                        break;
                                case "asdate":
                                        $frm .= $_html->elementFormTag('mask', $k, $k, $v,$_lib->getDateTH(TIMESTAMP,'/'), '', "data-inputmask='\"mask\": \"99/99/9999\"'  ");
                                        break;
                                case "note":
                                        $frm .= $_html->elementFormTag('textarea', $k, $k, $v, '', '', '');
                                        break;
                                default :
                                        $frm .= $_html->elementFormTag('textbox', $k, $k, $v, '', '', '');
                        }
                }
        }
        //----- End Form Edit
        echo $_hr->FnMyFromEdit('hr_'.$_PageName, $frm);


        /* REPORT  */
        $tabColTitle = array("cname" => "ชื่อ-สกุล", "ptype" => "ตำแหน่งที่สมัคร",
            "asdate" => "วันที", "score"=>"คะแนน", "notype" => "ความคิดเห็น", "note2" => "สรุป", "แบบประเมิน");

        $dbTable = array();
        if ($datadb)
                foreach ($datadb as $k => $v) {
                        $id = explode(',',$v['id']);
                        $app = $id[1]; $id = $id[0];

                        $dbDoAsm = $_hr->getDoAsm($id);
                        if($dbDoAsm){
                                $v['asdate'] = $dbDoAsm['asdate'];
                                $v['score'] =  $_hr->calcDoAsm($dbDoAsm['wvals'],$dbDoAsm['scores']);
                                $v['note'] = $dbDoAsm['note'];
                                $v['notype'] = $dbDoAsm['noname'];
                        }

                        if($_lib->isUser()){
                                if ($v['rpname'])
                                        $dbJobDetail = $_hr->DbJobDetail($v['rpname'],$_SESSION['SS_USER']['pptype']);
                        }else{
                                if ($v['rpname'])
                                        $dbJobDetail = $_hr->DbJobDetail($v['rpname']);
                        }
                        if (!$dbJobDetail) continue;
                        if ($_lib->isMaster() || $_lib->isAdmin()) {
                                if ($v['rpname']) {
                                        $v['rpname'] =  "<span>". $dbJobDetail['pptype'] . "/ " . $dbJobDetail['ptype'] ."</span>";
                                } else {
                                        continue;
                                }
                        } else {
                                if ($v['rpname']) {
                                        $v['rpname'] = $dbJobDetail['pptype'] . "/ " . $dbJobDetail['ptype'];
                                } else {
                                        continue;
                                }
                        }
                        $dbTable[] = $v;
                }

        if($_lib->isUser()){
                $htmlContent = $_hr->FnMyTable('hr_'.$_PageName, $tb_title, $tabColTitle, $dbTable,'ass');
        }else{
                $htmlContent = $_hr->FnMyTable('hr_'.$_PageName, $tb_title, $tabColTitle, $dbTable,'ass');
        }

        $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.7' "); //zoom:1.2
        $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_hr->FnTbWidth($_PageName,'id','10%');
echo $_hr->FnTbWidth($_PageName,'notype','10%');
echo $_hr->FnTbWidth($_PageName,'rpname','20%');
echo $_hr->FnTbWidth($_PageName,'cname','15%');


echo $_html->includeAll($_PageName);

//vvArray($_hr->DbPersonRegPosition('2'));

?>