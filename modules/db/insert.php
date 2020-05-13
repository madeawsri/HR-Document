<?
include "../../conn.php";
$m = $_REQUEST[m];
switch (trim($m)) {
    case "ins-mGroup": // group menu
        $dbmy->add_db("mgroup", array("name" => $_POST[name]));
        break;
    case "add-sGroup": // menu
        $dbmy->add_db("menu", array("name" => $_POST[name], "fname" => $_POST[fname], "gid" => $_POST[gid]));
        $pagename = "{$_POST[fname]}";
        $newFileName = '../../modules/db/' . $pagename . ".php";
        $newFileContent = '<?php
        /**
           * Created by boonyadol on '.date("d/m/Y H:i").'.
         **/
         ini_set("memory_limit","700M");
         set_time_limit(0);
         include "../../conn.php";

         $arr = array();
         $arr[\'ERR\']= "";
         $arr[\'SEND\']= $_REQUEST;
         $arr[\'SQL\'] = \'\';
         $arr[\'DATA\'] = \'\';
         $arr[\'CONTENT\'] = \'\';
         $arr[\'REPORT\'] = \'\';
         $arr[\'MSG\'] = \'\';

         switch($_REQUEST[\'mode\']) {
            case "": break;
         }

        $_html->boxTag(\'สรุปรายงาน\',$arr[\'REPORT\'], \'\', __boxStyle::Success);
        $arr[\'REPORT\'] = $_html->divTag(\'\', $_html->boxRender(), \'\', \'\'); //style="zoom:0.8"
        echo json_encode($arr);

        ?>';
        @file_put_contents($newFileName, $newFileContent);

        $newFileName = '../../modules/index/' . $pagename . ".php";
        $newFileContent = '<?php
        /**
           * Created by boonyadol on '.date("d/m/Y H:i").'.
         */
        include "../../conn.php";
        $title = "'.$_POST[name].'";
        $_PageName = trim(str_replace(\'.php\',\'\',basename($_SERVER[\'SCRIPT_NAME\'])));
        _p($_SESSION[SS_USER][id], $_REQUEST[m], \'vie\');
        $boxContent=\'\'; $footer = \'\'; $divBody = \'\'; $frmBody = \'\';


        $frmBody .= $_html->divTag(\'\', $_html->elementFormTag(\'submit\',\'btnSubmit\',\'btnSubmit\',\'ออกรายงาน\',\'ออกรายงาน\',\'btn btn-primary\',\'\') , \'col-lg-3\');
        $divBody .= $_html->divTag(\'\',$frmBody,\'row\');

        $btnReset = $_html->divTag(\'\',$_html->elementFormTag(\'reset\',\'btnReset\',\'btnReset\',\'\',\'ยกเลิก\',\'btn btn-danger hide\'),\'col-lg-3\');
        $divBody .= $_html->divTag(\'\',$btnReset,\'row\');

        $_html->formTag(\'frmRp\',$divBody);
        $boxContent = $_html->divTag(\'\', $_html->formRender() , \'col-lg-9\',"style=\'\' "); //zoom:1.2
        $_html->labelText = \'<i class="fa fa-tv"></i> ตั้งค่าปีฤดูหีบ <input type="text"  id="m_fyear" class="bg-hide b bg-black" size="3" value="\'.$m_fyear.\'" />\';
        $_html->boxTag($title,$boxContent,$footer);
        echo $_html->boxRender();
        echo $_html->divTag(\'rpShow\');

        echo $_html->includeAll($_PageName);

        ?>';
        @file_put_contents($newFileName, $newFileContent);

        $newFileName = '../../modules/js/' . $pagename . ".js";
        $newFileContent = '
         /**
           * Created by boonyadol on '.date("d/m/Y H:i").'.
         */
         var jPath = jServerName+"/../modules/db/"+jFileName+".php?site="+jSite;
         //var jPdfExport = jServerName+"/../modules/export/pdf/"+jFileName+".php?site="+jSite;
         //var jXlsExport = jServerName+"/../modules/export/xls/"+jFileName+".php?site="+jSite;
         ';
        @file_put_contents($newFileName, $newFileContent);

        break;
    case "add-login": //
        $u = trim($_POST[user]);
        $p = trim($_POST[pass]);
        $chkLogin = FnADLogin($u, $p);

        $dsLoginX = getMYSQLValues("tblogin x , tbinfo y", "x.*,y.pptype,y.pmtype,y.ptype ", "x.user = '{$u}' and x.id = y.loginid ");
        if($dsLoginX){
            $_SESSION["SS_USER"] = $dsLoginX;
            $_SESSION["SS_ACCESS"] = "1";
            print "OK";
        }else{
            if ($chkLogin) {
                $dsLogin = getMYSQLValues("tblogin", "*", "user = '{$u}' ");
                if ($dsLogin) {
                   // $dsLogin = getMYSQLValues("tblogin x , tbinto y", "x.*,y.pptype,y.pmtype,y.ptype ", "user = '{$u}' and x.id = y.loginid ");
                    $_SESSION["SS_USER"] = $dsLogin;
                } else {
                    $cdate = date("d-m-Y", TIMESTAMP);
                    $ctime = date("H:i", TIMESTAMP);
                    @$dbmy->add_db("tblogin", array("user" => $u, "dtime" => TIMESTAMP, "cdate" => $cdate, "ctime" => $ctime, 'site' => $site));
                    $dsLogin = @getMYSQLValues("tblogin x , tbinto y", "x.*,y.pptype,y.pmtype,y.ptype ", "user = '{$u}' and x.id = y.loginid ");
                    $_SESSION["SS_USER"] = $dsLogin;
                    $_SESSION["SS_ACCESS"] = "1";
                }
            print "OK";
            } else {
                print "รหัสผ่านหรือชื่ออีเมล์คุณไม่ถูกต้องครับ. กรุณากรอกใหม่ครับ.!";
            }
        }
        break;
    case "add-info": //
        $ar = $_POST[a];
        $cdate = date("d-m-Y", TIMESTAMP);
        $ctime = date("H:i", TIMESTAMP);

        $dbmy->add_db("tbinfo",
            array("name" => $a[0],
            "pptype" => $a[1],
            "ptype" => $a[2],
            "work" => $a[3],
            "rcode" => $a[4],
            "rname" => $a[5],
            "loginid" => $_SESSION[SS_USER][id],
            "pmtype" => -1,
            "dtime" => TIMESTAMP, "cdate" => $cdate, "ctime" => $ctime));

        $dbmy->update_db("tblogin", array("status_info" => 1 , "access"=>1 ), "id=" . $_SESSION[SS_USER][id]);
        $_SESSION[SS_USER][status_info] = 1;
        $dsLoginX = getMYSQLValues("tblogin x , tbinfo y", "x.*,y.pptype,y.pmtype,y.ptype ", "x.user = '{$_SESSION[SS_USER]['user']}' and x.id = y.loginid ");
        if($dsLoginX){
            $_SESSION["SS_USER"] = $dsLoginX;
            $_SESSION["SS_ACCESS"] = "1";
            print "OK";
        }
        //print "OK";
        break;
}
?>