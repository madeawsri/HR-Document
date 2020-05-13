<?php
        /**
           * Created by boonyadol on 15/03/2017 14:16.
         **/
         ini_set("memory_limit","700M");
         set_time_limit(0);
         include "../../conn.php";

         $arr = array();
         $arr['ERR']= "";
         $arr['SEND']= $_REQUEST;
         $arr['SQL'] = '';
         $arr['DATA'] = '';
         $arr['CONTENT'] = '';
         $arr['REPORT'] = '';
         $arr['MSG'] = '';

         switch($_REQUEST['mode']) {
            case "": break;
         }

        $_html->boxTag('สรุปรายงาน',$arr['REPORT'], '', __boxStyle::Success);
        $arr['REPORT'] = $_html->divTag('', $_html->boxRender(), '', ''); //style="zoom:0.8"
        echo json_encode($arr);

        ?>