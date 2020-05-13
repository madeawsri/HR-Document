<?php

/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 15/3/2560
 * Time: 16:13
 */
class hrClass
{
    function __construct()
    {
    }

    function FnFromAdd($tb_name)
    { // Edit
        global $_html;
        $frmAdd = $_html->elementFormTag('textbox', 'tname', 'tname', 'ประเภท', '', '', 'required');
        $frmAdd .= $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
        $frmAdd .= $_html->elementFormTag('textbox', 'tid', 'tid', '', '', 'hide', '');
        $_html->formTag('frmAdd' . $tb_name, $frmAdd, 'post', '', 'novalidate="novalidate"');
        return $_html->divTag('divAdd' . $tb_name, $_html->formRender(), 'row form-add-content_' . $tb_name, 'style="display:none;" ');
        /******* END ADD ******/
    }

    function FnMyFromAdd($tb_name, $frmAdd, $hide = 1)
    { // Edit
        global $_html;
        $_html->formTag('frmAdd' . $tb_name, $frmAdd, 'post', '', 'novalidate="novalidate"');
        if ($hide)
            return $_html->divTag('divAdd' . $tb_name, $_html->formRender(), 'row form-add-content_' . $tb_name, 'style="display:none;" ');
        else
            return $_html->divTag('divAdd' . $tb_name, $_html->formRender(), 'row form-add-content_' . $tb_name);
        /******* END ADD ******/
    }

    function FnFromEdit($tb_name)
    { // Edit
        global $_html;
        $frmAdd = $_html->elementFormTag('textbox', 'tname', 'tname', 'ประเภท', '', '', 'required');
        $frmAdd .= $_html->elementFormTag('textbox', 'tbname', 'tbname', '', $tb_name, 'hide', '');
        $frmAdd .= $_html->elementFormTag('textbox', 'tid', 'tid', '', '', 'hide', '');
        $_html->formTag('frmEdit' . $tb_name, $frmAdd, 'post', '', 'novalidate="novalidate"');
        return $_html->divTag('divEdit' . $tb_name, $_html->formRender(), 'row form-edit-content_' . $tb_name, 'style="display:none;" ');
        /******* END ADD ******/
    }

    function FnMyFromEdit($tb_name, $frmAdd, $hide = 1)
    { // Edit
        global $_html;
        $_html->formTag('frmEdit' . $tb_name, $frmAdd, 'post', '', 'novalidate="novalidate"');
        if ($hide)
            return $_html->divTag('divEdit' . $tb_name, $_html->formRender(), 'row form-edit-content_' . $tb_name, 'style="display:none;" ');
        else
            return $_html->divTag('divEdit' . $tb_name, $_html->formRender(), 'row form-edit-content_' . $tb_name);
        /******* END ADD ******/
    }

    function FnTbWidth($fname, $cname, $w, $q = 1)
    {
        if ($q)
            echo "<script> $('[id*=tbhr_{$fname}{$cname}]').attr('width','{$w}'); </script>";
        else
            echo "<script> $('[id*={$fname}{$cname}]').attr('width','{$w}'); </script>";
    }

    function FnTable($tb_name, $tb_title)
    {
        global $_lib;
        $addButton = "<p class='pull-right bb' style='font-size: large'><a href=\"javascript:void(0);\"
                 data-table='{$tb_name}' data-title='{$tb_title}'  data-mode='add{$tb_name}'
                 class='addButton btn btn-social btn-success btn-flat pull-right' >
                 <i class=\"fa fa-plus-circle \"></i>  เพิ่มข้อมูล  </a></p>
              ";
        $DbSetting = getMYSQLValueAll($tb_name, "id,name ");
        $h = array("รหัส", "ประเภท", "แก้ไข");
        $data = array();
        foreach ($DbSetting as $k => $v) {
            $v['config'] = "<a href='javascript:void(0);' data-id='{$v['id']}'
                       data-table='{$tb_name}' data-title='{$tb_title}'
                       data-mode='getSetting' class='editSettingButton'>
                          <i class=\"fa fa-pencil fa-2x text-color-green \"></i></a>";
            $data[] = $v;
        }
        $table = new tableClass('tb' . $tb_name, $h, $data, '10', 'hide', 'true', 'true', 'false');
        return $addButton . $table->render();
    }

