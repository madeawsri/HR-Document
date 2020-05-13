<?
include "../../conn.php";
/*
vvArray($_SESSION['SS_USER']);
vvArray($_SESSION[SS_USER]['pmtype']);
echo $_SESSION['M_FILE_NAME'];
echo $_SESSION['SS_USER']['pmtype'];
*/
if ($_lib->isMaster()) {
    echo $_html->boxMenu("จัดการเมนูใหม่","javascript:JLoadMain('menu');","ion-ios-list-outline");
    echo $_html->boxMenu("กำหนดข้อมูลพื้นฐาน","javascript:JLoadMain('setting');","ion-settings");
    echo $_html->boxMenu("กำหนดสิทธ์ผู้ใช้งาน","javascript:JLoadMain('permision_hr');","ion-settings");
    echo $_html->boxMenu("กำหนดสิทธ์การเข้าถึงเมนู","javascript:JLoadMain('menu_permis');","ion-settings");
}else if($_lib->isAdmin()){
    echo $_html->boxMenu("กำหนดข้อมูลพื้นฐาน","javascript:JLoadMain('setting');","ion-settings");
    echo $_html->boxMenu("กำหนดสิทธ์ผู้ใช้งาน","javascript:JLoadMain('permision_hr');","ion-settings");
    echo $_html->boxMenu("กำหนดสิทธ์การเข้าถึงเมนู","javascript:JLoadMain('menu_permis');","ion-settings");

}
?>

