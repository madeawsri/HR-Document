<?php
/**
 * Created by boonyadol on 20/03/2017 09:35.
 **/
ini_set("memory_limit", "700M");
set_time_limit(0);
include "../../conn.php";

$arr = array();
$arr['ERR'] = "";
$arr['SEND'] = $_REQUEST;
$arr['SQL'] = '';
$arr['DATA'] = '';
$arr['CONTENT'] = '';
$arr['REPORT'] = '';
$arr['MSG'] = '';
$arr['KEY_WHERE'] = "{$_REQUEST['keyid']} = '{$_REQUEST[$_REQUEST['keyid']]}'  ";

switch ($_REQUEST['mode']) {
    case "del" . $_REQUEST['tbname']:
        $tbname = $_REQUEST['tbname'];
        $arr['SQL'] = $dbmy->del($tbname,$arr['KEY_WHERE']);
        break;
    case "get":
      /*  $arr['DATA'] = getMYSQLValues(

            $_REQUEST['tbname'], "id,rpid, cid ,ddate, ssite, sname, rtype, note,sotype,score,
                          '{$_REQUEST['tbname']}' as  'tbname'",
            $arr['KEY_WHERE']);
            */

        /*  get data  */
        $datadb = $dbmy->exec("

        select
               concat(y.pname,y.fname,' ',y.lname) as cname,
               rp.regp as rpname ,
               x.asdate,
               x.sname,
               x.score,
               x.note,
               x.id,
               x.notype,
               x.cid,'' as wvals , '' as scores , x.approved
        from hr_interview as x , hr_person as y , hr_reg_position rp
        where x.cid = y.cid and rp.id = x.rpid and x.id = {$_REQUEST['id']}

        "); // must be use last "id" alway

        $dbTable = array();
        if ($datadb)
            foreach ($datadb as $k => $v) {

                $dbDoAsm = $_hr->getDoAsm($v['id']);
                if($dbDoAsm){
                    $v['asdate'] = $dbDoAsm['asdate'];
                    $v['score'] =  $_hr->calcDoAsm($dbDoAsm['wvals'],$dbDoAsm['scores']);
                    $v['note'] = $dbDoAsm['note'];
                    $v['scores'] = explode(',',$dbDoAsm['scores']);
                    $v['wvals'] =  explode(',',$dbDoAsm['wvals']);
                    $v['notype'] = $dbDoAsm['notype'];
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

         $arr['DATA'] = $dbTable[0];

        break;
    case "add" . $_REQUEST['tbname']:
        $arr['DATA'] = "add" . $_REQUEST['tbname'];
        $fields = $_REQUEST['dbfields'];
        $fields = explode(",", $fields);
        $insData = array();
        foreach ($fields as $v) {
            $insData[$v] = $_REQUEST[$v];
        }
        if (array_key_exists("cid",$insData))
            $insData['cid'] = str_replace('-', '', $insData['cid']);

        $insData['kslid'] = SITE_NAME;

        /* X CASE */
        $rpdata = $_hr->DbPersonRegPositionNotInterview($insData['cid']);
        $insData['rpid'] = $_REQUEST['cid']; // case add sent to rpid replace to cid
        $insData['cid'] = $rpdata[0]['cid'];


        $arr['SQL'] = $dbmy->add_db($_REQUEST['tbname'], $insData);
        break;

    case "edit" . $_REQUEST['tbname']:
        $tbname = $_REQUEST['tbname'];
        $fields = $_REQUEST['dbfields'];
        $fields = explode(",", $fields);
        $rds = explode(',',$_REQUEST['dbradios']);
        $insData = array();
        if($fields)
        foreach ($fields as $k=>$v) {
            if($v == 'cid') continue;
            $insData[$v] = $_REQUEST[$v];
        }
        $lasids = array(); $scores = array();
        $wvals = $_REQUEST['wval'];
        $wvals = explode(',',$wvals);
        if($rds)
        foreach ($rds as $k=>$v) {
            $scores[] = $_REQUEST[$v];
            $lasids[] = $k+1;
        }
        $lasids = implode(',',$lasids);
        $insData['score'] = array_sum($scores);
        $scores = implode(',',$scores);
        $insData['lasids'] = $lasids;
        $insData['scores'] = $scores;
        $insData['kslid'] = SITE_NAME;
        $insData['sid'] = $_SESSION['SS_USER']['id'];
        $insData['sname'] = $_SESSION['SS_USER_INFO']['name'];
        $insData['interview_id'] = $_REQUEST['id'];
        $insData['asid'] = $_REQUEST['asid'];
        $insData['wval'] = array_sum($wvals);
        $insData['wvals'] = $_REQUEST['wval'];
        /* X CASE */
        $dbDoAsm = getMYSQLValues('hr_do_asm','*',
            " interview_id = {$_REQUEST['id']} and sid = {$_SESSION['SS_USER']['id']}  ");
        if($dbDoAsm){
            $arr['SQL'] = $dbmy->update_db('hr_do_asm', $insData,
                " interview_id = {$_REQUEST['id']} and sid = {$_SESSION['SS_USER']['id']}  " );
        }else{
            $arr['SQL'] = $dbmy->add_db('hr_do_asm',$insData);
        }

        $arr['DATA'] = "OK";



        break;
}

$_html->boxTag('สรุปรายงาน', $arr['REPORT'], '', __boxStyle::Success);
$arr['REPORT'] = $_html->divTag('', $_html->boxRender(), '', ''); //style="zoom:0.8"
echo json_encode($arr);

?>