    function FnPermisTable($tb_name, $tb_title, $tb_head, $datadb, $type = "")
    {
        global $_lib;
        $arTypeHide = array(
            "pdf" => ' hide ', "add" => ' hide ', "edit" => ' hide ',
            "del" => ' hide ', 'pic' => ' hide ', "exp" => 'hide',
            'permis' => "hide");
        $arOp = array(" hide ", " ");
        if (!is_null($type)) {
            $type = explode(',', $type);
            if ($type)
                foreach ($type as $v) {
                    $arTypeHide[$v] = $arOp[$_lib->isMenu($v)];
                }
        }

        $data = array();
        if ($datadb)
            foreach ($datadb as $k => $v) {
                $data[] = $v;
            }

      echo $_lib->JRender("
        $('input[type=\"radio\"].minimal').iCheck({
              checkboxClass: 'icheckbox_minimal-red',
              radioClass: 'iradio_minimal-red'
              }).on('ifChecked', function (e) {
           jPmRadio($(this));
          });
        ");

        echo $_lib->JRender("
          $('input[type=\"radio\"].minimal2').iCheck({
              checkboxClass: 'icheckbox_minimal-red',
              radioClass: 'iradio_minimal-red'
              }).on('ifChecked', function (e) {

             jPmRadioApp($(this));

          });
        ");

        $table = new tableClass('tb' . $tb_name, $tb_head, $data, '9');
        return  $table->render();
    }

    function FnMyTable($tb_name, $tb_title, $tb_head, $datadb, $type = "add,edit")
    {
        global $_lib;
        $arTypeHide = array("info" => "hide", "pdf" => ' hide ', "add" => ' hide ',
            "edit" => ' hide ', "del" => ' hide ', 'pic' => ' hide ', "exp" => 'hide',"ass"=>'hide',"print"=>"hide","send"=>"hide");

        $arOp = array(" hide ", " ");
        if (!is_null($type)) {
            $type = explode(',', $type);
            if ($type)
                foreach ($type as $v) {
                    if($v != "pic")
                      $arTypeHide[$v] = $arOp[$_lib->isMenu($v)];
                    else $arTypeHide[$v] = '';
                }
        }

        $addButton = " <p class='pull-right bb {$arTypeHide['exp']}' style='font-size: large;padding-right: 15px;'><a href=\"javascript:void(0);\"
                 data-table='{$tb_name}' data-title='{$tb_title}' target='_parent' data-mode='pdf{$tb_name}'
                 class='expButton btn btn-social btn-info btn-flat pull-left' >
                 <i class=\"fa fa-file-pdf-o \"></i>  ส่งออก PDF  </a></p>
              ";
        $addButton .= "<p class='pull-right bb {$arTypeHide['add']}' style='font-size: large;padding-right: 15px;'><a href=\"javascript:void(0);\"
                 data-table='{$tb_name}' data-title='{$tb_title}'  data-mode='add{$tb_name}'
                 class='addButton btn btn-social btn-success btn-flat pull-left' >
                 <i class=\"fa fa-plus-circle \"></i>  เพิ่มข้อมูล  </a></p>
              ";

        $data = array();
        if ($datadb)
            foreach ($datadb as $k => $v) {

                //$id = $v['id'];

                $id = explode(',',$v['id']);
                $app = $id[1]; $id = $id[0];

                if ($v['cid'])
                    $cid = $v['cid'];
                else $cid = $v['id'];

                $v['id'] = "<a href='javascript:void(0);' data-id='{$id}' data-cid='{$cid}'
                       data-table='{$tb_name}' title='แก้ไขข้อมูล' data-title='{$tb_title}'
                       data-mode='get' class='editButton {$arTypeHide['edit']}'>
                          <i class=\"fa fa-pencil fa-2x text-color-green \"></i></a>";

                $v['id'] .= "<a href='javascript:void(0);' data-id='{$id}' data-cid='{$cid}'
                       data-table='{$tb_name}' title='ลบข้อมูล' data-title='ลบ{$tb_title}'
                       data-mode='del' class='delButton {$arTypeHide['del']}'>
                          <i class=\"fa fa-trash fa-2x text-color-red \"></i></a>";

                $v['id'] .= "<a href='javascript:void(0);' data-id='{$id}' data-cid = '{$cid}'
                       data-table='{$tb_name}' title='อัพโหลดรูปภาพประจำตัว{$tb_title}' data-title='รูปประจำตัว{$tb_title}'
                       data-mode='pic' class='picButton {$arTypeHide['pic']}'>
                          <i class=\"fa fa-picture-o fa-2x colorpicker-alpha \"></i></a>";

                $v['id'] .= "<a href='javascript:void(0);' data-id='{$id}' data-cid = '{$cid}'
                       data-table='{$tb_name}' title='ไฟล์แนบจัดเก็บเอกสารหลักฐาน {$tb_title}' data-title='{$tb_title}'
                       data-mode='pdf' class='pdfButton {$arTypeHide['pdf']}'>
                          <i class=\"fa fa-file-pdf-o fa-2x text-color-orange \"></i></a>";

                $v['id'] .= "<a href='javascript:void(0);' data-id='{$id}' data-cid = '{$cid}'
                       data-table='{$tb_name}' title='รายละเอียดผู้สมัคร {$tb_title}' data-title='{$tb_title}'
                       data-mode='info' class='infoButton {$arTypeHide['info']}'>
                          <i class=\"fa fa-info-circle fa-2x text-color-blue \"></i></a>";

                $v['id'] .= "<a href=\"javascript:void(0);\"
                                data-table='{$tb_name}' data-id='{$id}' data-title='{$tb_title}'  data-mode='add{$tb_name}'
                                class='printButton {$arTypeHide['print']}' ><i class=\"fa fa-print fa-2x \"></i></a>";

                $v['id'] .= "<a href='javascript:void(0);' data-id='{$id}' data-cid = '{$cid}'
                       data-table='{$tb_name}' title='ไฟล์แนบจัดเก็บเอกสารหลักฐาน {$tb_title}' data-title='{$tb_title}'
                       data-mode='send' class='sendButton {$arTypeHide['send']}'>
                          <i class=\"fa fa-send-o fa-2x text-color-green-alpha \"></i></a>";


                if(!$app) {
                    $v['id'] .= "<a href='javascript:void(0);' data-id='{$id}' data-cid = '{$cid}'
                       data-table='{$tb_name}' title='กรอก {$tb_title}' data-title='{$tb_title}'
                       data-mode='get' class='assButton {$arTypeHide['ass']}  ' >
                          <i class=\"fa fa-list-alt fa-2x text-color-blue \"></i></a>";
                }else{
                    $v['id'] .= "<i class=\"fa fa-list-alt fa-2x text-color-gray \"></i>";
                }


                $data[] = $v;
            }

        if (!trim($arTypeHide['pdf']))
            echo $_lib->JRender("$('.pdfButton').on('click', function () {
                    jUploadPdf($(this));
                    jListPdf($(this));
                });");

        if (!trim($arTypeHide['send']))
            echo $_lib->JRender("$('.sendButton').on('click', function () {
                    jUploadSend($(this));
                    jListSend($(this));
                });");

        if (!trim($arTypeHide['print']))
            echo $_lib->JRender("$('.printButton').on('click', function () {

                    jPDFPrint($(this).attr('data-id'), '_parent');
                });");

