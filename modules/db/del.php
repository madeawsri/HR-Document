<?
include "../../conn.php";
$m = $_REQUEST[m];
switch (trim($m)) {
    case "del-mGroup": // group menu
        $dbmy->del("mgroup", "id=" . $_POST[gid]);
        $dbmy->del("menu", "gid=" . $_POST[gid]);
        break;
    case "del-sGroup": // menu
        $dbmy->del("menu", "id=" . $_POST[gid]);
        @unlink("../../modules/db/{$_REQUEST['fname']}.php");
        @unlink("../../modules/index/{$_REQUEST['fname']}.php");
        @unlink("../../modules/js/{$_REQUEST['fname']}.js");
        break;
    case "del-MLList": // menu
        $dbmy->del("tbml", "mlid=" . $_POST[gid]);
        break;
}
?>