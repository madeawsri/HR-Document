<?
@session_start();
@date_default_timezone_set("Asia/Bangkok");
require_once('condb/mssql.inc.php');
require_once("condb/class.mysql.php");
require "libs/initClass.php";
require "libs/htmlClass.php";
require "libs/libClass.php";
require "libs/hrClass.php";
global $kks;
global $kks_name;
global $kks_code;
global $m_fyear;
global $_html,$_hr,$_lib;
global $dbmy,$db;
$_html = new htmlClass();
$_lib = new libClass();
$_hr = new hrClass();
define("PROJECT_NAME",'Recruitment Online System');
define("SITE_CONFIG", "hrksl");

$dbn = 'db_' . SITE_CONFIG;
define("TIMESTAMP", time());
define('_br', "<br>");
/* New Connection to DataBase MYSQL */
define("MY_HOST", "localhost"); // ชื่อ host
define("MY_DBNAME", 'db_hrksl'); //ชื่อฐานข้อมูล
define("MS_DBNAME", strtoupper( MY_DBNAME)); //ชื่อฐานข้อมูล
define("MY_USERNAME", "root"); // ขิ้อ user ติดต่อฐานข้อมูล
define("MY_PASSWORD", "kslitc123"); // รหัสผ่านติดต่อฐานข้อมูล



global $mEduTypes,$mStatusAppJob,$mSendAppJob;
$mEduTypes = array(1=>"ประถม",2=>"มัธยม",3=>"ปวส.",4=>"ปริญญา");
$mStatusAppJob = array("<span class='text-color-red bb'>ยังไม่ได้ลงประกาศ </span>","<span class='text-color-green bb'>ลงประกาศแล้ว</span>");
$mSendAppJob = array("<span class='text-color-red bb'>ยังไม่ได้ส่งเอกสาร </span>","<span class='text-color-green bb'>ส่งเอกสารแล้ว</span>");

$dbmy = New DBMY(); // OPTIMIZE TABLE  `web_news`
$db = $dbmy;
include "function.in.php";
$site = strtolower(trim($_REQUEST[site]));
$dbs = getMYSQLValues("setting", "*", "site = '{$site}' ");
if ($dbs) {
    define("SITE_NAME", $site);
    $sre = "http://" . $_SERVER['SERVER_NAME'] . "/" . SITE_CONFIG . "/" . SITE_NAME;
    define('IMAGE_CAR_PATH', $dbs['imgcarpath']);
    define('HR_ADMIN',$dbs['hradmin']);
    define("SERVER_NAME", $sre);
    define('SERVER_FID', $dbs[fid]);
    $m_fyear = $dbs[fyear];
    $site_name = $dbs['sname'];
    $site_start = $dbs['startdate'];
    $site_end = $dbs['enddate'];
    $kks_name = "บริษัทน้ำตาลขอนแก่น จำกัด(มหาชน)";
    $myServer = $dbs[server];
    $myUser = $dbs[user];
    $myPass = $dbs[pass];
    $myDB = $dbs[db];
    $kks = "สาขา " . $dbs[kks];
    $kks_code = $dbs[code];
    $kks_addr = $dbs[addr];
} else {
    print " <meta charset=\"utf-8\">";
    print "<center><h1><b>ท่านสิทธิเข้าใช้งาน ระบบ <?=PROJECT_NAME?>  <br>
  ติดต่อเจ้าหน้าที่ ITC (โรงงานน้ำตาลขอนแก่น สาขาน้ำพอง)<br><a href='mailto:boonyadol@kslgroup.com'>  คลิกที่นี่</a></b></h1></center>";
    exit(0);
}
?>