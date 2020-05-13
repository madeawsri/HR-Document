<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
include "../../conn.php";
include "../../libs/tabClass.php";
include "../../libs/tableClass.php";
$_lib->checkSession();
$title = "สรุปผลการประเมินผลสัมภาษณ์";
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
        "asdate" => "วันที่ประเมิน", "asids" => "ประเมินผลการสัมภาษณ์", "note" => "ความคิดเห็นเพิ่มเติม", "notype" => "สรุปผลการประเมิน");

    $tb_name = 'hr_interview';
    $tb_title = $v;

    /* mode Edit */
    if ($_lib->isUser()) {
        $dbPerson = $_hr->DbPersonRegPositionInInterview('', $_SESSION['SS_USER']['pptype']);
    } else {
        $dbPerson = $_hr->DbPersonRegPositionInInterview('');
    }


    if($_lib->isUser()){
        /*  get data  */
        $datadb = $dbmy->exec("
        select
               concat(y.pname,y.fname,' ',y.lname) as cname,
               rp.regp as rpname ,
               x.sname,
               concat(x.id,',',x.approved) as id
        from hr_interview as x , hr_person as y , hr_reg_position rp
        where x.cid = y.cid and rp.id = x.rpid and {$_SESSION['SS_USER']['id']} in (x.sname)
        order by x.id desc

        "); // must be use last "id" alway

    }else{
        /*  get data  */
        $datadb = $dbmy->exec("
        select
               concat(y.pname,y.fname,' ',y.lname) as cname,
               rp.regp as rpname ,
               x.sname,
               concat(x.id,',',x.approved) as id
        from hr_interview as x , hr_person as y , hr_reg_position  as rp , hr_do_asm as d
        where x.cid = y.cid and rp.id = x.rpid and x.id = d.interview_id
        order by x.id desc

        "); // must be use last "id" alway

    }

    //vvArray($datadb);

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
                    $arList = getMYSQLValueAll('hr_lst_asm', '*', ' asid =1 ');
                    $wval = array();
                    if ($arList)
                        foreach ($arList as $lk => $lv)
                            $wval[] = $lv['wval'];

                    $wval = implode(',', $wval);
                    if ($arList)
                        foreach ($arList as $lk => $lv) {
                            $li = $lk + 1;

                            for ($i = 0; $i <= 3; $i++) {
                                if ($i == 0) {
                                    $chk = "checked";
                                } else {
                                    $chk = '';
                                }
                                $c[$i] = ' <label style="cursor: pointer;">
                               <input type="radio"  name="pm' . $lv['id'] . '"  id="pm' . $lv['id'] . '"
                                      data-id="' . $lv['id'] . '"
                                      data-cate="' . $lv['asid'] . '"
                                      data-wval="' . $wval . '"
                                      data-option="ass"
                                      value="' . $i . '"
                                      class="minimal pmRadio-ass" id="pmRadio-ass"  ' . $chk . '></label>   ';
                            }
                            $chkdata .= "<tr>
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
                    $frm .= $_html->elementFormTag('mask', $k, $k, $v, $_lib->getDateTH(TIMESTAMP, '/'), '', "data-inputmask='\"mask\": \"99/99/9999\"'  ");
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
    echo $_hr->FnMyFromEdit($tb_name, $frm);


    /* REPORT  */
    $tabColTitle = array("cname" => "ชื่อ-สกุล", "ptype" => "ตำแหน่งที่สมัคร", "sname" => " ผลสรุปสัมภาษณ์ "
    , "แบบประเมิน");


//vvArray($datadb);
    $dbTable = array();
    if ($datadb)
        foreach ($datadb as $k => $v) {
            $flgApp = 0;
            $xx = "";
            $id = explode(',',$v['id']);
            $app = $id[1]; $id = $id[0];
            //if($id[1] != 1) continue;
            $dbDoAsm = $_hr->getDoAsms($id, $v['sname']);
           // vvArray($dbDoAsm);
           // exit;
            $hr_instead = 0;
            if($dbDoAsm)
                foreach($dbDoAsm as $ak=>$av) {
                    $vx = array();
                    if ($av) {
                        $vx['asdate'] = $av['asdate'];
                        $vx['score'] = $_hr->calcDoAsm($av['wvals'], $av['scores']);
                        $vx['note'] = $av['note'];
                        $vx['notype'] = $av['noname'];
                        $vx['sname'] = $av['cname'];
                        $xx .= "
                                 <p><span class='bb'>ผู้สัมภาษณ์</span> :  {$vx['sname']}
                                   <span class='bb'>วันที่</span> : {$vx['asdate']}
                                   <span class='bb'>คะแนน</span> : {$vx['score']}%</p>
                                 <p><span class='bb'>ความคิดเห็น</span> : {$vx['note']}</p>
                                 <p><span class='bb'>สรุปผล</span> : {$vx['notype']}</p><hr>
                                ";
                        $hr_instead = $av['instead'];
                        $flgApp = 1;
                    }else{ $flgApp = 0;  /*$xx .= "-- ยังไม่ดำเนินการประเมินผลสัมภาษณ์ -- <hr>";*/ }
                }
            if($hr_instead){
                $flgApp = 1;
            }

            $v['sname'] = $xx;

            if ($_lib->isUser()) {
                if ($v['rpname'])
                    $dbJobDetail = $_hr->DbJobDetail($v['rpname'], $_SESSION['SS_USER']['pptype']);
            } else {
                if ($v['rpname'])
                    $dbJobDetail = $_hr->DbJobDetail($v['rpname']);
            }
            if (!$dbJobDetail) continue;
            if ($_lib->isMaster() || $_lib->isAdmin()) {
                if ($v['rpname']) {
                    $v['rpname'] = "<span>" . $dbJobDetail['pptype'] . "/ " . $dbJobDetail['ptype'] . "</span>";
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

            $c1 = 'checked';  $c2 = '';
            if(!$app){
                $c2 = 'checked';   $c1 = '';
            }
            if($flgApp){
            if(!$_lib->isUser()) {
                $v['id'] = ' <label class="bb text-color-red" style="cursor: pointer;"><input type="radio" name="pm' . $id . '"
                            data-id="' . $id . '" data-option="open"  class="minimal2  " value="1"
                           ' . $c1 . ' > ปิดประเมินผล </label>   ';
                $v['id'] .= ' <label class="bb text-color-green" style="cursor: pointer;"><input type="radio" name="pm' . $id . '"
                            data-id="' . $id . '" data-option="open"  class="minimal2 " value="0"
                           ' . $c2 . ' > เปิดประเมินผล </label>   ';
            }}
            else $v['id'] = "<span class='text-color-orange bb'> ยังประเมิณไม่ครบ </span>";

            $dbTable[] = $v;
        }




    if ($_lib->isUser()) {
        $htmlContent = $_hr->FnPermisTable('hr_' . $_PageName, $tb_title, $tabColTitle, $dbTable);
    } else {
        $htmlContent = $_hr->FnPermisTable('hr_' . $_PageName, $tb_title, $tabColTitle, $dbTable );
    }


    $boxContent = $_html->divTag('', $htmlContent, 'col-lg-12', "style='zoom:0.7' "); //zoom:1.2
    $tab->tabData('tab' . $tb_name, $tb_title, $boxContent);
}
$boxContentTab = $tab->render();
$_html->boxTag($_PageTitle, $boxContentTab, $footer);
echo $_html->boxRender();
echo $_html->divTag('rpShow');
echo $_hr->FnTbWidth($_PageName, 'id', '10%');
echo $_hr->FnTbWidth($_PageName, 'notype', '10%');
echo $_hr->FnTbWidth($_PageName, 'rpname', '15%');
echo $_hr->FnTbWidth($_PageName, 'cname', '15%');
echo $_hr->FnTbWidth($_PageName, 'sname', '50%');


echo $_html->includeAll($_PageName);

//vvArray($_hr->DbPersonRegPosition('2'));

?>