        if (!trim($arTypeHide['del']))
            echo $_lib->JRender("$('.delButton').on('click', function () {
                    jPageDel($(this));
                });");

        if (!trim($arTypeHide['edit']))
            echo $_lib->JRender("$('.editButton').on('click', function () {
                    jPageEdit($(this));
                });");

        if (!trim($arTypeHide['add']))
            echo $_lib->JRender("$('.addButton').on('click', function () {
                    jPageAdd($(this));
                });");

        if($_lib->isUser()){
            //if (!trim($arTypeHide['pic']))
                echo $_lib->JRender("$('.picButton').on('click', function () {
                    jPagePicOnly($(this));
                });");
        }else {
            //if (!trim($arTypeHide['pic']))
                echo $_lib->JRender("$('.picButton').on('click', function () {
                    jPagePic($(this));
                });");
        }

        if (!trim($arTypeHide['info']))
            echo $_lib->JRender("$('.infoButton').on('click', function () {
                    jPageInfo($(this));
                });");

        if (!trim($arTypeHide['ass']))
            echo $_lib->JRender("$('.assButton').on('click', function () {
                    jPageEditAss($(this));
                });");


        if(in_array('checkbox',$type)){
            echo $_lib->JRender(" jMenuPermis(); ");
        }


        $table = new tableClass('tb' . $tb_name, $tb_head, $data, '8');
        return $addButton . $table->render();
    }

    function FnRpTable($tb_name, $tb_title, $tb_head, $datadb, $type = "add,edit")
    {
        global $_lib;
        $arTypeHide = array("pdf" => ' hide ', "add" => ' hide ', "edit" => ' hide ', "del" => ' hide ', 'pic' => ' hide ', "exp" => 'hide');
        $arOp = array(" hide ", " ");
        if (!is_null($type)) {
            $type = explode(',', $type);
            if ($type)
                foreach ($type as $v) {
                    //$arTypeHide[$v] = ' ';
                    $arTypeHide[$v] = $arOp[$_lib->isMenu($v)];
                }
        }
        /*
        if (!is_null($type)) {
            $type = explode(',', $type);
            if ($type)
                foreach ($type as $v) {
                    $arTypeHide[$v] = ' ';
                }
        }
        $arOp = array(" hide "," ");
        $arTypeHide['add']=  $arOp[$_lib->isMenu('add')];
        $arTypeHide['edit']= $arOp[$_lib->isMenu('edit')];
        $arTypeHide['del']=  $arOp[$_lib->isMenu('del')];
        $arTypeHide['pdf']=  $arOp[$_lib->isMenu('pdf')];
        */

        $addButton = " <p class='pull-right bb {$arTypeHide['exp']}' style='font-size: large;padding-right: 15px;'><a href=\"javascript:void(0);\"
                 data-table='{$tb_name}' data-title='{$tb_title}' target='_parent' data-mode='pdf{$tb_name}'
                 class='expButton btn btn-social btn-info btn-flat pull-left' >
                 <i class=\"fa fa-file-pdf-o \"></i>  ส่งออก PDF  </a></p>
              ";
        $addButton .= "<p class='pull-right bb {$arTypeHide['add']}' style='font-size: large;padding-right: 15px;'><a href=\"javascript:void(0);\"
                 data-table='{$tb_name}' data-title='{$tb_title}'  data-mode='add{$tb_name}'
                 class='addButton btn btn-social btn-success btn-flat pull-left' >
                 <i class=\"fa fa-plus-circle \"></i>  เพิ่มข้อมูล  </a></p>
              ";

        $data = array();
        if ($datadb)
            foreach ($datadb as $k => $v) {

                $id = $v['id'];
                if ($v['cid'])
                    $cid = $v['cid'];
                else $cid = $v['id'];

                $v['id'] = "<a href='javascript:void(0);' data-id='{$id}' data-cid='{$cid}'
                       data-table='{$tb_name}' title='แก้ไขข้อมูล' data-title='{$tb_title}'
                       data-mode='get' class='editButton {$arTypeHide['edit']}'>
                          <i class=\"fa fa-pencil fa-2x text-color-green \"></i></a>";

                $v['id'] .= "<a href='javascript:void(0);' data-id='{$id}' data-cid='{$cid}'
                       data-table='{$tb_name}' title='ลบข้อมูล' data-title='ลบ{$tb_title}'
                       data-mode='del' class='delButton {$arTypeHide['del']}'>
                          <i class=\"fa fa-trash fa-2x text-color-red \"></i></a>";

                $v['id'] .= "<a href='javascript:void(0);' data-id='{$id}' data-cid = '{$cid}'
                       data-table='{$tb_name}' title='อัพโหลดรูปภาพประจำตัว{$tb_title}' data-title='รูปประจำตัว{$tb_title}'
                       data-mode='pic' class='picButton {$arTypeHide['pic']}'>
                          <i class=\"fa fa-picture-o fa-2x colorpicker-alpha \"></i></a>";

                $v['id'] .= "<a href='javascript:void(0);' data-id='{$id}' data-cid = '{$cid}'
                       data-table='{$tb_name}' title='ไฟล์แนบจัดเก็บเอกสารหลักฐาน {$tb_title}' data-title='{$tb_title}'
                       data-mode='pdf' class='pdfButton {$arTypeHide['pdf']}'>
                          <i class=\"fa fa-file-pdf-o fa-2x text-color-orange \"></i></a>";

                $data[] = $v;
            }

        if (!trim($arTypeHide['pdf']))
            echo $_lib->JRender("$('.pdfButton').on('click', function () {
                    jUploadPdf($(this));
                    jListPdf($(this));
                });");

        if (!trim($arTypeHide['del']))
            echo $_lib->JRender("$('.delButton').on('click', function () {
                    jPageDel($(this));
                });");

        if (!trim($arTypeHide['edit']))
            echo $_lib->JRender("$('.editButton').on('click', function () {
                    jPageEdit($(this));
                });");

        if (!trim($arTypeHide['add']))
            echo $_lib->JRender("$('.addButton').on('click', function () {
                    jPageAdd($(this));
                });");

        if (!trim($arTypeHide['pic']))
            echo $_lib->JRender("$('.picButton').on('click', function () {
                    jPagePic($(this));
                });");


        $table = new tableClass('tb' . $tb_name, $tb_head, $data, '15');
        return $addButton . $table->render();
    }

    function DbPersonRegPositionNotInterview($rpid = "", $pptype = "")
    {
        global $dbmy, $_hr;
        if ($rpid)
            $rpid = " AND rp.id = '{$rpid}' ";
        if ($pptype)
            $pptype = " AND rp.regp in (
            select j.id from hr_job j
               where j.djob in (select jd.id from hr_dec_job jd where jd.pptype = {$pptype} )
            )    ";

        $sql = "
        SELECT p.cid,
               CONCAT( p.pname, p.fname,  ' ', p.lname ) AS cname ,
              rp.regp as rpname,
              rp.id as rpid
          FROM hr_person p, hr_reg_position rp
         WHERE p.cid = rp.cid
           and kslid = '{$_REQUEST['site']}' {$rpid} {$pptype}
           and rp.id not in (select iv.rpid from hr_interview iv where kslid = '{$_REQUEST['site']}' )
         order by p.id desc
      ";

        $datadb = $dbmy->exec($sql);
        $dbTable = array();
        if ($datadb)
            foreach ($datadb as $k => $v) {
                if ($v['rpname']) {
                    $dbJobDetail = $_hr->DbJobDetail($v['rpname']);
                    $v['rpname'] = $dbJobDetail['pptype'] . "/ " . $dbJobDetail['ptype'];
                    $v['ppid'] = $dbJobDetail['ppid'];
                    $v['pid'] = $dbJobDetail['pid'];
                } else {
                    $v['rpname'] = '<span class="text-color-red-alpha">-- รอตำแหน่งว่าง --</span>';
                    $v['ppid'] = '';
                    $v['pid'] = '';
                }
                $dbTable[] = $v;
            }
        return $dbTable;
    }

    function DbPersonRegPositionInInterview($rpid = "", $pptype = '')
    {
        global $dbmy, $_hr;
        if ($rpid)
            $rpid = " AND rp.id = '{$rpid}' ";
        if ($pptype)
            $pptype = " AND rp.regp in (
            select j.id from hr_job j
               where j.djob in (select jd.id from hr_dec_job jd where jd.pptype = {$pptype} )
            )    ";

        $sql = "
        SELECT p.cid,
               CONCAT( p.pname, p.fname,  ' ', p.lname ) AS cname ,
              rp.regp as rpname,
              rp.id as rpid
          FROM hr_person p, hr_reg_position rp
         WHERE p.cid = rp.cid
           and kslid = '{$_REQUEST['site']}' {$rpid} {$pptype}
           and rp.id in (select iv.rpid from hr_interview iv where kslid = '{$_REQUEST['site']}' )
         order by p.id desc
      ";
        //if($q) return  $sql;
        $datadb = $dbmy->exec($sql);
        $dbTable = array();
        if ($datadb)
            foreach ($datadb as $k => $v) {
                if ($v['rpname']) {
                    $dbJobDetail = $_hr->DbJobDetail($v['rpname']);
                    //vvArray($dbJobDetail);
                    $v['rpname'] = $dbJobDetail['pptype'] . "/ " . $dbJobDetail['ptype'];
                    $v['ppid'] = $dbJobDetail['ppid'];
                    $v['pid'] = $dbJobDetail['pid'];
                } else {
                    $v['rpname'] = '<span class="text-color-red-alpha">-- รอตำแหน่งว่าง --</span>';
                    $v['ppid'] = '';
                    $v['pid'] = '';
                }

                $dbTable[] = $v;
            }
        return $dbTable;
    }

    function DbJobDetail($id = "", $pptype = "")
    {
        global $dbmy;
        if ($id) $id = " AND j.id = {$id} ";
        if ($pptype) $pptype = " AND jd.pptype = {$pptype} ";
        $sql = "
        SELECT
	       j.id,j.kslid,
	       (select x.name from hr_jtype as x where x.id = j.jtype) as jtype,
	       j.din, j.dexp, j.nn, j.nx, j.dtime,
	       (select x.name from hr_pptype as x where x.id = jd.pptype) as pptype,
	       (select x.name from hr_ptype as x where x.id = jd.ptype) as ptype,
	       (select x.name from hr_agtype as x where x.id = jd.agtype) as agtype,
	       (select x.name from hr_sxtype as x where x.id = jd.sxtype) as sxtype,
	       concat(jd.etypes,'|',jd.vtypes) as ev,
	       jd.attb,
	       (select x.name from hr_satype as x where x.id = jd.satype) as satype,
	       jd.pptype as ppid,jd.ptype as pid

          FROM hr_job AS j, hr_dec_job AS jd
         WHERE j.djob IN (jd.id) {$id} {$pptype}
        ";
        $data = $dbmy->exec($sql);

        $dbTable = array();
        if ($data)
            foreach ($data as $k => $v) {
                $str = $v['ev'];
                $str = explode('|', $str);

                if ($str[0]) {
                    $ex = getMYSQLValueAll('hr_etype', 'name', 'id in (' . $str[0] . ') ');
                    $exx = array();
                    foreach ($ex as $ke => $ve) $exx[] = $ve['name'];
                    $ex = implode(', ', $exx);
                }
                if ($str[1]) {
                    $ev = getMYSQLValueAll('hr_vtype', 'name', 'id in (' . $str[1] . ') ');
                    $exv = array();
                    foreach ($ev as $ke => $ve) $exv[] = $ve['name'];
                    $ev = implode(', ', $exv);
                }

                $v['ev'] = "" . $ex . '<br>' . $ev . "";
                $dbTable[] = $v;
            }

        if (count($dbTable) == 1) return $dbTable[0]; else return $dbTable;
    }

    function DbRpUsers()
    {
        return getMYSQLValueAll('tbinfo', 'loginid as uid', 'pmtype <> 0');
    }

    function getRpUserPptype()
    {
        return $_SESSION['SS_USER']['pptpye'];
    }

    function isRpUsers($loginid)
    {
        return getMYSQLValue('tbinfo', 'count(*)', 'pmtype <> 0 and loginid = ' . $loginid);
    }

    function getRegPositions($cid)
    {
        global $_hr;
        $datadb = getMYSQLValueAll("hr_reg_position as x , hr_person as y ",
            "x.cid , concat(y.pname,y.fname,' ',y.lname) as cname," .
            " regp , x.rdate ,x.id  ",
            " (x.cid = y.cid  or x.cid=y.id) and x.cid = '{$cid}'  ORDER BY  x.dedit desc ,  x.id desc  "); // must be use last "id" alway
        $dbTable = array();
        if ($datadb)
            foreach ($datadb as $k => $v) {
                if ($v['regp']) {
                    $dbJobDetail = $_hr->DbJobDetail($v['regp']);
                    $v['ddate'] = "ประกาศวันที่ {$dbJobDetail['din']} ถึง {$dbJobDetail['dexp']}";
                    $v['regp'] = $dbJobDetail['pptype'] . "/ " . $dbJobDetail['ptype'];

                } else {
                    $v['ddate'] = "";
                    $v['regp'] = '<span class="text-color-red-alpha">-- รอตำแหน่งว่าง --</span>';
                }
                $dbTable[] = $v;
            }

        return $dbTable;


    }

    function getEducation($cid)
    {
        $ed = getMYSQLValues("hr_education as x , hr_person as y ",
            "( select name from hr_etype et where et.id = x.cer  ) as cer,
            ( select name from hr_vtype et where et.id = x.skk  ) as skk,
             x.suc, x.gra,
            ( select name from hr_eutype et where et.id = x.edu  ) as edu,
            x.id",
            " x.cid = y.cid and x.cid = '{$cid}'   order by id desc ");
        return $ed;
    }

    function getAbility($cid)
    {
        $ab = getMYSQLValues("hr_ability", "*", " cid = '{$cid}' ");
        return $ab;
    }

    function getCompanys($cid)
    {
        $datadb = getMYSQLValueAll("hr_company as x , hr_person as y ",
            "x.cid , concat(y.pname,y.fname,' ',y.lname) as cnamex," .
            " x.cname,x.cwork,(select name from hr_ctype as ps where ps.id = x.ctype ) as ctype,x.id",
            " x.cid = y.cid  and x.cid = '{$cid}'  ORDER BY x.id desc "); // must be use last "id" alway
        return $datadb;
    }

    function  getDocref($cid)
    {
        return getMYSQLValueAll('hr_docref', '*', " cid = '{$cid}' ");
    }

    function getInterview($cid)
    {
        global $dbmy, $_lib, $_hr;
        $datadb = $dbmy->exec("
        select (select so.name from hr_sotype so where so.id = x.sotype ) as sotype ,
               concat(y.pname,y.fname,' ',y.lname) as cname,
               rp.regp as rpname ,
               x.ddate,x.ssite,x.sname,
               case when x.note like '' then
                  concat((select r.name from hr_rtype as r where r.id = x.rtype ))
                else concat((select r.name from hr_rtype as r where r.id = x.rtype ),'<br> ** ',x.note) end as rtype ,
               x.id,x.note2,x.note
        from hr_interview as x , hr_person as y , hr_reg_position rp
        where x.cid = y.cid and rp.id = x.rpid and x.cid = '{$cid}' order by x.id desc
        "); // must be use last "id" alway

        $dbTable = array();
        if ($datadb)
            foreach ($datadb as $k => $v) {
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
                        $v['rpname'] = $dbJobDetail['pptype'] . "/ " . $dbJobDetail['ptype'];
                    } else {
                        $v['rpname'] = '<span class="text-color-red-alpha">-- รอตำแหน่งว่าง --</span>';
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
        return $dbTable;
    }

    function getPmtype($id = 1)
    {
        if ($id != 1)
            return getMYSQLValues('hr_pmtype', 'id,name', 'id = ' . $id ,'1 order by id  ');
        else return getMYSQLValueAll('hr_pmtype', 'id,name','1 order by id  ');
    }

    function getDoAsm($id,$sid=""){

      return getMYSQLValues('hr_do_asm','*,(select x.name from hr_notype x where x.id = notype) as noname ',' interview_id = '.$id);
    }

    function getDoAsms($id="1",$sid=""){
        global $_lib;
        $arr = array();
        $sid = explode(',',$sid);
        if($_lib->isUser()){
            if($sid)
                foreach($sid as $k=>$v) {
                    $data = @getMYSQLValues('hr_do_asm', '*,
             (select x.name from hr_notype x where x.id = notype) as noname,
             (select x.name from tbinfo x where x.loginid = '.$v.') as cname
             ', ' interview_id = ' . $id.' and sid = '.$v);
                    $arr[] = $data;
                }
        }else{
            if($sid)

                    $data = @getMYSQLValues('hr_do_asm', '*,
             (select x.name from hr_notype x where x.id = notype) as noname,
             (select x.name from tbinfo x where x.loginid = '.$_SESSION['SS_USER']['id'].') as cname
             ', ' interview_id = ' . $id.' and sid = '.$_SESSION['SS_USER']['id'] );
                    $arr[] = $data;

        }


        return $arr;
    }


    function calcDoAsm($w,$s,$max=3){
         if(!$w) return false;
         $wval = explode(',',$w);
         $sval = explode(',',$s);
         $w = count($wval);
         $wret = array_sum($wval);
         $max = $max * $wret;
         $ret = 0;
         foreach($wval as $k=>$v){
             $ret += ($v*$sval[$k]);
         }
        return number_format( ($ret/$max)*100 ,2);//*($w/100);
    }

    function getLoginInfo($loginid=1){
        if($loginid != 1 )
         return getMYSQLValues('tbinfo','loginid,name,pptype'," loginid = {$loginid} ");
        else return getMYSQLValueAll('tbinfo','loginid,name,pptype'," 1 ");
    }
}