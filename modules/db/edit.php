<?
include "../../conn.php";
$m = $_REQUEST[m];
switch (trim($m)) {
    case "edit-mGroup": // group menu
        $name = $_POST[name];
        $dbmy->update_db("mgroup", array("name" => $name), "id=" . $_POST[gid]);
        break;
    case "edit-sGroup": // menu
        $name = $_POST[name];
        $fname = $_POST[fname];
        $dbmy->update_db("menu", array("name" => $name, "fname" => $fname), "id=" . $_POST[gid]);
        break;
    case "edit-mlapporved":
        // print "";
        $dbmy->update_db("tbml", array("mlapproved" => 1,
            "mltimesc" => TIMESTAMP,
            "mltimech" => date('d-m-Y H:s', TIMESTAMP)), "mlid=" . $_POST[gid]);
        break;
}
?>