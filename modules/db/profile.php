<?php
/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 11/4/2560
 * Time: 9:28
 */
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

$data = getMYSQLValue('hr_person','count(*)',"cid = '{$_REQUEST['cid']}' " );
$arr['DATA']  = (int)$data;
echo json_encode($arr);